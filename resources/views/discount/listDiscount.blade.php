@extends('layout.adminDashboard')
@section('content')
<div class="card">
    <div class="card-header">
        <h5 class="card-title">Danh sách mã giảm giá</h5>
        <div class="card-tools">
            <a href="{{ route('discounts.create') }}" class="btn btn-primary btn-sm">
                <i class="fas fa-plus"></i> Thêm mới
            </a>
        </div>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered table-striped text-center">
                <thead>
                    <tr>
                        <th width="5%">ID</th>
                        <th width="20%">Tên</th>
                        <th width="10%">Loại</th>
                        <th width="10%">Giá trị</th>
                        <th width="15%">Ngày bắt đầu</th>
                        <th width="15%">Ngày kết thúc</th>
                        <th width="10%">Trạng thái</th>
                        <th width="15%">Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($discounts as $discount)
                    <tr>
                        <td>{{ $discount->id }}</td>
                        <td>{{ $discount->name }}</td>
                        <td>
                            @if ($discount->type == 'percentage')
                                <span class="badge badge-info">Phần trăm</span>
                            @else
                                <span class="badge badge-primary">Giá tiền</span>
                            @endif
                        </td>
                        <td>
                            @if ($discount->type == 'percentage')
                                {{ $discount->value }}%
                            @else
                                {{ number_format($discount->value, 0, ',', '.') }} đ
                            @endif
                        </td>
                        <td>{{ $discount->start_at ? date('d/m/Y H:i', strtotime($discount->start_at)) : 'Không giới hạn' }}</td>
                        <td>{{ $discount->end_at ? date('d/m/Y H:i', strtotime($discount->end_at)) : 'Không giới hạn' }}</td>
                        <td>
                            @if ($discount->status == 'active')
                                <span class="badge badge-success">Hoạt động</span>
                            @else
                                <span class="badge badge-danger">Không hoạt động</span>
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('discounts.edit', $discount->id) }}" class="btn btn-sm btn-info">
                                <i class="fas fa-edit"></i> Sửa
                            </a>
                            <button type="button" class="btn btn-sm btn-danger delete-btn" data-id="{{ $discount->id }}" data-toggle="modal" data-target="#deleteModal">
                                <i class="fas fa-trash"></i> Xóa
                            </button>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="text-center">Không có dữ liệu</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <!-- After your table -->
        <div class="d-flex justify-content-end mt-3">
            {{ $discounts->links('pagination::bootstrap-5') }}
        </div>
    </div>
</div>

<!-- Modal xóa -->
<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteModalLabel">Xác nhận xóa</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                Bạn có chắc chắn muốn xóa mã giảm giá này không?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Hủy</button>
                <form id="deleteForm" action="{{ route('discounts.destroy', $discount->id) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Xóa</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Cập nhật action của form xóa khi mở modal
        const deleteButtons = document.querySelectorAll('.delete-btn');
        deleteButtons.forEach(button => {
            button.addEventListener('click', function() {
                const id = this.getAttribute('data-id');
                document.getElementById('deleteForm').action = `{{ route('discounts.destroy', '') }}/${id}`;
            });
        });
    });
</script>
@endsection