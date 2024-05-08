@extends('admin.layouts.app')
@section('custon_css')
    <link rel="stylesheet" href="{{ asset('backend/dropjoze.css') }}">
    <link rel="stylesheet" href="{{ asset('backend') }}/plugins/select2/css/select2.min.css">
@endsection
@section('admin_contant')
    <div class="p-3">
        <form action="{{ url()->current() }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="row">
                <div class="col-md-8">
                    <div class="row">
                        <div class="col-10 m-3">
                            <div class="row mb-2">
                                <div class="col-3">
                                    <label class="text-muted" for="title">Title*</label>
                                </div>
                                <div class="col-9">
                                    <input type="text" value="{{ old('title') }}"
                                        class="form-control @error('title') is-invalid @enderror" id="title"
                                        name="title">
                                    @error('title')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                    <small class="form-text text-muted">This is your main category</small>
                                </div>
                            </div>

                            <div class="row my-4">
                                <div class="col-3">
                                    <label class="text-muted" for="product_id">Product Id* (unique)</label>
                                </div>
                                <div class="col-9">
                                    <input type="text" class="form-control @error('product_id') is-invalid @enderror"
                                        id="product_id" name="product_id" value="{{ old('product_id') }}">
                                    @error('product_id')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                    <small id="emailHelp" class="form-text text-muted">This is your main category</small>
                                </div>
                            </div>

                            <div class="row my-4">
                                <div class="col-3">
                                    <label class="text-muted" for="weight">Weight</label>
                                </div>
                                <div class="col-9">
                                    <input type="text" value="{{ old('weight') }}" class="form-control" id="weight"
                                        name="weight">
                                    <small id="emailHelp" class="form-text text-muted">This is your main weight</small>
                                </div>
                            </div>

                            <div class="row my-4">
                                <div class="col-3">
                                    <label class="text-muted" for="minimum_purchase">Minimum Purchase*</label>
                                </div>
                                <div class="col-9">
                                    <input type="text"
                                        class="form-control @error('minimum_purchase') is-invalid @enderror"
                                        id="minimum_purchase" name="minimum_purchase" value="{{ old('minimum_purchase') }}">
                                    @error('minimum_purchase')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>

                            <div class="row my-4">
                                <div class="col-3">
                                    <label class="text-muted" for="barcode">Barcode</label>
                                </div>
                                <div class="col-9">
                                    <input type="text" value="{{ old('barcode') }}" class="form-control" id="barcode"
                                        name="barcode">
                                </div>
                            </div>

                            <h4>--- Shipping Cost Attribute</h4>
                            <div class="form-check ml-4 mt-4">
                                <input class="form-check-input" type="checkbox" name="free_shipping" value="1"
                                    id="free_shipping">
                                <label class="text-muted" for="free_shipping">
                                    Free Shipping
                                </label>
                            </div>
                            <div class="row my-4" id="dimensionsRow">
                                <div class="col">
                                    <label class="text-muted" for="width">Width</label>
                                    <input type="text" class="form-control" id="width" name="width"
                                        value="{{ old('width') }}">
                                </div>
                                <div class="col">
                                    <label class="text-muted" for="length">Length</label>
                                    <input type="text" class="form-control" id="length" name="length"
                                        value="{{ old('length') }}">
                                </div>
                            </div>

                            <h4>--- Extra</h4>
                            <hr>

                            <div class="my-4">
                                <div>
                                    <label class="text-muted" for="short_des">Short Description*</label>
                                </div>
                                <div>
                                    <textarea name="short_des" class="form-control @error('short_des') is-invalid @enderror" id="short_des">{{ old('short_des') }}</textarea>
                                    @error('short_des')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>

                            <div class="my-4">
                                <div>
                                    <label class="text-muted" for="description">Description</label>
                                </div>
                                <div>
                                    <textarea name="description" class="form-control @error('description') is-invalid @enderror" id="description">{{ old('description') }}</textarea>
                                    @error('description')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="form-group">
                                    <label class="text-muted" for="related-products">Related Products</label>
                                    <div class="select2-purple">
                                        <select id="related-products" name="related_products[]" class="select2"
                                            multiple="multiple" data-placeholder="Select Related Products"
                                            style="width: 100%;">
                                        </select>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                    <hr>
                    <hr>
                    <div>
                        <h3>----SEO Meta Tags</h3>
                        <div class="row">
                            <div class="col-10 m-3">
                                <div class="row mb-4">
                                    <div class="col-3">
                                        <label class="text-muted" for="meta_title">Meta Title</label>
                                    </div>
                                    <div class="col-9">
                                        <input type="text" value="{{ old('meta_title') }}"
                                            class="form-control @error('meta_title') is-invalid @enderror" id="meta_title"
                                            name="meta_title">
                                        @error('meta_title')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row mb-4">
                                    <div class="col-3">
                                        <label class="text-muted" for="meta_slug">Meta slug</label>
                                    </div>
                                    <div class="col-9">
                                        <input type="text"
                                            class="form-control @error('meta_slug') is-invalid @enderror" id="meta_slug"
                                            name="meta_slug" value="{{ old('meta_slug') }}">
                                        @error('meta_slug')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row my-4">
                                    <div class="col-3">
                                        <label class="text-muted" for="tags">Tags</label>
                                    </div>
                                    <div class="col-9">
                                        <input type="text" class="form-control @error('tags') is-invalid @enderror"
                                            id="tags" name="tags" value="{{ old('tags') }}">
                                        @error('tags')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="my-4">
                                    <div class="my-auto">
                                        <label class="text-muted" for="meta_des">Meta Description</label>
                                    </div>
                                    <div>
                                        <textarea class="form-control @error('meta_des') is-invalid @enderror" name="meta_des" rows="5" cols="10"
                                            id="meta_des">{{ old('meta_des') }}</textarea>
                                        @error('meta_des')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>


                                <div class="row my-4">
                                    <div class="col-3">
                                        <label class="text-muted" for="meta_img">Meta Images</label>
                                    </div>
                                    <div class="col-9">
                                        <input type="file" class="form-control @error('meta_img') is-invalid @enderror"
                                            id="meta_img" name="meta_img">
                                        @error('meta_img')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-body">


                            <div class="mb-4">
                                <div class="form-group">
                                    <label class="text-muted" for="type">Where it Show at home page</label>
                                    <select class="form-control @error('type') is-invalid @enderror" name="type"
                                        id="type" style="width: 100%;">
                                        <option selected disabled>Select One</option>
                                        <option value="gaming" @if (old('type') == 'gaming') selected @endif>
                                            Gaming</option>
                                        <option value="adventure" @if (old('type') == 'adventure') selected @endif>
                                            Adventure</option>
                                        <option value="accessories" @if (old('type') == 'accessories') selected @endif>
                                            Accessories</option>
                                    </select>
                                    @error('type')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>








                            <div class="mb-4">
                                <div class="form-group">
                                    <label class="text-muted" for="category_id">Category</label>
                                    <select class="form-control @error('category_id') is-invalid @enderror"
                                        name="category_id" id="category_id" style="width: 100%;">
                                        <option selected disabled>Select One</option>
                                        @foreach ($categories as $category)
                                            <option value="{{ $category->id }}"
                                                @if (old('category_id') == $category->id) selected @endif>
                                                {{ $category->category_name }}</option>
                                        @endforeach
                                    </select>
                                    @error('category_id')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>






                            <div class="my-4">
                                <div class="form-group">
                                    <label class="text-muted" for="subCat_id">Sub Category</label>
                                    <select class="form-control" name="subCat_id" id="subCat_id" style="width: 100%;">
                                        <!-- Sub Category options will be dynamically populated here -->
                                    </select>
                                </div>
                            </div>

                            <div class="my-4">
                                <div class="form-group">
                                    <label class="text-muted" for="childCat_id">Child Category</label>
                                    <select class="form-control" id="childCat_id" name="childCat_id"
                                        style="width: 100%;">
                                        <!-- Child Category options will be dynamically populated here -->
                                    </select>
                                </div>
                            </div>

                            <div class="my-4">
                                <div class="form-group">
                                    <label class="text-muted" for="brand_id">Brand</label>
                                    <select class="form-control" id="brand_id" name="brand_id" style="width: 100%;">
                                        <option selected disabled>Select One</option>
                                        @foreach ($brands as $brand)
                                            <option value="{{ $brand->id }}">{{ $brand->brand_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="row my-4">
                                <div class="">
                                    <label class="text-muted" for="refundable">Refundable</label>
                                </div>
                                <div class="custom-control custom-switch ml-4">
                                    <input type="checkbox" class="custom-control-input" id="refundable"
                                        name="refundable">
                                    <label class="custom-control-label" for="refundable"></label>
                                </div>
                            </div>
                            <div class="row my-4">
                                <div class="">
                                    <label class="text-muted" for="cash_on_delivary">Cash On Delivery</label>
                                </div>
                                <div class="custom-control custom-switch ml-4">
                                    <input type="checkbox" class="custom-control-input" id="cash_on_delivary"
                                        name="cash_on_delivary">
                                    <label class="custom-control-label" for="cash_on_delivary"></label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-body">
                            <div class="mb-4">
                                <label class="text-muted">Upload Tumbnail Image*</label>
                                <input type="file" id="file" name="thum_img" accept="image/*" hidden>
                                <div class="img-area" data-img="">
                                    <i class='bx bxs-cloud-upload icon'></i>
                                    <h3>Upload Tumbnail Image</h3>
                                    <p>Image size must be image</p>
                                </div>
                                <div class="text-center">
                                    <div class="btn btn-primary select-image">Select Image</div>
                                </div>
                            </div>
                            @error('thum_img')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                            <hr>

                            <div class="extra_img">
                                <div class="d-flex custon_css justify-content-between">
                                    <div>
                                        <label class="" for="thum_img">Add Images</label>
                                    </div>
                                    <div id="actions">
                                        <div class="btn-group" id="add">
                                            <span class="btn btn-primary col fileinput-button">
                                                <i class="fas fa-plus"></i>
                                                <span>Add</span>
                                            </span>
                                        </div>
                                    </div>
                                </div>

                                <div class="">
                                    <table class="table table-bordered img_table" id="dynamic_field">
                                        <div class="card-header">
                                            <h3 class="card-title">More Images (Click Add For More Image)</h3>
                                        </div>
                                        <tr>
                                            <td><input type="file" accept="image/*" name="images[]"
                                                    class="form-control name_list" hidden /></td>
                                            {{-- <td><button type="button" name="add" id="add"
                                                    class="btn btn-success">Add</button></td> --}}
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="text-right mb-5">
                <button type="submit" class="btn btn-primary btn-lg">Submit</button>
            </div>
        </form>
    </div>
@endsection

@section('custom_js')
    <script src="{{ asset('backend/dropzone.js') }}"></script>
    <!-- dropzonejs -->
    <script src="{{ asset('backend') }}/plugins/dropzone/min/dropzone.min.js"></script>
    <script src="{{ asset('backend') }}/plugins/select2/js/select2.full.min.js"></script>

    <script>
        // Get the checkbox element
        const freeShippingCheckbox = document.getElementById('free_shipping');
        // Get the row div element
        const dimensionsRow = document.getElementById('dimensionsRow');

        // Add event listener to checkbox
        freeShippingCheckbox.addEventListener('change', function() {
            // Check if checkbox is checked
            if (this.checked) {
                // Hide the row div
                dimensionsRow.style.display = 'none';
            } else {
                // Show the row div
                dimensionsRow.style.display = 'flex'; // or 'block' depending on your CSS
            }
        });

        // Initially hide or show based on checkbox state
        if (freeShippingCheckbox.checked) {
            dimensionsRow.style.display = 'none';
        } else {
            dimensionsRow.style.display = 'flex'; // or 'block' depending on your CSS
        }
    </script>


    <script>
        $('#category_id').change(function() {
            var selectedCategoryId = $(this).val();
            var subCategorySelect = $('#subCat_id');

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

        $(document).ready(function() {
            $('#subCat_id').change(function() {
                var selectedSubCategoryId = $(this).val();
                var childCategorySelect = $('#childCat_id');

                // Show loading indicator for child categories
                childCategorySelect.html('<option value="" selected disabled>Loading...</option>');

                $.ajax({
                    url: '/admin/chlidCategoryBySabCategoyId/' + selectedSubCategoryId,
                    type: 'GET',
                    dataType: 'json',
                    success: function(response) {
                        childCategorySelect.empty();
                        childCategorySelect.append(
                            '<option value="" selected disabled>Select One</option>');

                        if (response.childCat && response.childCat.length > 0) {
                            $.each(response.childCat, function(key, value) {
                                childCategorySelect.append('<option value="' + value
                                    .id +
                                    '">' + value.childcategory_name + '</option>');
                            });
                        } else {
                            childCategorySelect.append(
                                '<option value="" disabled>No child categories found</option>'
                            );
                        }

                        // Hide loading indicator on success
                        childCategorySelect.closest('.form-group').find('.loading-indicator')
                            .hide();
                    },
                    error: function() {
                        // Display an error message and hide loading indicator on failure
                        childCategorySelect.html(
                            '<option value="" selected disabled>Error loading child categories</option>'
                        );
                        childCategorySelect.closest('.form-group').find('.loading-indicator')
                            .hide();
                    }
                });
            });
        });
    </script>
    <script>
        $(function() {
            $('#short_des').summernote({
                height: 100, // Set height
                toolbar: [
                    ['style', ['bold', 'italic', 'clear']],
                    ['para', ['ul', 'ol', 'paragraph']],
                ],
            });
        });
        $(function() {
            $('#description').summernote({
                height: 200,
            });
        });
    </script>
    <script>
        $(document).ready(function() {
            var i = 1;

            $('#add').click(function() {
                i++;
                $('#dynamic_field').append(`<tr id="row${i}" class="dynamic-added">
                    <td>
                        <input type="file" accept="image/*" name="images[]" class="form-control name_list image_input" onchange="readURL(this, '#preview${i}');" />
                        <img id="preview${i}" class="preview_image" width="100" height="100" style="display:none;">
                    </td>
                    <td style="width: 8%">
                        <button type="button" name="remove" id="${i}" class="btn btn-danger btn_remove">X</button>
                    </td>
                </tr>`);

            });

            $(document).on('click', '.btn_remove', function() {
                var button_id = $(this).attr("id");
                $('#row' + button_id).remove();
            });
        });

        function readURL(input, previewId) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    $(previewId).attr('src', e.target.result).show();
                    $(input).hide();
                }
                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>

    <script>
        $(function() {
            //Initialize Select2 Elements
            $('.select2').select2()

            //Initialize Select2 Elements
            $('.select2bs4').select2({
                theme: 'bootstrap4'
            })

        })
    </script>
    <script>
        $(document).ready(function() {
            $('#related-products').select2({
                ajax: {
                    url: '{{ route('products.search') }}',
                    type: 'GET',
                    dataType: 'json',
                    delay: 250,
                    data: function(params) {
                        return {
                            query: params.term,
                        };
                    },
                    processResults: function(data) {
                        return {
                            results: $.map(data, function(item) {
                                return {
                                    id: item.id,
                                    text: item.title
                                };
                            })
                        };
                    },
                    cache: true
                },
                placeholder: 'Select Related Products',
                minimumInputLength: 1
            });

            $('#myForm').submit(function() {
                var selectedValues = $('#related-products').val();
                $('#selected-values').val(JSON.stringify(selectedValues));
            });
        });
    </script>
@endsection
