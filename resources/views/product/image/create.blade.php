@extends('layout.adminDashboard')

@section('content')
    <div class="container mt-4">
        <div class="card">
            <div class="card-body">
                <h3>Thêm ảnh cho biến thể sản phẩm</h3>

                <form action="" method="POST" enctype="multipart/form-data">
                    @csrf

                    <!-- Hiển thị màu sắc của biến thể -->
                    <div class="mb-3">
                        <label for="nameProduct" class="form-label">Tên sản phẩm: {{$productVariant->product->name}}</label>
                        <br>
                        <label for="color" class="form-label">Màu: {{ $productVariant->color->name }}</label>
                    </div>

                    <!-- Chọn nhiều ảnh -->
                    <div class="mb-3">
                        <label for="images" class="form-label">Chọn ảnh cho màu {{ $productVariant->color->name }}</label>
                        <input type="file" class="form-control" name="images[]" id="images" multiple accept="image/*" required>
                        <div class="form-text">Có thể chọn nhiều ảnh. Định dạng: JPG, PNG, GIF</div>
                    </div>

                    <!-- Nút submit -->
                    <button type="submit" class="btn btn-primary">Thêm ảnh</button>
                </form>
            </div>
        </div>
    </div>
@endsection
