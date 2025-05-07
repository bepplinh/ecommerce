@extends('layout.adminDashboard')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="card w-90 mx-auto" style="width: 90%;">
                <div class="card-header d-flex align-items-center">
                    <h5 class="mb-0">Chỉnh sửa mã giảm giá</h5>
                    <a class="btn btn-secondary ms-auto" href="{{ route('discounts.index') }}">
                        <i class="fas fa-list me-1"></i> Danh sách mã giảm giá
                    </a>
                </div>

                <div class="card-body">
                    <form action="{{ route('discounts.update', $discount->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="row">
                            <div class="col-md-5">
                                <div class="form-group">
                                    <label for="name">Tên mã giảm giá <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('name') is-invalid @enderror" id="name"
                                        name="name" value="{{ old('name', $discount->name) }}" required>
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
                                                value="percentage" {{ old('type', $discount->type) == 'percentage' ? 'checked' : '' }}>
                                            <label class="form-check-label" for="type_percentage">Phần trăm (%)</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="type" id="type_fixed"
                                                value="fixed" {{ old('type', $discount->type) == 'fixed' ? 'checked' : '' }}>
                                            <label class="form-check-label" for="type_fixed">Số tiền cố định (VNĐ)</label>
                                        </div>
                                    </div>
                                    @error('type')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="value">Giá trị <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <input type="text" 
                                            class="form-control @error('value') is-invalid @enderror" 
                                            id="value" 
                                            name="value"
                                            value="{{ old('value', $discount->value) }}" 
                                            required>
                                    </div>
                                    @error('value')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <small id="percentage-note" class="form-text text-muted">Nhập giá trị từ 0 đến 100%</small>
                                    <small id="fixed-note" class="form-text text-muted d-none">Nhập số tiền giảm giá</small>
                                </div>
                            </div>

                            <div class="col-md-2"></div>

                            <div class="col-md-5">
                                <div class="form-group">
                                    <label for="start_at">Ngày bắt đầu</label>
                                    <input type="datetime-local" class="form-control @error('start_at') is-invalid @enderror"
                                        id="start_at" name="start_at" 
                                        value="{{ old('start_at', $discount->start_at ? date('Y-m-d\TH:i', strtotime($discount->start_at)) : '') }}">
                                    @error('start_at')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <small class="form-text text-muted">Để trống nếu không có giới hạn thời gian bắt đầu</small>
                                </div>

                                <div class="form-group">
                                    <label for="end_at">Ngày kết thúc</label>
                                    <input type="datetime-local" class="form-control @error('end_at') is-invalid @enderror"
                                        id="end_at" name="end_at" 
                                        value="{{ old('end_at', $discount->end_at ? date('Y-m-d\TH:i', strtotime($discount->end_at)) : '') }}">
                                    @error('end_at')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <small class="form-text text-muted">Để trống nếu không có giới hạn thời gian kết thúc</small>
                                </div>

                                <div class="form-group">
                                    <label for="status">Trạng thái</label>
                                    <select class="form-control @error('status') is-invalid @enderror" id="status" name="status">
                                        <option value="active" {{ old('status', $discount->status) == 'active' ? 'selected' : '' }}>
                                            Hoạt động
                                        </option>
                                        <option value="inactive" {{ old('status', $discount->status) == 'inactive' ? 'selected' : '' }}>
                                            Không hoạt động
                                        </option>
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
                                <button type="submit" class="btn btn-primary px-4">Cập nhật</button>
                                <a href="{{ route('discounts.index') }}" class="btn btn-secondary ms-2">Hủy</a>
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
    const percentageNote = document.getElementById('percentage-note');
    const fixedNote = document.getElementById('fixed-note');

    // Hàm cập nhật hiển thị thông báo
    function updateNote() {
        if (typePercentage.checked) {
            // Nếu chọn "percentage", hiển thị thông báo phần trăm
            percentageNote.classList.remove('d-none');
            fixedNote.classList.add('d-none');
        } else if (typeFixed.checked) {
            // Nếu chọn "fixed", hiển thị thông báo số tiền
            percentageNote.classList.add('d-none');
            fixedNote.classList.remove('d-none');
        }
    }

    // Lần đầu khi load trang, gọi hàm cập nhật thông báo
    updateNote();

    // Thêm sự kiện thay đổi khi chọn type giảm giá
    typePercentage.addEventListener('change', updateNote);
    typeFixed.addEventListener('change', updateNote);
});

</script>

@endsection