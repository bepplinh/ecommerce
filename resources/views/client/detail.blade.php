@extends('layout.clientApp')
@push('styles')
<style>
    .old-price {
        font-size: 13px;
    }

    .product-single__category {
        font-size: 16px;
        color: #666;
        margin-top: -5px;
        margin-bottom: 2px;
    }

    .qty-control {
        margin-right: 11px;
    }

    .size-container {
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
        margin-top: 10px;
    }

    .size-option-wrapper {
        position: relative;
    }

    .size-radio {
        position: absolute;
        opacity: 0;
        cursor: pointer;
    }

    .size-box {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 45px;
        height: 45px;
        border: 1px solid #e0e0e0;
        font-size: 16px;
        font-weight: 400;
        cursor: pointer;
        margin-bottom: 0;
        transition: all 0.3s ease;
    }

    .size-radio:checked+.size-box {
        border: 1px solid #000;
        font-weight: 500;
    }

    .size-radio:focus+.size-box {
        box-shadow: 0 0 3px rgba(0, 0, 0, 0.2);
    }

    /* XXL size is typically wider */
    label[for="sizeXXL"].size-box {
        width: 80px;
    }

    .size-guide {
        font-size: 0.875rem;
    }

    .color-option-wrapper {
        position: relative;
    }

    .color-radio {
        position: absolute;
        opacity: 0;
        cursor: pointer;
    }

    .color-box {
        padding: 8px 16px;
        border: 1px solid #e0e0e0;
        border-radius: 4px;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .color-radio:checked+.color-box {
        border: 1px solid #000;
        background-color: #f8f9fa;
    }

    .color-radio:focus+.color-box {
        box-shadow: 0 0 3px rgba(0, 0, 0, 0.2);
    }
</style>
@endpush
@section('content')
<main class="pt-90">
    <div class="mb-md-1 pb-md-3"></div>
    <section class="product-single container">
        <div class="row">
            <div class="col-lg-7">
                <div class="product-single__media" data-media-type="vertical-thumbnail">
                    <div class="product-single__image">
                        <div class="swiper-container">
                            <div class="swiper-wrapper">
                                @foreach ($product->productVariants as $variant)
                                @if ($variant->images->isNotEmpty())
                                @foreach ($variant->images as $image)
                                <div class="swiper-slide product-single__image-item"
                                    data-color-id="{{ $variant->color->id }}" style="display: none;">
                                    <img loading="lazy" class="h-auto"
                                        src="{{ asset('storage/' . $image->image_path) }}" width="674" height="674"
                                        alt="{{ $variant->color->name }}" />
                                    <a data-fancybox="gallery" href="{{ asset('storage/' . $image->image_path) }}"
                                        data-bs-toggle="tooltip" data-bs-placement="left" title="Zoom">
                                        <svg width="16" height="16" viewBox="0 0 16 16" fill="none"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <use href="#icon_zoom" />
                                        </svg>
                                    </a>
                                </div>
                                @endforeach
                                @endif
                                @endforeach
                            </div>


                            <div class="swiper-button-prev"><svg width="7" height="11" viewBox="0 0 7 11"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <use href="#icon_prev_sm" />
                                </svg></div>
                            <div class="swiper-button-next"><svg width="7" height="11" viewBox="0 0 7 11"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <use href="#icon_next_sm" />
                                </svg></div>
                        </div>
                    </div>
                    <div class="product-single__thumbnail">
                        <div class="swiper-container">
                            <div class="swiper-wrapper">
                                {{-- @if ($mainImage)
                                <div class="swiper-slide product-single__image-item"><img loading="lazy" class="h-auto"
                                        src="{{asset($mainImage->image_path)}}" width="104" height="104" alt="" /></div>
                                @endif

                                @foreach ($otherImages as $image)
                                <div class="swiper-slide product-single__image-item"><img loading="lazy" class="h-auto"
                                        src="{{asset($image->image_path)}}" width="104" height="104" alt="" /></div>
                                @endforeach --}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-5">
                <!-- Existing code (breadcrumb, prev-next, etc.) unchanged -->
                <div class="d-flex justify-content-between mb-2 pb-md-2">
                    <div class="breadcrumb mb-0 d-none d-md-block flex-grow-1">
                        <a href="#" class="menu-link menu-link_us-s text-uppercase fw-medium">Home</a>
                        <span class="breadcrumb-separator menu-link fw-medium ps-1 pe-1">/</span>
                        <a href="#" class="menu-link menu-link_us-s text-uppercase fw-medium">The Shop</a>
                    </div><!-- /.breadcrumb -->

                    <div
                        class="product-single__prev-next d-flex align-items-center justify-content-between justify-content-md-end flex-grow-1">
                        <a href="#" class="text-uppercase fw-medium"><svg width="10" height="10" viewBox="0 0 25 25"
                                xmlns="http://www.w3.org/2000/svg">
                                <use href="#icon_prev_md" />
                            </svg><span class="menu-link menu-link_us-s">Prev</span></a>
                        <a href="#" class="text-uppercase fw-medium"><span
                                class="menu-link menu-link_us-s">Next</span><svg width="10" height="10"
                                viewBox="0 0 25 25" xmlns="http://www.w3.org/2000/svg">
                                <use href="#icon_next_md" />
                            </svg></a>
                    </div><!-- /.shop-acs -->
                </div>
                <h1 class="product-single__name">{{ $product->name }}</h1>
                <div class="product-single__category">{{ $product->category->name }}</div>
                <div class="product-single__rating">
                    <div class="reviews-group d-flex">
                        <svg class="review-star" viewBox="0 0 9 9" xmlns="http://www.w3.org/2000/svg">
                            <use href="#icon_star" />
                        </svg>
                        <svg class="review-star" viewBox="0 0 9 9" xmlns="http://www.w3.org/2000/svg">
                            <use href="#icon_star" />
                        </svg>
                        <svg class="review-star" viewBox="0 0 9 9" xmlns="http://www.w3.org/2000/svg">
                            <use href="#icon_star" />
                        </svg>
                        <svg class="review-star" viewBox="0 0 9 9" xmlns="http://www.w3.org/2000/svg">
                            <use href="#icon_star" />
                        </svg>
                        <svg class="review-star" viewBox="0 0 9 9" xmlns="http://www.w3.org/2000/svg">
                            <use href="#icon_star" />
                        </svg>
                    </div>
                    <span class="reviews-note text-lowercase text-secondary ms-1">8k+ reviews</span>
                </div>

                <div class="product-single__price">
                    @if ($product->discount_id && $product->sale_price)
                    <span class="current-price">
                        {{ number_format($product->sale_price, 0, ',', '.') }}
                        <svg style="height: 0.9em; width: 0.7em; vertical-align: middle; margin-left: -6px;"
                            viewBox="0 0 16 16">
                            <text x="0" y="12" font-family="Arial, sans-serif" font-size="20" font-weight="bold"
                                fill="currentColor">₫</text>
                        </svg>
                    </span>
                    <span class="old-price" style="text-decoration: line-through; margin-left: 0px; color: #999;">
                        {{ number_format($product->price, 0, ',', '.') }}
                        <svg style="height: 0.9em; width: 0.7em; vertical-align: middle; margin-left: -2px;"
                            viewBox="0 0 16 16">
                            <text x="0" y="12" font-family="Arial, sans-serif" font-size="20" font-weight="bold"
                                fill="#999">₫</text>
                        </svg>
                    </span>
                    @else
                    <span class="current-price">
                        {{ number_format($product->price, 0, ',', '.') }}
                        <svg style="height: 0.9em; width: 0.7em; vertical-align: middle; margin-left: -6px;"
                            viewBox="0 0 16 16">
                            <text x="0" y="12" font-family="Arial, sans-serif" font-size="20" font-weight="bold"
                                fill="currentColor">₫</text>
                        </svg>
                    </span>
                    @endif
                </div>

                <div class="product-single__short-desc">
                    <p>{{ $product->description }}</p>
                </div>
                <form name="addtocart-form" method="post">
                    @csrf
                    <div class="product-single__colors mb-4">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <label class="fw-medium mb-0">Màu sắc:</label>
                        </div>
                        <div class="color-options d-flex flex-wrap gap-2">
                            @php
                            $displayedColors = [];
                            @endphp
                            @foreach ($product->productVariants as $variant)
                            @if (!in_array($variant->color->name, $displayedColors))
                            <div class="color-option-wrapper">
                                <input type="radio" name="color" id="color{{ $variant->color->id }}"
                                    value="{{ $variant->color->id }}" class="color-radio" required>
                                <label for="color{{ $variant->color->id }}" class="color-box d-flex align-items-center">
                                    <span class="color-dot me-2"
                                        style="width: 20px; height: 20px; border-radius: 50%; background-color: {{ $variant->color->hex_code }}; border: 1px solid #ddd;"></span>
                                    <span>{{ $variant->color->name }}</span>
                                </label>
                            </div>
                            @php
                            $displayedColors[] = $variant->color->name;
                            @endphp
                            @endif
                            @endforeach
                        </div>

                        <script>
                            document.addEventListener('DOMContentLoaded', function() {
                                // Initialize Swiper
                                const mainSwiper = new Swiper('.product-single__image .swiper-container', {
                                    navigation: {
                                        nextEl: '.swiper-button-next',
                                        prevEl: '.swiper-button-prev',
                                    },
                                });

                                // Function to show images for a specific color
                                function showImagesForColor(colorId) {
                                    // Hide all images first
                                    document.querySelectorAll('.swiper-slide.product-single__image-item').forEach(slide => {
                                        slide.style.display = 'none';
                                    });

                                    // Show images for selected color
                                    const colorImages = document.querySelectorAll(`.swiper-slide[data-color-id="${colorId}"]`);
                                    colorImages.forEach(slide => {
                                        slide.style.display = 'block';
                                    });

                                    // Update Swiper
                                    mainSwiper.update();
                                    mainSwiper.slideTo(0);
                                }

                                // Function to show sizes for a specific color
                                function showSizesForColor(colorId) {
                                    const sizesContainer = document.getElementById('sizes');
                                    sizesContainer.innerHTML = ''; // Clear existing sizes

                                    // Get all variants for the selected color
                                    const colorVariants = @json($product->productVariants);
                                    const colorSizes = colorVariants.filter(variant => variant.color_id == colorId);

                                    // Create size options
                                    colorSizes.forEach(variant => {
                                        const sizeBoxWrapper = document.createElement('div');
                                        sizeBoxWrapper.classList.add('size-option-wrapper');

                                        const sizeRadio = document.createElement('input');
                                        sizeRadio.type = 'radio';
                                        sizeRadio.name = 'size';
                                        sizeRadio.value = variant.size_id;
                                        sizeRadio.id = `size${variant.size_id}`;
                                        sizeRadio.classList.add('size-radio');
                                        sizeRadio.required = true;

                                        const sizeLabel = document.createElement('label');
                                        sizeLabel.setAttribute('for', `size${variant.size_id}`);
                                        sizeLabel.classList.add('size-box');
                                        sizeLabel.textContent = variant.size.name;

                                        sizeBoxWrapper.appendChild(sizeRadio);
                                        sizeBoxWrapper.appendChild(sizeLabel);
                                        sizesContainer.appendChild(sizeBoxWrapper);
                                    });
                                }

                                // Add change event listener to color radios
                                document.querySelectorAll('.color-radio').forEach(radio => {
                                    radio.addEventListener('change', function() {
                                        const selectedColorId = this.value;
                                        showImagesForColor(selectedColorId);
                                        showSizesForColor(selectedColorId);
                                    });
                                });

                                // Show images and sizes for first color on page load
                                const firstColorRadio = document.querySelector('.color-radio');
                                if (firstColorRadio) {
                                    firstColorRadio.checked = true;
                                    showImagesForColor(firstColorRadio.value);
                                    showSizesForColor(firstColorRadio.value);
                                }
                            });
                        </script>

                    </div>

                    @push('scripts')
                    <script src="{{ asset('js/detail/detail.js') }}"></script>
                    @endpush

                    <!-- Size Selection Section -->
                    <div class="product-single__sizes mb-4">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <label class="fw-medium mb-0">Size:</label>
                            <div class="size-guide d-flex align-items-center">
                                <svg aria-hidden="true" focusable="false" viewBox="0 0 24 24" role="img" width="24px"
                                    height="24px" fill="none">
                                    <path stroke="currentColor" stroke-width="1.5"
                                        d="M21.75 10.5v6.75a1.5 1.5 0 01-1.5 1.5H3.75a1.5 1.5 0 01-1.5-1.5V10.5m3.308-2.25h12.885">
                                    </path>
                                    <path stroke="currentColor" stroke-width="1.5"
                                        d="M15.79 5.599l2.652 2.65-2.652 2.653M8.21 5.599l-2.652 2.65 2.652 2.653M17.25 19v-2.5M12 19v-2.5M6.75 19v-2.5">
                                    </path>
                                </svg>
                                <a href="#" class="text-decoration-underline menu-link menu-link_us-s ms-1"
                                    data-bs-toggle="modal" data-bs-target="#sizeGuideModal">Size Guide</a>
                            </div>
                        </div>

                        <div class="size-options">
                            <div id="sizes" class="size-container">
                                <!-- Các ô size sẽ được điền qua JavaScript sau khi chọn màu -->
                            </div>
                        </div>
                    </div>

                    <div class="product-single__addtocart">
                        <div class="qty-control position-relative">
                            <input type="number" name="quantity" value="1" min="1"
                                class="qty-control__number text-center">
                            <div class="qty-control__reduce">-</div>
                            <div class="qty-control__increase">+</div>
                        </div><!-- .qty-control -->
                        <button type="submit" class="btn btn-primary btn-addtocart js-open-aside"
                            data-aside="cartDrawer">Add to
                            Cart</button>
                    </div>
                </form>

                @include('client.detail_component.product_info')
            </div>

            @include('client.detail_component.size_guide_modal')
        </div>
        @include('client.detail_component.more_infomation')
    </section>
    @include('client.detail_component.related_product')
</main>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Initialize Swiper
        const mainSwiper = new Swiper('.product-single__image .swiper-container', {
            navigation: {
                nextEl: '.swiper-button-next',
                prevEl: '.swiper-button-prev',
            },
        });

        // Function to show images for a specific color
        function showImagesForColor(colorId) {
            // Hide all images first
            document.querySelectorAll('.swiper-slide.product-single__image-item').forEach(slide => {
                slide.style.display = 'none';
            });

            // Show images for selected color
            const colorImages = document.querySelectorAll(`.swiper-slide[data-color-id="${colorId}"]`);
            colorImages.forEach(slide => {
                slide.style.display = 'block';
            });

            // Update Swiper
            mainSwiper.update();
            mainSwiper.slideTo(0);
        }

        // Function to show sizes for a specific color
        function showSizesForColor(colorId) {
            const sizesContainer = document.getElementById('sizes');
            sizesContainer.innerHTML = ''; // Clear existing sizes

            // Get all variants for the selected color
            const colorVariants = @json($product->productVariants);
            const colorSizes = colorVariants.filter(variant => variant.color_id == colorId);

            // Create size options
            colorSizes.forEach(variant => {
                const sizeBoxWrapper = document.createElement('div');
                sizeBoxWrapper.classList.add('size-option-wrapper');

                const sizeRadio = document.createElement('input');
                sizeRadio.type = 'radio';
                sizeRadio.name = 'size';
                sizeRadio.value = variant.size_id;
                sizeRadio.id = `size${variant.size_id}`;
                sizeRadio.classList.add('size-radio');
                sizeRadio.required = true;

                const sizeLabel = document.createElement('label');
                sizeLabel.setAttribute('for', `size${variant.size_id}`);
                sizeLabel.classList.add('size-box');
                sizeLabel.textContent = variant.size.name;

                sizeBoxWrapper.appendChild(sizeRadio);
                sizeBoxWrapper.appendChild(sizeLabel);
                sizesContainer.appendChild(sizeBoxWrapper);
            });
        }

        // Add change event listener to color radios
        document.querySelectorAll('.color-radio').forEach(radio => {
            radio.addEventListener('change', function() {
                const selectedColorId = this.value;
                showImagesForColor(selectedColorId);
                showSizesForColor(selectedColorId);
            });
        });

        // Show images and sizes for first color on page load
        const firstColorRadio = document.querySelector('.color-radio');
        if (firstColorRadio) {
            firstColorRadio.checked = true;
            showImagesForColor(firstColorRadio.value);
            showSizesForColor(firstColorRadio.value);
        }
    });
</script>
@endpush