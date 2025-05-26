@extends('layout.adminDashboard')

@section('content')
<div class="container mt-4">
    @if($order)
        <form method="POST" action="{{ route('order.admin.update', $order->id) }}" id="status-form">
            @csrf
            @method('PUT')
            <div class="mb-3">
                <strong>Order Code:</strong> {{ $order->order_code }}<br>
                <strong>Order Date:</strong> {{ $order->created_at->format('d/m/Y H:i') }}<br>
                <strong>Customer:</strong> {{ $order->shippingAddress->full_name ?? '' }}<br>
                <strong>Phone:</strong> {{ $order->shippingAddress->phone ?? '' }}<br>
                <strong>Shipping Address:</strong>
                {{ $order->shippingAddress->house_number ?? '' }}, {{ $order->shippingAddress->street ?? '' }}, {{ $order->shippingAddress->ward ?? '' }}, {{ $order->shippingAddress->district ?? '' }}, {{ $order->shippingAddress->city ?? '' }}
                <br>
                <strong>Payment Method:</strong>
                <span class="badge 
                    @if($order->payment_method == 'payos') bg-info text-dark
                    @elseif($order->payment_method == 'cod') bg-secondary
                    @elseif($order->payment_method == 'vnpay') bg-primary
                    @else bg-light text-dark
                    @endif
                ">
                    {{ strtoupper($order->payment_method) }}
                </span>
                <br>
                <strong>Payment Status:</strong>
                <span class="badge 
                    @if($order->payment_status == 'paid') bg-success
                    @elseif($order->payment_status == 'unpaid') bg-warning text-dark
                    @elseif($order->payment_status == 'failed') bg-danger
                    @else bg-secondary
                    @endif
                ">
                    {{ ucfirst($order->payment_status) }}
                </span>
                <br>
                    <strong>Shipping Method:</strong>
                <span class="badge 
                    @if($order->shipping_method == 'standard_delivery') bg-primary
                    @elseif($order->shipping_method == 'express_delivery') bg-info text-dark
                    @else bg-secondary
                    @endif
                ">
                    {{ ucfirst(str_replace('_', ' ', $order->shipping_method)) }}
                </span>
                <br>
                <strong>Shipping Fee:</strong>
                @php
                    if($order->shipping_method == 'standard_delivery') {
                        $shipping_fee = 30000; 
                    } elseif($order->shipping_method == 'express_delivery') {
                        $shipping_fee = 50000; 
                    } else {
                        $shipping_fee = 0; 
                    }
                @endphp
                {{ number_format($shipping_fee) }} ₫
                <br>
            </div>
            <div class="row mb-3 align-items-center">
                <div class="col"></div>
                <div class="col text-end">
                    <label for="order-status" class="me-2"><strong>Status:</strong></label>
                    <select name="status" id="order-status" class="form-select d-inline-block w-auto" style="display:inline-block;">
                        <option value="pending" @if($order->status == 'pending') selected @endif>Pending</option>
                        <option value="processing" @if($order->status == 'processing') selected @endif>Processing</option>
                        <option value="completed" @if($order->status == 'completed') selected @endif>Completed</option>
                        <option value="cancelled" @if($order->status == 'cancelled') selected @endif>Cancelled</option>
                    </select>
                    <span id="status-badge" class="badge ms-2
                        @if($order->status == 'pending') bg-warning text-dark
                        @elseif($order->status == 'processing') bg-info text-dark
                        @elseif($order->status == 'completed') bg-success
                        @elseif($order->status == 'cancelled') bg-danger
                        @else bg-secondary
                        @endif
                    ">
                        {{ ucfirst($order->status) }}
                    </span>
                </div>
            </div>
            <div class="table-responsive">
                <table class="table table-bordered align-middle">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Product Image</th>
                            <th>Product Code</th>
                            <th>Product Name</th>
                            <th>Variant</th>
                            <th>Quantity</th>
                            <th>Unit Price</th>
                            <th>Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($orderItems as $key => $item)
                        <tr>
                            <td>{{ $key + 1 }}</td>
                            <td>
                                @if(isset($item->productVariants->product->image))
                                    <img src="{{ asset('storage/' . $item->productVariants->product->image) }}" alt="Product Image" style="width:60px; height:60px; object-fit:cover;">
                                @else
                                    <span>No image</span>
                                @endif
                            </td>
                            <td>{{ $item->productVariants->product->code ?? 'N/A' }}</td>
                            <td>{{ $item->productVariants->product->name ?? 'N/A' }}</td>
                            <td>
                                @if($item->productVariants)
                                    Color: {{ $item->productVariants->color->name ?? '' }},
                                    Size: {{ $item->productVariants->size->name ?? '' }}
                                @endif
                            </td>
                            <td>{{ $item->quantity }}</td>
                            <td>{{ number_format($item->price) }} ₫</td>
                            <td>{{ number_format($item->price) }} ₫</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="row mb-3">
                <div class="col text-end">
                    <strong>Total Amount:</strong> {{ number_format($order->total_amount) }} ₫
                </div>
            </div>
            <div class="row mb-3 align-items-center">
                <div class="col">
                    <a href="{{ route('order.admin.manage') }}" class="btn btn-secondary">Back to Orders</a>
                </div>
                <div class="col text-end">
                    <button type="submit" class="btn btn-primary ms-2">Save</button>
                </div>
            </div>
        </form>
    @else
        <div class="alert alert-warning">Order not found.</div>
    @endif
</div>
@endsection
