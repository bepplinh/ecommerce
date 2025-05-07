@extends('layout.adminDashboard')
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="card w-90 mx-auto" style="width: 90%;">
                <div class="card-header d-flex align-items-center">
                    <h5 class="mb-0">Thêm mã giảm giá mới</h5>
                    <a class="btn btn-secondary ms-auto" href="{{ route('discounts.index') }}">
                        <i class="fas fa-list me-1"></i> List Discounts
                    </a>
                </div>
                
                <div class="card-body">
                    <form action="{{ route('discounts.store') }}" method="POST">
                        @csrf

                        <div class="row">
                            <!-- Cột bên trái -->
                            <div class="col-md-5">
                                <div class="form-group">
                                    <label for="name">Tên mã giảm giá <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('name') is-invalid @enderror" id="name"
                                        name="name" value="{{ old('name') }}" required>
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <small class="form-text text-muted">Tên mã giảm giá phải là duy nhất</small>
                                </div>

                                <div class="form-group">
                                    <label for="type">Loại giảm giá <span class="text-danger">*</span></label>
                                    <div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="type" id="type_percentage"
                                                value="percentage" {{ old('type') == 'percentage' ? 'checked' : '' }} checked>
                                            <label class="form-check-label" for="type_percentage">Phần trăm (%)</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="type" id="type_fixed"
                                                value="fixed" {{ old('type') == 'fixed' ? 'checked' : '' }}>
                                            <label class="form-check-label" for="type_fixed">Số tiền cố định (VNĐ)</label>
                                        </div>
                                    </div>
                                    @error('type')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="value">Giá trị <span class="text-danger">*</span></label>
                                    <!-- Change the input type from number to text -->
                                    <div class="input-group">
                                        <input type="text" 
                                               class="form-control @error('value') is-invalid @enderror" 
                                               id="value" 
                                               name="value"
                                               value="{{ old('value') }}" 
                                               required>
                                        <div class="input-group-append">
                                            <span class="input-group-text" id="value-addon">%</span>
                                        </div>
                                    </div>
                                    
                                    
                                    @error('value')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <small id="percentage-note" class="form-text text-muted">Nhập giá trị từ 0 đến 100%</small>
                                    <small id="fixed-note" class="form-text text-muted d-none">Nhập số tiền giảm giá</small>
                                </div>
                            </div>

                            <!-- Khoảng trống giữa -->
                            <div class="col-md-2"></div>

                            <!-- Cột bên phải -->
                            <div class="col-md-5">
                                <div class="form-group">
                                    <label for="start_at">Ngày bắt đầu</label>
                                    <input type="datetime-local" class="form-control @error('start_at') is-invalid @enderror"
                                        id="start_at" name="start_at" value="{{ old('start_at') }}">
                                    @error('start_at')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <small class="form-text text-muted">Để trống nếu không có giới hạn thời gian bắt đầu</small>
                                </div>

                                <div class="form-group">
                                    <label for="end_at">Ngày kết thúc</label>
                                    <input type="datetime-local" class="form-control @error('end_at') is-invalid @enderror"
                                        id="end_at" name="end_at" value="{{ old('end_at') }}">
                                    @error('end_at')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <small class="form-text text-muted">Để trống nếu không có giới hạn thời gian kết thúc</small>
                                </div>

                                <div class="form-group">
                                    <label for="status">Trạng thái</label>
                                    <select class="form-control @error('status') is-invalid @enderror" id="status"
                                        name="status">
                                        <option value="active" {{ old('status') == 'active' ? 'selected' : '' }}>Hoạt động</option>
                                        <option value="inactive" {{ old('status') == 'inactive' ? 'selected' : '' }}>Không hoạt
                                            động</option>
                                    </select>
                                    @error('status')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Nút submit và cancel -->
                        <div class="row mt-4">
                            <div class="col-12 text-center">
                                <button type="submit" class="btn btn-primary px-4">Thêm mới</button>
                                <a href="{{ route('discounts.index') }}" class="btn btn-secondary ml-2">Hủy</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const typePercentage = document.getElementById('type_percentage');
            const typeFixed = document.getElementById('type_fixed');
            const valueAddon = document.getElementById('value-addon');
            const percentageNote = document.getElementById('percentage-note');
            const fixedNote = document.getElementById('fixed-note');
            const valueInput = document.getElementById('value');
    
            function formatNumberInput(value) {
                if (!value) return '';
                // Remove all non-digits
                value = value.replace(/\D/g, '');
                // Format with thousand separator
                return value.replace(/\B(?=(\d{3})+(?!\d))/g, '.');
            }
    
            function updateValueType() {
                if (typePercentage.checked) {
                    // Khi chọn loại phần trăm
                    valueAddon.textContent = '%';
                    percentageNote.classList.remove('d-none');
                    fixedNote.classList.add('d-none');
                    valueInput.setAttribute('max', '100');
                    valueInput.setAttribute('step', '0.01');
                    valueInput.value = valueInput.value.replace(/\./g, '');
                } else {
                    // Khi chọn loại số tiền cố định
                    valueAddon.textContent = 'VNĐ';
                    percentageNote.classList.add('d-none');
                    fixedNote.classList.remove('d-none');
                    valueInput.removeAttribute('max');
                    valueInput.setAttribute('step', '1000');
                    valueInput.value = formatNumberInput(valueInput.value);
                }
            }
    
            valueInput.addEventListener('input', function() {
                if (typePercentage.checked) {
                    let value = this.value.replace(/\D/g, '');
                    if (parseFloat(value) > 100) {
                        this.value = '100';
                    }
                } else {
                    this.value = formatNumberInput(this.value);
                }
            });
    
            // Add this function to prepare the value before form submission
            document.querySelector('form').addEventListener('submit', function(e) {
                if (typeFixed.checked) {
                    valueInput.value = valueInput.value.replace(/\./g, '');
                }
            });
    
            typePercentage.addEventListener('change', updateValueType);
            typeFixed.addEventListener('change', updateValueType);
    
            // Run once on page load
            updateValueType();
    
            // Validate input khi thay đổi
            valueInput.addEventListener('input', function() {
                if (typePercentage.checked && parseFloat(this.value) > 100) {
                    this.value = '100';
                }
            });
        });
    </script>
@endsection
