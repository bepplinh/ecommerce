<?php

namespace App\Http\Controllers\Product;

use App\Models\Size;
use App\Models\Brand;
use App\Models\Color;
use App\Models\Product;
use App\Models\Category;
use App\Models\Discount;
use Illuminate\Support\Str;
use App\Models\ProductImage;
use Illuminate\Http\Request;
use App\Models\ProductVariants;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\Product\CreateProductRequest;
use App\Http\Requests\Product\UpdateProductRequest;

class ProductController extends Controller
{
    public function index(Request $request)
    {

        $query = Product::query();

        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('code', 'like', "%{$search}%");
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
                $query->latest();
                break;
        }

        $products = $query->with(['productVariants.color', 'productVariants.size'])
            ->paginate(10)
            ->withQueryString();
        return view('product.listProduct')->with([
            'products' => $products,
            'title' => 'Product List',
            'heading' => 'Product List',
        ]);
    }

    public function create()
    {
        $categories = Category::all();
        $brands = Brand::all();
        $sizes = Size::all();
        $colors = Color::all();
        $discounts = Discount::all();
        return view('product.createProduct')->with([
            'categories' => $categories,
            'brands' => $brands,
            'sizes' => $sizes,
            'colors' => $colors,
            'discounts' => $discounts,
            'title' => 'Create Product',
            'heading' => 'Add New Product',
        ]);
    }

    public function store(CreateProductRequest $request)
    {

        $request->validated();

        $productCode = $request->code;
        $productName = $request->name;

        $imageName = $productCode . '_' . Str::slug($productName) . '.' . $request->file('image')->getClientOriginalExtension();


        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->storeAs('product/thumbnail', $imageName, 'public');
        }

        $product = Product::create([
            'name' => $request->name,
            'code' => $request->code,
            'description' => $request->description,
            'price' => (int) str_replace(['.', ','], '', $request->price),
            'status' => $request->status,
            'category_id' => $request->category_id,
            'brand_id' => $request->brand_id,
            'image_url' => $imagePath ? Storage::url($imagePath) : null,
        ]);

        foreach ($request->variants as $variant) {
            ProductVariants::create([
                'product_id' => $product->id,
                'color_id' => $variant['color_id'],
                'size_id' => $variant['size_id'],
                'stock' => $variant['stock'],
            ]);
        }

        return redirect()->back()->with('toastr', [
            'status' => 'success',
            'message' => 'Create Product Successfully!',
        ]);
    }

    public function edit($id)
    {
        $product = Product::findOrFail($id);
        $sizes = Size::all();
        $colors = Color::all();
        $categories = Category::all();
        $brands = Brand::all();
        $discounts = Discount::all();

        return view('product.editProduct')->with([
            'product' => $product,
            'sizes' => $sizes,
            'colors' => $colors,
            'categories' => $categories,
            'brands' => $brands,
            'discounts' => $discounts,
            'title' => 'Edit Product',
            'heading' => 'Edit Product',
        ]);
    }

    public function update(UpdateProductRequest $request, $id)
    {
        $request->validated();
        $product = Product::findOrFail($id);

        if ($request->hasFile('image')) {
            $productCode = $request->code;
            $productName = $request->name;

            $imageName = $productCode . '_' . Str::slug($productName) . '.' . $request->file('image')->getClientOriginalExtension();
            if ($product->image_url && Storage::exists('public/product/thumbnail/' . basename($product->image_url))) {
                Storage::delete('public/product/thumbnail/' . basename($product->image_url));
            }
            $imagePath = $request->file('image')->storeAs('product/thumbnail', $imageName, 'public');
            $product->image_url = Storage::url($imagePath);
        }

        $product->name = $request->name;
        $product->code = $request->code;
        $product->description = $request->description;
        $product->price = (int) str_replace(['.', ','], '', $request->price);
        $product->status = $request->status;
        $product->category_id = $request->category_id;
        $product->brand_id = $request->brand_id;
        $product->save();

        if ($request->has('variants')) {
            foreach ($request->variants as $variant) {
                if (!empty($variant['id'])) {
                    $productVariant = ProductVariants::find($variant['id']);
                    if ($productVariant) {
                        $productVariant->update([
                            'color_id' => $variant['color_id'],
                            'size_id' => $variant['size_id'],
                            'stock' => $variant['stock'],
                        ]);
                    }
                } else {
                    ProductVariants::create([
                        'product_id' => $product->id,
                        'color_id' => $variant['color_id'],
                        'size_id' => $variant['size_id'],
                        'stock' => $variant['stock'],
                    ]);
                }
            }
        }

        if ($request->has('deleted_variants')) {
            foreach ($request->deleted_variants as $variantId) {
                ProductVariants::where('id', $variantId)->delete();
            }
        }

        return redirect()->route('products.index')->with('toastr', [
            'status' => 'success',
            'message' => 'Product updated successfully',
        ]);
    }

    public function destroy(Product $product)
    {
        $product = Product::findOrFail($product->id);
        $product->delete();
        return redirect()->back()->with('toastr', [
            'status' => 'success',
            'message' => 'Product deleted successfully',
        ]);
    }

    public function deleteImage($id)
    {
        $image = ProductImage::findOrFail($id);
        $oldImagePath = public_path($image->image_path);
        if (file_exists($oldImagePath)) {
            unlink($oldImagePath);
        }
        $image->delete();
        return redirect()->back()->with('toastr', [
            'status' => 'success',
            'message' => 'Image deleted successfully',
        ]);
    }
}
