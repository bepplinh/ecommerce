<?php

namespace App\Http\Controllers\Client;

use App\Models\CartItem;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;

class CheckoutController extends Controller
{
    public function showCheckout()
    {
        $user = Auth::user();

        $cartItems = CartItem::whereHas('cart', function ($query) use ($user) {
            $query->where('user_id', $user->id);
        })->with('productVariants.product')->get();

        $totalPrice = $cartItems->sum(function ($item) {
            return $item->productVariants->product->sale_price * $item->quantity;
        });

        return view('client.checkout', compact('totalPrice', 'cartItems'));
    }

    public function showInformation()
    {
        return view('client.information');
    }

    public function placeOrder(Request $request)
    {
        $validatedData = $request->validate([
            'full_name' => 'required|string|max:255',
            'phone' => 'required|string|max:15',
            'house_number' => 'required|string|max:255',
            'street' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'district' => 'required|string|max:255',
            'ward' => 'required|string|max:255',
        ]);

        return redirect()->route('order.success')->with('success', 'Đặt hàng thành công!');
    }
}
