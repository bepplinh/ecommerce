<?php

namespace App\Http\Controllers\Client;

use App\Models\Size;
use App\Models\Brand;
use App\Models\Color;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ShopController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::with(['category', 'brand']);

        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                    ->orWhere('code', 'like', '%' . $request->search . '%')
                    ->orWhereHas('brand', function ($b) use ($request) {
                        $b->where('name', 'like', '%' . $request->search . '%');
                    })
                    ->orWhereHas('category', function ($c) use ($request) {
                        $c->where('name', 'like', '%' . $request->search . '%');
                    });
            });
        }

        if ($request->filled('category')) {
            $category = Category::where('slug', $request->category)->first();
            if ($category) {
                $query->where('category_id', $category->id);
            }
        }
        if ($request->filled('color')) {
            $query->whereHas('productVariants', function ($q) use ($request) {
                $q->where('color_id', $request->color);
            });
        }
        if ($request->filled('brand')) {
            $query->where('brand_id', $request->brand);
        }
        if ($request->filled('size')) {
            $query->whereHas('productVariants', function ($q) use ($request) {
                $q->where('size_id', $request->size);
            });
        }
        if ($request->filled('price_min') && $request->filled('price_max')) {
            $query->whereBetween('price', [$request->price_min, $request->price_max]);
        } elseif ($request->filled('price_min')) {
            $query->where('price', '>=', $request->price_min);
        } elseif ($request->filled('price_max')) {
            $query->where('price', '<=', $request->price_max);
        }
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        if ($request->filled('stock')) {
            $query->whereHas('sizes', function ($q) {
                $q->where('stock', '>', 0);
            });
        }
        if ($request->filled('rating')) {
            $query->whereHas('reviews', function ($q) use ($request) {
                $q->where('rating', '>=', $request->rating);
            });
        }

        switch ($request->sort) {
            case 'name_asc':
                $query->orderBy('name', 'asc');
                break;
            case 'name_desc':
                $query->orderBy('name', 'desc');
                break;
            case 'price_asc':
                $query->orderBy('price', 'asc');
                break;
            case 'price_desc':
                $query->orderBy('price', 'desc');
                break;
            case 'newest':
                $query->orderBy('created_at', 'desc');
                break;
            case 'oldest':
                $query->orderBy('created_at', 'asc');
                break;
            default:
                $query->orderBy('created_at', 'desc');
        }

        // Paginate 1 lần duy nhất
        $products = $query->paginate(18)->withQueryString();

        $categories = Category::get();
        $brands = Brand::get();
        $sizes = Size::get();
        $colors = Color::all();

        return view('client.shop', [
            'products' => $products,
            'categories' => $categories,
            'brands' => $brands,
            'sizes' => $sizes,
            'colors' => $colors,
            'title' => 'Shop',
        ]);
    }
}
