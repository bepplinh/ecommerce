<?php

namespace App\Http\Controllers\Client;

use Illuminate\Http\Request;
use App\Models\ProductVariants;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function showCartItemQuantity()
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

        $cart = $user->cart()->where('status', 'active')->first();

        if (!$cart) {
            return redirect()->back()->with('error', 'Giỏ hàng của bạn đang trống.');
        }

        $cartItems = $cart->cartItems()->with('productVariants.product')->get();
        return view('client.cart', compact('cartItems'));
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

        $productVariant = ProductVariants::where('product_id', $product_id)
            ->where('color_id', $validatedData['color'])
            ->where('size_id', $validatedData['size'])
            ->first();

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

        return redirect()->back()->with('toastr', [
            'status' => 'success',
            'message' => 'Product added to cart successfully.',
        ]);
    }

    public function removeCartItem($id)
    {
        $user = Auth::user();

        if (!$user) {
            return redirect()->route('login')->with('error', 'Bạn cần đăng nhập để xóa sản phẩm khỏi giỏ hàng.');
        }

        $cartItem = $user->cart()->where('status', 'active')->first()->cartItems()->find($id);

        if ($cartItem) {
            $cartItem->delete();
            return redirect()->back()->with('toastr', [
                'status' => 'success',
                'message' => 'Product removed from cart successfully.',
            ]);
        }
    }

    public function updateQuantity(Request $request, $id)
    {
        $user = Auth::user();

        if (!$user) {
            return response()->json(['success' => false, 'message' => 'Bạn cần đăng nhập để thực hiện thao tác này.'], 401);
        }

        $cartItem = $user->cart->cartItems()->find($id);

        if (!$cartItem) {
            return response()->json(['success' => false, 'message' => 'Không tìm thấy mục giỏ hàng.'], 404);
        }

        $validatedData = $request->validate([
            'quantity' => 'required|integer|min:1',
        ]);

        // Cập nhật số lượng và tổng giá trị
        $cartItem->quantity = $validatedData['quantity'];
        $cartItem->price = $cartItem->quantity * $cartItem->productVariants->product->price;
        $cartItem->save();

        // Tính toán tổng giá trị giỏ hàng
        $cart = $user->cart;
        $total = $cart->cartItems->sum('price');

        return response()->json([
            'success' => true,
            'subtotal' => number_format($cartItem->price, 2),
            'total' => number_format($total, 2),
        ]);
    }
}
