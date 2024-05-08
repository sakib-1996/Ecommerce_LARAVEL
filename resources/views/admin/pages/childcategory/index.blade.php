@extends('admin.layouts.app')
@section('admin_contant')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Child Category</h1>
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
                            <h3 class="card-title">All Child Categories List Hare</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table id="example1" class="table table-bordered table-striped table-sm ytable">
                                <thead>
                                    <tr>
                                        <th>SL</th>
                                        <th>Child Category Name</th>
                                        <th>Category Name</th>
                                        <th>Sub Category Name</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>


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
                    <h5 class="modal-title" id="exampleModalLabel">Add New Child Category</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('admin.storeChildCategory') }}" method="Post">
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
                            <label for="sub_category_name">Sub Category Name</label>
                            <select id="sub_category_name" class="form-control" name="subcategory_id" required>
                                <option value="" selected disabled>Select One</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="childcategory_name">Child Category Name</label>
                            <input type="text" class="form-control" id="childcategory_name" name="childcategory_name"
                                required="">
                            <small id="emailHelp" class="form-text text-muted">This is your Child Category</small>
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
                <form action="{{ route('admin.ChildcategoryUpdate') }}" method="Post" enctype="multipart/form-data">
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
                            <label for="e_sub_category_name">Sub Category Name</label>
                            <select id="e_sub_category_name" class="form-control" name="subcategory_id" required>
                                <option value="" selected disabled>Select One</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <input type="hidden" id="e_childcategory_id" name="id">
                            <label for="e_childcategory_name">Child Category Name</label>
                            <input type="text" class="form-control" id="e_childcategory_name"
                                name="childcategory_name" required="">
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
@endsection
@section('custom_js')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- DataTables -->
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>

    <script type="text/javascript">
        $(document).ready(function() {
            $('.ytable').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('admin.childCategory') }}",
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex'
                    },
                    {
                        data: 'childcategory_name',
                        name: 'childcategory_name'
                    },
                    {
                        data: 'category_name',
                        name: 'category_name'
                    },
                    {
                        data: 'subcategory_name',
                        name: 'subcategory_name'
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: true,
                        searchable: true
                    },
                ]
            });

            $('#category_name').change(function() {
                var selectedCategoryId = $(this).val();
                var subCategorySelect = $('#sub_category_name');

                subCategorySelect.html('<option value="" selected disabled>Loading...</option>');

                $.ajax({
                    url: '/admin/sabCategoryByCategoyId/' + selectedCategoryId,
                    type: 'GET',
                    dataType: 'json',
                    success: function(response) {
                        subCategorySelect.empty();
                        subCategorySelect.append(
                            '<option value="" selected disabled>Select One</option>');

                        $.each(response.data, function(index, subcategory) {
                            subCategorySelect.append('<option value="' + subcategory
                                .id + '">' + subcategory.subcategory_name +
                                '</option>');
                        });
                    },
                    error: function(error) {
                        subCategorySelect.html(
                            '<option value="" selected disabled>Error loading subcategories</option>'
                        );
                    }
                });
            });
        });

        $('#e_category_name').change(function() {
            var selectedCategoryId = $(this).val();
            var subCategorySelect = $('#e_sub_category_name');

            subCategorySelect.html('<option value="" selected disabled>Loading...</option>');

            $.ajax({
                url: '/admin/sabCategoryByCategoyId/' + selectedCategoryId,
                type: 'GET',
                dataType: 'json',
                success: function(response) {
                    subCategorySelect.empty();
                    subCategorySelect.append('<option value="" selected disabled>Select One</option>');

                    $.each(response.data, function(index, subcategory) {
                        subCategorySelect.append('<option value="' + subcategory.id + '">' +
                            subcategory.subcategory_name + '</option>');
                    });
                },
                error: function(error) {
                    subCategorySelect.html(
                        '<option value="" selected disabled>Error loading subcategories</option>');
                }
            });
        });




        // Edit button click event
        $('body').on('click', '.edit', function() {
            let cat_id = $(this).data('id');
            $.get("sabCategoryByCategoyId/edit/" + cat_id, function(data) {
                $("#e_childcategory_name").val(data.childcategory_name);
                $("#e_childcategory_id").val(data.id);
                $("#e_category_name").val(data.category_id).trigger('change');

                var subCategoryValue = data.subcategory_id;
                $("#e_sub_category_name option").each(function() {
                    $(this).prop('selected', $(this).val() == subCategoryValue);
                });
            });

        });
    </script>
@endsection
