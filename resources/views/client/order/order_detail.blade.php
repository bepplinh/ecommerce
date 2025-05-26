@extends('layout.clientApp')
@push('styles')
<link rel="stylesheet" href="{{ asset('css/order/order_detail.css') }}">
@endpush

@section('content')
<div class="container mt-4">
    <h3>Order Details</h3>
    @if($order)
        <div class="mb-3">
            <strong>Order Code:</strong> {{ $order->order_code }}<br>
            <strong>Order Date:</strong> {{ $order->created_at->format('d/m/Y H:i') }}<br>
            <strong>Status:</strong>
            @if($order->status == 'pending')
                <span class="badge bg-warning text-dark">Pending</span>
            @elseif($order->status == 'completed')
                <span class="badge bg-success">Completed</span>
            @elseif($order->status == 'cancelled')
                <span class="badge bg-danger">Cancelled</span>
            @else
                <span class="badge bg-secondary">{{ $order->status }}</span>
            @endif
            <br>    
            <strong>Shipping Method: </strong> {{$order->shipping_method}} <br>
            <strong>Shipping Address:</strong><br>
            {{ $order->shippingAddress->full_name ?? '' }}<br>
            {{ $order->shippingAddress->phone ?? '' }}<br>
            {{ $order->shippingAddress->house_number ?? '' }}, {{ $order->shippingAddress->street ?? '' }}, {{ $order->shippingAddress->ward ?? '' }}, {{ $order->shippingAddress->district ?? '' }}, {{ $order->shippingAddress->city ?? '' }}
        </div>
        <div class="table-responsive">
            <table class="table table-bordered align-middle">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Product Image</th>
                        <th>Product Code</th>
                        <th>Product</th>
                        <th>Color</th>
                        <th>Size</th>
                        <th>Quantity</th>
                        <th>Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($order->orderItems as $key => $item)
                    <tr>
                        <td>{{ $key + 1 }}</td>
                        <td>
                            @if(isset($item->productVariants->product->image))
                                <img src="{{ asset('storage/' . $item->productVariants->product->image) }}" alt="Product Image" style="width:60px; height:60px; object-fit:cover;">
                            @else
                                <img src="{{ asset('images/default-product.png') }}" alt="Default Image" style="width:60px; height:60px; object-fit:cover;">
                            @endif
                        </td>
                        <td>{{ $item->productVariants->product->code }}</td>
                        <td>{{ $item->productVariants->product->name ?? 'N/A' }}</td>
                        <td>
                            {{ $item->productVariants->color->name }}
                        </td>
                        <td>
                            {{ $item->productVariants->size->name }}
                        </td>   
                        <td>{{ $item->quantity }}</td>
                        <td>
                            @if($item->productVariants->product->discount)
                                {{ number_format($item->productVariants->product->sale_price) }} đ
                            @else
                                {{ number_format($item->productVariants->product->price) }} đ
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="text-end">
            <strong>Shipping Fee:</strong> {{number_format($order->shipping_medthod === 'standard_delivery' ? 30000 : 50000, 0)}} đ
        </div>
        <div class="text-end">
            <strong>Total Amount:</strong> {{ number_format($order->total_amount) }} đ
        </div>
    @else
        <div class="alert alert-warning">Order not found.</div>
    @endif
    <a href="{{ route('order.manage') }}" class="btn btn-secondary">Back to Orders</a>
</div>
@endsection