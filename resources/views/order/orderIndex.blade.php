@extends('layout.adminDashboard')

@push('styles')
<link rel="stylesheet" href="{{ asset('/css/order/orderIndex.css') }}">
@endpush
@section('content')
<main>
  <form method="GET" action="{{ route('order.admin.manage') }}" class="header-row">
    <input type="text" name="q" id="search" class="search-input" value="{{ request('q') }}" placeholder="Search orders..." aria-label="Search orders" />
    <select name="payment_method" class="form-select ms-2" style="max-width:160px;">
        <option value="">Tất cả phương thức</option>
        <option value="cod" {{ request('payment_method')=='cod'?'selected':'' }}>COD</option>
        <option value="payos" {{ request('payment_method')=='payos'?'selected':'' }}>PayOS</option>
        <option value="vnpay" {{ request('payment_method')=='vnpay'?'selected':'' }}>VNPay</option>
    </select>
    <select name="status" class="form-select ms-2" style="max-width:160px;">
        <option value="">Tất cả trạng thái</option>
        <option value="pending" {{ request('status')=='pending'?'selected':'' }}>Pending</option>
        <option value="processing" {{ request('status')=='processing'?'selected':'' }}>Processing</option>
        <option value="completed" {{ request('status')=='completed'?'selected':'' }}>Completed</option>
        <option value="cancelled" {{ request('status')=='cancelled'?'selected':'' }}>Cancelled</option>
    </select>
    <button type="submit" class="btn btn-primary ms-2">Search</button>
    <a href="{{ route('order.admin.manage') }}" class="btn btn-secondary ms-2">Đặt lại</a>
  </form>
  <div class="table-container" role="region" aria-label="Order management table">
    <table>
      <thead>
        <tr>
          <th>Order Code</th>
          <th>Customer</th>
          <th>Phone</th>
          <th>Date</th>
          <th>Status</th>
          <th>Total</th>
          <th>Payment Method</th>
          <th>Payment Status</th>
          <th>Action</th>
        </tr>
      </thead>
      <tbody id="orderTableBody">
        @foreach($orders as $order)
        <tr>
          <td data-label="Order Code">#{{ $order->order_code }}</td>
          <td data-label="Customer">{{ $order->shippingAddress->full_name ?? '' }}</td>
          <td data-label="Phone">{{ $order->shippingAddress->phone ?? '' }}</td>
          <td data-label="Date">{{ $order->created_at->format('Y-m-d H:i') }}</td>
          <td data-label="Status">
            @if($order->status == 'pending')
              <span class="status pending">Pending</span>
            @elseif($order->status == 'processing')
              <span class="status processing">Processing</span>
            @elseif($order->status == 'completed')
              <span class="status completed">Completed</span>
            @elseif($order->status == 'cancelled')
              <span class="status cancelled">Cancelled</span>
            @else
              <span class="status">{{ ucfirst($order->status) }}</span>
            @endif
          </td>
          <td data-label="Total">{{ number_format($order->total_amount) }} ₫</td>
          <td data-label="Payment Method">
            @if($order->payment_method == 'payos')
              <span class="status payos">PayOS</span>
            @elseif($order->payment_method == 'cod')
              <span class="status cod">COD</span>
            @elseif($order->payment_method == 'vnpay')
              <span class="status vnpay">VNPay</span>
            @else
              <span class="status">{{ ucfirst($order->payment_method) }}</span>
            @endif
          </td>
          <td data-label="Payment Status">
            @if($order->payment_status == 'paid')
              <span class="status paid">Paid</span>
            @elseif($order->payment_status == 'unpaid')
              <span class="status unpaid">Unpaid</span>
            @elseif($order->payment_status == 'failed')
              <span class="status failed">Failed</span>
            @else
              <span class="status">{{ ucfirst($order->payment_status) }}</span>
            @endif
          </td>
          <td data-label="Action">
            <a href="{{ route('order.admin.detail', $order->id) }}" class="action-btn">View</a>
          </td>
        </tr>
        @endforeach
      </tbody>
    </table>
    <div class="d-flex justify-content-center mt-3">
        {{ $orders->links() }}
    </div>
  </div>
</main>
@endsection