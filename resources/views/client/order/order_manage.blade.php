@extends('layout.clientApp')
@section('content')
<div class="container mt-4">
    <h3>Your Orders</h3>
    @if($orders->count())
        <div class="table-responsive">
            <table class="table table-bordered align-middle">
                <thead>
                    <tr>
                        <th>Order Code</th>
                        <th>Order Date</th>
                        <th>Status</th>
                        <th>Total Amount</th>
                        <th>Shipping Address</th>
                        <th>Details</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($orders as $order)
                    <tr>
                        <td>{{ $order->order_code }}</td>
                        <td>{{ $order->created_at->format('d/m/Y H:i') }}</td>
                        <td>
                            @if($order->status == 'pending')
                                <span class="badge bg-warning text-dark">Pending</span>
                            @elseif($order->status == 'completed')
                                <span class="badge bg-success">Completed</span>
                            @elseif($order->status == 'cancelled')
                                <span class="badge bg-danger">Cancelled</span>
                            @else
                                <span class="badge bg-secondary">{{ $order->status }}</span>
                            @endif
                        </td>
                        <td>{{ number_format($order->total_amount) }} đ</td>
                        <td>
                            {{ $order->shippingAddress->full_name ?? '' }}<br>
                            {{ $order->shippingAddress->phone ?? '' }}<br>
                            {{ $order->shippingAddress->house_number ?? '' }}, {{ $order->shippingAddress->street ?? '' }}, {{ $order->shippingAddress->ward ?? '' }}, {{ $order->shippingAddress->district ?? '' }}, {{ $order->shippingAddress->city ?? '' }}
                        </td>
                        <td>
                            <a href="{{ route('order.detail', $order->id) }}" class="btn btn-sm btn-info">View Details</a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @else
        <div class="alert alert-info">You have no orders yet.</div>
    @endif
</div>
@endsection