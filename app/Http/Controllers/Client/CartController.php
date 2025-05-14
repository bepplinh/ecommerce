<?php

namespace App\Http\Controllers\Client;

use App\Models\CartItem;
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
            $cart = $user->cart()->create(['status' => 'active']);
            $cartItems = [];  // Giỏ hàng trống
        } else {
            $cartItems = $cart->cartItems()->with('productVariants.product')->get();
            $subtotal_Cart = $cartItems->reduce(function ($carry, $item) {
                $price = $item->productVariants->product->discount
                    ? $item->productVariants->product->sale_price 
                    : $item->productVariants->product->price;
        
                return $carry + ($price * $item->quantity);
            }, 0);
        }

        // Trả về view giỏ hàng với thông báo nếu cần
        return view('client.cart', compact('cartItems', 'subtotal_Cart'));
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

    public function increaseQuantity($id)
    {
        $user = Auth::user();

        if (!$user) {
            return redirect()->route('login')->with('error', 'Bạn cần đăng nhập để thay đổi số lượng.');
        }

        // Find the cart item and increase quantity
        $cartItem = $user->cart()->where('status', 'active')->first()->cartItems()->find($id);

        if ($cartItem) {
            $cartItem->quantity += 1;
        
            // Kiểm tra sự tồn tại của sale_price và discount
            if ($cartItem->productVariants && $cartItem->productVariants->product) {
                $product = $cartItem->productVariants->product;
                
                // Kiểm tra xem có discount hay không, nếu có thì sử dụng sale_price, nếu không thì dùng price
                $cartItem->price = $product->discount
                    ? ($product->sale_price ?? $product->price) * $cartItem->quantity
                    : $product->price * $cartItem->quantity;
            }
        
            // Lưu lại thay đổi
            $cartItem->save();
        }

        return redirect()->back()->with('toastr', [
            'status' => 'success',
            'message' => 'Số lượng đã được cập nhật.',
        ]);
    }

    // Decrease quantity of an item in the cart
    public function decreaseQuantity($id)
    {
        $user = Auth::user();

        if (!$user) {
            return redirect()->route('login')->with('error', 'Bạn cần đăng nhập để thay đổi số lượng.');
        }

        // Find the cart item and decrease quantity
        $cartItem = $user->cart()->where('status', 'active')->first()->cartItems()->find($id);

        if ($cartItem && $cartItem->quantity > 1) {
            $cartItem->quantity -= 1;
        
            // Kiểm tra sự tồn tại của sale_price và discount
            if ($cartItem->productVariants && $cartItem->productVariants->product) {
                $product = $cartItem->productVariants->product;
                
                // Kiểm tra xem có discount hay không, nếu có thì sử dụng sale_price, nếu không thì dùng price
                $cartItem->price = $product->discount
                    ? ($product->sale_price ?? $product->price) * $cartItem->quantity
                    : $product->price * $cartItem->quantity;
            }
        
            // Lưu lại thay đổi
            $cartItem->save();
        }

        return redirect()->back()->with('toastr', [
            'status' => 'success',
            'message' => 'Số lượng đã được cập nhật.',
        ]);
    }
}
