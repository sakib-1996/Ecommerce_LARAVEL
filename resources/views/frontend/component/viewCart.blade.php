<!-- START SECTION BREADCRUMB -->
<div class="breadcrumb_section bg_gray page-title-mini">
    <div class="container"><!-- STRART CONTAINER -->
        <div class="row align-items-center">
            <div class="col-md-6">
                <div class="page-title">
                    <h1>Shopping Cart</h1>
                </div>
            </div>
            <div class="col-md-6">
                <ol class="breadcrumb justify-content-md-end">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item"><a href="#">Pages</a></li>
                    <li class="breadcrumb-item active">Shopping Cart</li>
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
            <div class="row pb-5">
                <div class="col-12">
                    <div class="table-responsive shop_cart_table">
                        <form action="{{ route('updateCart') }}" method="POST" enctype="multipart/form-data">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th class="product-thumbnail">&nbsp;</th>
                                        <th class="product-name">Product</th>
                                        <th class="product-price">Price</th>
                                        <th class="product-price">Brand</th>
                                        <th class="product-quantity">Quantity</th>
                                        <th class="product-subtotal">Total</th>
                                        <th class="product-remove">Remove</th>
                                    </tr>
                                </thead>
                                @csrf
                                <tbody>
                                    @php
                                        $total = 0; // Initialize total variable
                                    @endphp

                                    @if (isset($cartProducts))
                                        @foreach ($cartProducts as $cartProduct)
                                            <?php
                                            $productQty = App\Models\ProductQty::where('product_id', $cartProduct->product_id)
                                                ->where('current_qty', '!=', 0)
                                                ->where('druft', '!=', 0)
                                                ->first();
                                            ?>

                                            <tr>
                                                <td class="product-thumbnail">
                                                    <a href="#"><img
                                                            src="{{ asset('storage/' . $cartProduct->product->thum_img) }}"
                                                            alt="product1"></a>
                                                </td>
                                                <td class="product-name" data-title="Product">
                                                    <a href="#">{{ $cartProduct->product->title }}</a>
                                                </td>

                                                @if ($productQty)
                                                    <td class="product-price" data-title="Price">
                                                        ${{ $productQty->unit_price }}</td>
                                                @else
                                                    <td class="product-price" data-title="Price">$00</td>
                                                @endif

                                                <td>Herllo</td>

                                                <td class="product-quantity" data-title="Quantity">
                                                    <div class="quantity">
                                                        @if ($productQty)
                                                            <input type="button" value="-"
                                                                onclick="minus('{{ $cartProduct->id }}', '{{ $productQty->unit_price }}','totalId-{{ $cartProduct->id }}')"
                                                                class="minus">
                                                            <input type="text" name="quantity[]"
                                                                id="{{ $cartProduct->id }}"
                                                                value="{{ $cartProduct->quantity }}" title="Qty"
                                                                class="qty" size="4">
                                                            <input type="button" value="+"
                                                                onclick="plus('{{ $cartProduct->id }}', '{{ $productQty->unit_price }}','totalId-{{ $cartProduct->id }}')"
                                                                class="plus">
                                                            <input type="hidden" name="product_id[]"
                                                                value="{{ $cartProduct->product_id }}" />
                                                        @else
                                                            <!-- Handle case where $productQty is null -->
                                                        @endif
                                                    </div>
                                                </td>

                                                @if ($productQty)
                                                    <td class="product-subtotal" id="totalId-{{ $cartProduct->id }}"
                                                        data-title="Total">
                                                        ${{ $productQty->unit_price * $cartProduct->quantity }}</td>
                                                @else
                                                    <td class="product-subtotal" id="totalId-{{ $cartProduct->id }}"
                                                        data-title="Total">$00</td>
                                                @endif

                                                <td class="product-remove" data-title="Remove">
                                                    <a href="{{ route('removeCartItem', $cartProduct->id) }}"><i
                                                            class="ti-close"></i></a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @endif

                                    {{-- <input type="text" value="{{ $total }}"> --}}
                                </tbody>
                            </table>
                            <div class="m-5">
                                <div class="text-end">
                                    <button class="btn btn-fill-out" type="submit">Proceed To CheckOut</button>
                                </div>
                            </div>
                        </form>
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


<script>
    $(document).ready(function() {
        $('#shipping_country').on('change', function() {
            var countryId = $(this).val(); // Get the selected country ID

            // Make an AJAX call to fetch shipping information based on the selected country
            $.ajax({
                url: '/availabledistrict/' + countryId,

                method: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                },
                success: function(response) {
                    // Clear existing options
                    // $('.district').empty();

                    // Append options
                    $.each(response.data, function(index, district) {
                        $('.district').append('<option value="' + district.id +
                            '" data-base-cost="' + district.base_cost +
                            '" data-cost-by-condition="' + district
                            .cost_by_condition +
                            '">' + district.district_name + '</option>');
                    });
                },
                error: function(xhr, status, error) {
                    console.error(xhr.responseText);
                }
            });
        });

        $('.district').on('change', function() {
            var selectedOption = $(this).find('option:selected');
            var baseCost = selectedOption.data('base-cost');
            var costByCondition = selectedOption.data('cost-by-condition');
            // Ensure the `cost` function is defined and available
            cost(baseCost, costByCondition);
        });
    });

    function cost(baseCost, costByCondition) {
        // Your logic here
        console.log("Base Cost: " + baseCost);
        $('.shipping').empty();
        $('.shipping').append(baseCost + costByCondition);
        $('.total').empty();
        $('.total').append({{ $total }} + baseCost + costByCondition);

        // console.log({{ $total }} + baseCost + costByCondition);
        // console.log("Cost by Condition: " + costByCondition);

    }
</script>

<script>
    $(document).ready(function() {
        $('#checkoutButton').click(function(e) {
            e.preventDefault(); // Prevent the default form submission

            // Display SweetAlert confirmation dialog
            Swal.fire({
                title: 'Are you sure?',
                text: "If you chnage in your cart you have to update cart first",
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, updated'
            }).then((result) => {
                if (result.isConfirmed) {
                    $(this).closest('form').submit();
                }
            });
        });
    });
</script>
