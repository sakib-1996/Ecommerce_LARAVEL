    <!-- START SECTION BREADCRUMB -->
    <div class="breadcrumb_section bg_gray page-title-mini">
        <div class="container"><!-- STRART CONTAINER -->
            <div class="row align-items-center">
                <div class="col-md-6">
                    <div class="page-title">
                        <h1>Wishlist</h1>
                    </div>
                </div>
                <div class="col-md-6">
                    <ol class="breadcrumb justify-content-md-end">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item"><a href="#">Pages</a></li>
                        <li class="breadcrumb-item active">Wishlist</li>
                    </ol>
                </div>
            </div>
        </div><!-- END CONTAINER-->
    </div>
    <!-- END SECTION BREADCRUMB -->

    <!-- START MAIN CONTENT -->
    <div class="main_content mb-5">

        <!-- START SECTION SHOP -->
        <div class="">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <div class="table-responsive wishlist_table">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th class="product-thumbnail">&nbsp;</th>
                                        <th class="product-name" style="width: 40%">Product</th>
                                        <th class="product-price">Price</th>
                                        <th class="product-stock-status">Stock Status</th>
                                        <th class="product-add-to-cart"></th>
                                        <th class="product-remove">Remove</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @isset($wishList)
                                        @foreach ($wishList as $productWish)
                                            <tr>
                                                <td class="product-thumbnail">
                                                    <a href="{{ route('productById', $productWish->product->id) }}"><img
                                                            src="{{ asset('storage/' . $productWish->product->thum_img) }}"
                                                            alt="product"></a>
                                                </td>
                                                <td class="product-name" data-title="Product">
                                                    <a
                                                        href="{{ route('productById', $productWish->product->id) }}">{{ $productWish->product->title }}</a>
                                                </td>
                                                @php
                                                    $qty = App\Models\ProductQty::where(
                                                        'product_id',
                                                        $productWish->product_id,
                                                    )
                                                        ->where('current_qty', '!=', 0)
                                                        ->where('druft', '!=', 0)
                                                        ->first();
                                                @endphp
                                                <td class="product-price" data-title="Price">$@if ($qty)
                                                        {{ $qty->unit_price }}
                                                    @else
                                                        00
                                                    @endif
                                                </td>

                                                <td class="product-stock-status" data-title="Stock Status">
                                                    @if ($qty)
                                                        <span class="badge rounded-pill text-bg-success">In Stock</span>
                                                    @else
                                                        <span class="badge rounded-pill text-bg-danger">Out of Stock</span>
                                                    @endif
                                                </td>
                                                <td class="product-add-to-cart">
                                                    <form action="{{ route('addToCart') }}" method="POST">
                                                        @csrf
                                                        <input type="hidden" name="product_id"
                                                            value="{{ $productWish->product_id }}">
                                                        <input type="hidden" name="quantity"
                                                            value="{{ $productWish->product->minimum_purchase ?? 1 }}">
                                                        <button type="submit" class="btn btn-sm btn-fill-out"><i
                                                                class="icon-basket-loaded"></i> Add to Cart</button>
                                                    </form>
                                                </td>

                                                <td class="product-remove" data-title="Remove">
                                                    <a href="{{ route('removeWishlist', $productWish->id) }}"><i
                                                            class="ti-close"></i></a>

                                                </td>
                                            </tr>
                                        @endforeach
                                    @endisset

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- END SECTION SHOP -->
    </div>
    <!-- END MAIN CONTENT -->

    <script>
        function plus(cartId, price, totalId) {
            console.log("Cart ID:", cartId);
            console.log("Price:", price);
            console.log("Total ID:", totalId);

            var oldQtyValue = document.getElementById(cartId).value;
            var newQtyValue = parseInt(oldQtyValue, 10) + 1;
            var newTotal = newQtyValue * price;
            document.getElementById(totalId).innerText = '';
            console.log("New Total:", newTotal);
            document.getElementById(totalId).innerText = '$' + newTotal;
        }

        function minus(cartId, price, totalId) {
            console.log("Cart ID:", cartId);
            console.log("Price:", price);
            console.log("Total ID:", totalId);

            var oldQtyValue = document.getElementById(cartId).value;
            var newQtyValue = parseInt(oldQtyValue, 10) - 1;
            if (newQtyValue < 1) {
                newQtyValue = 1;
            }
            var newTotal = newQtyValue * price;
            console.log("New Total:", newTotal);
            document.getElementById(totalId).innerText = '';
            document.getElementById(totalId).innerText = '$' + newTotal;
        }
    </script>
