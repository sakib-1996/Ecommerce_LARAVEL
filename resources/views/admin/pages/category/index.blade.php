@extends('admin.layouts.app')
@section('admin_contant')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Categories</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <button class="btn btn-primary" data-toggle="modal" data-target="#categoryModal"> + Add New</button>
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
                            <h3 class="card-title">All Categories List Hare</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table id="example1" class="table table-bordered table-striped table-sm">
                                <thead>
                                    <tr>
                                        <th>SL</th>
                                        <th>Category Name</th>
                                        <th>Category Slug</th>
                                        <th>Category Image</th>
                                        <th>Home Page </th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($categories as $key => $category)
                                        <tr>
                                            <td>{{ $key + 1 }}</td>
                                            <td>{{ $category->category_name }}</td>
                                            <td>{{ $category->category_slug }}</td>

                                            <td>
                                                <img src="{{ asset('storage/' . $category->cat_img) }}" style="width: 100px"
                                                    alt="">
                                            </td>
                                            <td>
                                                @if ($category->front_page == 1)
                                                    Yes
                                                @else
                                                    No
                                                @endif
                                            </td>

                                            <td>
                                                <a href="#" class="btn btn-info btn-sm edit"
                                                    data-id="{{ $category->id }}" data-toggle="modal"
                                                    data-target="#editModal"><i class="fas fa-edit"></i></a>

                                                <a href="{{ route('admin.deleteCategory', $category->id) }}"
                                                    class="btn btn-danger btn-sm" id="delete"><i
                                                        class="fas fa-trash"></i></a>
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

    {{-- category insert modal --}}
    <div class="modal fade" id="categoryModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Add New Category</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('admin.storeCategory') }}" method="Post" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="category_name">Category Name</label>
                            <input type="text" class="form-control" id="category_name" name="category_name"
                                required="">
                            <small id="" class="form-text text-muted">This is your main category</small>
                        </div>
                        <div class="mb-4">
                            <div class="form-group">
                                <label class="" for="front_page">Front Page</label>
                                <select class="form-control" name="front_page" id="front_page" style="width: 100%;">
                                    <option selected disabled>Select One</option>
                                    <option value="1">Yes</option>
                                    <option value="0">No</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="cat_img">Category Image*</label>
                            <input type="file" class="form-control" id="cat_img" name="cat_img" required="">
                            <small id="" class="form-text text-muted">This is your main category</small>
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
                    <h5 class="modal-title" id="exampleModalLabel">Edit Category</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('admin.categoryUpdate') }}" method="Post" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="e_category_name">Category Name</label>
                            <input type="text" class="form-control" id="e_category_name" name="category_name"
                                required="">
                            <input type="hidden" name="id" id="e_category_id">
                            <input type="text" name="old_cat_img" id="old_cat_img">
                            <small id="" class="form-text text-muted">This is your main category</small>
                        </div>

                        <div class="mb-4">
                            <div class="form-group">
                                <label class="" for="e_front_page">Front Page</label>
                                <select class="form-control" name="e_front_page" id="e_front_page" style="width: 100%;">
                                    <option selected disabled>Select One</option>
                                    <option value="1">Yes</option>
                                    <option value="0">No</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="e_cat_img">Category Image (240, 120)*</label>
                            <input type="file" class="form-control" id="e_cat_img" name="e_cat_img">
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

    <script type="text/javascript">
        $(document).ready(function() {
            $('body').on('click', '.edit', function() {
                let cat_id = $(this).data('id');
                $.get("category/edit/" + cat_id, function(data) {
                    $("#e_category_name").val(data.category_name);
                    $("#e_category_id").val(data.id);
                    $("#e_front_page").val(data.front_page);
                    $("#old_cat_img").val(data.cat_img);
                });
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
                "searching": false,
                "ordering": true,
                "info": true,
                "autoWidth": false,
                "responsive": true,
            });
        }); <
    </script>
@endsection
