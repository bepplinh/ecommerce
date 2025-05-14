@extends('layout.clientApp')
@push('styles')
@endpush
@section('content')
    <main class="pt-90">
        <div class="mb-4 pb-4"></div>
        <section class="shop-checkout container">
            <h2 class="page-title">Cart</h2>
            @if(count($cartItems) == 0)
                <div class="text-center py-5">
                    <h3>No Orders</h3>
                    <p>Your cart is empty. Add products to your cart to continue shopping.</p>
                    <a href="{{ route('shop') }}" class="btn btn-primary">Continue Shopping</a>
                </div>
            @else
                <div class="checkout-steps">
                    <a href="cart.html" class="checkout-steps__item active">
                        <span class="checkout-steps__item-number">01</span>
                        <span class="checkout-steps__item-title">
                            <span>Shopping Bag</span>
                            <em>Manage Your Items List</em>
                        </span>
                    </a>
                    <a href="checkout.html" class="checkout-steps__item">
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
                                                <img loading="lazy" src="assets/images/cart-item-1.jpg" width="120"
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
                                            <span
                                                class="shopping-cart__product-price">${{ number_format($cartItem->productVariants->product->price, 0, ',', '.') }}</span>
                                        </td>
                                        <td>
                                            <div class="qty-control position-relative">
                                                <input type="number" name="quantity" value="{{$cartItem->quantity}}" min="1"
                                                    class="qty-control__number text-center">
                                                <form method="POST"
                                                    action="{{ route('cart.decreaseQuantity', $cartItem->id) }}">
                                                    @csrf
                                                    @method('PUT')
                                                    <div class="qty-control__reduce">-</div>
                                                </form>

                                                <form method="POST"
                                                    action="{{ route('cart.increaseQuantity', $cartItem->id) }}">
                                                    @csrf
                                                    @method('PUT')
                                                    <div class="qty-control__increase">+</div>
                                                </form>
                                            </div>
                                        </td>
                                        <td>
                                            <span class="shopping-cart__subtotal" id="subtotal-{{ $cartItem->id }}">
                                                {{-- ${{ number_format($cartItem->price, 0, ',', '.') }} --}}
                                                @if($cartItem->productVariants->product->discount)
                                                    ${{ number_format($cartItem->productVariants->product->sale_price, 0, ',', '.') }}
                                                @else
                                                    ${{ number_format($cartItem->productVariants->product->price, 0, ',', '.') }} 
                                                @endif   
                                            </span>
                                        </td>
                                        <td>
                                            <a href="{{ route('cart.removeCartItem', $cartItem->id) }}" class="remove-cart">
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
                            </tbody>
            @endforeach
            </table>
            <div class="cart-table-footer">
                <form action="#" class="position-relative bg-body">
                    <input class="form-control" type="text" name="coupon_code" placeholder="Coupon Code">
                    <input class="btn-link fw-medium position-absolute top-0 end-0 h-100 px-4" type="submit"
                        value="APPLY COUPON">
                </form>
                <button class="btn btn-light">UPDATE CART</button>
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
                                    <td>${{ number_format($subtotal_Cart, 0, ',', '.') }}</td>
                                </tr>
                                <tr>
                                    <th>Shipping</th>
                                    <td>
                                        <div class="form-check">
                                            <input class="form-check-input form-check-input_fill" type="checkbox"
                                                value="" id="free_shipping">
                                            <label class="form-check-label" for="free_shipping">Free
                                                shipping</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input form-check-input_fill" type="checkbox"
                                                value="" id="flat_rate">
                                            <label class="form-check-label" for="flat_rate">Flat rate: $49</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input form-check-input_fill" type="checkbox"
                                                value="" id="local_pickup">
                                            <label class="form-check-label" for="local_pickup">Local pickup:
                                                $8</label>
                                        </div>
                                        <div>Shipping to AL.</div>
                                        <div>
                                            <a href="#" class="menu-link menu-link_us-s">CHANGE ADDRESS</a>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <th>VAT</th>
                                    <td>$19</td>
                                </tr>
                                <tr>
                                    <th>Total</th>
                                    <td>$1319</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="mobile_fixed-btn_wrapper">
                        <div class="button-wrapper container">
                            <a href="checkout.html" class="btn btn-primary btn-checkout">PROCEED TO CHECKOUT</a>
                        </div>
                    </div>
                </div>
            </div>
            </div>
        </section>
        @endif
    </main>

@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
        $(".qty-control__increase").on("click", function() {
            $(this).closest("form").submit();  // Gửi form tăng số lượng
        });

        $(".qty-control__reduce").on("click", function() {
            $(this).closest("form").submit();  // Gửi form giảm số lượng
        });
    });
    </script>
@endpush