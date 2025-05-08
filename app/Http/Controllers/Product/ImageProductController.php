<?php

namespace App\Http\Controllers\Product;

use App\Models\Color;
use App\Models\Product;
use Illuminate\Support\Str;
use App\Models\ProductImage;
use Illuminate\Http\Request;
use App\Models\ProductVariants;
use Illuminate\Routing\Controller;

class ImageProductController extends Controller
{
    public function index()
    {
        $products = Product::with('productVariants.color')->get();
        return view('product.image.index')->with([
            'products' => $products,
            'title' => 'Images For Product',
            'heading' => 'Thêm ảnh cho sản phẩm',
        ]);
    }

    public function edit($productId)
    {
        $product = Product::with('productVariants.color')->findOrFail($productId);

        return view('product.image.edit')->with([
            'product' => $product,
            'title' => 'Images For Product',
            'heading' => 'Thêm ảnh sản phẩm',
        ]);;
    }

    public function create($productVariantId)
    {
        $productVariant = ProductVariants::with('color')->findOrFail($productVariantId);

        return view('product.image.create')->with([
            'productVariant' => $productVariant,
            'title' => 'Thêm ảnh sản phẩm',
            'heading' => 'Thêm ảnh sản phẩm',
        ]);
    }

    public function store(Request $request, $variantId)
    {
        // Xác thực dữ liệu từ request
        $request->validate([
            'images' => 'required|array',
            'images.*' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'main_image' => 'required|string'
        ]);

        // Lấy thông tin ProductVariant
        $productVariant = ProductVariants::findOrFail($variantId);
        $product = $productVariant->product;  // Giả sử ProductVariant có quan hệ với Product
        $color = $productVariant->color;     // Giả sử ProductVariant có quan hệ với Color (Màu)

        // Đường dẫn thư mục lưu ảnh
        $directory = 'product/images/' . $product->name . '/' . $color->name;

        // Xử lý từng file ảnh được upload
        foreach ($request->file('images') as $index => $image) {
            // Tạo tên file theo định dạng yêu cầu
            $fileName = $product->name . '_' . $color->name . '_' . ($index + 1) . '.' . $image->getClientOriginalExtension();

            // Lưu ảnh vào thư mục đúng vị trí
            $path = $image->storeAs(
                $directory,
                $fileName,
                'public'
            );

            // Lưu thông tin vào database
            ProductImage::create([
                'product_variant_id' => $variantId,
                'image_path' => $path,
                'is_main' => ($image->getClientOriginalName() === $request->main_image)  // Đánh dấu ảnh chính
            ]);
        }

        return redirect()->route('admin.product.variant.index', $productVariant->product_id)
            ->with('success', 'Ảnh sản phẩm đã được tải lên thành công!');
    }
}
