@extends('admin.layouts.app')
@section('admin_contant')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Available Country</h1>
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
                            <h3 class="card-title">All Country List Hare</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table id="example1" class="table table-bordered table-striped table-sm">
                                <thead>
                                    <tr>
                                        <th style="width: 5%">SL</th>
                                        <th>Country Name</th>
                                        {{-- <th>Category Slug</th> --}}
                                        <th style="width: 18%">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($countries as $key => $country)
                                        <tr>
                                            <td>{{ $key + 1 }}</td>
                                            <td>{{ $country->country_name }}</td>
                                            <td>
                                                <a href="#" class="btn btn-info btn-sm edit"
                                                    data-id="{{ $country->id }}" data-toggle="modal"
                                                    data-target="#editModal"><i class="fas fa-edit"></i></a>

                                                <a href="{{ route('settings.destroyCountry', $country->id) }}"
                                                    class="btn btn-danger btn-sm" id="delete"><i
                                                        class="fas fa-trash"></i></a>

                                                <a href="{{ route('settings.districtIndex', $country->id) }}"
                                                    class="btn btn-primary btn-sm"><i class="fas fa-ribbon"></i></a>
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

    {{-- color insert modal --}}
    <div class="modal fade" id="colorModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Add New Country</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('Settings.addCountry') }}" method="Post" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="country">Country Name</label>
                            <input type="text" class="form-control" id="country" name="country">
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
                <form action="{{ route('settings.countryUpdate') }}" method="Post" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="e_country">Size Title</label>
                            <input type="text" class="form-control" id="e_country" name="e_country" required="">
                            <input type="hidden" name="id" id="e_country_id">
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
            let country_id = $(this).data('id');
            $.get("available-country/edit/" + country_id, function(data) {

                $("#e_country").val(data.country_name);
                $("#e_country_id").val(data.id);
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
