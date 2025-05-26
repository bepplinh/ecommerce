@extends('layout.clientApp')
@push('styles')
    <link rel="stylesheet" href="{{ asset('css/cart/modal_address.css') }}">
@endpush
@section('content')
    <main class="pt-90">
        <div class="mb-4 pb-4"></div>
        <section class="shop-checkout container">
            @if ($cartItems->isEmpty())
                <div class="text-center py-5">
                    <h3>No Orders</h3>
                    <p>Your cart is empty. Add products to your cart to continue shopping.</p>
                    <a href="{{ route('shop') }}" class="btn btn-primary">Continue Shopping</a>
                </div>
            @else
                <div class="checkout-steps">
                    <a href="{{ route('cart.detail') }}" class="checkout-steps__item active">
                        <span class="checkout-steps__item-number">01</span>
                        <span class="checkout-steps__item-title">
                            <span>Shopping Bag</span>
                            <em>Manage Your Items List</em>
                        </span>
                    </a>
                    <a href="{{ route('cart.checkout.show') }}" class="checkout-steps__item">
                        <span class="checkout-steps__item-number">02</span>
                        <span class="checkout-steps__item-title">
                            <span>Shipping and Checkout</span>
                            <em>Checkout Your Items List</em>
                        </span>
                    </a>
                    <a href="{{ route('cart.information') }}" class="checkout-steps__item">
                        <span class="checkout-steps__item-number">03</span>
                        <span class="checkout-steps__item-title">
                            <span>Confirmation</span>
                            <em>Review And Submit Your Order</em>
                        </span>
                    </a>
                </div>
                <div class="shopping-cart">
                    <div class="cart-table__wrapper">
                        <table class="cart-table">
                            <thead>
                                <tr>
                                    <th>Product</th>
                                    <th></th>
                                    <th>Price</th>
                                    <th>Quantity</th>
                                    <th>Subtotal</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($cartItems as $cartItem)
                                    <tr>
                                        <td>
                                            <div class="shopping-cart__product-item">
                                                <img loading="lazy" src="{{asset($cartItem->productVariants->product->image_url)}}" width="120"
                                                    height="120" alt="" />
                                            </div>
                                        </td>
                                        <td>
                                            <div class="shopping-cart__product-item__detail">
                                                <h4>{{ $cartItem->productVariants->product->name }}</h4>
                                                <ul class="shopping-cart__product-item__options">
                                                    <li>Color: {{ $cartItem->productVariants->color->name }}</li>
                                                    <li>Size: {{ $cartItem->productVariants->size->name }}</li>
                                                </ul>
                                            </div>
                                        </td>
                                        <td>
                                            <span class="shopping-cart__product-price">
                                                ${{ number_format($cartItem->productVariants->product->discount ? $cartItem->productVariants->product->sale_price : $cartItem->productVariants->product->price, 0) }}
                                            </span>
                                        </td>
                                        <td>
                                            <div class="qty-control position-relative">
                                                <div class="qty-control position-relative">
                                                    <input type="number" name="quantity" value="{{ $cartItem->quantity }}"
                                                        min="1" class="qty-control__number text-center">
                                                    <form method="POST"
                                                        action="{{ route('cart.decreaseQty', $cartItem->id) }}"
                                                        class="d-inline">
                                                        @csrf
                                                        @method('PUT')
                                                        <div class="qty-control__reduce">-</div>
                                                    </form>
                                                    <form method="POST"
                                                        action="{{ route('cart.increaseQty', $cartItem->id) }}"
                                                        class="d-inline">
                                                        @csrf
                                                        @method('PUT')
                                                        <div class="qty-control__increase">+</div>
                                                    </form>

                                                    <script>
                                                        $(document).ready(function() {
                                                            $('.qty-control__reduce').click(function(e) {
                                                                e.preventDefault();
                                                                $(this).closest('form').submit();
                                                            });
                                                            $('.qty-control__increase').click(function(e) {
                                                                e.preventDefault();
                                                                $(this).closest('form').submit();
                                                            });
                                                        });
                                                    </script>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <span class="shopping-cart__subtotal" id="subtotal-{{ $cartItem->id }}">
                                                ${{ number_format($cartItem->price, 0) }}
                                            </span>
                                        </td>
                                        <td>
                                            <a href="{{ route('cart.removeCartItem', $cartItem->id) }}"
                                                class="remove-cart">
                                                <svg width="10" height="10" viewBox="0 0 10 10" fill="#767676"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <path
                                                        d="M0.259435 8.85506L9.11449 0L10 0.885506L1.14494 9.74056L0.259435 8.85506Z" />
                                                    <path
                                                        d="M0.885506 0.0889838L9.74057 8.94404L8.85506 9.82955L0 0.97449L0.885506 0.0889838Z" />
                                                </svg>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <div class="cart-table-footer">
                            <form action="#" class="position-relative bg-body">
                                <input class="form-control" type="text" name="coupon_code" placeholder="Coupon Code">
                                <input class="btn-link fw-medium position-absolute top-0 end-0 h-100 px-4" type="submit"
                                    value="APPLY COUPON">
                            </form>
                            <button class="btn btn-light update-cart">UPDATE CART</button>

<form action="{{ route('payment.vnpay') }}" method="POST">
    @csrf
    <button type="submit" class="btn btn-primary" name="redirect">Thanh toán VNPAY</button>
</form>
                        </div>
                    </div>
                    <div class="shopping-cart__totals-wrapper">
                        <div class="sticky-content">
                            <div class="shopping-cart__totals">
                                <h3>Cart Totals</h3>
                                <table class="cart-totals">
                                    <tbody>
                                        <tr>
                                            <th>Subtotal</th>
                                            <td id="cart-total"> ${{ number_format($cartItems->sum('price')) }}</td>
                                        </tr>
                                        <tr>
                                            <th>Shipping</th>
                                            <form id="checkout-form" action="{{ route('cart.checkout') }}" method="POST"
                                                style="display: none;">
                                                @csrf
                                            <td>
                                                <div class="form-check">
                                                    <input class="form-check-input form-check-input_fill" type="radio"
                                                        name="shipping_fee" value="standard_delivery"
                                                        id="standard_delivery">
                                                    <label class="form-check-label" for="standard_delivery">Standard
                                                        delivery: $30.000</label>
                                                </div>

                                                <div class="form-check">
                                                    <input class="form-check-input form-check-input_fill" type="radio"
                                                        name="shipping_fee" value="fast_delivery" id="fast_delivery">
                                                    <label class="form-check-label" for="fast_delivery">
                                                        Super fast delivery: $50.000</label>
                                                </div>

                                                @php
                                                    $shipping = session('shipping_address');
                                                @endphp

                                                @if ($shipping)
                                                    <div>
                                                        <strong>Shipping to:</strong><br>
                                                        {{ $shipping['full_name'] }} - {{ $shipping['phone'] }}<br>
                                                        {{ $shipping['house_number'] }}
                                                        {{ $shipping['street'] ? ', ' . $shipping['street'] : '' }}
                                                        {{ $shipping['ward'] ? ', ' . $shipping['ward'] : '' }}
                                                        {{ $shipping['district'] ? ', ' . $shipping['district'] : '' }}
                                                        {{ $shipping['city'] ? ', ' . $shipping['city'] : '' }}
                                                    </div>
                                                @else
                                                    <div>Shipping to <span class="text-danger">Empty</span></div>
                                                @endif
                                                <div>
                                                    <a href="" class="menu-link menu-link_us-s"
                                                        data-bs-toggle="modal" data-bs-target="#shippingAddressModal">CHANGE
                                                        ADDRESS</a>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>VAT</th>
                                            <td>$0</td>
                                        </tr>
                                        <tr>
                                            <th>Total</th>
                                            <td id="cart-grand-total">${{ number_format($cartItems->sum('price') + 0) }}
                                            </td>
                                            
                                                <input type="hidden" name="grand_total" id="grand_total_input">
                                            </form>

                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="mobile_fixed-btn_wrapper">
                                <div class="button-wrapper container">
                                    <a href="#" class="btn btn-primary btn-checkout"
                                        id="btn-proceed-checkout">PROCEED TO CHECKOUT</a>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </section>
    </main>

    @include('client.cart_component.modal_address')
@endsection

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const subtotal = {{ $cartItems->sum('price') }};
        const shippingRadios = document.querySelectorAll('input[name="shipping_fee"]');
        const grandTotalTd = document.getElementById('cart-grand-total');
        const grandTotalInput = document.getElementById('grand_total_input');
        const btnCheckout = document.getElementById('btn-proceed-checkout');

        function formatNumber(num) {
            return num.toLocaleString('en-US');
        }

        function getShippingFee() {
            const checked = document.querySelector('input[name="shipping_fee"]:checked');
            if (!checked) return 0;
            if (checked.value === 'standard_delivery') return 30000;
            if (checked.value === 'fast_delivery') return 50000;
            return 0;
        }

        function updateTotal() {
            const shipping = getShippingFee();
            const grandTotal = subtotal + shipping;
            grandTotalTd.textContent = '$' + formatNumber(grandTotal);
            grandTotalInput.value = grandTotal;
        }

        shippingRadios.forEach(radio => {
            radio.addEventListener('change', updateTotal);
        });

        if (!document.querySelector('input[name="shipping_fee"]:checked')) {
            shippingRadios[0].checked = true;
        }

        updateTotal();

        btnCheckout.addEventListener('click', function (e) {
            e.preventDefault(); // chặn chuyển hướng mặc định
            updateTotal(); // đảm bảo giá trị mới nhất
            document.getElementById('checkout-form').submit(); // submit form
        });
    });
</script>