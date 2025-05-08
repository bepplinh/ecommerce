<!-- resources/views/products/edit.blade.php -->
@extends('layout.adminDashboard')

@section('content')
    <div class="container mt-4">
        <div class="card">
            <div class="card-body">
                <h3>Chỉnh sửa sản phẩm - {{ $product->name }}</h3>

                <h4>Chọn màu để thêm ảnh</h4>
                <div class="list-group">
                    @foreach ($product->productVariants as $variant)
                        <a href="{{ route('product.images.create', $variant->id) }}" class="list-group-item list-group-item-action">
                            <span class="badge" style="background-color: {{ $variant->color->hex_code }}; color: white;">
                                {{ $variant->color->name }}
                            </span>
                        </a>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@endsection
