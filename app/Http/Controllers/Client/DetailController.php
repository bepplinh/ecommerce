<?php

namespace App\Http\Controllers\Client;

use App\Models\Color;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DetailController extends Controller
{
    public function showProductDetail($id)
    {
        $product = Product::with([
            'productVariants.color', 
            'productVariants.size',  
            'productVariants.images', 
        ])->findOrFail($id);
    
        return view('client.detail', compact('product'));
    }

    public function getSizesByColor($colorId)
    {
        // Tìm màu theo ID
        $color = Color::find($colorId);

        // Lấy các ProductVariants của màu này
        $productVariants = $color->productVariants;

        // Lấy các kích thước (size) từ các ProductVariants liên quan đến màu này
        $sizes = $productVariants->map(function ($variant) {
            return $variant->size; // Lấy kích thước của từng ProductVariant
        })->unique('id'); // Đảm bảo không trùng lặp kích thước

        // Trả về dữ liệu dưới dạng JSON
        return response()->json(['sizes' => $sizes]);
    }
}
