<!-- START SECTION SHOP -->
<div class="section small_pt pb_70">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="heading_s1 text-center">
                    <h2>Exclusive Products</h2>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="tab-style1">
                    <ul class="nav nav-tabs justify-content-center" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" id="arrival-tab" data-bs-toggle="tab" href="#arrival"
                                role="tab" aria-controls="arrival" aria-selected="true">Gaming</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="sellers-tab" data-bs-toggle="tab" href="#sellers" role="tab"
                                aria-controls="sellers" aria-selected="false">Adventure</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="featured-tab" data-bs-toggle="tab" href="#featured" role="tab"
                                aria-controls="featured" aria-selected="false">accessories</a>
                        </li>

                    </ul>
                </div>
                <div class="tab-content">
                    <div class="tab-pane fade show active" id="arrival" role="tabpanel" aria-labelledby="arrival-tab">
                        <div class="row shop_container reveal">
                            @foreach ($products as $product)
                                @if ($product->status == 1 && $product->druft == 1 && $product->type == 'gaming')
                                    @php
                                        $hasNonZeroQty = false;
                                        foreach ($product->productQtys as $productQty) {
                                            if ($productQty->current_qty != 0 && $productQty->druft == 1) {
                                                $hasNonZeroQty = true;
                                                break;
                                            }
                                        }
                                    @endphp
                                    @if ($hasNonZeroQty)
                                        <div class="col-lg-3 col-md-4 col-6">
                                            <div class="product">

                                                <form action="{{ route('addToCart') }}"
                                                    id="addToCartForm{{ $product->id }}" method="POST">
                                                    @csrf <!-- CSRF protection for Laravel forms -->
                                                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                                                    <input type="hidden" name="quantity"
                                                        value="{{ $product->minimum_purchase }}">
                                                    <div class="product_img">
                                                        <a href="shop-product-detail.html">
                                                            <img src="{{ asset('storage/' . $product->thum_img) }}"
                                                                alt="product_img1">

                                                        </a>
                                                        <div class="product_action_box">
                                                            <ul class="list_none pr_action_btn">
                                                                <li class="add-to-cart">
                                                                    <a href="#"
                                                                        onclick="document.getElementById('addToCartForm{{ $product->id }}').submit(); return false;"><i
                                                                            class="icon-basket-loaded"></i> Add To
                                                                        Cart</a>
                                                                </li>
                                                                <li>
                                                                    <a
                                                                        href="{{ route('addToWishlist', ['productId' => $product->id]) }}">
                                                                        <i class="icon-heart"></i>
                                                                    </a>
                                                                </li>

                                                                </li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </form>

                                                <div class="product_info">
                                                    <h6 class="product_title"><a
                                                            href="{{ route('productById', $product->id) }}">{{ $product->title }}</a>
                                                    </h6>
                                                    <div class="product_price">
                                                        <?php
                                                        // Search for the discount for the related product by its ID
                                                        $product_dis = App\Models\Discount::where('product_id', $product->id)
                                                            ->where('status', 1)
                                                            ->where('druft', 1)
                                                            ->first();
                                                        ?>
                                                        <div class="product_price">
                                                            @if ($product_dis)
                                                                <span
                                                                    class="price">{{ intval($productQty->unit_price) - intval($product_dis->dis_rate) }}</span>
                                                                <del>${{ intval($productQty->unit_price) }}</del>
                                                                <div class="on_sale">
                                                                    <span>{{ number_format(($product_dis->dis_rate / intval($productQty->unit_price)) * 100, 2) }}%</span>
                                                                </div>
                                                            @else
                                                                <span
                                                                    class="price">{{ intval($productQty->unit_price) - 00 }}</span>
                                                                <del>$00</del>
                                                                <div class="on_sale">
                                                                    <span>00%</span>
                                                                </div>
                                                            @endif

                                                            {{-- <p class="bg-warning"> Current Qty :
                                                                {{ $productQty->current_qty }}</p> --}}
                                                        </div>
                                                    </div>
                                                    <div class="pr_desc">
                                                        <p></p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                @endif
                            @endforeach
                        </div>
                    </div>
                    <div class="tab-pane fade" id="sellers" role="tabpanel" aria-labelledby="sellers-tab">
                        <div class="row shop_container reveal">
                            @foreach ($products as $product)
                                @if ($product->status == 1 && $product->druft == 1 && $product->type == 'adventure')
                                    @php
                                        $hasNonZeroQty = false;
                                        foreach ($product->productQtys as $productQty) {
                                            if ($productQty->current_qty != 0 && $productQty->druft == 1) {
                                                $hasNonZeroQty = true;
                                                break;
                                            }
                                        }
                                    @endphp
                                    @if ($hasNonZeroQty)
                                        <div class="col-lg-3 col-md-4 col-6">
                                            <div class="product">

                                                <form action="{{ route('addToCart') }}"
                                                    id="addToCartForm{{ $product->id }}" method="POST">
                                                    @csrf <!-- CSRF protection for Laravel forms -->
                                                    <input type="hidden" name="product_id"
                                                        value="{{ $product->id }}">
                                                    <input type="hidden" name="quantity"
                                                        value="{{ $product->minimum_purchase }}">
                                                    <div class="product_img">
                                                        <a href="shop-product-detail.html">
                                                            <img src="{{ asset('storage/' . $product->thum_img) }}"
                                                                alt="product_img1">
                                                        </a>
                                                        <div class="product_action_box">
                                                            <ul class="list_none pr_action_btn">
                                                                <li class="add-to-cart">
                                                                    <a href="#"
                                                                        onclick="document.getElementById('addToCartForm{{ $product->id }}').submit(); return false;"><i
                                                                            class="icon-basket-loaded"></i> Add To
                                                                        Cart</a>
                                                                </li>
                                                                <li><a
                                                                        href="{{ route('addToWishlist', ['productId' => $product->id]) }}">
                                                                        <i class="icon-heart"></i>
                                                                    </a>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </form>

                                                <div class="product_info">
                                                    <h6 class="product_title"><a
                                                            href="{{ route('productById', $product->id) }}">{{ $product->title }}</a>
                                                    </h6>
                                                    <div class="product_price">
                                                        <?php
                                                        // Search for the discount for the related product by its ID
                                                        $product_dis = App\Models\Discount::where('product_id', $product->id)
                                                            ->where('status', 1)
                                                            ->where('druft', 1)
                                                            ->first();
                                                        ?>
                                                        <div class="product_price">
                                                            @if ($product_dis)
                                                                <span
                                                                    class="price">{{ intval($productQty->unit_price) - intval($product_dis->dis_rate) }}</span>
                                                                <del>${{ intval($productQty->unit_price) }}</del>
                                                                <div class="on_sale">
                                                                    <span>{{ number_format(($product_dis->dis_rate / intval($productQty->unit_price)) * 100, 2) }}%</span>
                                                                </div>
                                                            @else
                                                                <span
                                                                    class="price">{{ intval($productQty->unit_price) - 00 }}</span>
                                                                <del>$00</del>
                                                                <div class="on_sale">
                                                                    <span>00%</span>
                                                                </div>
                                                            @endif

                                                            {{-- <p class="bg-warning"> Current Qty :
                                                                {{ $productQty->current_qty }}</p> --}}
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="pr_desc">
                                                        <p></p>
                                                    </div>
                                                   
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                @endif
                            @endforeach
                        </div>
                    </div>
                    <div class="tab-pane fade" id="featured" role="tabpanel" aria-labelledby="featured-tab">
                        <div class="row shop_container reveal">
                            @foreach ($products as $product)
                                @if ($product->status == 1 && $product->druft == 1 && $product->type == 'accessories')
                                    @php
                                        $hasNonZeroQty = false;
                                        foreach ($product->productQtys as $productQty) {
                                            if ($productQty->current_qty != 0 && $productQty->druft == 1) {
                                                $hasNonZeroQty = true;
                                                break;
                                            }
                                        }
                                    @endphp
                                    @if ($hasNonZeroQty)
                                        <div class="col-lg-3 col-md-4 col-6">
                                            <div class="product">

                                                <form action="{{ route('addToCart') }}"
                                                    id="addToCartForm{{ $product->id }}" method="POST">
                                                    @csrf <!-- CSRF protection for Laravel forms -->
                                                    <input type="hidden" name="product_id"
                                                        value="{{ $product->id }}">
                                                    <input type="hidden" name="quantity"
                                                        value="{{ $product->minimum_purchase }}">
                                                    <div class="product_img">
                                                        <a href="shop-product-detail.html">
                                                            <img src="{{ asset('storage/' . $product->thum_img) }}"
                                                                alt="product_img1">

                                                        </a>
                                                        <div class="product_action_box">
                                                            <ul class="list_none pr_action_btn">
                                                                <li class="add-to-cart">
                                                                    <a href="#"
                                                                        onclick="document.getElementById('addToCartForm{{ $product->id }}').submit(); return false;"><i
                                                                            class="icon-basket-loaded"></i> Add To
                                                                        Cart</a>
                                                                </li>

                                                                <li>
                                                                    <a
                                                                        href="{{ route('addToWishlist', ['productId' => $product->id]) }}">
                                                                        <i class="icon-heart"></i>
                                                                    </a>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </form>

                                                <div class="product_info">
                                                    <h6 class="product_title"><a
                                                            href="shop-product-detail.html">{{ $product->title }}</a>
                                                    </h6>
                                                    <div class="product_price">
                                                        <span class="price">${{ $productQty->unit_price }}</span>
                                                        @if ($product->discounted_price)
                                                            <del>$</del>
                                                            <div class="on_sale">
                                                                <span>% Off</span>
                                                            </div>
                                                        @endif
                                                    </div>
                                                    
                                                    <div class="pr_desc">
                                                        <p></p>
                                                    </div>
                                                    
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                @endif
                            @endforeach
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
<!-- END SECTION SHOP -->
