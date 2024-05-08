@extends('admin.layouts.app')
@section('admin_contant')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Product Discount</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#staticBackdrop">
                            + Add New Discount
                        </button>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header bg-dark">
                            <h3 class="card-title">Discount List Hare</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table id="example1" class="table table-bordered table-hover table-striped table-sm">
                                <thead>
                                    <tr>
                                        <th style="width: 3%">SL</th>
                                        <th>Dis Title</th>
                                        <th>Dis Rate</th>
                                        <th>Dis Description</th>
                                        <th>Start Time</th>
                                        <th>End Time</th>
                                        <th>Druft</th>
                                        <th>Run Time</th>
                                        <th>Status</th>
                                        <th class="text-right" style="width: 15%">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($discounts as $index => $discount)
                                        <tr>
                                            <td style="width: 3%">{{ $index + 1 }}</td>
                                            <td>{{ $discount->dis_title }}</td>
                                            <td>${{ $discount->dis_rate }}</td>
                                            <td>{{ strlen($discount->dis_details) > 20 ? substr($discount->dis_details, 0, 20) . '...' : $discount->dis_details }}
                                            </td>

                                            <td>
                                                <i class="fa fa-calendar-days"></i><span>
                                                    {{ \Carbon\Carbon::parse($discount->start_date)->toDateString() }}</span>
                                                <br>

                                                <i class="fa fa-clock"></i><span class="badge badge-info ml-1">
                                                    {{ \Carbon\Carbon::parse($discount->start_date)->format('H:i') }}</span>
                                            </td>

                                            <td>
                                                <i class="fa fa-calendar-days"></i><span>
                                                    {{ \Carbon\Carbon::parse($discount->end_date)->toDateString() }}</span>
                                                <br>

                                                <i class="fa fa-clock"></i><span class="badge badge-info ml-1">
                                                    {{ \Carbon\Carbon::parse($discount->end_date)->format('H:i') }}</span>
                                            </td>
                                            <td>
                                                @if ($discount->druft == 0)
                                                    <span class="badge badge-danger ml-1">Yes</span>
                                                @else
                                                    <span class="badge badge-success ml-1">No</span>
                                                    <i class="fa-solid fa-tags"></i>
                                                @endif
                                            </td>

                                            <td>
                                                {!! $discount->run_time ? $discount->run_time : '<span class="badge badge-success ml-1">Unlimited</span>' !!}
                                            </td>


                                            <td>
                                                <form id="myForm-{{ $discount->id }}"
                                                    action="{{ route('discountStatusUpdate', $discount->id) }}"
                                                    method="POST">
                                                    @csrf
                                                    <div class="custom-control custom-switch">
                                                        <input class="custom-control-input status-checkbox" type="checkbox"
                                                            onclick="updateStatus({{ $discount->id }})"
                                                            id="status-{{ $discount->id }}" data-id="{{ $discount->id }}"
                                                            {{ $discount->status == 1 ? 'checked' : '' }}>
                                                        <label class="custom-control-label"
                                                            for="status-{{ $discount->id }}"></label>
                                                    </div>
                                                </form>
                                            </td>
                                            <td class="d-flex justify-content-end">

                                                <a href="#" class="btn btn-info btn-sm edit"
                                                    data-id="{{ $discount->id }}" data-toggle="modal"
                                                    data-target="#editModal"><i class="fas fa-edit"></i></a>

                                                <a href="{{ route('product.DeleteDis', $discount->id) }}"
                                                    class="btn btn-danger btn-sm mx-4" id="delete">
                                                    <i class="fas fa-trash"></i>

                                                </a>
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


    <!-- Insart Modal -->
    <div class="modal fade" id="staticBackdrop" data-backdrop="static" data-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">Add New Discount For--- <br>{{ $product->title }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('products.addDis', $product->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf 
                    <div class="modal-body">
                        <div>
                            <div><label for="dis_title">Discount Title*</label></div>
                            <div>
                                <input type="text" class="form-control" name="dis_title" id="dis_title">
                            </div>
                        </div>

                        <div>
                            <div><label for="dis_rate">Discount Rate*</label></div>
                            <div>
                                <input type="text" class="form-control" name="dis_rate" id="dis_rate">
                            </div>
                        </div>

                        <div class="my-4">
                            <div>
                                <label for="start_time">Start Date And Time*</label>
                            </div>
                            <div class="d-flex">
                                <input type="date" name="start_date" class="form-control mr-1" id="start_time">
                                <input type="time" name="start_time" class="form-control ml-1" id="start_time">
                            </div>
                        </div>
                        <div class="my-4">
                            <div>
                                <label for="end_time">End Date And Time*</label>
                            </div>
                            <div class="d-flex">
                                <input type="date" name="end_date" class="form-control mr-1" id="end_time">
                                <input type="time" name="end_time" class="form-control ml-1" id="end_time">
                            </div>
                        </div>
                        <div class="my-4">
                            <div><label for="run_time">Run Time</label></div>
                            <div>
                                <input type="number" class="form-control" id="run_time" min="1">
                            </div>
                        </div>
                        <div>
                            <div><label for="details">Discount Title</label></div>
                            <div>
                                <textarea class="form-control" name="details" id="details" cols="" rows="3"></textarea>
                            </div>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>


    {{-- edit modal --}}
    <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">Edit Discount For--- <br>{{ $product->title }}
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('admin.updateDiscount') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <input type="text" name="id" id="dis_id">
                        <div>
                            <div><label for="e_dis_title">Discount Title*</label></div>
                            <div>
                                <input type="text" class="form-control" name="dis_title" id="e_dis_title">
                            </div>
                        </div>

                        <div>
                            <div><label for="e_dis_rate">Discount Rate*</label></div>
                            <div>
                                <input type="text" class="form-control" name="dis_rate" id="e_dis_rate">
                            </div>
                        </div>

                        <div class="my-4">
                            <div>
                                <label for="start_time">Start Date And Time*</label>
                            </div>
                            <div class="d-flex">
                                <input type="date" name="start_date" class="form-control mr-1" id="e_start_date">
                                <input type="time" name="start_time" class="form-control ml-1" id="e_start_time">
                            </div>
                        </div>
                        <div class="my-4">
                            <div>
                                <label for="end_time">End Date And Time*</label>
                            </div>
                            <div class="d-flex">
                                <input type="date" name="end_date" class="form-control mr-1" id="e_end_date">
                                <input type="time" name="end_time" class="form-control ml-1" id="e_end_time">
                            </div>
                        </div>
                        <div class="my-4">
                            <div><label for="e_run_time">Run Time</label></div>
                            <div>
                                <input type="number" class="form-control" id="e_run_time" min="1">
                            </div>
                        </div>
                        <div>
                            <div><label for="e_details">Discount Title</label></div>
                            <div>
                                <textarea class="form-control" name="details" id="e_details" cols="" rows="3"></textarea>
                            </div>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Submit</button>
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
    <script>
        function updateStatus(id) {
            document.getElementById('myForm-' + id).submit();
        }
    </script>
    <script type="text/javascript">
        $('body').on('click', '.edit', function() {
            let dis_id = $(this).data('id');
            $.get("/admin/products/discount/edit/" + dis_id, function(data) {

                $("#dis_id").val(data.id);
                $("#e_dis_title").val(data.dis_title);
                $("#e_dis_rate").val(data.dis_rate);

                $("#e_start_date").val(data.start_date.split(' ')[0]);
                var startTime = new Date(data.start_date);
                var startTimeString = startTime.getHours() + ":" + startTime.getMinutes();
                $("#e_start_time").val(startTimeString);

                $("#e_end_date").val(data.end_date.split(' ')[0]);
                var endTime = new Date(data.end_date);
                var endTimeString = endTime.getHours() + ":" + endTime.getMinutes();
                $("#e_end_time").val(endTimeString);

                $("#e_run_time").val(data.run_time);
                $("#e_details").val(data.dis_details);
            });
        });
    </script>
@endsection
