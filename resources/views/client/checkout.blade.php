@extends('layout.clientApp')
@section('content')
<main class="pt-90">
  <div class="mb-4 pb-4"></div>
  <section class="shop-checkout container">
    <div class="checkout-steps">
      <a href="{{route('cart.detail')}}" class="checkout-steps__item active">
        <span class="checkout-steps__item-number">01</span>
        <span class="checkout-steps__item-title">
          <span>Shopping Bag</span>
          <em>Manage Your Items List</em>
        </span>
      </a>
      <a href="{{route('cart.checkout')}}" class="checkout-steps__item active">
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
    <form name="checkout-form" action="https://uomo-html.flexkitux.com/Demo3/shop_order_complete.html">
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
                <input type="text" class="form-control" name="full_name" required="">
                <label for="full_name">Full Name *</label>
                <span class="text-danger"></span>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-floating my-3">
                <input type="text" class="form-control" name="phone" required="">
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
                <input type="text" class="form-control" name="house_number">
                <label for="house_number">House Number </label>
                <span class="text-danger"></span>
              </div>
            </div>
            <div class="col-md-4">
              <div class="form-floating my-3">
                <input type="text" class="form-control" name="city" id="city" required="">
                <label for="city">Town / City *</label>
                <span class="text-danger"></span>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-floating my-3">
                <input type="text" class="form-control" name="ward" required="">
                <label for="ward">Ward *</label>
                <span class="text-danger"></span>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-floating my-3">
                <input type="text" class="form-control" name="district" required="">
                <label for="district">District *</label>
                <span class="text-danger"></span>
              </div>
            </div>
            <div class="col-md-12">
              <div class="form-floating my-3">
                <input type="text" class="form-control" name="street" required="">
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
                    <th align="right">SUBTOTAL</th>
                  </tr>
                </thead>
                <tbody></tbody>
                @foreach($cartItems as $cartItem)
                <tr>
                  <td>
                    @if($cartItem->quantity > 1)
                    {{$cartItem->productVariants->product->name}} -
                    {{$cartItem->productVariants->color->name}} - {{$cartItem->productVariants->size->name}}
                    - x{{$cartItem->quantity}}
                    @else
                    {{$cartItem->productVariants->product->name}} -
                    {{$cartItem->productVariants->color->name}} - {{$cartItem->productVariants->size->name}}
                    @endif
                  </td>
                  <td align="right">
                    @if($cartItem->productVariants->product->sale_price)
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
                    <td align="right">${{ number_format($totalPrice)}}</td>
                  </tr>
                  <tr>
                    <th>SHIPPING</th>
                    <td align="right">Free shipping</td>
                  </tr>
                  <tr>
                    <th>VAT</th>
                    <td align="right">$19</td>
                  </tr>
                  <tr>
                    <th>TOTAL</th>
                    <td align="right">$81.40</td>
                  </tr>
                </tbody>
              </table>
            </div>
            <div class="checkout__payment-methods">
              <div class="form-check">
                <input class="form-check-input form-check-input_fill" type="radio" name="checkout_payment_method"
                  id="checkout_payment_method_1" checked>
                <label class="form-check-label" for="checkout_payment_method_1">
                  Direct bank transfer
                  <p class="option-detail">
                    Make your payment directly into our bank account. Please use your Order ID as the payment
                    reference.Your order will not be shipped until the funds have cleared in our account.
                  </p>
                </label>
              </div>
              <div class="form-check">
                <input class="form-check-input form-check-input_fill" type="radio" name="checkout_payment_method"
                  id="checkout_payment_method_2">
                <label class="form-check-label" for="checkout_payment_method_2">
                  Check payments
                  <p class="option-detail">
                    Phasellus sed volutpat orci. Fusce eget lore mauris vehicula elementum gravida nec dui. Aenean
                    aliquam varius ipsum, non ultricies tellus sodales eu. Donec dignissim viverra nunc, ut aliquet
                    magna posuere eget.
                  </p>
                </label>
              </div>
              <div class="form-check">
                <input class="form-check-input form-check-input_fill" type="radio" name="checkout_payment_method"
                  id="checkout_payment_method_3">
                <label class="form-check-label" for="checkout_payment_method_3">
                  Cash on delivery
                  <p class="option-detail">
                    Phasellus sed volutpat orci. Fusce eget lore mauris vehicula elementum gravida nec dui. Aenean
                    aliquam varius ipsum, non ultricies tellus sodales eu. Donec dignissim viverra nunc, ut aliquet
                    magna posuere eget.
                  </p>
                </label>
              </div>
              <div class="form-check">
                <input class="form-check-input form-check-input_fill" type="radio" name="checkout_payment_method"
                  id="checkout_payment_method_4">
                <label class="form-check-label" for="checkout_payment_method_4">
                  Paypal
                  <p class="option-detail">
                    Phasellus sed volutpat orci. Fusce eget lore mauris vehicula elementum gravida nec dui. Aenean
                    aliquam varius ipsum, non ultricies tellus sodales eu. Donec dignissim viverra nunc, ut aliquet
                    magna posuere eget.
                  </p>
                </label>
              </div>
              <div class="policy-text">
                Your personal data will be used to process your order, support your experience throughout this
                website, and for other purposes described in our <a href="terms.html" target="_blank">privacy
                  policy</a>.
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