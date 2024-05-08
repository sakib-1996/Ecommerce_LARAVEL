<!-- START SECTION CLIENT LOGO -->
<div class="section small_pt">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="heading_tab_header">
                    <div class="heading_s2">
                        <h2>Our Brands</h2>
                    </div>
                </div>
            </div>
        </div>
        <div class="row reveal">
            <div class="col-12">
                <div class="client_logo carousel_slider owl-carousel owl-theme nav_style3" data-dots="false"
                    data-nav="true" data-margin="30" data-loop="true" data-autoplay="true"
                    data-responsive='{"0":{"items": "2"}, "480":{"items": "3"}, "767":{"items": "4"}, "991":{"items": "5"}}'>
                    @foreach ($brands as $brand)
                        <div class="item">
                            <div class="cl_logo">
                                <img src="{{ asset('storage/' . $brand->brand_logo) }}" alt="cl_logo" />
                            </div>
                            <div class="text-center">
                                <p><b>{{ $brand->brand_name }}</b></p>
                            </div>
                        </div>
                    @endforeach


                </div>
            </div>
        </div>
    </div>
</div>
<!-- END SECTION CLIENT LOGO -->
