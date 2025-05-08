@extends('layout.adminDashboard')
@section('content')
<div class="container mt-4">
    <div class="card shadow-sm">
        <div class="card-header bg-light d-flex justify-content-between align-items-center">
            <h5 class="mb-0">
                <i class="fas fa-edit me-2"></i>Chỉnh sửa sản phẩm
            </h5>
            <a href="{{ route('products.index') }}" class="btn btn-outline-secondary">
                <i class="fas fa-arrow-left me-1"></i> Quay lại
            </a>
        </div>
        <div class="card-body">
            <form action="{{ route('products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="row g-3">
                    <!-- Thông tin cơ bản -->
                    <div class="col-md-8">
                        <div class="card h-100">
                            <div class="card-header bg-white">
                                <h6 class="card-title mb-0">Thông tin cơ bản</h6>
                            </div>
                            <div class="card-body">
                                <div class="row g-3">
                                    <!-- Mã sản phẩm -->
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="code" class="form-label">Mã sản phẩm <span
                                                    class="text-danger">*</span></label>
                                            <input type="text" class="form-control @error('code') is-invalid @enderror"
                                                id="code" name="code" value="{{ old('code', $product->code) }}"
                                                required>
                                            @error('code')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <!-- Tên sản phẩm -->
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="name" class="form-label">Tên sản phẩm <span
                                                    class="text-danger">*</span></label>
                                            <input type="text" class="form-control @error('name') is-invalid @enderror"
                                                id="name" name="name" value="{{ old('name', $product->name) }}"
                                                required>
                                            @error('name')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <!-- Giá -->
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="price" class="form-label">Giá (VNĐ) <span
                                                    class="text-danger">*</span></label>
                                                    <input type="text" class="form-control @error('price') is-invalid @enderror" id="price"
                                                    name="price" value="{{ old('price', number_format($product->price)) }}" required 
                                                    oninput="formatPrice(this)">
                                            @error('price')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <!-- Discount Field -->
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="discount_id" class="form-label">Giảm giá</label>
                                            <select class="form-select @error('discount_id') is-invalid @enderror"
                                                id="discount_id" name="discount_id">
                                                <option value="">-- Chọn giảm giá --</option>
                                                @foreach($discounts as $discount)
                                                <option value="{{ $discount->id }}" {{ old('discount_id', $product->
                                                    discount_id) == $discount->id ? 'selected' : '' }}
                                                    data-type="{{ $discount->type }}"
                                                    data-value="{{ $discount->value }}"
                                                    data-percentage="{{ $discount->percentage }}">
                                                    {{ $discount->name }}
                                                    ({{ $discount->type === 'fixed' ? number_format($discount->value, 0, ',', '.') . ' VNĐ' : $discount->value . '%' }})
                                                </option>
                                                @endforeach
                                            </select>
                                            @error('discount_id')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>


                                    <!-- Danh mục -->
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="category_id" class="form-label">Danh mục <span
                                                    class="text-danger">*</span></label>
                                            <select class="form-select @error('category_id') is-invalid @enderror"
                                                id="category_id" name="category_id" required>
                                                <option value="">-- Chọn danh mục --</option>
                                                @foreach($categories as $category)
                                                <option value="{{ $category->id }}" {{ old('category_id', $product->
                                                    category_id) == $category->id ? 'selected' : '' }}>
                                                    {{ $category->name }}
                                                </option>
                                                @endforeach
                                            </select>
                                            @error('category_id')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <!-- Thương hiệu -->
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="brand_id" class="form-label">Thương hiệu</label>
                                            <select class="form-select @error('brand_id') is-invalid @enderror"
                                                id="brand_id" name="brand_id">
                                                <option value="">-- Chọn thương hiệu --</option>
                                                @foreach($brands as $brand)
                                                <option value="{{ $brand->id }}" {{ old('brand_id', $product->brand_id)
                                                    == $brand->id ? 'selected' : '' }}>
                                                    {{ $brand->name }}
                                                </option>
                                                @endforeach
                                            </select>
                                            @error('brand_id')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <!-- Trạng thái -->
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="status" class="form-label">Trạng thái <span
                                                    class="text-danger">*</span></label>
                                            <select class="form-select @error('status') is-invalid @enderror"
                                                id="status" name="status" required>
                                                <option value="active" {{ old('status', $product->status) == 'active' ?
                                                    'selected' : '' }}>
                                                    Hoạt động
                                                </option>
                                                <option value="inactive" {{ old('status', $product->status) ==
                                                    'inactive' ? 'selected' : '' }}>
                                                    Không hoạt động
                                                </option>
                                            </select>
                                            @error('status')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-12">
                                        <div class="form-group">
                                            <label for="description" class="form-label">Mô tả </label>
                                            <textarea
                                                class="form-control editor @error('description') is-invalid @enderror"
                                                id="description" name="description"
                                                rows="5">{{ old('description', $product->description) }}</textarea>
                                            @error('description')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="mb-3">
                                        <label for="image" class="form-label">Hình ảnh sản phẩm</label>
                                        <input type="file" class="form-control @error('image') is-invalid @enderror" name="image"
                                               id="image" accept="image/*">
                                        <div class="form-text">Chỉ có thể chọn một ảnh. Định dạng: JPG, PNG, GIF</div>
                                    
                                        <div id="image-preview" class="mt-2">
                                            @if($product->image_url)
                                                <div class="current-image" id="current-image">
                                                    <!-- Hiển thị ảnh hiện tại của sản phẩm -->
                                                    <img src="{{ asset($product->image_url) }}" 
                                                         class="img-thumbnail" 
                                                         style="width: 150px; height: 150px; object-fit: cover;">
                                                    <div class="mt-2">
                                                        <small class="text-muted">Ảnh hiện tại</small>
                                                    </div>
                                                </div>
                                            @endif
                                        </div>
                                    
                                        @error('image')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Quản lý biến thể -->
                <div class="card mt-4">
                    <div class="card-header bg-white d-flex justify-content-between align-items-center">
                        <h6 class="card-title mb-0">Biến thể sản phẩm</h6>
                        <button type="button" class="btn btn-sm btn-primary" id="add-variant">
                            <i class="fas fa-plus me-1"></i> Thêm biến thể
                        </button>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered" id="variants-table">
                                <thead class="table-light">
                                    <tr>
                                        <th>Màu sắc</th>
                                        <th>Kích thước</th>
                                        <th>Số lượng</th>
                                        <th>Thao tác</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($product->productVariants as $index => $variant)
                                    <tr class="variant-row">
                                        <td>
                                            <div class="d-flex align-items-center gap-2">
                                                <div class="color-dot"
                                                    style="width: 18px; height: 18px; border-radius: 50%; background-color: {{ $variant->color->hex_code }}; border: 1px solid #ddd;">
                                                </div>
                                                <select name="variants[{{ $index }}][color_id]"
                                                    class="form-select form-select-sm" required>
                                                    @foreach($colors as $color)
                                                    <option value="{{ $color->id }}" {{ $variant->color_id == $color->id
                                                        ? 'selected' : '' }}
                                                        data-hex="{{ $color->hex_code }}">
                                                        {{ $color->name }}
                                                    </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </td>
                                        <td>
                                            <select name="variants[{{ $index }}][size_id]"
                                                class="form-select form-select-sm" required>
                                                @foreach($sizes as $size)
                                                <option value="{{ $size->id }}" {{ $variant->size_id == $size->id ?
                                                    'selected' : '' }}>
                                                    {{ $size->name }}
                                                </option>
                                                @endforeach
                                            </select>
                                        </td>
                                        <td>
                                            <input type="number" name="variants[{{ $index }}][stock]"
                                                class="form-control form-control-sm" value="{{ $variant->stock }}"
                                                required>
                                        </td>
                                        <td class="align-middle">
                                            <button type="button" class="btn btn-sm btn-danger remove-variant">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                            <input type="hidden" name="variants[{{ $index }}][id]"
                                                value="{{ $variant->id }}">
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="d-flex justify-content-end mt-4">
                    <button type="button" class="btn btn-secondary me-2" onclick="history.back()">Hủy</button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-1"></i> Lưu thay đổi
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Update the variant template structure -->
<template id="variant-template">
    <tr class="variant-row">
        <td>
            <div class="d-flex align-items-center gap-2">
                <div class="color-dot"
                    style="width: 18px; height: 18px; border-radius: 50%; background-color: #ffffff; border: 1px solid #ddd;">
                </div>
                <select name="variants[__INDEX__][color_id]" class="form-select form-select-sm color-select" required>
                    <option value="">-- Chọn màu --</option>
                    @foreach($colors as $color)
                    <option value="{{ $color->id }}" data-hex="{{ $color->hex_code }}">{{ $color->name }}</option>
                    @endforeach
                </select>
            </div>
        </td>
        <td>
            <select name="variants[__INDEX__][size_id]" class="form-select form-select-sm" required>
                <option value="">-- Chọn size --</option>
                @foreach($sizes as $size)
                <option value="{{ $size->id }}">{{ $size->name }}</option>
                @endforeach
            </select>
        </td>
        <td>
            <input type="number" name="variants[__INDEX__][stock]" class="form-control form-control-sm" value="0"
                required>
        </td>
        <td>
            <button type="button" class="btn btn-sm btn-danger remove-variant">
                <i class="fas fa-trash"></i>
            </button>
            <input type="hidden" name="variants[__INDEX__][id]" value="">
        </td>
    </tr>
</template>

<!-- Update the JavaScript for adding variants -->
@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        let variantIndex = {{ count($product->productVariants) }};
        
        document.getElementById('add-variant').addEventListener('click', function() {
            const template = document.getElementById('variant-template').innerHTML;
            const newRow = template.replace(/__INDEX__/g, variantIndex);
            document.querySelector('#variants-table tbody').insertAdjacentHTML('beforeend', newRow);
            
            // Initialize color select for the new row
            const newColorSelect = document.querySelector(`#variants-table tbody tr:last-child select[name="variants[${variantIndex}][color_id]"]`);
            newColorSelect.addEventListener('change', function() {
                const hex = this.options[this.selectedIndex].dataset.hex || '#ffffff';
                const dot = this.closest('div').querySelector('.color-dot');
                dot.style.backgroundColor = hex;
            });
            
            variantIndex++;
        });
    });
</script>
@endpush

<script>
    document.getElementById('image').addEventListener('change', function (e) {
        const preview = document.getElementById('image-preview');
        preview.innerHTML = ''; // Xóa ảnh cũ (nếu có)

        const file = e.target.files[0]; // Lấy tệp ảnh đầu tiên
        if (file) {
            const reader = new FileReader();
            reader.onload = function (e) {
                // Tạo phần tử <div> để chứa ảnh và nút xóa
                const div = document.createElement('div');
                div.style.position = 'relative';
                div.style.width = '150px';
                div.style.height = '150px';
                
                // Tạo phần tử <img> để hiển thị ảnh đã chọn
                const img = document.createElement('img');
                img.src = e.target.result;
                img.classList.add('img-thumbnail');
                img.style.width = '100%';
                img.style.height = '100%';
                img.style.objectFit = 'cover'; // Đảm bảo ảnh không bị méo

                // Tạo nút xóa
                const removeButton = document.createElement('div');
                removeButton.innerText = 'X';
                removeButton.style.position = 'absolute';
                removeButton.style.top = '5px';
                removeButton.style.right = '5px';
                removeButton.style.backgroundColor = 'rgba(0, 0, 0, 0.5)';
                removeButton.style.color = '#fff';
                removeButton.style.padding = '5px';
                removeButton.style.borderRadius = '50%';
                removeButton.style.cursor = 'pointer';
                removeButton.style.fontWeight = 'bold';

                // Thêm sự kiện xóa ảnh
                removeButton.addEventListener('click', function () {
                    preview.innerHTML = ''; // Xóa ảnh và nút xóa
                    document.getElementById('image').value = ''; // Reset trường file
                });

                // Thêm ảnh và nút xóa vào div
                div.appendChild(img);
                div.appendChild(removeButton);
                
                // Thêm div vào preview
                preview.appendChild(div);
            };
            reader.readAsDataURL(file); // Đọc ảnh và tạo URL
        }
    });
</script>

<script>
    function formatPrice(input) {
    var value = input.value.replace(/\D/g, '');  // Xóa các ký tự không phải số
    input.value = value.replace(/\B(?=(\d{3})+(?!\d))/g, ",");  // Thêm dấu phẩy sau mỗi 3 chữ số
}
    // Preview hình ảnh chính
    function previewImage(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('preview-image').src = e.target.result;
            }
            reader.readAsDataURL(input.files[0]);
        }
    }

    document.addEventListener('DOMContentLoaded', function() {
    let variantIndex = {{ count($product->productVariants) }};

    // Xử lý thêm biến thể
    document.getElementById('add-variant').addEventListener('click', function() {
        const template = document.getElementById('variant-template').innerHTML;
        const newRow = template.replace(/__INDEX__/g, variantIndex);
        document.querySelector('#variants-table tbody').insertAdjacentHTML('beforeend', newRow);

        // Cập nhật dot màu khi chọn màu
        const newColorSelect = document.querySelector('#variants-table tbody tr:last-child .color-select');
        newColorSelect.addEventListener('change', updateColorDot);
        
        variantIndex++;
    });

    // Cập nhật dot màu
    function updateColorDot() {
        const hex = this.options[this.selectedIndex].dataset.hex || '#ffffff';
        const dot = this.closest('div').querySelector('.color-dot');
        dot.style.backgroundColor = hex;
    }

    // Thêm sự kiện cho tất cả các select màu hiện có (Event delegation)
    document.querySelector('#variants-table').addEventListener('change', function(e) {
        if (e.target.classList.contains('color-select')) {
            updateColorDot.call(e.target);
        }
    });

    // Xóa biến thể
    document.querySelector('#variants-table').addEventListener('click', function(e) {
        if (e.target.classList.contains('remove-variant') || e.target.closest('.remove-variant')) {
            if (confirm('Bạn có chắc chắn muốn xóa biến thể này?')) {
                const row = e.target.closest('.variant-row');
                row.remove();
            }
        }
    });

    // TinyMCE cho editor
    if (typeof tinymce !== 'undefined') {
        tinymce.init({
            selector: '.editor',
            height: 300,
            plugins: 'advlist autolink lists link image charmap preview anchor searchreplace visualblocks code fullscreen insertdatetime media table paste help wordcount',
            toolbar: 'undo redo | formatselect | bold italic backcolor | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | removeformat | help',
        });
    }

    });

</script>

@endsection