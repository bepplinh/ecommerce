@extends('layout.adminDashboard')

@section('content')
<div class="container mt-4" style="max-width: 600px;">
    <div class="d-flex justify-content-end mb-2">
        <a href="{{ route('product.images.index') }}" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left me-1"></i> Quay lại
        </a>
    </div>
    <div class="card shadow-sm border-0">
        <div class="card-header bg-white py-3">
            <div>
                <h5 class="mb-0 text-muted">Tên sản phẩm:</h5>
                <h4 class="mb-0 text-primary">{{ $product->name }}</h4>
                <small class="text-muted">Mã: {{ $product->code }}</small>
            </div>
        </div>
        <div class="card-body">
            <h4 class="mb-3 text-secondary">
                <i class="fas fa-palette mr-2"></i>Chọn màu để thêm ảnh
            </h4>

            <div class="list-group color-variants">
                @php
                    $displayedColors = [];
                @endphp
                @foreach ($product->productVariants as $variant)
                    @if (!in_array($variant->color->name, $displayedColors))
                        <a href="{{ route('product.images.create', $variant->id) }}"
                            class="list-group-item list-group-item-action d-flex align-items-center p-3 mb-2 border">
                            <span class="color-badge mr-3" style="background-color: {{ $variant->color->hex_code }};"></span>
                            <span class="variant-name">{{ $variant->color->name }}</span>
                            <i class="fas fa-arrow-right ml-auto text-muted"></i>
                        </a>
                        @php
                            $displayedColors[] = $variant->color->name;
                        @endphp
                    @endif
                @endforeach
            </div>
            
        </div>
    </div>
</div>

<style>
    .card {
        transition: all 0.3s ease;
        border-radius: 8px;
        margin: 0 auto;
    }

    .card-body {
        padding: 25px;
    }


    .list-group-item {
        border-radius: 6px !important;
        transition: all 0.2s ease-in-out;
    }

    .list-group-item:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        border-left: 4px solid #007bff;
    }

    .color-badge {
        width: 30px;
        height: 30px;
        border-radius: 50%;
        display: inline-block;
        border: 1px solid #e9e9e9;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }

    .variant-name {
        font-weight: 500;
        font-size: 16px;
    }

    .color-variants {
        max-width: 100%;
    }
</style>
@endsection