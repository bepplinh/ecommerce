@extends('layout.clientApp')
@section('content')
    <main class="pt-90">
        <div class="mb-4 pb-4"></div>
        <section class="shop-checkout container">
            <div class="checkout-steps">
                <a href="{{ route('cart.detail') }}" class="checkout-steps__item active">
                    <span class="checkout-steps__item-number">01</span>
                    <span class="checkout-steps__item-title">
                        <span>Shopping Bag</span>
                        <em>Manage Your Items List</em>
                    </span>
                </a>
                <a href="{{ route('cart.checkout') }}" class="checkout-steps__item active">
                    <span class="checkout-steps__item-number">02</span>
                    <span class="checkout-steps__item-title">
                        <span>Shipping and Checkout</span>
                        <em>Checkout Your Items List</em>
                    </span>
                </a>
                <a href="order-confirmation.html" class="checkout-steps__item">
                    <span class="checkout-steps__item-number">03</span>
                    <span class="checkout-steps__item-title">
                        <span>Confirmation</span>
                        <em>Review And Submit Your Order</em>
                    </span>
                </a>
            </div>
            <form name="checkout-form" action="{{route('order')}}" method="POST">
                @csrf
                <input type="hidden" name="cart_id" value="{{ $cart->id }}">
                <div class="checkout-form">
                    <div class="billing-info__wrapper">
                        <div class="row">
                            <div class="col-6">
                                <h4>SHIPPING DETAILS</h4>
                            </div>
                            <div class="col-6">
                            </div>
                        </div>

                        <div class="row mt-5">
                            <div class="col-md-6">
                                <div class="form-floating my-3">
                                    <input type="text" class="form-control" name="full_name" required=""
                                        @if (session('shipping_address')) value="{{ session('shipping_address')['full_name'] }}" @endif>
                                    <label for="full_name">Full Name *</label>
                                    <span class="text-danger"></span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating my-3">
                                    <input type="text" class="form-control" name="phone" required=""
                                        @if (session('shipping_address')) value="{{ session('shipping_address')['phone'] }}" @endif>
                                    <label for="phone">Phone Number *</label>
                                    <span class="text-danger"></span>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-floating my-3">
                                    <input type="text" class="form-control" name="zip">
                                    <label for="zip">Pincode </label>
                                    <span class="text-danger"></span>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-floating mt-3 mb-3">
                                    <input type="text" class="form-control" name="house_number"
                                        @if (session('shipping_address')) value="{{ session('shipping_address')['house_number'] }}" @endif>
                                    <label for="house_number">House Number </label>
                                    <span class="text-danger"></span>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-floating my-3">
                                    <input type="text" class="form-control" name="city" id="city" required=""
                                        @if (session('shipping_address')) value="{{ session('shipping_address')['city'] }}" @endif>
                                    <label for="city">Town / City *</label>
                                    <span class="text-danger"></span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating my-3">
                                    <input type="text" class="form-control" name="ward" required=""
                                        @if (session('shipping_address')) value="{{ session('shipping_address')['ward'] }}" @endif>
                                    <label for="ward">Ward *</label>
                                    <span class="text-danger"></span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating my-3">
                                    <input type="text" class="form-control" name="district" required=""
                                        @if (session('shipping_address')) value="{{ session('shipping_address')['district'] }}" @endif>
                                    <label for="district">District *</label>
                                    <span class="text-danger"></span>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-floating my-3">
                                    <input type="text" class="form-control" name="street" required=""
                                        @if (session('shipping_address')) value="{{ session('shipping_address')['street'] }}" @endif>
                                    <label for="street">Street *</label>
                                    <span class="text-danger"></span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="checkout__totals-wrapper">
                        <div class="sticky-content">
                            <div class="checkout__totals">
                                <h3>Your Order</h3>
                                <table class="checkout-cart-items">
                                    <thead>
                                        <tr>
                                            <th>PRODUCT</th>
                                            <th align="right">TOTAL</th>
                                        </tr>
                                    </thead>
                                    <tbody></tbody>
                                    @foreach ($cartItems as $cartItem)
                                        <tr>
                                            <td>
                                                @if ($cartItem->quantity > 1)
                                                    {{ $cartItem->productVariants->product->name }} -
                                                    {{ $cartItem->productVariants->color->name }} -
                                                    {{ $cartItem->productVariants->size->name }}
                                                    - x{{ $cartItem->quantity }}
                                                @else
                                                    {{ $cartItem->productVariants->product->name }} -
                                                    {{ $cartItem->productVariants->color->name }} -
                                                    {{ $cartItem->productVariants->size->name }}
                                                @endif
                                            </td>
                                            <td align="right">
                                                @if ($cartItem->productVariants->product->sale_price)
                                                    {{ number_format($cartItem->productVariants->product->sale_price * $cartItem->quantity) }}
                                                @else
                                                    {{ number_format($cartItem->productVariants->product->price * $cartItem->quantity) }}
                                                @endif
                                            </td>
                                    @endforeach
                                    </tr>
                                    </tbody>
                                </table>
                                <table class="checkout-totals">
                                    <tbody>
                                        <tr>
                                            <th>SUBTOTAL</th>
                                            <td align="right">${{ number_format($totalPrice) }}</td>
                                        </tr>
                                        <tr>
                                            <th>SHIPPING</th>
                                            <td align="right">
                                                @if(session('shipping_fee') == 'standard_delivery')
                                                 Standard Delivery : $30.000
                                                 @else
                                                    Fast Devlirery : $50.000
                                                @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>VAT</th>
                                            <td align="right">$0</td>
                                        </tr>
                                        <tr>
                                            <th>TOTAL</th>
                                            <td align="right">{{number_format(session('grand_total'), '0')}}</td>
                                        </tr>

                                    </tbody>
                                </table>
                            </div>
                            <div class="checkout__payment-methods">
                                <div class="form-check">
                                    <input class="form-check-input form-check-input_fill" type="radio"
                                        name="checkout_payment_method" id="checkout_payment_method_1" value="vnpay" checked>
                                    <label class="form-check-label" for="checkout_payment_method_1">
                                        VnPay
                                        <p class="option-detail">
                                            Make your payment directly into our bank account. Please use your Order ID as
                                            the payment reference. Your order will not be shipped until the funds have cleared in our account.
                                        </p>
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input form-check-input_fill" type="radio"
                                        name="checkout_payment_method" id="checkout_payment_method_3" value="cod">
                                    <label class="form-check-label" for="checkout_payment_method_3">
                                        Cash on delivery
                                        <p class="option-detail">
                                            Cash or Banking
                                        </p>
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input form-check-input_fill" type="radio"
                                        name="checkout_payment_method" id="checkout_payment_method_payos" value="payos">
                                    <label class="form-check-label" for="checkout_payment_method_payos">
                                        PayOS
                                        <p class="option-detail">
                                            Thanh toán qua PayOS (ATM, QR, ví điện tử, v.v.)
                                        </p>
                                    </label>
                                </div>
                                <div class="policy-text">
                                    Your personal data will be used to process your order, support your experience
                                    throughout this website, and for other purposes described in our <a href="terms.html"
                                        target="_blank">privacy policy</a>.
                                </div>
                            </div>
                            <button class="btn btn-primary btn-checkout">PLACE ORDER</button>
                        </div>
                    </div>
                </div>
            </form>
        </section>
    </main>
@endsection
