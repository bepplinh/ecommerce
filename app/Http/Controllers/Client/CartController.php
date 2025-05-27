<?php

namespace App\Http\Controllers\Client;

use App\Models\CartItem;
use App\Models\Shipping_Address;
use Illuminate\Http\Request;
use App\Models\ProductVariants;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function showCart()
    {
        $user = Auth::user();
        $cart = $user->cart()->where('status', 'active')->first();
        if ($cart) {
            $totalQuantity = $cart->cartItems()->sum('quantity');
        } else {
            $totalQuantity = 0;
        }
        return view('layout.clientApp', compact('totalQuantity'));
    }

    public function showCartDetail()
    {
        $user = Auth::user();

        if (!$user) {
            return redirect()->route('login')->with('error', 'Bạn cần đăng nhập để xem giỏ hàng.');
        }

        $shipping_addresses = Shipping_Address::where('user_id', $user->id)->get();

        // Lấy cart items chỉ thuộc cart chưa completed
        $cartItems = CartItem::whereHas('cart', function ($query) use ($user) {
            $query->where('user_id', $user->id)
                  ->where('status', '!=', 'completed');
        })
        ->with('productVariants.product', 'productVariants.images')
        ->get();

        return view('client.cart', compact('cartItems', 'shipping_addresses'));
    }

    public function addToCart(Request $request, $product_id)
    {
        $user = Auth::user();

        if (!$user) {
            return redirect()->route('login')->with('error', 'Bạn cần đăng nhập để thêm sản phẩm vào giỏ hàng.');
        }

        $validatedData = $request->validate([
            'product_id' => 'required|integer|exists:products,id',
            'color' => 'required|integer|exists:colors,id',
            'size' => 'required|integer|exists:sizes,id',
            'quantity' => 'required|integer|min:1',
        ]);

        $productVariant = ProductVariants::where('product_id', $product_id)->where('color_id', $validatedData['color'])->where('size_id', $validatedData['size'])->first();

        if (!$productVariant) {
            return redirect()->back()->with('error', 'Không tìm thấy sản phẩm với kích thước và màu sắc đã chọn.');
        }

        $price = $productVariant->product->sale_price ?? $productVariant->product->price;

        $cart = $user->cart()->firstOrCreate(['status' => 'active']);
        $cartItem = $cart->cartItems()->where('product_variant_id', $productVariant->id)->first();
        if ($cartItem) {
            $cartItem->quantity += $validatedData['quantity'];
            $cartItem->price = $price * $cartItem->quantity;
            $cartItem->save();
        } else {
            $cart->cartItems()->create([
                'product_variant_id' => $productVariant->id,
                'quantity' => $validatedData['quantity'],
                'price' => $price * $validatedData['quantity'],
            ]);
        }

        return redirect()
            ->back()
            ->with('toastr', [
                'status' => 'success',
                'message' => 'Product added to cart successfully.',
            ]);
    }

    public function removeCartItem($id)
    {
        $cartItem = CartItem::findOrFail($id);
        $cartItem->delete();

        return redirect()
            ->back()
            ->with('toastr', [
                'status' => 'success',
                'message' => 'Product removed from cart successfully.',
            ]);
    }

    public function increaseQty($id)
    {
        $cartItem = CartItem::findOrFail($id);
        $cartItem->quantity += 1;
        if ($cartItem->productVariants->product->discount) {
            $cartItem->price = $cartItem->productVariants->product->sale_price * $cartItem->quantity;
        } else {
            $cartItem->price = $cartItem->productVariants->product->price * $cartItem->quantity;
        }
        $cartItem->save();

        return redirect()->back();
    }

    public function decreaseQty($id)
    {
        $cartItem = CartItem::findOrFail($id);
        if ($cartItem->quantity > 1) {
            $cartItem->quantity -= 1;
            if ($cartItem->productVariants->product->discount) {
                $cartItem->price = $cartItem->productVariants->product->sale_price * $cartItem->quantity;
            } else {
                $cartItem->price = $cartItem->productVariants->product->price * $cartItem->quantity;
            }
            $cartItem->save();
        }

        return redirect()->back();
    }

    public function saveShippingAddressToSession(Request $request)
    {
        if ($request->filled('address_id')) {
            $address = Shipping_Address::find($request->address_id);
            if ($address) {
                session(['shipping_address' => $address->toArray()]);
            }
        } else {
            $request->validate([
                'full_name' => 'required|string|max:255',
                'phone' => 'required|string|max:15',
                'house_number' => 'required|string|max:255',
                'street' => 'nullable|string|max:255',
                'ward' => 'nullable|string|max:255',
                'district' => 'nullable|string|max:255',
                'city' => 'nullable|string|max:255',
            ]);

            session([
                'shipping_address' => [
                    'full_name' => $request->input('full_name'),
                    'phone' => $request->input('phone'),
                    'house_number' => $request->input('house_number'),
                    'street' => $request->input('street'),
                    'district' => $request->input('district'),
                    'ward' => $request->input('ward'),
                    'city' => $request->input('city'),
                ],
            ]);
        }

        return redirect()->back();
    }
}
