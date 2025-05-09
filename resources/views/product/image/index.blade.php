<!-- resources/views/products/index.blade.php -->
@extends('layout.adminDashboard')

@section('content')
    <div class="container mt-4">
        <div class="card">
            <div class="card-body">
                <h3>Danh sách sản phẩm</h3>
                <table class="table table-bordered text-center align-middle">
                    <thead>
                        <tr>
                            <th class="w-10 align-middle">Mã sản phẩm</th>
                            <th class="w-10 align-middle">Ảnh</th>
                            <th class="w-10 align-middle">Tên sản phẩm</th>
                            <th class="w-60 align-middle">Màu sắc</th>
                            <th class="w-10 align-middle">Hành động</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($products as $product)
                            <tr>
                                <td class="w-10 align-middle">{{ $product->code }}</td>
                                <td class="w-10 align-middle">
                                    @if ($product->image_url)
                                        <img src="{{ asset($product->image_url) }}"
                                            class="img-thumbnail" style="width: 100px; height: 100px; object-fit: cover;">
                                    @else
                                        <span class="text-muted">Chưa có ảnh</span>
                                    @endif
                                </td>
                                <td class="w-10 align-middle">{{ $product->name }}</td>
                                <td class="w-60 align-middle">
                                    @php
                                        $displayedColors = [];
                                    @endphp
                                    @foreach ($product->productVariants as $variant)
                                        @if (!in_array($variant->color->name, $displayedColors))
                                            <span class="badge" style="background-color: {{ $variant->color->hex_code }}; color: white;">
                                                {{ $variant->color->name }}
                                            </span>
                                            @php
                                                $displayedColors[] = $variant->color->name;
                                            @endphp
                                        @endif
                                    @endforeach
                                </td>
                                <td class="w-10 align-middle">
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
