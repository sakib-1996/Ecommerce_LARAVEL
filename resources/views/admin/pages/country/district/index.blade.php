@extends('admin.layouts.app')
@section('admin_contant')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Available district in {{ $exist_country->country_name	}}</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <button class="btn btn-primary" data-toggle="modal" data-target="#colorModal"> + Add New</button>
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
                        <div class="card-header">
                            <h3 class="card-title">All district List Hare</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table id="example1" class="table table-bordered table-striped table-sm">
                                <thead>
                                    <tr>
                                        <th>SL</th>
                                        <th>District Name</th>
                                        <th>Base Cost</th>
                                        <th>Cost By Height & Width</th>
                                        {{-- <th>Category Slug</th> --}}
                                        <th style="width: 15%">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($districts as $key => $district)
                                        <tr>
                                            <td>{{ $key + 1 }}</td>
                                            <td>{{ $district->district_name }}</td>
                                            <td>{{ $district->base_cost }}</td>
                                            <td>{{ $district->cost_by_condition }}</td>
                                            <td>
                                                <a href="#" class="btn btn-info btn-sm edit"
                                                    data-id="{{ $district->id }}" data-toggle="modal"
                                                    data-target="#editModal"><i class="fas fa-edit"></i></a>

                                                <a href="{{ route('settings.destroyDistrict', $district->id) }}"
                                                    class="btn btn-danger btn-sm" id="delete"><i
                                                        class="fas fa-trash"></i></a>
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

    {{-- color insert modal --}}
    <div class="modal fade" id="colorModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Add New district</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('Settings.addistrict') }}" method="Post" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="district_name">District Name</label>
                            <input type="text" class="form-control" id="district_name" name="district_name">
                            <input type="hidden" name="country_id" value="{{ $exist_country->id }}">
                        </div>
                        <div class="form-group">
                            <label for="base_cost">Base Cost</label>
                            <input type="text" class="form-control" id="base_cost" name="base_cost">
                        </div>
                        <div class="form-group">
                            <label for="cost_by_condition">Cost By Height & Width</label>
                            <input type="text" class="form-control" id="cost_by_condition" name="cost_by_condition">
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                        <button type="Submit" class="btn btn-primary">Submit</button>
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
                    <h5 class="modal-title" id="exampleModalLabel">Edit Size</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('settings.districtUpdate') }}" method="Post" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">

                        <div class="form-group">
                            <label for="e_district_name">District Name</label>
                            <input type="text" class="form-control" id="e_district_name" name="e_district_name">
                            <input type="hidden" name="id" id="e_district_id">
                        </div>
                        <div class="form-group">
                            <label for="e_base_cost">Base Cost</label>
                            <input type="text" class="form-control" id="e_base_cost" name="e_base_cost">
                        </div>
                        <div class="form-group">
                            <label for="e_cost_by_condition">Cost By Height & Width</label>
                            <input type="text" class="form-control" id="e_cost_by_condition" name="e_cost_by_condition">
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                        <button type="Submit" class="btn btn-primary">Submit</button>
                    </div>
                </form>

                <div class="modal-body" id="modal_body">

                </div>
            </div>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/Dropify/0.2.2/js/dropify.js"></script>

    <script type="text/javascript">
        $('.dropify').dropify();
    </script>

    <script type="text/javascript">
        $('body').on('click', '.edit', function() {
            let district_id = $(this).data('id');
            $.get("district/edit/" + district_id, function(data) {

                $("#e_district_name").val(data.district_name);
                $("#e_base_cost").val(data.base_cost);
                $("#e_cost_by_condition").val(data.cost_by_condition);
                $("#e_district_id").val(data.id);
            });
        });
    </script>
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
                "searching": true,
                "ordering": true,
                "info": true,
                "autoWidth": false,
                "responsive": true,
            });
        });
    </script>
@endsection
