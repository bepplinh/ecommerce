<?php

namespace App\Http\Controllers\Product;

use App\Models\Color;
use App\Models\Product;
use App\Models\ProductVariants;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class ImageProductController extends Controller
{
    public function index()
    {
        $products = Product::with('productVariants.color')->get();
        return view('product.image.index')->with([
            'products' => $products,
            'title' => 'Thêm ảnh sản phẩm',
            'heading' => 'Thêm ảnh sản phẩm',
        ]);
    }

    public function edit($productId)
    {
        $product = Product::with('productVariants.color')->findOrFail($productId);

        return view('product.image.edit')->with([
            'product' => $product,
            'title' => 'Thêm ảnh sản phẩm',
            'heading' => 'Thêm ảnh sản phẩm',
        ]);;
    }

    public function showImageColor($id)  
    {
        $product = Product::findOrFail($id);
        return view('product.image.listImageColor')->with([
            'product' => $product,
            'title' => 'Thêm ảnh sản phẩm',
            'heading' => 'Thêm ảnh sản phẩm',
        ]);
    }

    public function create($productVariantId)
    {
        // Lấy product variant theo ID
        $productVariant = ProductVariants::with('color')->findOrFail($productVariantId);
        
        // Truyền vào view
        return view('product.image.create')->with([
            'productVariant' => $productVariant,
            'title' => 'Thêm ảnh sản phẩm',
            'heading' => 'Thêm ảnh sản phẩm',
        ]);
    }
}
