@extends('admin.layouts.app')
@section('admin_contant')
    <div class="p-3">
        <form action="{{ url()->current() }}" method="POST" enctype="multipart/form-data">
            <div class="row px-4">
                <div class="col-lg-8 col-xl-8 col-md-8">
                    @csrf
                    <div class="row">
                        <div class="col-lg-10 col-xl-10 col-md-10">
                            <h4>{{ $product->title }}{{ $product->product_id }}</h4>
                            <hr>
                            <h4>Product price + stock</h4>
                            <div class="row">
                                <div class="col-lg-10 col-xl-10 col-md-10 m-3">
                                    <div class="row my-4">
                                        <div class="col-lg-3 col-xl-3 col-md-3">
                                            <label class="text-muted" for="qty">Total Quantity</label>

                                        </div>
                                        <div class="col-lg-9 col-xl-9 col-md-9">
                                            <input type="text" class="form-control @error('qty') is-invalid @enderror"
                                                id="qty" name="qty">
                                            @error('qty')
                                                <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="row my-4">
                                        <div class="col-lg-3 col-xl-3 col-md-3">
                                            <label class="text-muted" for="unit_price">Unit price (Selling)</label>
                                        </div>
                                        <div class="col-lg-9 col-xl-9 col-md-9">
                                            <input type="text"
                                                class="form-control @error('unit_price') is-invalid @enderror"
                                                id="unit_price" name="unit_price">
                                            @error('unit_price')
                                                <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="row my-4">
                                        <div class="col-lg-3 col-xl-3 col-md-3">
                                            <label class="text-muted" for="purchase_price">Purchase price</label>
                                        </div>
                                        <div class="col-lg-9 col-xl-9 col-md-9">
                                            <input type="text"
                                                class="form-control @error('purchase_price') is-invalid @enderror"
                                                id="purchase_price" name="purchase_price">
                                            @error('purchase_price')
                                                <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>
                                    </div>

                                </div>
                            </div>

                        </div>
                    </div>

                </div>
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-body">
                            <h4>Product Attributes</h4>
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
                                    @error('size_id')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>

                            <!-- Color -->
                            <div class="form-group">
                                <label class="text-muted" for="color_id">Color</label>
                                <select class="form-control" id="color_id" name="color_id" style="width: 100%;">
                                    <option selected disabled>Select One</option>
                                    @foreach ($colors as $color)
                                        <option value="{{ $color->id }}" style="color: {{ $color->color_code }};">
                                            &#9632;{{ $color->color }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('color_id')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <!-- Unit -->
                            <div class="my-4">
                                <div class="form-group">
                                    <label class="text-muted" for="unit">Unit (kg/pc)</label>
                                    <br>
                                    <input type="text" class="form-control" id="unit" name="unit"
                                        placeholder="kg/pc">
                                    @error('unit')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
            <div>

                <button type="submit" class="btn btn-primary ml-4">Primary</button>
            </div>
        </form>
        {{-- <div class="row my-4">
                                    <div class="col-3">
                                        <label class="text-muted" for="e_category_name">Discount Date Start</label>
                                    </div>
                                    <div class="col-9">
                                        <input type="text" class="form-control" id="e_category_name" name="category_name"
                                            required="">

                                    </div>
                                </div>

                                <div class="row my-4">
                                    <div class="col-3">
                                        <label class="text-muted" for="e_category_name">Discount Date End</label>
                                    </div>
                                    <div class="col-9">
                                        <input type="text" class="form-control" id="e_category_name" name="category_name"
                                            required="">
                                    </div>
                                </div>

                                <div class="row my-4">
                                    <div class="col-3">
                                        <label class="text-muted" for="e_category_name">Discount</label>
                                    </div>
                                    <div class="col-9">
                                        <input type="text" class="form-control" id="e_category_name" name="category_name"
                                            required="">
                                    </div>
                                </div> --}}
    </div>
@endsection
