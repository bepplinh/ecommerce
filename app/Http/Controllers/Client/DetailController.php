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

        // Nhóm các productVariants theo color
        $colorsWithImages = $product->productVariants->groupBy('color_id')->map(function ($variants) {
            return [
                'color' => $variants->first()->color,
                'images' => $variants->pluck('images')->flatten(),
            ];
        });

        return view('client.detail', compact('product', 'colorsWithImages'));
    }
}
