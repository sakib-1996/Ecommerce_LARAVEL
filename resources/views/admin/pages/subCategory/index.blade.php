@extends('admin.layouts.app')
@section('admin_contant')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Sub Category</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <button class="btn btn-primary" data-toggle="modal" data-target="#subCategoryModal"> + Add New</button>
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
                            <h3 class="card-title">All Sub Categories List Hare</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table id="example1" class="table table-bordered table-striped table-sm">
                                <thead>
                                    <tr>
                                        <th>SL</th>
                                        <th>Sub Category Name</th>
                                        <th>Sub Category Slug</th>
                                        <th>Category Name</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($subCategories as $key => $subCategory)
                                        <tr>
                                            <td>{{ $key + 1 }}</td>
                                            <td>{{ $subCategory->subcategory_name }}</td>
                                            <td>{{ $subCategory->subcat_slug }}</td>
                                            <td>{{ $subCategory->category->category_name }}</td>
                                            <td>
                                                <a href="#" class="btn btn-info btn-sm edit"
                                                    data-id="{{ $subCategory->id }}" data-toggle="modal"
                                                    data-target="#editModal"><i class="fas fa-edit"></i></a>

                                                <a href="{{ route('admin.deleteSubCategory', $subCategory->id) }}"
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

    {{-- Sub category insert modal --}}
    <div class="modal fade" id="subCategoryModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Add New Category</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('admin.storeSubCategory') }}" method="Post">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="category_name">Category Name</label>
                            <select id="category_name" class="form-control" name="category_id" required>
                                <option value="" selected disabled>Select One</option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}"
                                        {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                        {{ $category->category_name }}
                                    </option>
                                @endforeach
                            </select>

                        </div>
                        <div class="form-group">
                            <label for="subcategory_name">SubCategory Name</label>
                            <input type="text" class="form-control" id="subcategory_name" name="subcategory_name"
                                required="">
                            <small id="emailHelp" class="form-text text-muted">This is your sub category</small>
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
                    <h5 class="modal-title" id="exampleModalLabel">Edit Sub Category</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('admin.updateSubCategory') }}" method="Post" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="e_category_name">Category Name</label>
                            <select id="e_category_name" class="form-control" name="category_id" required>
                                <option value="" selected disabled>Select One</option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}"
                                        {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                        {{ $category->category_name }}
                                    </option>
                                @endforeach
                            </select>

                        </div>
                        <div class="form-group">
                            <input type="hidden" id="e_subcategory_id" name="id">
                            <label for="e_subcategory_name">SubCategory Name</label>
                            <input type="text" class="form-control" id="e_subcategory_name" name="subcategory_name"
                                required="">
                            <small id="emailHelp" class="form-text text-muted">This is your sub category</small>
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
            let cat_id = $(this).data('id');
            $.get("subCategory/edit/" + cat_id, function(data) {
                $("#e_subcategory_name").val(data.subcategory_name);
                $("#e_subcategory_id").val(data.id);
                $("#e_category_name").val(data.category_id).trigger('change');
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
        });
    </script>
@endsection
