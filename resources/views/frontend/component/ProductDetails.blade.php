<!-- START SECTION BREADCRUMB -->
<div class="breadcrumb_section bg_gray page-title-mini">
    <div class="container"><!-- STRART CONTAINER -->
        <div class="row align-items-center">
            <div class="col-md-6">
                <div class="page-title">
                    <h1>Product Detail</h1>
                </div>
            </div>
            <div class="col-md-6">
                <ol class="breadcrumb justify-content-md-end">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                    <li class="breadcrumb-item">Pages</li>
                    <li class="breadcrumb-item active">Product Detail</li>
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

                <div class="col-lg-6 col-md-6 mb-4 mb-md-0">
                    <div class="product-image">
                        <div class="product_img_box">
                            <img id="product_img" src='{{ asset('storage/' . $product->thum_img) }}'
                                data-zoom-image="{{ asset('storage/' . $product->thum_img) }}" alt="product_img1" />
                            <a href="#" class="product_img_zoom" title="Zoom">
                                <span class="linearicons-zoom-in"></span>
                            </a>
                        </div>
                        <div id="pr_item_gallery" class="product_gallery_item slick_slider" data-slides-to-show="4"
                            data-slides-to-scroll="1" data-infinite="false">

                            @foreach ($product->productImgs as $productImg)
                                <div class="item">
                                    <a href="#" class="product_gallery_item active"
                                        data-image="{{ asset('storage/' . $productImg->product_img) }}"
                                        data-zoom-image="{{ asset('storage/' . $productImg->product_img) }}">
                                        <img src="{{ asset('storage/' . $productImg->product_img) }}"
                                            alt="product_small_img1" />
                                    </a>
                                </div>
                            @endforeach


                        </div>
                    </div>
                </div>


                <div class="col-lg-6 col-md-6">
                    <div class="pr_detail">
                        <div class="product_description">
                            <h4 class="product_title">{{ $product->title }}</h4>
                            <div class="product_price">
                                @php
                                    // Define $productQty here or fetch it from wherever it's supposed to come from
                                    $productQty = null; // Initialize the variable

                                    $hasNonZeroQty = false;
                                    foreach ($product->productQtys as $qty) {
                                        if ($qty->current_qty != 0) {
                                            if ($qty->druft != 0) {
                                                $hasNonZeroQty = true;
                                            }
                                            $productQty = $qty; // Assign $qty to $productQty
                                            break;
                                        }
                                    }

                                    $discountRate = null; // Initialize the variable
                                    foreach ($product->discounts as $discount) {
                                        if ($discount->druft == 1 && $discount->status == 1) {
                                            $discountRate = $discount->dis_rate;
                                            break;
                                        }
                                    }
                                @endphp

                                @if ($hasNonZeroQty === true && $productQty !== null)
                                    @if ($discountRate !== null)
                                        <span
                                            class="price">{{ intval($productQty->unit_price) - intval($discountRate) }}</span>
                                        <del>${{ intval($productQty->unit_price) }}</del>
                                        <div class="on_sale">
                                            <span>{{ number_format(($discountRate / intval($productQty->unit_price)) * 100, 2) }}%</span>
                                        </div>
                                    @else
                                        <span class="price">{{ intval($productQty->unit_price) - 0 }}</span>
                                        <del>$00</del>
                                        <div class="on_sale">
                                            <span>00%</span>
                                        </div>
                                    @endif

                                    {{-- <p class="bg-warning"> Current Qty : {{ $productQty->current_qty }}</p> --}}
                                @elseif ($hasNonZeroQty === false)
                                    <span class="mt-3 d-block">Regular Price Tk 0</span>
                                    <span class="d-block">Special Price Tk 0</span>
                                    <p class="mt-3 badge text-bg-danger">Stock Out</p>
                                    <!-- Additional logic here to handle the case when $productQty is null -->
                                @endif
                            </div>
                            <div class="pr_desc">
                                <a>{{ $product->slug }}.</a>
                            </div>
                            <h4>Quick Overview</h4>
                            <div class="ms-5">
                                <p>{!! $product->short_des !!}</p>
                            </div>
                            <div class="pr_desc">
                                <a class="d-block">
                                    Refundable : <?php echo $product->refundable == 1 ? 'Yes' : 'No'; ?>
                                </a>
                                <a class="d-block">
                                    Cash On Delivery : <?php echo $product->cash_on_delivary == 1 ? 'Yes' : 'No'; ?>
                                </a>
                            </div>
                        </div>
                        <hr />
                        @if ($hasNonZeroQty === true)
                            <form action="{{ route('addToCart') }}" method="POST">
                                @csrf
                                <input type="hidden" name="product_id" value="{{ $product->id }}">
                                <input type="hidden" name="stock_id" value="{{ $productQty->id }}">
                                <div class="cart_extra">
                                    <div class="cart-product-quantity">
                                        <div class="quantity">
                                            <input type="button" value="-" class="minus">
                                            <input type="text" name="quantity" value="1" title="Qty"
                                                class="qty" size="4">
                                            <input type="button" value="+" class="plus">
                                        </div>
                                    </div>
                                    <div class="cart_btn">
                                        <button class="btn btn-fill-out btn-addtocart" type="submit"><i
                                                class="icon-basket-loaded"></i> Add to cart</button>
                                        <a href="{{ route('addToWishlist', ['productId' => $product->id]) }}"><i
                                                class="icon-heart"></i>
                                        </a>
                                    </div>
                                </div>
                            </form>
                        @elseif ($hasNonZeroQty === false)
                            <div class="cart_extra">
                                <div class="cart-product-quantity">
                                    <div class="quantity">
                                        <input @disabled(true) type="button" value="-"
                                            class="minus">
                                        <input @disabled(true) type="text" name="quantity"
                                            value="1" title="Qty" class="qty" size="4">
                                        <input @disabled(true) type="button" value="+"
                                            class="plus">
                                    </div>
                                </div>
                                <div class="cart_btn">
                                    <button @disabled(true) class="btn btn-fill-out btn-addtocart"
                                        type="button">Out Of Stock</button>
                                    <a href="{{ route('addToWishlist', ['productId' => $product->id]) }}"><i
                                            class="icon-heart"></i>
                                    </a>
                                </div>
                            </div>
                        @endif
                        <hr />
                        <ul class="product-meta">
                            <li>Barcode : {{ $product->barcode }}</li>

                            <li>
                                Category : <a
                                    href="{{ route('productByCategory', $product->cat_id) }}">{{ $product->category->category_name }}</a>
                                @if ($product->subCat_id)
                                    <a href="{{ route('productBySubCatId', $product->subCat_id) }}"> /
                                        {{ $product->subCategory->subcategory_name }}</a>
                                @endif
                                @if ($product->childCat_id)
                                    <a href="#"> /
                                        {{ $product->childCategory->childcategory_name }}</a>
                                @endif
                            </li>




                        </ul>

                        <div class="product_share">
                            <span>Share:</span>
                            <ul class="social_icons">
                                <li><a href="#"><i class="ion-social-facebook"></i></a></li>
                                <li><a href="#"><i class="ion-social-twitter"></i></a></li>
                                <li><a href="#"><i class="ion-social-googleplus"></i></a></li>
                                <li><a href="#"><i class="ion-social-youtube-outline"></i></a></li>
                                <li><a href="#"><i class="ion-social-instagram-outline"></i></a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="large_divider clearfix"></div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="tab-style3">
                        <ul class="nav nav-tabs" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link " id="Description-tab" data-bs-toggle="tab" href="#Description"
                                    role="tab" aria-controls="Description" aria-selected="true">Additional
                                    info</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link active" id="Additional-info-tab" data-bs-toggle="tab"
                                    href="#Additional-info" role="tab" aria-controls="Additional-info"
                                    aria-selected="false">Description</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="Reviews-tab" data-bs-toggle="tab" href="#Reviews"
                                    role="tab" aria-controls="Reviews" aria-selected="false">Reviews
                                    ({{ $reviews->count() ?? 0 }})</a>
                            </li>
                        </ul>
                        <div class="tab-content shop_info_tab">
                            <div class="tab-pane fade" id="Description" role="tabpanel"
                                aria-labelledby="Description-tab">
                                <p>{!! $product->short_des !!}</p>
                            </div>
                            <div class="tab-pane fade show active" id="Additional-info" role="tabpanel"
                                aria-labelledby="Additional-info-tab">
                                <p>{!! $product->description !!}</p>
                            </div>

                            <div class="tab-pane fade" id="Reviews" role="tabpanel" aria-labelledby="Reviews-tab">
                                <div class="comments">
                                    <h5 class="product_tab_title">{{ $reviews->count() ?? 0 }} Reviews for this product</span></h5>
                                    <ul class="list_none comment_list mt-4">
                                        @isset($reviews)
                                            @foreach ($reviews as $review)
                                                <li>
                                                    <div class="comment_img">
                                                        <img src="{{ asset('frontend') }}/assets/images/user1.jpg"
                                                            alt="user1" />
                                                    </div>
                                                    <div class="comment_block">
                                                        <div class="rating_wrap">
                                                            <div class="rating">
                                                                <div class="product_rate"
                                                                    style="width: {{ $review->rating * 20 }}%"></div>
                                                            </div>
                                                        </div>
                                                        <p class="customer_meta">
                                                            <span class="review_author">
                                                                {{ $review->userProfile->first_name }}
                                                                {{ $review->userProfile->last_name ?? 'Unknown' }}
                                                            </span>
                                                            <span
                                                                class="comment-date">{{ $review->created_at->format('d F Y') }}</span>
                                                        </p>
                                                        <div class="description">
                                                            <p>{{ $review->review }}</p>
                                                        </div>
                                                        @if (auth()->user()->id == $review->user_id)
                                                            <div class=" text-end">
                                                                <a href="{{ route('deletReview', $review->id) }}"
                                                                    class="btn btn-sm btn-danger">Delete</a>
                                                            </div>
                                                        @endif
                                                    </div>
                                                </li>
                                            @endforeach

                                        @endisset

                                    </ul>
                                </div>
                                <div class="review_form field_form">
                                    <h5>Add a review</h5>
                                    <form action="{{ route('productReview') }}" method="POST" class="row mt-3">
                                        @csrf
                                        <div class="form-group col-12 mb-3">
                                            <div class="star_rating">
                                                <span data-value="1"><i class="far fa-star"></i></span>
                                                <span data-value="2"><i class="far fa-star"></i></span>
                                                <span data-value="3"><i class="far fa-star"></i></span>
                                                <span data-value="4"><i class="far fa-star"></i></span>
                                                <span data-value="5"><i class="far fa-star"></i></span>
                                            </div>
                                            <input type="hidden" name="rating" id="ratingInput">
                                            <input type="hidden" name="product_id" value="{{ $product->id }}">
                                        </div>
                                        <div class="form-group col-12 mb-3">
                                            <textarea required="required" placeholder="Your review *" class="form-control" name="message" rows="4"></textarea>
                                        </div>
                                        <div class="form-group col-12 mb-3">
                                            <button type="submit" class="btn btn-fill-out" name="submit"
                                                value="Submit">Submit Review</button>
                                        </div>
                                    </form>

                                </div>
                            </div>




                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="small_divider"></div>
                    <div class="divider"></div>
                    <div class="medium_divider"></div>
                </div>
            </div>
            {{-- Related Product --}}
            <div class="row">
                <div class="col-12">
                    <div class="heading_s1">
                        <h3>Releted Products</h3>
                    </div>
                    <div class="releted_product_slider carousel_slider owl-carousel owl-theme reveal" data-margin="20"
                        data-responsive='{"0":{"items": "1"}, "481":{"items": "2"}, "768":{"items": "3"}, "1199":{"items": "4"}}'>
                        @if (isset($product->related_product))

                            @foreach ($product->related_product as $related_product_id)
                                <?php
                                // Search for product by its ID
                                $related_product = App\Models\Product::find($related_product_id);
                                ?>
                                @if ($related_product)
                                    @php
                                        $hasNonZeroQty = false;
                                        foreach ($related_product->productQtys as $rel_productQty) {
                                            if ($rel_productQty->current_qty != 0) {
                                                if ($rel_productQty->druft != 0) {
                                                    $hasNonZeroQty = true;
                                                }
                                                break;
                                            }
                                        }
                                    @endphp
                                    <div class="item">
                                        <div class="product">
                                            <div class="product_img">
                                                <a href="shop-product-detail.html">
                                                    <img src="{{ asset('storage/' . $related_product->thum_img) }}"
                                                        alt="product_img1">
                                                </a>
                                                @if ($hasNonZeroQty === true)
                                                    <form action="{{ route('addToCart') }}"
                                                        id="addToCartForm{{ $related_product->id }}" method="POST">
                                                        @csrf <!-- CSRF protection for Laravel forms -->
                                                        <input type="hidden" name="product_id"
                                                            value="{{ $related_product->id }}">
                                                        <input type="hidden" name="quantity"
                                                            value="{{ $related_product->minimum_purchase }}">
                                                        <div class="product_action_box">
                                                            <ul class="list_none pr_action_btn">
                                                                <li class="add-to-cart">
                                                                    <a href="#"
                                                                        onclick="document.getElementById('addToCartForm{{ $related_product->id }}').submit(); return false;">
                                                                        <i class="icon-basket-loaded"></i> Add To Cart
                                                                    </a>
                                                                </li>
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
                                                    <div class="product_action_box">
                                                        <span class="badge text-bg-secondary">Out of Stock</span>
                                                        <ul class="list_none pr_action_btn">
                                                            <li><a
                                                                    href="{{ route('addToWishlist', ['productId' => $product->id]) }}"><i
                                                                        class="icon-heart"></i>
                                                                </a>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                @endif

                                            </div>
                                            <div class="product_info">
                                                <h6 class="product_title"><a
                                                        href="{{ route('productById', $related_product->id) }}">{{ $related_product->title }}</a>
                                                </h6>

                                                @if ($hasNonZeroQty === true)
                                                    <?php
                                                    // Search for the discount for the related product by its ID
                                                    $product_dis = App\Models\Discount::where('product_id', $related_product_id)->where('status', 1)->where('druft', 1)->first();
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
                                                                class="price">{{ (optional($productQty)->unit_price ?? 0) - 0 }}</span>

                                                            <del>$00</del>
                                                            <div class="on_sale">
                                                                <span>00%</span>
                                                            </div>
                                                        @endif

                                                        {{-- <p class="bg-warning"> Current Qty :
                                                            {{ $rel_productQty->current_qty }}</p> --}}
                                                    </div>
                                                @elseif ($hasNonZeroQty === false)
                                                    <div class="product_price">
                                                        <div class="d-flex justify-content-between">
                                                            <p class="price">$0</p>
                                                            <div class="on_sale">
                                                                <p><span class="badge text-bg-danger">Stock Out</span>
                                                                </p>
                                                            </div>
                                                        </div>
                                                        {{-- <p class="bg-warning"> Current Qty :
                                                            {{ $rel_productQty->current_qty }} in druft</p> --}}
                                                    </div>
                                                @endif

                                            </div>
                                        </div>
                                    </div>
                                @else
                                    <h1>Product not found</h1>
                                @endif
                            @endforeach
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- END SECTION SHOP -->
</div>
<!-- END MAIN CONTENT -->
<script>
    $(document).ready(function() {
        $('.star_rating span').click(function() {
            var ratingValue = $(this).data('value');
            $('#ratingInput').val(ratingValue);
        });
    });
</script>
