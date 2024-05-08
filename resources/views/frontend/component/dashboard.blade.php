    <!-- START MAIN CONTENT -->
    <div class="main_content">
        <!-- START SECTION SHOP -->
        <div class="section">
            <div class="container">
                <div class="row">
                    <div class="col-lg-3 col-md-4">
                        <div class="dashboard_menu">
                            <ul class="nav nav-tabs flex-column" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" id="dashboard-tab" data-bs-toggle="tab" href="#dashboard"
                                        role="tab" aria-controls="dashboard" aria-selected="false"><i
                                            class="ti-layout-grid2"></i>Dashboard</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="orders-tab" data-bs-toggle="tab" href="#orders"
                                        role="tab" aria-controls="orders" aria-selected="false"><i
                                            class="ti-shopping-cart-full"></i>Orders</a>
                                </li>

                                <li class="nav-item">
                                    <a class="nav-link" id="account-detail-tab" data-bs-toggle="tab"
                                        href="#account-detail" role="tab" aria-controls="account-detail"
                                        aria-selected="true"><i class="ti-id-badge"></i>Account details</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('logout') }}"><i class="ti-lock"></i>Logout</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-lg-9 col-md-8">
                        <div class="tab-content dashboard_content">
                            <div class="tab-pane fade active show" id="dashboard" role="tabpanel"
                                aria-labelledby="dashboard-tab">
                                <div class="card">
                                    <div class="card-header">
                                        <h3>Dashboard</h3>
                                    </div>
                                    <div class="card-body">
                                        <p>From your account dashboard. you can easily check &amp; view your <a
                                                href="javascript:;" onclick="$('#orders-tab').trigger('click')">recent
                                                orders</a>, manage your <a href="javascript:;"
                                                onclick="$('#address-tab').trigger('click')">shipping and billing
                                                addresses</a> and <a href="javascript:;"
                                                onclick="$('#account-detail-tab').trigger('click')">edit your password
                                                and
                                                account details.</a></p>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="orders" role="tabpanel" aria-labelledby="orders-tab">
                                <div class="card">
                                    <div class="card-header">
                                        <h3>Orders</h3>
                                    </div>
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <table class="table">
                                                <thead>
                                                    <tr>
                                                        <th>Order</th>
                                                        <th>Date</th>
                                                        <th>Payment Status</th>
                                                        <th>Delivery Status</th>
                                                        <th>Total</th>
                                                        <th>Actions</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @if (isset($orders))
                                                        @foreach ($orders as $order)
                                                            <tr>
                                                                <td>#{{ $order->id }}</td>
                                                                <td>{{ $order->created_at->format('Y-m-d') }}</td>
                                                                {{-- <td>Processing</td> --}}
                                                                <td>{{ $order->payment_status }}</td>
                                                                <td>{{ $order->delivery_status }}</td>
                                                                <td>${{ $order->payable }}</td>
                                                                <td>
                                                                    <button type="button"
                                                                        class="btn btn-fill-out btn-sm ajax-call"
                                                                        data-order-id="{{ $order->id }}"
                                                                        data-bs-toggle="modal"
                                                                        data-bs-target="#staticBackdrop">
                                                                        View
                                                                    </button>
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                    @endif
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="tab-pane fade" id="account-detail" role="tabpanel"
                                aria-labelledby="account-detail-tab">
                                <div class="card">
                                    <div class="card-header">
                                        <h3>Account Details</h3>
                                    </div>
                                    <div class="card-body">
                                        <p>Already have an account? <a href="{{ route('login') }}">Log in instead!</a>
                                        </p>
                                        <form method="post" action="{{ route('profileCreate') }}"
                                            enctype="multipart/form-data">
                                            @csrf
                                            <div class="row">
                                                <div class="form-group col-md-6 mb-3">
                                                    <label for="first_name">First Name <span
                                                            class="required">*</span></label>
                                                    <input id="first_name"
                                                        class="form-control @error('first_name') is-invalid @enderror"
                                                        name="first_name" type="text"
                                                        value="{{ isset($userProfile) ? $userProfile->first_name : old('first_name') }}">
                                                    @error('first_name')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>


                                                <div class="form-group col-md-6 mb-3">
                                                    <label for="last_name">Last Name</label>
                                                    <input id="last_name"
                                                        class="form-control @error('last_name') is-invalid @enderror"
                                                        name="last_name" type="text"
                                                        value="{{ isset($userProfile) ? $userProfile->last_name : old('last_name') }}">
                                                    @error('last_name')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>


                                                <div class="form-group col-md-6 mb-3">
                                                    <div class="custom_select">
                                                        <label for="shipping_country">Select Your Country<span
                                                                class="required">*</span></label>
                                                        <select name="country_id" id="shipping_country"
                                                            class="form-control @error('country_id') is-invalid @enderror">
                                                            <option disabled selected>Select Your Shipping Country
                                                            </option>
                                                            @foreach ($countries as $country)
                                                                <option value="{{ $country->id }}"
                                                                    {{ isset($userProfile) && $userProfile->country_id == $country->id ? 'selected' : '' }}>
                                                                    {{ $country->country_name }}</option>
                                                            @endforeach
                                                        </select>
                                                        @error('country_id')
                                                            <span class="invalid-feedback" role="alert">
                                                                <strong>{{ $message }}</strong>
                                                            </span>
                                                        @enderror
                                                    </div>
                                                </div>


                                                <div class="form-group col-md-6 mb-3">
                                                    <div class="custom_select">
                                                        <label for="districts_id">Select Your District<span
                                                                class="required">*</span></label>
                                                        <select name="districts_id"
                                                            class="district form-control @error('districts_id') is-invalid @enderror">

                                                        </select>
                                                        @error('districts_id')
                                                            <span class="invalid-feedback" role="alert">
                                                                <strong>{{ $message }}</strong>
                                                            </span>
                                                        @enderror
                                                    </div>
                                                </div>

                                                <div class="form-group col-md-12 mb-3">
                                                    <label for="address_1">Address 1 <span
                                                            class="required">*</span></label>
                                                    <input id="address_1"
                                                        class="form-control @error('address_1') is-invalid @enderror"
                                                        name="address_1" type="text"
                                                        value="{{ isset($userProfile) ? $userProfile->address_1 : old('address_1') }}">
                                                    @error('address_1')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>


                                                <div class="form-group col-md-12 mb-3">
                                                    <label for="address_2">Address 2</label>
                                                    <input id="address_2"
                                                        class="form-control @error('address_2') is-invalid @enderror"
                                                        name="address_2" type="text"
                                                        value="{{ isset($userProfile) ? $userProfile->address_2 : old('address_2') }}">
                                                    @error('address_2')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>

                                                <div class="form-group col-md-12 mb-3">
                                                    <label for="city">City / Town <span
                                                            class="required">*</span></label>
                                                    <input id="city"
                                                        class="form-control @error('city') is-invalid @enderror"
                                                        name="city" type="city"
                                                        value="{{ isset($userProfile) ? $userProfile->city : old('city') }}">
                                                    @error('city')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>


                                                <div class="form-group col-md-12 mb-3">
                                                    <label for="post_code">Postcode / Zip <span
                                                            class="required">*</span></label>
                                                    <input id="post_code"
                                                        class="form-control @error('post_code') is-invalid @enderror"
                                                        name="post_code" type="text"
                                                        value="{{ isset($userProfile) ? $userProfile->post_code : old('post_code') }}">
                                                    @error('post_code')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>


                                                <div class="form-group col-md-12 mb-3">
                                                    <label for="email">Email Address <span
                                                            class="required">*</span></label>
                                                    <input id="email" readonly
                                                        class="form-control @error('email') is-invalid @enderror"
                                                        name="email" type="email"
                                                        value="{{ auth()->user()->email }}">
                                                    @error('email')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                                <hr>
                                                <div>
                                                    <h4 class="text-center text-danger">Changing Password</h4>
                                                </div>
                                                <div class="form-group col-md-12 mb-3">
                                                    <label for="password">Current Password</label>
                                                    <input id="password"
                                                        class="form-control @error('password') is-invalid @enderror"
                                                        name="password" type="password"
                                                        value="{{ old('password') }}">
                                                    @error('password')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                                <div class="form-group col-md-12 mb-3">
                                                    <label for="npassword">New Password</label>
                                                    <input id="npassword"
                                                        class="form-control @error('npassword') is-invalid @enderror"
                                                        name="npassword" type="password"
                                                        value="{{ old('npassword') }}">
                                                    @error('npassword')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                                <div class="form-group col-md-12 mb-3">
                                                    <label for="cpassword">Confirm Password</label>
                                                    <input id="cpassword"
                                                        class="form-control @error('cpassword') is-invalid @enderror"
                                                        name="cpassword" type="password"
                                                        value="{{ old('cpassword') }}">
                                                    @error('cpassword')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                                <div class="col-md-12">
                                                    <button type="submit" class="btn btn-fill-out"
                                                        value="Submit">Save</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- END SECTION SHOP -->
    </div>


    <!-- Button trigger modal -->


    <!-- Modal -->
    <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div>
                        <div class="container-fluid">
                            <div class="row mb-2">
                                <div class="col-sm-6">
                                    <h1>Invoice</h1>
                                </div>

                            </div>
                        </div>
                        <!-- /.container-fluid -->
                        <div class="container-fluid">
                            <div class="row">
                                <div class="col-12">
                                    <!-- Main content -->
                                    <div class="invoice p-3 mb-3">
                                        <!-- title row -->
                                        <div class="row">
                                            <div class="col-12">
                                                <h4>
                                                    <i class="fas fa-globe"></i> E Commerce.
                                                    <small class="float-end date">Date: 2/10/2014</small>
                                                </h4>
                                            </div>
                                            <!-- /.col -->
                                        </div>
                                        <!-- info row -->
                                        <div class="row invoice-info">
                                            <div class="col-sm-4 invoice-col">
                                                From
                                                <address>
                                                    <strong>E Commerce.</strong><br>
                                                    795 Folsom Ave, Suite 600<br>
                                                    San Francisco, CA 94107<br>
                                                    Phone: (804) 123-5432<br>
                                                    Email: info@almasaeedstudio.com
                                                </address>
                                            </div>
                                            <!-- /.col -->
                                            <div class="col-sm-4 invoice-col">
                                                To
                                                <address>
                                                    <p class="ship_details">

                                                    </p>
                                                </address>
                                            </div>
                                            <!-- /.col -->
                                            <div class="col-sm-4 invoice-col">
                                                <b class="me-2">Invoice</b><span class="invoice_id"></span>
                                                <br>
                                                <br>
                                                <b class="me-2">Order ID:</b><span class="tran_id"></span>
                                                <br>
                                                <b class="me-2">Subtotal:</b><span class="total"></span>
                                                <br>
                                                <b class="me-2">Vat:</b><span class="vat"></span>
                                                <br>
                                                <b class="me-2">Shipping Cost:</b><span
                                                    class="shipping_cost"></span>
                                                <br>
                                                <b class="me-2">Discount:</b><span class="discount"></span>
                                                <br>
                                                <b class="me-2">Account:</b><span class="payable"></span>
                                                <br>
                                            </div>
                                            <!-- /.col -->
                                        </div>
                                        <!-- /.row -->

                                        <!-- Table row -->
                                        <div class="row my-5">
                                            <div class="col-12 table-responsive">
                                                <table class="table table-striped">
                                                    <thead>
                                                        <tr>
                                                            <th style="width: 5%">Sl #</th>
                                                            <th style="width: 50%">Product</th>
                                                            <th style="">Qty</th>
                                                            <th style="">SKU</th>
                                                            <th style="">Subtotal</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody class="invoice_product">

                                                    </tbody>
                                                </table>
                                            </div>
                                            <!-- /.col -->
                                        </div>
                                        <!-- /.row -->

                                        <div class="row">
                                            <!-- accepted payments column -->
                                            <div class="col-6">
                                                <p class="lead">Payment Methods:</p>
                                                <img src="{{ asset('backend') }}/dist/img/credit/visa.png"
                                                    alt="Visa">
                                                <img src="{{ asset('backend') }}/dist/img/credit/mastercard.png"
                                                    alt="Mastercard">
                                                <img src="{{ asset('backend') }}/dist/img/credit/american-express.png"
                                                    alt="American Express">
                                                <img src="{{ asset('backend') }}/dist/img/credit/paypal2.png"
                                                    alt="Paypal">

                                                <p class="text-muted well well-sm shadow-none"
                                                    style="margin-top: 10px;">
                                                    Etsy doostang zoodles disqus groupon greplin oooj voxy zoodles,
                                                    weebly ning heekya handango imeem
                                                    plugg
                                                    dopplr jibjab, movity jajah plickers sifteo edmodo ifttt zimbra.
                                                </p>
                                            </div>
                                            <!-- /.col -->
                                            <div class="col-6">

                                                <div class="table-responsive">
                                                    <table class="table">
                                                        <tr>
                                                            <th style="width:50%">Subtotal:</th>
                                                            <td>$<span class="total"></span></td>
                                                        </tr>
                                                        <tr>
                                                            <th>Tax (3%)</th>
                                                            <td>$<span class="vat"></span></td>
                                                        </tr>
                                                        <tr>
                                                            <th>Shipping:</th>
                                                            <td>$<span class="shipping_cost"></span></td>
                                                        </tr>
                                                        <tr>
                                                            <th>Discount:</th>
                                                            <td>$<span class="discount"></span></td>
                                                        </tr>
                                                        <tr>
                                                            <th>Total:</th>
                                                            <td>$<span class="payable"></span></td>
                                                        </tr>
                                                    </table>
                                                </div>
                                            </div>
                                            <!-- /.col -->
                                        </div>
                                        <!-- /.row -->

                                        <!-- this row will not appear when printing -->
                                        <div class="row no-print">
                                            <div class="col-12">
                                                <a href="#" rel="noopener" target="_blank"
                                                    class="btn btn-default"><i class="fas fa-print"></i> Print</a>
                                                <button type="button" class="btn btn-primary float-right"
                                                    style="margin-right: 5px;">
                                                    <i class="fas fa-download"></i> Generate PDF
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- /.container-fluid -->
                    </div>
                    <!-- /.content-wrapper -->
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>


    <!-- END MAIN CONTENT -->
    <script>
        $(document).ready(function() {
            $('#shipping_country').on('change', function() {
                var countryId = $(this).val(); // Get the selected country ID

                // Retrieve CSRF token from meta tag
                var csrfToken = $('meta[name="csrf-token"]').attr('content');

                // Make an AJAX call to fetch shipping information based on the selected country
                $.ajax({
                    url: '/availabledistrict/' + countryId,
                    method: 'POST',
                    data: {
                        _token: csrfToken, // Pass the retrieved CSRF token
                    },
                    success: function(response) {
                        // Clear existing options
                        $('.district').empty();
                        // Append initial disabled and selected option
                        $('.district').append(
                            '<option disabled selected>Select Your Shipping District</option>'
                        );

                        // Check if response contains data
                        if (response && response.data) {
                            // Append options
                            $.each(response.data, function(index, district) {
                                $('.district').append('<option value="' + district.id +
                                    '">' + district.district_name + '</option>');
                            });
                        } else {
                            console.error('No data found in response.');
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('Error:', xhr.responseText);
                    }
                });
            });
        });
    </script>
    <script>
        $(document).ready(function() {
            $('.ajax-call').click(function(event) {
                event.preventDefault();

                var orderID = $(this).data('order-id');
                var url = "{{ route('ordersProduct', ':orderID') }}";
                url = url.replace(':orderID', orderID);

                $.ajax({
                    url: url,
                    type: "GET",
                    dataType: "json",
                    success: function(response) {
                        var invoice = response[0].invoice;
                        var products = response;

                        // Split the details and extract individual parts
                        var cusDetails = invoice.cus_details.split(',');
                        var shipDetails = invoice.ship_details.split(',');

                        // Construct HTML content representing the shipping details
                        var shipDetailsHtml = '<strong>Name: ' + shipDetails[0] + '</strong> ' +
                            '<br>' +
                            'Address: ' + shipDetails[1] + '<br>' +
                            // 'Address: ' + shipDetails[1] + '<br>' +
                            'City: ' + shipDetails[2] + '<br>' +
                            'Phone: ' + shipDetails[3];

                        // Clear and update the shipping details
                        $('.ship_details').empty().html(shipDetailsHtml);

                        // Clear and update the invoice details
                        $('.invoice_id').empty().text('#' + invoice.id);
                        $('.tran_id').empty().text(invoice.tran_id);
                        $('.total').empty().text(invoice.total);
                        $('.vat').empty().text(invoice.vat);
                        $('.discount').empty().text(invoice.discount ? invoice.discount : 0);
                        $('.shipping_cost').empty().text(invoice.shipping_cost);
                        $('.payable').empty().text(invoice.payable);

                        // Format the created date
                        var createdDate = new Date(invoice.created_at);
                        var options = {
                            day: 'numeric',
                            month: 'long',
                            year: 'numeric'
                        };
                        var formattedDate = createdDate.toLocaleDateString('en-US', options);
                        $('.date').empty().text(formattedDate);

                        // Clear and update the product details
                        var productsHtml = '';
                        var count = 1;
                        // Loop through products to construct HTML content
                        products.forEach(function(product) {
                            productsHtml += '<tr>' +
                                '<td>' + count++ + '</td>' +
                                '<td>' + product.product.title + '</td>' +
                                '<td>' + product.qty + '</td>' +
                                '<td>' + product.sku + '</td>' +
                                '<td>$' + product.product_sub_total + '</td>' +
                                '</tr>';
                        });

                        // Clear and append the product details
                        $('.invoice_product').empty().append(productsHtml);
                    },

                    error: function(xhr, status, error) {
                        console.error(xhr.responseText);
                    }
                });
            });
        });
    </script>
