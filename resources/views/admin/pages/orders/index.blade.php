@extends('admin.layouts.app')
@section('custon_css')
    <style>
        .delivery-status {
            width: 100%;
            padding: 8px;
            border: 1px solid #5e8df3;
            border-radius: 4px;
            background-color: #fff;
            color: #2e2e2e;
            font-size: 14px;
        }
    </style>
@endsection
@section('admin_contant')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Orders</h1>
                </div>
            </div>
        </div>
    </div>
    <!-- /.content-header -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header bg-dark">
                            <h3 class="card-title">All Order List Here</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table style="width: 100%" id=""
                                class="table table-bordered table-striped table-sm ytable">
                                <thead>
                                    <tr>
                                        <th style="width: 20%">Transaction ID</th>
                                        <th style="width: 20%">Buying Date</th>
                                        <th style="width: 20%">Delivery Status</th>
                                        <th>Total Price</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>

                                    @isset($invoices)
                                        @foreach ($invoices as $invoice)
                                            <tr>
                                                <td>{{ $invoice->tran_id }}</td>
                                                <td>{{ $invoice->created_at->format('Y-m-d') }}</td>
                                                <td>
                                                    <form id="deliveryStatusForm{{ $invoice->id }}"
                                                        action="{{ route('deliveryStatus', $invoice->id) }}" method="POST">
                                                        @csrf
                                                        <select name="deliveryStatus" class="form-select delivery-status"
                                                            data-invoice-id="{{ $invoice->id }}">
                                                            <option value="Pending"
                                                                {{ $invoice->delivery_status == 'Pending' ? 'selected' : '' }}>
                                                                Pending</option>
                                                            <option value="Processing"
                                                                {{ $invoice->delivery_status == 'Processing' ? 'selected' : '' }}>
                                                                Processing</option>
                                                            <option value="Completed"
                                                                {{ $invoice->delivery_status == 'Completed' ? 'selected' : '' }}>
                                                                Delivared</option>

                                                        </select>
                                                    </form>
                                                </td>
                                                <td>{{ $invoice->total }}</td>
                                                <td>
                                                    <a href="#" class="btn btn-primary ajax-call"
                                                        data-order-id="{{ $invoice->id }}" data-toggle="modal"
                                                        data-target="#staticBackdrop">Invoice</a>
                                                    <!-- Add more actions if needed -->
                                                </td>
                                            </tr>
                                        @endforeach
                                    @endisset
                                </tbody>
                            </table>
                        </div>
                    </div>
                    @if ($invoices->total() > $invoices->perPage())
                        <nav aria-label="Page navigation">
                            <ul class="pagination justify-content-center">
                                {{-- Previous Page Link --}}
                                @if ($invoices->onFirstPage())
                                    <li class="page-item disabled">
                                        <span class="page-link">&laquo;</span>
                                    </li>
                                @else
                                    <li class="page-item">
                                        <a class="page-link" href="{{ $invoices->previousPageUrl() }}"
                                            rel="prev">&laquo;</a>
                                    </li>
                                @endif

                                {{-- Pagination Elements --}}
                                @for ($i = 1; $i <= $invoices->lastPage(); $i++)
                                    <li class="page-item {{ $invoices->currentPage() == $i ? 'active' : '' }}">
                                        <a class="page-link" href="{{ $invoices->url($i) }}">{{ $i }}</a>
                                    </li>
                                @endfor

                                {{-- Next Page Link --}}
                                @if ($invoices->hasMorePages())
                                    <li class="page-item">
                                        <a class="page-link" href="{{ $invoices->nextPageUrl() }}"
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
    </section>


    <!-- Modal -->
    <div class="modal fade " id="staticBackdrop" data-backdrop="static" data-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
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
                                                    <small class="float-right date">Date: 2/10/2014</small>
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
                                                <b class="mr-2">Invoice</b><span class="invoice_id"></span>
                                                <br>
                                                <br>
                                                <b class="mr-2">Order ID:</b><span class="tran_id"></span>
                                                <br>
                                                <b class="mr-2">Subtotal:</b><span class="total"></span>
                                                <br>
                                                <b class="mr-2">Vat:</b><span class="vat"></span>
                                                <br>
                                                <b class="mr-2">Shipping Cost:</b><span class="shipping_cost"></span>
                                                <br>
                                                <b class="mr-2">Discount:</b><span class="discount"></span>
                                                <br>
                                                <b class="mr-2">Account:</b><span class="payable"></span>
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

                                                <p class="text-muted well well-sm shadow-none" style="margin-top: 10px;">
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
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary">Understood</button>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('custom_js')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

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

    <script>
        $(document).ready(function() {
            $('.delivery-status').change(function() {
                var formId = $(this).closest('form').attr('id');
                $('#' + formId).submit();
            });
        });
    </script>
@endsection
