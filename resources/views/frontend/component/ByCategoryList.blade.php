    <!-- START SECTION BREADCRUMB -->
    <div class="breadcrumb_section bg_gray page-title-mini">
        <div class="container"><!-- STRART CONTAINER -->
            <div class="row align-items-center">
                <div class="col-md-6">
                    <div class="page-title">
                        <h1>Shop List</h1>
                    </div>
                </div>
                <div class="col-md-6">
                    <ol class="breadcrumb justify-content-md-end">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                        <li class="breadcrumb-item">Pages</li>
                        <li class="breadcrumb-item active">Shop List</li>
                    </ol>
                </div>
            </div>
        </div><!-- END CONTAINER-->
    </div>
    <!-- END SECTION BREADCRUMB -->

    <!-- START MAIN CONTENT -->
    <div class="main_content">

        <!-- START SECTION SHOP -->
        <div class="">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <div class="row align-items-center mb-4 pb-1">
                            <div class="col-12">
                                <div class="product_header">
                                    <div class="product_header_left">
                                        <div class="custom_select">
                                            <select class="form-control form-control-sm">
                                                <option value="order">Default sorting</option>
                                                <option value="popularity">Sort by popularity</option>
                                                <option value="date">Sort by newness</option>
                                                <option value="price">Sort by price: low to high</option>
                                                <option value="price-desc">Sort by price: high to low</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="product_header_right">
                                        <div class="products_view">
                                            <a href="javascript:;" class="shorting_icon grid active"><i
                                                    class="ti-view-grid"></i></a>
                                            <a href="javascript:;" class="shorting_icon list "><i
                                                    class="ti-layout-list-thumb"></i></a>
                                        </div>
                                        {{-- <div class="custom_select">
                                            <select class="form-control form-control-sm">
                                                <option value="">Showing</option>
                                                <option value="9">9</option>
                                                <option value="12">12</option>
                                                <option value="18">18</option>
                                            </select>
                                        </div> --}}
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row shop_container grid">

                            @if ($products->isNotEmpty())
                                @foreach ($products as $product)
                                    @php
                                        $hasNonZeroQty = false;
                                        foreach ($product->productQtys as $productQty) {
                                            if ($productQty->current_qty != 0) {
                                                if ($productQty->druft != 0) {
                                                    $hasNonZeroQty = true;
                                                }
                                                break;
                                            }
                                        }
                                    @endphp

                                    <div class="col-lg-3 col-md-4 col-6">
                                        <div class="product">
                                            <div class="product_img">
                                                <a href="shop-product-detail.html">
                                                    <img src="{{ asset('storage/' . $product->thum_img) }}"
                                                        alt="product_img1">
                                                </a>

                                                @if ($hasNonZeroQty === true)
                                                    <form action="{{ route('addToCart') }}"
                                                        id="addToCartForm{{ $product->id }}" method="POST">
                                                        @csrf <!-- CSRF protection for Laravel forms -->
                                                        <input type="hidden" name="product_id"
                                                            value="{{ $product->id }}">
                                                        <input type="hidden" name="quantity"
                                                            value="{{ $product->minimum_purchase }}">
                                                        <div class="product_action_box">
                                                            <ul class="list_none pr_action_btn">
                                                                <li class="add-to-cart">
                                                                    {{-- <button type="submit"><i class="icon-basket-loaded"></i></button> --}}
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
                                                    </form>
                                                @elseif ($hasNonZeroQty === false)
                                                    <div class="product_action_box">
                                                        <span class="badge text-bg-secondary">Out of Stock</span>
                                                        <ul class="list_none pr_action_btn">
                                                            <li>
                                                                <a
                                                                    href="{{ route('addToWishlist', ['productId' => $product->id]) }}">
                                                                    <i class="icon-heart"></i>
                                                                </a>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                @endif
                                            </div>
                                            <div class="product_info">
                                                <h6 class="product_title"><a
                                                        href="{{ route('productById', $product->id) }}">{{ $product->title }}</a>
                                                </h6>


                                                @if ($hasNonZeroQty === true)
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

                                                    <form action="{{ route('addToCart') }}"
                                                        id="addToCartForm{{ $product->id }}" method="POST">
                                                        @csrf <!-- CSRF protection for Laravel forms -->
                                                        <div class="pr_desc">
                                                            <p>{!! $product->short_des !!}</p>
                                                        </div>
                                                        <input type="hidden" name="product_id"
                                                            value="{{ $product->id }}">
                                                        <input type="hidden" name="quantity"
                                                            value="{{ $product->minimum_purchase }}">

                                                        <div class="list_product_action_box">
                                                            <ul class="list_none pr_action_btn">
                                                                <li class="add-to-cart"><a href="#"
                                                                        onclick="document.getElementById('addToCartForm{{ $product->id }}').submit(); return false;"><i
                                                                            class="icon-basket-loaded"></i>
                                                                        Add To Cart</a></li>
                                                                <li>
                                                                    <a
                                                                        href="{{ route('addToWishlist', ['productId' => $product->id]) }}"><i
                                                                            class="icon-heart"></i>
                                                                    </a>

                                                                </li>
                                                            </ul>
                                                        </div>
                                                    </form>
                                                @elseif ($hasNonZeroQty === false)
                                                    <div class="product_price">
                                                        <div class="d-flex justify-content-between">
                                                            <p class="price">$0</p>
                                                            <div class="on_sale">
                                                                <span><span class="ms-2 badge text-bg-danger">Stock
                                                                        Out</span>
                                                                </span>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="pr_desc">
                                                        <p>{!! $product->short_des !!}</p>
                                                    </div>
                                                    <div class="list_product_action_box">
                                                        <ul class="list_none pr_action_btn">
                                                            <button @disabled(true)
                                                                class="btn btn-fill-out btn-addtocart"
                                                                type="button">Out Of Stock</button>

                                                            <li>
                                                                <a
                                                                    href="{{ route('addToWishlist', ['productId' => $product->id]) }}">
                                                                    <i class="icon-heart"></i>
                                                                </a>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                @endif



                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            @else
                                <h1>No Products</h1>
                            @endif



                        </div>
                        <div class="row">
                            @if ($products->total() > $products->perPage())
                                <nav aria-label="Page navigation">
                                    <ul class="pagination justify-content-center">
                                        {{-- Previous Page Link --}}
                                        @if ($products->onFirstPage())
                                            <li class="page-item disabled">
                                                <span class="page-link">&laquo;</span>
                                            </li>
                                        @else
                                            <li class="page-item">
                                                <a class="page-link" href="{{ $products->previousPageUrl() }}"
                                                    rel="prev">&laquo;</a>
                                            </li>
                                        @endif

                                        {{-- Pagination Elements --}}
                                        @for ($i = 1; $i <= $products->lastPage(); $i++)
                                            <li
                                                class="page-item {{ $products->currentPage() == $i ? 'active' : '' }}">
                                                <a class="page-link"
                                                    href="{{ $products->url($i) }}">{{ $i }}</a>
                                            </li>
                                        @endfor

                                        {{-- Next Page Link --}}
                                        @if ($products->hasMorePages())
                                            <li class="page-item">
                                                <a class="page-link" href="{{ $products->nextPageUrl() }}"
                                                    rel="next">&raquo;</a>
                                            </li>
                                        @else
                                            <li class="page-item disabled">
                                                <span class="page-link">&raquo;</span>
                                            </li>
                                        @endif
                                    </ul>
                                </nav>
                            @endif

                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- END SECTION SHOP -->
    </div>
    <!-- END MAIN CONTENT -->
