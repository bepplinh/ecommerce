<div class="modal fade" id="shippingAddressModal" tabindex="-1" aria-labelledby="shippingAddressModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <form method="POST" action="{{ route('cart.saveShippingAddressToSession') }}">
            @csrf
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title" id="shippingAddressModalLabel">Chọn địa chỉ giao hàng</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Đóng"></button>
                </div>
                <div class="modal-body">
                    @if(isset($shipping_addresses) && $shipping_addresses->count() > 0)
                        <div class="mb-3">
                            <label class="form-label">Địa chỉ của bạn</label>
                            <div class="list-group">
                                @foreach($shipping_addresses as $address)
                                    <label class="list-group-item list-group-item-action mb-2" style="cursor:pointer;">
                                        <input class="form-check-input me-2" type="radio" name="address_id" value="{{ $address->id }}"
                                            @if(session('shipping_address.id') == $address->id) checked @endif>
                                        <strong>{{ $address->full_name }}</strong> | {{ $address->phone }}<br>
                                        {{ $address->house_number }}, {{ $address->street }}, {{ $address->ward }}, {{ $address->district }}, {{ $address->city }}
                                    </label>
                                @endforeach
                            </div>
                        </div>
                    @else
                        <div class="alert alert-info">Bạn chưa có địa chỉ nào, vui lòng thêm mới bên dưới.</div>
                    @endif

                    <hr>
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label for="full_name" class="form-label">Họ tên</label>
                            <input type="text" class="form-control" id="full_name" name="full_name"
                                value="{{ old('full_name') }}">
                        </div>
                        <div class="col-md-6">
                            <label for="phone" class="form-label">Số điện thoại</label>
                            <input type="text" class="form-control" id="phone" name="phone"
                                value="{{ old('phone') }}">
                        </div>
                        <div class="col-md-4">
                            <label for="house_number" class="form-label">Số nhà</label>
                            <input type="text" class="form-control" id="house_number" name="house_number"
                                value="{{ old('house_number') }}">
                        </div>
                        <div class="col-md-8">
                            <label for="street" class="form-label">Đường</label>
                            <input type="text" class="form-control" id="street" name="street"
                                value="{{ old('street') }}">
                        </div>
                        <div class="col-md-4">
                            <label for="city" class="form-label">Tỉnh/Thành phố</label>
                            <input type="text" class="form-control" id="city" name="city"
                                value="{{ old('city') }}">
                        </div>
                        <div class="col-md-4">
                            <label for="district" class="form-label">Quận/Huyện</label>
                            <input type="text" class="form-control" id="district" name="district"
                                value="{{ old('district') }}">
                        </div>
                        <div class="col-md-4">
                            <label for="ward" class="form-label">Phường/Xã</label>
                            <input type="text" class="form-control" id="ward" name="ward"
                                value="{{ old('ward') }}">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                    <button type="submit" class="btn btn-primary">Lưu & Sử dụng địa chỉ</button>
                </div>
            </div>
        </form>
    </div>
</div>
