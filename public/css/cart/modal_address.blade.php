<div class="modal fade" id="shippingAddressModal" tabindex="-1" aria-labelledby="shippingAddressModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <form method="POST" action="{{ route('cart.saveShippingAddressToSession') }}">
            @csrf
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title" id="shippingAddressModalLabel">Nhập thông tin giao hàng</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Đóng"></button>
                </div>
                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label for="full_name" class="form-label">Fullname</label>
                            <input type="text" class="form-control" id="full_name" name="full_name" required
                                @if (session('shipping_address')) value="{{ session('shipping_address')['full_name'] }}" @endif>
                        </div>
                        <div class="col-md-6">
                            <label for="phone" class="form-label">Phone Number</label>
                            <input type="text" class="form-control" id="phone" name="phone" required
                                @if (session('shipping_address')) value="{{ session('shipping_address')['phone'] }}" @endif>
                        </div>
                        <div class="col-md-4">
                            <label for="house_number" class="form-label">House Number</label>
                            <input type="text" class="form-control" id="house_number" name="house_number" required
                                @if (session('shipping_address')) value="{{ session('shipping_address')['house_number'] }}" @endif>
                        </div>
                        <div class="col-md-8">
                            <label for="street" class="form-label">Street</label>
                            <input type="text" class="form-control" id="" name="street" required
                                @if (session('shipping_address')) value="{{ session('shipping_address')['street'] }}" @endif>
                        </div>
                        <div class="col-md-4">
                            <label for="city" class="form-label">City</label>
                            <input type="text" class="form-control" id="city" name="city" required
                                @if (session('shipping_address')) value="{{ session('shipping_address')['city'] }}" @endif>
                        </div>
                        <div class="col-md-4">
                            <label for="district" class="form-label">District</label>
                            <input type="text" class="form-control" id="district" name="district" required
                                @if (session('shipping_address')) value="{{ session('shipping_address')['district'] }}" @endif>
                        </div>
                        <div class="col-md-4">
                            <label for="ward" class="form-label">Ward</label>
                            <input type="text" class="form-control" id="ward" name="ward" required
                                @if (session('shipping_address')) value="{{ session('shipping_address')['ward'] }}" @endif>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary save">Save</button>
                </div>
            </div>
        </form>
    </div>
</div>
