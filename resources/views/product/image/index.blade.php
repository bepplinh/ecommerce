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
                            <th>Tên sản phẩm</th>
                            <th>Màu sắc</th>
                            <th>Hành động</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($products as $product)
                            <tr>
                                <td>{{ $product->name }}</td>
                                <td>
                                    <!-- Hiển thị tất cả màu sắc của sản phẩm -->
                                    @foreach ($product->productVariants as $variant)
                                        <span class="badge" style="background-color: {{ $variant->color->hex_code }}; color: white;">
                                            {{ $variant->color->name }}
                                        </span>
                                    @endforeach
                                </td>
                                <td>
                                    <!-- Nút chỉnh sửa để hiển thị các màu của sản phẩm -->
                                    <a href="{{ route('productImage.edit', $product->id) }}" class="btn btn-warning btn-sm">Chỉnh sửa</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
