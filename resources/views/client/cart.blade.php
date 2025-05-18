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
      <a href="cart.html" class="checkout-steps__item active">
        <span class="checkout-steps__item-number">01</span>
        <span class="checkout-steps__item-title">
          <span>Shopping Bag</span>
          <em>Manage Your Items List</em>
        </span>
      </a>
      <a href="{{route('cart.checkout')}}" class="checkout-steps__item">
        <span class="checkout-steps__item-number">02</span>
        <span class="checkout-steps__item-title">
          <span>Shipping and Checkout</span>
          <em>Checkout Your Items List</em>
        </span>
      </a>
      <a href="{{route('cart.information')}}" class="checkout-steps__item">
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
            @foreach($cartItems as $cartItem)
            <tr>
              <td>
                <div class="shopping-cart__product-item">
                  <img loading="lazy" src="assets/images/cart-item-1.jpg" width="120" height="120" alt="" />
                </div>
              </td>
              <td>
                <div class="shopping-cart__product-item__detail">
                  <h4>{{$cartItem->productVariants->product->name}}</h4>
                  <ul class="shopping-cart__product-item__options">
                    <li>Color: {{$cartItem->productVariants->color->name}}</li>
                    <li>Size: {{$cartItem->productVariants->size->name}}</li>
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
                    <input type="number" name="quantity" value="{{$cartItem->quantity}}" min="1"
                      class="qty-control__number text-center">
                    <form method="POST" action="{{route('cart.decreaseQty', $cartItem->id)}}" class="d-inline">
                      @csrf
                      @method('PUT')
                      <div class="qty-control__reduce">-</div>
                    </form>
                    <form method="POST" action="{{route('cart.increaseQty', $cartItem->id)}}" class="d-inline">
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
                <a href="{{route('cart.removeCartItem', $cartItem->id)}}" class="remove-cart">
                  <svg width="10" height="10" viewBox="0 0 10 10" fill="#767676" xmlns="http://www.w3.org/2000/svg">
                    <path d="M0.259435 8.85506L9.11449 0L10 0.885506L1.14494 9.74056L0.259435 8.85506Z" />
                    <path d="M0.885506 0.0889838L9.74057 8.94404L8.85506 9.82955L0 0.97449L0.885506 0.0889838Z" />
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
                  <td id="cart-total">${{ number_format($cartItems->sum('price')) }}</td>
                </tr>
                <tr>  
                  <th>Shipping</th>
                  <td>
                    <div class="form-check">
                      <input class="form-check-input form-check-input_fill" type="checkbox" value="" id="free_shipping">
                      <label class="form-check-label" for="free_shipping">Free shipping</label>
                    </div>
                    <div class="form-check">
                      <input class="form-check-input form-check-input_fill" type="checkbox" value="" id="flat_rate">
                      <label class="form-check-label" for="flat_rate">Flat rate: $49</label>
                    </div>
                    <div class="form-check">
                      <input class="form-check-input form-check-input_fill" type="checkbox" value="" id="local_pickup">
                      <label class="form-check-label" for="local_pickup">Local pickup: $8</label>
                    </div>
                    <div>Shipping to AL.</div>
                    <div>
                      <a href="" class="menu-link menu-link_us-s" data-bs-toggle="modal" data-bs-target="#shippingAddressModal">CHANGE ADDRESS</a>
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
    @endif
  </section>
</main>

<!-- Modal Địa chỉ giao hàng bố cục đẹp -->
<div class="modal fade" id="shippingAddressModal" tabindex="-1" aria-labelledby="shippingAddressModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <form method="POST" action="#">
      @csrf
      <div class="modal-content">
        <div class="modal-header bg-primary text-white">
          <h5 class="modal-title" id="shippingAddressModalLabel">Nhập thông tin giao hàng</h5>
          <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Đóng"></button>
        </div>
        <div class="modal-body">
          <div class="row g-3">
            <div class="col-md-6">
              <label for="full_name" class="form-label">Họ và tên</label>
              <input type="text" class="form-control" id="full_name" name="full_name" required>
            </div>
            <div class="col-md-6">
              <label for="phone" class="form-label">Số điện thoại</label>
              <input type="text" class="form-control" id="phone" name="phone" required>
            </div>
            <div class="col-md-4">
              <label for="house_number" class="form-label">Số nhà</label>
              <input type="text" class="form-control" id="house_number" name="house_number" required>
            </div>
            <div class="col-md-8">
              <label for="street" class="form-label">Đường</label>
              <input type="text" class="form-control" id="street" name="street" required>
            </div>
            <div class="col-md-4">
              <label for="city" class="form-label">Tỉnh/Thành phố</label>
              <input type="text" class="form-control" id="city" name="city" required>
            </div>
            <div class="col-md-4">
              <label for="district" class="form-label">Quận/Huyện</label>
              <input type="text" class="form-control" id="district" name="district" required>
            </div>
            <div class="col-md-4">
              <label for="ward" class="form-label">Phường/Xã</label>
              <input type="text" class="form-control" id="ward" name="ward" required>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
          <button type="submit" class="btn btn-primary">Lưu thông tin</button>
        </div>
      </div>
    </form>
  </div>
</div>

@endsection