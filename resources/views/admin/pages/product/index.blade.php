@extends('admin.layouts.app')
@section('admin_contant')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>All Products</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <a href="{{ route('products.create') }}" class="btn btn-primary"> + Add New</a>
                    </ol>
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
                        <div class="card-header bg-dark">
                            <h3 class="card-title">All Products List Hare</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table id="example1" class="table table-bordered table-hover table-striped table-sm">
                                <thead>
                                    <tr>
                                        <th style="width: 5%">SL</th>
                                        <th style="width: 25%">Product Title</th>
                                        <th>Current Qty</th>
                                        <th>Base Price</th>
                                        <th>Status</th>
                                        <th>Druft</th>
                                        <th class="text-right" style="width: 18%">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($products as $key => $product)
                                        <tr>
                                            <td>
                                                {{ $key + 1 }}
                                                @foreach ($product->discounts as $discount)
                                                    @if ($discount->druft == 1)
                                                        <i class="ml-2 text-success fa-solid fa-tags"></i>
                                                    @break
                                                @endif
                                            @endforeach
                                        </td>

                                        <td>{{ $product->product_id }}</td>
                                        @if ($product->productQtys && $product->productQtys->isNotEmpty())
                                            @php $hasNonZeroQty = false; @endphp
                                            @foreach ($product->productQtys as $productQty)
                                                @if ($productQty->current_qty != 0)
                                                    <td>{{ $productQty->current_qty }}
                                                        @if ($productQty->druft === 0)
                                                            <span class="badge badge-warning ml-1">Draft</span>
                                                        @else
                                                            <span class="badge badge-success ml-1">Published</span>
                                                        @endif
                                                    </td>
                                                    <td>{{ $productQty->unit_price }}</td>
                                                    @php $hasNonZeroQty = true; @endphp
                                                @break
                                            @endif
                                        @endforeach
                                        @if (!$hasNonZeroQty)
                                            <td>00</td>
                                            <td>Undefine</td>
                                        @endif
                                    @else
                                        <td>Undefine</td>
                                        <td>Undefine</td>
                                    @endif

                                    <td>
                                        @if ($product->status == 0)
                                            <span class="badge badge-danger ml-1">False</span>
                                        @else
                                            <span class="badge badge-success ml-1">True</span>
                                        @endif
                                    </td>

                                    <td>
                                        <form id="myForm-{{ $product->id }}"
                                            action="{{ route('products.druft.update', $product->id) }}"
                                            method="POST">
                                            @csrf
                                            <div class="custom-control custom-switch">
                                                <input class="custom-control-input druft-checkbox" type="checkbox"
                                                    onclick="updateStatus({{ $product->id }})"
                                                    id="status-{{ $product->id }}" data-id="{{ $product->id }}"
                                                    {{ $product->druft == 1 ? 'checked' : '' }}>
                                                <label class="custom-control-label"
                                                    for="status-{{ $product->id }}"></label>
                                            </div>
                                        </form>
                                    </td>

                                    <td class="d-flex justify-content-end">
                                        <a href="{{ route('editeProduct', $product->id) }}"
                                            class="text-success edit mx-1">
                                            <h5><i class="fas fa-edit"></i></h5>
                                        </a>

                                        <a href="{{ route('deleteProduct', $product->id) }}"
                                            class="text-danger mx-4" id="delete">
                                            <h5>
                                                <i class="fas fa-trash"></i>
                                            </h5>
                                        </a>

                                        <div class="btn-group dropleft">
                                            <a class="text-info mx-2" type="button" id="dropdownMenuButton"
                                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                <h5><i class="fa fa-ellipsis-vertical"></i></h5>
                                            </a>
                                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                <a class="dropdown-item"
                                                    href="{{ route('products.QtyDetails', $product->id) }}">Qty
                                                    Details</a>
                                                <a class="dropdown-item"
                                                    href="{{ route('products.addQty', $product->id) }}">Add Qty</a>
                                                <a class="dropdown-item"
                                                    href="{{ route('products.disIndex', $product->id) }}">Discount</a>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach

                        </tbody>
                    </table>
                </div>
                <!-- /.card-body -->
            </div>
            <!-- /.card -->
        </div>
        <!-- /.col -->
    </div>
    <!-- /.row -->
</div>
<!-- /.container-fluid -->
</section>
<!-- /.content -->


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
<script>
    function updateStatus(id) {
        document.getElementById('myForm-' + id).submit();
    }
</script>
@endsection
