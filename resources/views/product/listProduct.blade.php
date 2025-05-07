@extends('layout.adminDashboard')
@section('content')
<div class="container mt-4">
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center text-center">
            <h5 class="mb-0">Danh sách sản phẩm</h5>
            <a href="{{ route('products.create') }}" class="btn btn-primary ms-auto">
                <i class="fas fa-plus me-1"></i> Thêm sản phẩm
            </a>
        </div>
        <div class="card-body">
            <div class="mb-3 d-flex justify-content-between align-items-center">
                <div class="w-50">
                    <form action="{{ route('products.index') }}" method="GET">
                        <div class="input-group">
                            <input type="text" class="form-control text-center" name="search"
                                placeholder="Tìm kiếm theo tên hoặc mã sản phẩm..." value="{{ request('search') }}">
                            <button class="btn btn-outline-secondary" type="submit">
                                <i class="fas fa-search"></i>
                            </button>
                            @if(request('search'))
                            <a href="{{ route('products.index') }}" class="btn btn-outline-secondary">
                                <i class="fas fa-times"></i>
                            </a>
                            @endif
                        </div>
                    </form>
                </div>
                <div>
                    <form action="{{ route('products.index') }}" method="GET">
                        <select name="sort" class="form-select" onchange="this.form.submit()" style="min-width: 200px;">
                            <option value="">Sắp xếp theo</option>
                            <option value="name_asc" {{ request('sort') == 'name_asc' ? 'selected' : '' }}>Tên (A-Z)</option>
                            <option value="name_desc" {{ request('sort') == 'name_desc' ? 'selected' : '' }}>Tên (Z-A)</option>
                            <option value="price_asc" {{ request('sort') == 'price_asc' ? 'selected' : '' }}>Giá (Thấp-Cao)</option>
                            <option value="price_desc" {{ request('sort') == 'price_desc' ? 'selected' : '' }}>Giá (Cao-Thấp)</option>
                            <option value="newest" {{ request('sort') == 'newest' ? 'selected' : '' }}>Mới nhất</option>
                            <option value="oldest" {{ request('sort') == 'oldest' ? 'selected' : '' }}>Cũ nhất</option>
                        </select>
                    </form>
                </div>
            </div>

            <div class="table-responsive">
                <table class="table table-hover align-middle text-center">
                    <thead>
                        <tr class="align-middle">
                            <th class="text-center">Mã SP</th>
                            <th class="text-center">Hình ảnh</th>
                            <th class="text-center">Tên sản phẩm</th>
                            <th class="text-center">Giá (VNĐ)</th>
                            <th class="text-center">Giá khuyến mãi (VNĐ)</th>
                            <th class="text-center">Biến thể (Màu / Size / Số lượng)</th>
                            <th class="text-center">Thương hiệu</th>
                            <th class="text-center">Danh mục</th>
                            <th class="text-center">Trạng thái</th>
                            <th class="text-center">Thao tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($products as $product)
                        <tr>
                            <td>{{ $product->code }}</td>
                            <td>
                                <img src="{{ asset($product->image) }}" alt="{{ $product->name }}" class="img-thumbnail mx-auto d-block"
                                    style="max-width: 100px;">
                            </td>
                            <td>{{ $product->name }}</td>
                            <td>{{ number_format($product->price, 0, ',', '.') }}</td>
                            <td>
                                @if ($product->discount_id) 
                                    @if ($product->sale_price) 
                                        {{ number_format($product->sale_price, 0, ',', '.') }}
                                    @else
                                        Không có
                                    @endif
                                @else
                                    Không có
                                @endif
                            </td>
                            
                            <td>
                                @php
                                    $variantsByColor = [];
                                    foreach($product->productVariants as $variant) {
                                        $colorName = $variant->color->name;
                                        if (!isset($variantsByColor[$colorName])) {
                                            $variantsByColor[$colorName] = [];
                                        }
                                        $variantsByColor[$colorName][] = $variant;
                                    }
                                @endphp
                            
                                @forelse ($variantsByColor as $colorName => $variants)
                                    <div class="mb-2">
                                        <strong>Màu: {{ $colorName }}</strong>
                                        <ul class="list-unstyled ml-3">
                                            @foreach ($variants as $variant)
                                                <li>- Size: <strong>{{ $variant->size->name }}</strong> | SL: <strong>{{ $variant->stock }}</strong></li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @empty
                                    <div>Empty</div>
                                @endforelse
                            </td>
                            <td>
                                {{ $product->brand ? $product->brand->name : 'Empty' }}
                            </td>
                            <td>
                                {{ $product->category ? $product->category->name : 'Empty' }}
                            </td>
                            <td>
                                <span class="badge {{ $product->status == 'active' ? 'bg-success' : 'bg-danger' }}">
                                    {{ $product->status == 'active' ? 'Hoạt động' : 'Không hoạt động' }}
                                </span>
                            </td>
                            <td>
                                <div class="btn-group d-flex justify-content-center" role="group">
                                    <a href="{{ route('products.edit', $product->id) }}" class="btn btn-sm btn-warning w-50">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('products.destroy', $product->id) }}" method="POST" class="d-inline w-50">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger w-100"
                                            onclick="return confirm('Bạn có chắc chắn muốn xóa?')">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="9" class="text-center">Không có sản phẩm nào</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="d-flex justify-content-end mt-3">
                {{ $products->links('pagination::bootstrap-5') }}
            </div>

        </div>
    </div>
</div>
@endsection
