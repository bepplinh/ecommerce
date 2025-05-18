{{-- filepath: /Applications/XAMPP/xamppfiles/htdocs/ecommerce/ecommerce/resources/views/order/order.blade.php --}}
@extends('layout.adminDashboard')

@section('content')
<style>
    /* Table Styles */
.table-order {
    background: #fff;
    border-radius: 10px;
    overflow: hidden;
    box-shadow: 0 2px 8px rgba(0,0,0,0.06);
    margin-bottom: 30px;
}

.table-order th, .table-order td {
    vertical-align: middle !important;
    text-align: center;
    padding: 14px 10px;
}

.table-order th {
    background: #f5f6fa;
    color: #333;
    font-weight: 600;
    border-bottom: 2px solid #eaeaea;
}

.table-order tr {
    transition: background 0.2s;
}

.table-order tbody tr:hover {
    background: #f0f8ff;
}

.table-order .badge {
    font-size: 0.95em;
    padding: 6px 14px;
    border-radius: 20px;
}

.table-order .btn-outline-info {
    border-radius: 20px;
    padding: 4px 18px;
    font-size: 0.95em;
    transition: background 0.2s, color 0.2s;
}

.table-order .btn-outline-info:hover {
    background: #17a2b8;
    color: #fff;
}

/* Section Title */
.order-title {
    font-size: 2rem;
    font-weight: 700;
    margin-bottom: 24px;
    color: #22223b;
    letter-spacing: 1px;
}

/* Responsive */
@media (max-width: 768px) {
    .table-order th, .table-order td {
        padding: 10px 4px;
        font-size: 0.95em;
    }
    .order-title {
        font-size: 1.3rem;
    }
}
</style>
<main class="pt-90">
    <section class="container-fluid px-0">
        <div class="table-responsive">
            <table class="table table-bordered align-middle table-order">
                <thead>
                    <tr>
                        <th>Mã đơn</th>
                        <th>Ngày đặt</th>
                        <th>Trạng thái</th>
                        <th>Tổng tiền</th>
                        <th>Chi tiết</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>#1001</td>
                        <td>15/05/2025 14:30</td>
                        <td><span class="badge bg-warning">Chờ xác nhận</span></td>
                        <td>1.200.000 ₫</td>
                        <td>
                            <a href="#" class="btn btn-sm btn-outline-info">Xem</a>
                        </td>
                    </tr>
                    <tr>
                        <td>#1000</td>
                        <td>10/05/2025 09:10</td>
                        <td><span class="badge bg-success">Hoàn thành</span></td>
                        <td>850.000 ₫</td>
                        <td>
                            <a href="#" class="btn btn-sm btn-outline-info">Xem</a>
                        </td>
                    </tr>
                    <tr>
                        <td>#0999</td>
                        <td>01/05/2025 17:45</td>
                        <td><span class="badge bg-danger">Đã hủy</span></td>
                        <td>2.000.000 ₫</td>
                        <td>
                            <a href="#" class="btn btn-sm btn-outline-info">Xem</a>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </section>
</main>
@endsection