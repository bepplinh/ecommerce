<!-- resources/views/products/index.blade.php -->
@extends('layout.adminDashboard')

@section('content')
    <div class="container mt-4">
        <div class="card">
            <div class="card-body">
                <h3>Danh sách sản phẩm</h3>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th class="w-10">Mã sản phẩm</th>
                            <th class="w-10">Ảnh</th>
                            <th class="w-10">Tên sản phẩm</th>
                            <th class="w-60">Màu sắc</th>
                            <th class="w-10">Hành động</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($products as $product)
                            <tr>
                                <td class="w-10">{{ $product->code }}</td>
                                <td class="w-10">
                                    @if ($product->image_url)
                                        <img src="{{ asset($product->image_url) }}"
                                            class="img-thumbnail" style="width: 100px; height: 100px;">
                                    @else
                                        <span class="text-muted">Chưa có ảnh</span>
                                    @endif
                                </td>
                                <td class="w-10">{{ $product->name }}</td>
                                <td class="w-60">
                                    @foreach ($product->productVariants as $variant)
                                        <span class="badge" style="background-color: {{ $variant->color->hex_code }}; color: white;">
                                            {{ $variant->color->name }}
                                        </span>
                                    @endforeach
                                </td>
                                <td class="w-10">
                                    <a href="{{ route('productImage.edit', $product->id) }}" class="btn btn-warning btn-sm">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
