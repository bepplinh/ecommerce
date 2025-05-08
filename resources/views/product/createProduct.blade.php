@extends('layout.adminDashboard')
@section('content')
    <div class="container mt-4">
        <div class="card">
            <div class="card-body">
                <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data"
                    class="needs-validation" novalidate>
                    @csrf

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="name" class="form-label">Tên sản phẩm</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" name="name"
                                id="name" value="{{ old('name') }}" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label for="code" class="form-label">Mã sản phẩm</label>
                            <input type="text" class="form-control @error('code') is-invalid @enderror" name="code"
                                id="code" value="{{ old('code') }}" required>
                            @error('code')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="category_id" class="form-label">Danh mục</label>
                            <select class="form-select select2-custom @error('category_id') is-invalid @enderror"
                                name="category_id" id="category_id" required>
                                <option value="">-- Chọn danh mục --</option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}"
                                        {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('category_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label for="brand_id" class="form-label">Thương hiệu</label>
                            <select class="form-select select2-custom @error('brand_id') is-invalid @enderror"
                                name="brand_id" id="brand_id" required>
                                <option value="">-- Chọn thương hiệu --</option>
                                @foreach ($brands as $brand)
                                    <option value="{{ $brand->id }}"
                                        {{ old('brand_id') == $brand->id ? 'selected' : '' }}>
                                        {{ $brand->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('brand_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    {{-- Màu - Size - Số lượng --}}
                    <div class="mb-3">
                        <label class="form-label">Màu - Size - Số lượng</label>
                        <div id="variant-list">
                            @if (old('variants'))
                                @foreach (old('variants') as $i => $variant)
                                    <div class="row mb-2 align-items-end variant-item">
                                        <div class="col-md-4">
                                            <select name="variants[{{ $i }}][color_id]" class="form-select"
                                                required>
                                                <option value="">-- Chọn màu --</option>
                                                @foreach ($colors as $color)
                                                    <option value="{{ $color->id }}"
                                                        {{ $variant['color_id'] == $color->id ? 'selected' : '' }}>
                                                        {{ $color->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-4">
                                            <select name="variants[{{ $i }}][size_id]" class="form-select"
                                                required>
                                                <option value="">-- Chọn size --</option>
                                                @foreach ($sizes as $size)
                                                    <option value="{{ $size->id }}"
                                                        {{ $variant['size_id'] == $size->id ? 'selected' : '' }}>
                                                        {{ $size->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-3">
                                            <input type="number" name="variants[{{ $i }}][stock]"
                                                class="form-control" placeholder="Số lượng" value="{{ $variant['stock'] }}"
                                                required>
                                        </div>
                                        <div class="col-md-1 text-end">
                                            <button type="button" class="btn btn-danger btn-remove-variant">
                                                <i class="fas fa-trash-alt"></i>
                                            </button>
                                        </div>
                                    </div>
                                @endforeach
                            @else
                                <div class="row mb-2 align-items-end variant-item">
                                    <div class="col-md-4">
                                        <select name="variants[0][color_id]" class="form-select" required>
                                            <option value="">-- Chọn màu --</option>
                                            @foreach ($colors as $color)
                                                <option value="{{ $color->id }}">{{ $color->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-4">
                                        <select name="variants[0][size_id]" class="form-select" required>
                                            <option value="">-- Chọn size --</option>
                                            @foreach ($sizes as $size)
                                                <option value="{{ $size->id }}">{{ $size->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-3">
                                        <input type="number" name="variants[0][stock]" class="form-control"
                                            placeholder="Số lượng" required>
                                    </div>
                                    <div class="col-md-1 text-end">
                                        <button type="button" class="btn btn-danger btn-remove-variant">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                    </div>
                                </div>
                            @endif
                        </div>

                        <button type="button" class="btn btn-outline-primary" id="btn-add-variant">
                            <i class="fas fa-plus-circle me-1"></i> Thêm biến thể
                        </button>
                    </div>


                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="price" class="form-label">Giá</label>
                            <div class="input-group">
                                <span class="input-group-text">VNĐ</span>
                                <input type="text" class="form-control @error('price') is-invalid @enderror"
                                    name="price" id="price" value="{{ old('price') }}" required>
                            </div>
                            @error('price')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label for="discount_id" class="form-label">Giảm giá</label>
                            <select class="form-select @error('discount_id') is-invalid @enderror" name="discount_id"
                                id="discount_id">
                                <option value="">Không áp dụng giảm giá</option>
                                @foreach ($discounts as $discount)
                                    <option value="{{ $discount->id }}"
                                        {{ old('discount_id') == $discount->id ? 'selected' : '' }}>
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

                    <div class="col-md-6 mb-3">
                        <label for="status" class="form-label">Trạng thái</label>
                        <select class="form-select @error('status') is-invalid @enderror" name="status" id="status">
                            <option value="active" {{ old('status') == 'active' ? 'selected' : '' }}>Hoạt động
                            </option>
                            <option value="inactive" {{ old('status') == 'inactive' ? 'selected' : '' }}>Không hoạt
                                động
                            </option>
                        </select>
                        @error('status')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="description" class="form-label">Mô tả</label>
                        <textarea class="form-control @error('description') is-invalid @enderror" name="description" id="description"
                            rows="3">{{ old('description') }}</textarea>
                        @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>


                    <div class="mb-3">
                        <label for="image" class="form-label">Hình ảnh sản phẩm</label>
                        <input type="file" class="form-control @error('image') is-invalid @enderror" name="image"
                            id="image" accept="image/*" required>
                        <div class="form-text">Chỉ có thể chọn một ảnh. Định dạng: JPG, PNG, GIF</div>
                        <div id="image-preview" class="mt-2">
                            <!-- Preview ảnh sẽ xuất hiện ở đây -->
                        </div>
                        @error('image')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="text-end">
                        <a href="{{ route('products.create') }}" class="btn btn-secondary me-2"
                            onclick="return confirmCancel(event)">
                            <i class="fas fa-times me-1"></i> Hủy
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-1"></i> Tạo sản phẩm
                        </button>
                    </div>
            </div>

                <script>
                    document.getElementById('image').addEventListener('change', function(e) {
                        const preview = document.getElementById('image-preview');
                        preview.innerHTML = ''; // Xóa preview cũ

                        const file = e.target.files[0]; // Chỉ lấy tệp đầu tiên (vì chỉ có thể chọn một ảnh)
                        if (file) {
                            const reader = new FileReader();
                            reader.onload = function(e) {
                                // Tạo một thẻ <img> để hiển thị ảnh đã chọn
                                const img = document.createElement('img');
                                img.src = e.target.result;
                                img.classList.add('img-thumbnail');
                                img.style.width = '150px';
                                img.style.height = '150px';
                                img.style.objectFit = 'cover'; // Đảm bảo ảnh không bị méo

                                // Hiển thị ảnh trong preview
                                preview.appendChild(img);
                            };
                            reader.readAsDataURL(file);
                        }
                    });
                </script>
            </form>
        </div>
    </div>

    <script>
        function confirmCancel(event) {
            event.preventDefault();
            if (confirm('Bạn có chắc chắn muốn hủy?')) {
                window.location.href = event.currentTarget.href;
            }
        }

        const priceInput = document.getElementById('price');
        priceInput.addEventListener('input', function(e) {
            const rawValue = this.value.replace(/\D/g, '');
            this.value = Number(rawValue).toLocaleString('vi-VN');
            this.setSelectionRange(this.value.length, this.value.length);
        });

        let variantIndex = {{ old('variants') ? count(old('variants')) : 1 }};

        document.getElementById('btn-add-variant').addEventListener('click', function() {
            const container = document.getElementById('variant-list');

            const newItem = document.createElement('div');
            newItem.classList.add('row', 'mb-2', 'align-items-end', 'variant-item');
            newItem.innerHTML = `
        <div class="col-md-4">
            <select name="variants[${variantIndex}][color_id]" class="form-select" required>
                <option value="">-- Chọn màu --</option>
                @foreach ($colors as $color)
                    <option value="{{ $color->id }}">{{ $color->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-4">
            <select name="variants[${variantIndex}][size_id]" class="form-select" required>
                <option value="">-- Chọn size --</option>
                @foreach ($sizes as $size)
                    <option value="{{ $size->id }}">{{ $size->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-3">
            <input type="number" name="variants[${variantIndex}][stock]" class="form-control" placeholder="Số lượng" required>
        </div>
        <div class="col-md-1 text-end">
            <button type="button" class="btn btn-danger btn-remove-variant">
                <i class="fas fa-trash-alt"></i>
            </button>
        </div>
        `;
            container.appendChild(newItem);
            variantIndex++;
        });

        document.getElementById('variant-list').addEventListener('click', function(e) {
            if (e.target.closest('.btn-remove-variant')) {
                e.target.closest('.variant-item').remove();
            }
        });
    </script>
@endsection
