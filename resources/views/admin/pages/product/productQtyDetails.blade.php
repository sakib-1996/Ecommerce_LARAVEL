@extends('admin.layouts.app')
@section('admin_contant')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Product Invantory Details</h1>
                </div>
                <div class="col-sm-6">
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>
    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="row mb-2">
                                <div class="col-sm-6">
                                    <h4>{{ $product->title }}</h4>
                                    <h4>{{ $product->product_id }}</h4>
                                </div>
                                <div class="col-sm-6">
                                    <ol class="breadcrumb float-sm-right">
                                        <a href="{{ route('products.addQty', $product->id) }}" class="btn btn-primary"> +
                                            Add Quantity</a>
                                    </ol>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <table id="example1" class="table table-bordered table-hover table-striped table-sm">
                                <thead>
                                    <tr>
                                        <th style="width: 3%">SL</th>
                                        <th>SKU</th>
                                        <th>Quantity</th>
                                        <th>Current Qty</th>
                                        <th>Status</th>
                                        <th>Druft</th>
                                        <th>Unit Price</th>
                                        <th>Purchase Price</th>
                                        <th>Size</th>
                                        <th>Color</th>
                                        <th>Unit</th>
                                        <th>Date</th>
                                        <th class="text-right" style="width: 12%">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $nonZeroQtyItems = $productQtys->reject(function ($item) {
                                            return $item->current_qty == 0;
                                        });

                                        $zeroQtyItems = $productQtys->filter(function ($item) {
                                            return $item->current_qty == 0;
                                        });

                                        $sortedProductQtys = $nonZeroQtyItems->concat($zeroQtyItems)->values();
                                        $firstNonZeroEncountered = false;
                                    @endphp

                                    @foreach ($sortedProductQtys as $key => $productQty)
                                        <tr>
                                            <td>{{ $key + 1 }}</td>
                                            <td>{{ $productQty->sku }}</td>
                                            <td>{{ $productQty->qty }}</td>
                                            <td>
                                                {{ $productQty->current_qty == 0 ? '00' : $productQty->current_qty }}

                                            </td>
                                            <td>
                                                @if ($productQty->current_qty != 0)
                                                    @if (!$firstNonZeroEncountered)
                                                        <?php $firstNonZeroEncountered = true; ?>
                                                        <span class="badge badge-success ml-1">Active</span>
                                                    @else
                                                        <span class="badge badge-warning ml-1">In Stock</span>
                                                    @endif
                                                @else
                                                    <span class="badge badge-danger ml-1">Stock Out</span>
                                                @endif
                                            </td>
                                            <th>

                                                <form id="myForm-{{ $productQty->id }}"
                                                    action="{{ route('qty.druft.update', $productQty->id) }}"
                                                    method="POST">
                                                    @csrf <!-- Add CSRF token field -->
                                                    <div class="custom-control custom-switch">
                                                        <input class="custom-control-input druft-checkbox" type="checkbox"
                                                            onclick="updateStatus({{ $productQty->id }})"
                                                            id="status-{{ $productQty->id }}"
                                                            data-id="{{ $productQty->id }}"
                                                            {{ $productQty->druft == 1 ? 'checked' : '' }}>
                                                        <label class="custom-control-label"
                                                            for="status-{{ $productQty->id }}"></label>
                                                    </div>
                                                </form>
                                                @if ($productQty->druft === 0)
                                                    <div class="badge badge-warning ml-1">Druft</div>
                                                @else
                                                    <div class="badge badge-success ml-1">Published</div>
                                                @endif
                                            </th>
                                            <td>{{ $productQty->unit_price }}</td>
                                            <td>{{ $productQty->purchase_price }}</td>
                                            <td>{{ optional($productQty->size)->title }}</td>
                                            <td>{{ optional($productQty->color)->color }}</td>
                                            <td>{{ optional($productQty->unit)->value }}</td>
                                            <td>{{ $productQty->created_at->format('d-m-y') }}</td>
                                            <td class="text-right">
                                                <a href="#" class="btn btn-info btn-sm edit mx-1"
                                                    data-id="{{ $productQty->id }}" data-toggle="modal"
                                                    data-target="#editModal"><i class="fas fa-edit"></i></a>

                                                <a href="{{ route('Qty.delete', $productQty->id) }}"
                                                    class="btn btn-danger btn-sm mx-1" id="delete">
                                                    <i class="fas fa-trash"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Modal -->
    <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Edit Quentity</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('products.QtyUpdate') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body p-4">
                        <div class="">
                            <input type="" name="id" id="qtyUpdateId">
                            <div>
                                <label class="text-muted" for="qty">Quantity</label>
                            </div>
                            <div>
                                <input type="text" class="form-control" id="qty" name="qty">
                            </div>
                        </div>
                        <div class="">
                            <div>
                                <label class="text-muted" for="unit_price">Unit Price</label>
                            </div>
                            <div>
                                <input type="text" class="form-control" id="unit_price" name="unit_price">
                            </div>
                        </div>
                        <div class="my-2">
                            <div>
                                <label class="text-muted" for="purchase_price">Purchase Price</label>
                            </div>
                            <div>
                                <input type="text" class="form-control" id="purchase_price" name="purchase_price">
                            </div>
                        </div>
                        <div class="my-2">
                            <div>
                                <label class="text-muted" for="unit">Unit (kg/pc)</label>
                            </div>
                            <div>
                                <input type="text" class="form-control" id="unit" name="unit"
                                    placeholder="kg/pc">
                            </div>
                        </div>
                        <!-- Size -->
                        <div class="mb-4">
                            <div class="form-group">
                                <label class="text-muted" for="size_id">Size</label>
                                <select class="form-control" id="size_id" name="size_id" style="width: 100%;">
                                    <option selected disabled>Select One</option>
                                    @foreach ($sizes as $size)
                                        <option value="{{ $size->id }}">{{ $size->title }}</option>
                                    @endforeach

                                </select>

                            </div>
                        </div>
                        <!-- Color -->
                        <div class="form-group">
                            <label class="text-muted" for="color_id">Color</label>
                            <select class="form-control" id="color_id" name="color_id" style="width: 100%;">
                                <option selected disabled>Select One</option>
                                @foreach ($colors as $color)
                                    <option value="{{ $color->id }}">{{ $color->color }}</option>
                                @endforeach
                            </select>

                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/Dropify/0.2.2/js/dropify.js"></script>
@endsection
@section('custom_js')
    <script>
        $(function() {
            $("#example1").DataTable({
                "responsive": true,
                "lengthChange": false,
                "autoWidth": false,
                "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
            }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
            $('#example2').DataTable({
                "paging": true,
                "lengthChange": false,
                "searching": false,
                "ordering": true,
                "info": true,
                "autoWidth": false,
                "responsive": true,
            });
        });
    </script>

    <script type="text/javascript">
        $(document).ready(function() {
            $('body').on('click', '.edit', function() {
                let qtyId = $(this).data('id');
                $.get("/admin/products/QtyById/" + qtyId, function(data) {
                    // Populate form fields with received data
                    $("#unit_price").val(data.unit_price);
                    $("#qty").val(data.qty);

                    $("#purchase_price").val(data.purchase_price);
                    $("#unit").val(data.unit);
                    $("#qtyUpdateId").val(data.id);
                    // Populate Size dropdown
                    $("#size_id").val(data.size_id);
                    $("#color_id").val(data.color_id);
                });
            });
        });
    </script>

    <script>
        function updateStatus(id) {
            document.getElementById('myForm-' + id).submit();
        }
    </script>
@endsection
