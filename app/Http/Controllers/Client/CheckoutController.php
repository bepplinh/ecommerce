    <?php

namespace App\Http\Controllers\Client;

use App\Models\Order;
use App\Models\CartItem;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use App\Models\Shipping_Address;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\PaymentController;

class CheckoutController extends Controller
{
    public function handleCheckoutPost(Request $request)
    {
        session()->put('allow_checkout', true);
        session(['shipping_fee' => $request->input('shipping_fee')]);
        if ($request->has('grand_total')) {
            session(['grand_total' => $request->input('grand_total')]);
        }

        return redirect()->route('cart.checkout.show');
    }

    public function showCheckoutPage()
    {
        $user = Auth::user();

        $cart = $user->cart()->where('status', 'active')->first();
        $cartItems = $cart ? $cart->cartItems()->with('productVariants.product')->get() : collect();

        $totalPrice = $cartItems->sum(function ($item) {
            return $item->productVariants->product->sale_price * $item->quantity;
        });
        session(['totalPrice' => $totalPrice]);
        if (session('shipping_address')) {
            return view('client.checkout', compact('totalPrice', 'cartItems', 'cart'));
        } else {
            return redirect()->back()->with('toastr', [
                'status' => 'warning',
                'message' => 'Please enter your address',
            ]);
        }
    }

    public function placeOrder(Request $request)
    {
        $user = Auth::user();

        $cart_id = $request->input('cart_id');
        $paymentMethod = $request->input('checkout_payment_method');

        if (session()->has('shipping_address') && isset(session('shipping_address')['id'])) {
            $shippingAddress = Shipping_Address::find(session('shipping_address')['id']);
        } else {
            $validated_Data_Address = $request->validate([
                'full_name' => 'required|string|max:255',
                'phone' => 'required|string|max:15',
                'house_number' => 'required|string|max:255',
                'street' => 'required|string|max:255',
                'city' => 'required|string|max:255',
                'district' => 'required|string|max:255',
                'ward' => 'required|string|max:255',
            ]);
            $data = array_merge(['user_id' => $user->id], $validated_Data_Address);

            $shippingAddress = Shipping_Address::where($data)->first();

            if (!$shippingAddress) {
                $shippingAddress = Shipping_Address::create($data);
            }
        }

        $cart = $user->cart()->where('id', $cart_id)->first();

        if ($paymentMethod === 'payos') {
            return redirect()->route('payment.payos', [
                'cart_id' => $cart->id,
                'shipping_address_id' => $shippingAddress->id,
            ]);
        } else {

            $cartItems = $cart ? $cart->cartItems()->with('productVariants.product')->get() : collect();

            $order = Order::create([
                'user_id' => $user->id,
                'shipping_address_id' => $shippingAddress->id,
                'total_amount' => session('grand_total'),
                'shipping_method' => session('shipping_fee'),
                'payment_method' => 'cod',
                'status' => 'pending',
                'order_code' => 'DH' . time() . $user->id,
            ]);

            foreach ($cartItems as $cartItem) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_variant_id' => $cartItem->productVariants->id,
                    'quantity' => $cartItem->quantity,
                    'price' => $cartItem->price,
                ]);
            }

            if ($cart) {
                $cart->status = 'completed';
                $cart->save();
            }

            return redirect()->route('order.success', ['order_id' => $order->id])->with('toastr', [
                'status' => 'success',
                'message' => 'Order placed successfully!',
            ]);
        }
    }

    public function showSuccessPage($order_id)
    {
        $user = Auth::user();
        $order = Order::where('user_id', $user->id)
            ->where('id', $order_id)
            ->with('orderItems.productVariants.product', 'shippingAddress')
            ->firstOrFail();

        $orderItems = $order->orderItems;

        return view('client.information', compact('order', 'orderItems'));
    }
}
