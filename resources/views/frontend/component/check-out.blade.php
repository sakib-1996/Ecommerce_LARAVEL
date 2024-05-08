<div class="breadcrumb_section bg_gray page-title-mini">
    <div class="container"><!-- STRART CONTAINER -->
        <div class="row align-items-center">
            <div class="col-md-6">
                <div class="page-title">
                    <h1>Checkout</h1>
                </div>
            </div>
            <div class="col-md-6">
                <ol class="breadcrumb justify-content-md-end">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                    <li class="breadcrumb-item">Pages</li>
                    <li class="breadcrumb-item active">Checkout</li>
                </ol>
            </div>
        </div>
    </div><!-- END CONTAINER-->
</div>

<div class="main_content pb-5">

    <!-- START SECTION SHOP -->
    <div class="">
        <div class="container">
            {{-- <form method="post" action="{{ route('checkOut') }}" enctype="multipart/form-data"> --}}
            <form id="myForm" action="{{ route('checkOut') }}" method="post">
                @csrf
                <div class="row">
                    <div class="col-md-6">
                        <div class="heading_s1">
                            <h4>Billing Details</h4>
                        </div>


                        <div class="form-group mb-3">
                            <label for="">First Name </label>
                            <input type="text" readonly required class="form-control" name="fname"
                                placeholder="First name *"
                                value="{{ isset($userProfile) ? $userProfile->first_name : '' }}">

                        </div>
                        <div class="form-group mb-3">
                            <label for="">Last Name </label>
                            <input type="text" readonly required class="form-control" name="lname"
                                placeholder="Last name *"value="{{ isset($userProfile) ? $userProfile->last_name : '' }}">
                        </div>
                        <div class="form-group mb-3">
                            <label for="">Country * </label>
                            <input type="text" readonly required class="form-control" name="country"
                                placeholder="Country *"
                                value="{{ isset($userProfile) ? $userProfile->country->country_name : '' }}">
                        </div>
                        <?php
                        $district = App\Models\AvailableDistrict::where('id', $userProfile->districts_id)->first();
                        
                        ?>
                        <div class="form-group mb-3">
                            <label for="">District * </label>
                            <input type="text" readonly required class="form-control" name="district"
                                placeholder="District *" readonly
                                value="{{ isset($district) ? $district->district_name : '' }}">
                        </div>

                        <div class="form-group mb-3">
                            <label for="">Address-1 * </label>
                            <input type="text" readonly class="form-control" name="billing_address" required=""
                                placeholder="Address *"
                                value="{{ isset($userProfile) ? $userProfile->address_1 : '' }}">
                        </div>
                        <div class="form-group mb-3">
                            <label for="">Address-2 * </label>
                            <input type="text" readonly class="form-control" name="billing_address2" required=""
                                placeholder="Address line2"
                                value="{{ isset($userProfile) ? $userProfile->address_2 : '' }}">
                        </div>
                        <div class="form-group mb-3">
                            <label for="">City / Town *</label>
                            <input class="form-control" readonly required type="text" name="city"
                                placeholder="City / Town *" value="{{ isset($userProfile) ? $userProfile->city : '' }}">
                        </div>

                        <div class="form-group mb-3">
                            <label for="">Postcode / ZIP *</label>
                            <input class="form-control" readonly required type="text" name="zipcode"
                                placeholder="Postcode / ZIP *"
                                value="{{ isset($userProfile) ? $userProfile->post_code : '' }}">
                        </div>

                        <div class="form-group mb-3">
                            <label for="">Phone* (You can change)</label>
                            <input class="form-control" required type="text" name="phone" placeholder="Phone *"
                                value="{{ auth()->check() ? auth()->user()->phone : '' }}">
                        </div>

                        <div class="form-group mb-4">
                            <label for="">Email*</label>
                            <input class="form-control" readonly required type="text" name="email"
                                placeholder="Email address *"value="{{ auth()->check() ? auth()->user()->email : '' }}">
                        </div>


                        <div class="ship_detail">
                            <div class="form-group mb-3">
                                <div class="chek-form">
                                    <div class="custome-checkbox">
                                        <input class="form-check-input" type="checkbox" name="checkbox"
                                            id="differentaddress">
                                        <label class="form-check-label label_info" for="differentaddress"><span>Ship
                                                to a different address?</span></label>
                                    </div>
                                </div>
                            </div>
                            <div class="different_address">

                                <div class="form-group mb-3">
                                    <input name="first_name2" type="text" class="form-control"
                                        placeholder="First name *">
                                </div>
                                <div class="form-group mb-3">
                                    <input name="last_name2" class="form-control" type="text"
                                        placeholder="Last Name">
                                </div>
                                <div class="form-group mb-3">
                                    <div class="custom_select">
                                        <select name="country_id2" id="shipping_country" class="form-control">
                                            <option disabled selected>Select your country...</option>
                                            @foreach ($countries as $country)
                                                <option value="{{ $country->id }}">{{ $country->country_name }}
                                                </option>
                                            @endforeach

                                        </select>
                                    </div>
                                </div>
                                <div class="form-group mb-3">
                                    <div class="custom_select">
                                        <select name="district_id2" class="district_id2 form-control">

                                        </select>
                                    </div>
                                </div>

                                <div class="form-group mb-3">
                                    <input type="text" name="e_address_1" class="form-control"
                                        placeholder="Address-1 *">
                                </div>
                                <div class="form-group mb-3">
                                    <input name="city2" class="form-control" type="text"
                                        placeholder="City / Town *">
                                </div>
                                <div class="form-group mb-3">
                                    <input name="postcode_2" class="form-control" type="text"
                                        placeholder="Postcode / ZIP *">
                                </div>

                                <div class="form-group mb-3">
                                    <input name="phone_2" class="form-control" type="text" placeholder="Phone *">
                                </div>
                            </div>
                        </div>
                        <div class="heading_s1">
                            <h4>Additional information</h4>
                        </div>
                        <div class="form-group mb-0">
                            <textarea rows="5" class="form-control" placeholder="Order notes"></textarea>
                        </div>

                    </div>


                    <div class="col-md-6">
                        <div class="order_review">
                            <div class="heading_s1">
                                <h4>Your Orders</h4>
                            </div>
                            <div class="table-responsive order_table">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>Product</th>
                                            <th style="width: 2%">Quantity</th>
                                            <th>Total</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            $totalAmount = 0; // Initialize total amount
                                            $totalProductArea = 0; // Initialize total product area
                                            $discount = 0;
                                        @endphp

                                        @foreach ($cartProducts as $cartProduct)
                                            @php
                                                // Fetch product quantities outside of the loop
                                                $productsQty = App\Models\ProductQty::where(
                                                    'product_id',
                                                    $cartProduct->product_id,
                                                )
                                                    ->where('druft', '!=', 0)
                                                    ->get();
                                                $remainingQty = $cartProduct->quantity;

                                                // Search for the discount for the related product by its ID
                                                $product_dis = App\Models\Discount::where(
                                                    'product_id',
                                                    $cartProduct->product_id,
                                                )
                                                    ->where('status', 1)
                                                    ->where('druft', 1)
                                                    ->first();

                                                if ($product_dis !== null) {
                                                    $discount += $product_dis->dis_rate * $cartProduct->quantity; // Accumulate the discount
                                                }
                                            @endphp

                                            @isset($productsQty)
                                                @foreach ($productsQty as $productQty)
                                                    @php
                                                        $productPrice = $productQty->unit_price;
                                                    @endphp

                                                    @if ($productQty->current_qty > 0)
                                                        <!-- Check if current_qty is greater than 0 -->
                                                        @if ($remainingQty <= 0)
                                                        @break

                                                    @elseif ($productQty->current_qty >= $remainingQty)
                                                        <tr>
                                                            <td>{{ $cartProduct->product->title }}</td>
                                                            <td>
                                                                <span class="product-qty">x
                                                                    {{ $remainingQty }}</span>
                                                                <input name="qtyId[]" type="hidden"
                                                                    value="{{ $productQty->id }}">
                                                                <input name="disId[]" type="hidden"
                                                                    value="{{ $product_dis ? $product_dis->id : '' }}">
                                                                <input name="qty[]" type="hidden"
                                                                    value="{{ $remainingQty }}">
                                                                <input name="productId[]" type="hidden"
                                                                    value="{{ $cartProduct->product_id }}">
                                                            </td>
                                                            <td>${{ $productPrice * $remainingQty }}</td>
                                                        </tr>
                                                        @php
                                                            $totalAmount += $productPrice * $remainingQty; // Update total amount
                                                            $totalProductArea +=
                                                                $cartProduct->product->length *
                                                                $cartProduct->product->width *
                                                                $remainingQty; // Update total product area
                                                            $remainingQty = 0;
                                                        @endphp
                                                    @else
                                                        <tr>
                                                            <td>{{ $cartProduct->product->title }}</td>
                                                            <td>
                                                                <span class="product-qty">x
                                                                    {{ $productQty->current_qty }}</span>
                                                                <input name="qtyId[]" type="text"
                                                                    value="{{ $productQty->id }}">
                                                                <input name="disId[]" type="text"
                                                                    value="{{ $product_dis ? $product_dis->id : '' }}">
                                                                <input name="qty[]" type="text"
                                                                    value="{{ $productQty->current_qty }}">
                                                                <input name="productId[]" type="text"
                                                                    value="{{ $cartProduct->product_id }}">
                                                            </td>
                                                            <td>${{ $productPrice * $productQty->current_qty }}
                                                            </td>
                                                        </tr>
                                                        @php
                                                            $totalAmount += $productPrice * $productQty->current_qty; // Update total amount
                                                            $totalProductArea +=
                                                                $cartProduct->product->length *
                                                                $cartProduct->product->width *
                                                                $productQty->current_qty; // Update total product area
                                                            $remainingQty -= $productQty->current_qty;
                                                        @endphp
                                                    @endif
                                                @endif
                                            @endforeach
                                        @endisset
                                    @endforeach

                                </tbody>

                                <tfoot>
                                    <tr>
                                        <th>SubTotal</th>
                                        <td></td>
                                        <td class="product-subtotal">${{ $totalAmount }}</td>
                                    </tr>
                                    <tr>
                                        <th>Vat (3%)</th>
                                        <td></td>
                                        <td class="product-subtotal">${{ ($totalAmount * 3) / 100 }}</td>
                                    </tr>
                                    <tr>
                                        <th>Discount</th>
                                        <td></td>
                                        <td class="product-subtotal">${{ $discount }}</td>
                                    </tr>
                                    <tr>
                                        <th>Shipping</th>
                                        <td></td>
                                        <td>$<span class="shipping">
                                                @php
                                                    $ProductAreaCost = $district->base_cost; // Initialize outside of if statement
                                                @endphp
                                                @if ($totalProductArea >= 400)
                                                    {{ $district->base_cost + ($totalProductArea - 400) * $district->cost_by_condition }}

                                                    @php
                                                        $ProductAreaCost =
                                                            $district->base_cost +
                                                            ($totalProductArea - 400) * $district->cost_by_condition;
                                                    @endphp
                                                @else
                                                    {{ $district->base_cost }}
                                                    @php
                                                        $ProductAreaCost = $district->base_cost;
                                                    @endphp
                                                @endif

                                            </span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Total</th>
                                        <td></td>
                                        <td class="product-subtotal">$<span
                                                class="total">{{ $totalAmount + $ProductAreaCost - $discount + ($totalAmount * 3) / 100 }}</span>
                                        </td>
                                    </tr>

                                </tfoot>
                            </table>
                        </div>
                        <button type="submit" class="btn btn-fill-out btn-block">Place Order</button>
                    </div>
                </div>
        </form>
    </div>
</div>
</div>
</div>
<!-- END MAIN CONTENT -->

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
                    $('.district_id2').empty();
                    $('.district_id2').append(
                        '<option disabled selected>Select your country...</option>');


                    // Append options
                    $.each(response.data, function(index, district) {
                        $('.district_id2').append('<option value="' + district.id +
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

        $('.district_id2').on('change', function() {
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

        var shippingCost = baseCost + {{ $totalProductArea - 400 }} * costByCondition

        $('.shipping').append(shippingCost);
        $('.total').empty();
        $('.total').append({{ $totalAmount + ($totalAmount * 3) / 100 }} + shippingCost);




        // console.log("Cost by Condition: " + costByCondition);

    }
</script>

<script>
    $(document).ready(function() {
        $('#myForm').submit(function(event) {
            // Prevent default form submission
            event.preventDefault();

            // Serialize form data
            var formData = $(this).serialize();

            // Submit form data via AJAX
            $.ajax({
                type: 'POST',
                url: $(this).attr('action'),
                data: formData,
                success: function(response) {
                    try {
                        // Update result div with server response
                        $('#result').html(response);

                        // Show paymentMethodModal modal
                        $('#paymentMethodModal').modal('show');

                        // Parse the JSON response
                        var responseData =
                            response; // No need to parse as it's already an object

                        // Check if the response status is "success"
                        if (responseData.status === "success") {
                            // Clear previous content in paymentList
                            $("#paymentList").empty();

                            // Loop through payment methods and populate the table
                            responseData.paymentMethod.desc.forEach((item, i) => {
                                let EachItem = `<tr>
                <td><img class="w-50" src="${item.logo}" alt="product"></td>
                <td><p>${item.name}</p></td>
                <td><a class="btn btn-danger btn-sm" href="${item.redirectGatewayURL}">Pay</a></td>
            </tr>`;
                                $("#paymentList").append(EachItem);
                            });
                        } else {
                            // If status is not "success", show an alert
                            alert("Request Fail");
                        }
                    } catch (error) {
                        console.error("Error processing response:", error);
                        // Handle the error gracefully, display an error message, or take appropriate action
                    }
                },

                error: function(xhr, status, error) {
                    // Handle errors
                    console.error(xhr.responseText);
                }
            });
        });
    });
</script>
