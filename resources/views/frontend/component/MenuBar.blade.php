<header class="header_wrap fixed-top header_with_topbar">
    <div class="top-header">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <div class="d-flex align-items-center justify-content-center justify-content-md-start">
                        <ul class="contact_detail text-center text-lg-start">
                            <li><i class="ti-mobile"></i><span>123-456-7890</span></li>
                        </ul>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="text-center text-md-end">
                        <ul class="header_list">
                            <li><a href="{{ route('wishlist') }}"><i class="ti-heart"></i><span>Wishlist</span></a></li>
                            @auth
                                <li class="nav-item dropdown">
                                    <a href="" data-bs-toggle="dropdown" class="nav-icon pe-md-0">
                                        {{ auth()->user()->name }}
                                    </a>

                                    <div class="dropdown-menu dropdown-menu-end">
                                        <h5 class="dropdown-item"><a href="{{ route('userDashboard') }}">Dashboard</a></h5>
                                        @if (auth()->user()->is_admin === 0)
                                            <a href="{{ route('logout') }}" class="dropdown-item">Logout</a>
                                        @endif
                                    </div>
                                </li>
                            @endauth
                            @guest
                                <li><a href="{{ route('login') }}"><i class="ti-user"></i><span>Login</span></a></li>
                            @endguest
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="bottom_header dark_skin main_menu_uppercase">
        <div class="container">
            <nav class="navbar navbar-expand-lg">
                <a class="navbar-brand" href="{{ route('home') }}">
                    <img class="logo_light" src="{{ asset('frontend') }}/assets/images/logo_light.png" alt="logo" />
                    <img class="logo_dark" src="{{ asset('frontend') }}/assets/images/logo_dark.png" alt="logo" />
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarSupportedContent" aria-expanded="false">
                    <span class="ion-android-menu"></span>
                </button>
                <div class="collapse navbar-collapse justify-content-end" id="navbarSupportedContent">
                    <ul class="navbar-nav">
                        <li class="">
                            <a class="nav-link @if (url()->current() === route('home')) text-danger @endif"
                                href="{{ route('home') }}">Home</a>
                        </li>
                        <li class="dropdown">
                            <a class="dropdown-toggle nav-link" href="#" data-bs-toggle="dropdown">Pages</a>
                            <div class="dropdown-menu">
                                <ul>
                                    {{-- <li><a class="dropdown-item nav-link nav_item" href="#">About Us</a></li> --}}
                                    <li><a class="dropdown-item nav-link nav_item"
                                            href="{{ route('contactPage') }}">Contact Us</a>
                                    </li>
                                </ul>
                            </div>
                        </li>
                        <li class="dropdown dropdown-mega-menu">
                            <a class="dropdown-toggle nav-link" href="#" data-bs-toggle="dropdown">Products</a>
                            <div class="dropdown-menu">
                                <ul class="mega-menu d-lg-flex">
                                    @foreach ($categories as $category)
                                        <li class="mega-menu-col col-lg-3">
                                            <ul>
                                                <li><a class="dropdown-header nav-link nav_item"
                                                        href="{{ route('productByCategory', $category->id) }}">{{ $category->category_name }}</a>
                                                </li>
                                                @foreach ($category->subcategories as $subcategory)
                                                    <li class="ms-2"><a class="dropdown-item nav-link nav_item"
                                                            href="{{ route('productBySubCatId', $subcategory->id) }}">{{ $subcategory->subcategory_name }}</a>
                                                    </li>
                                                @endforeach
                                            </ul>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </li>
                    </ul>
                </div>
                <ul class="navbar-nav attr-nav align-items-center">
                    <li><a href="javascript:;" class="nav-link search_trigger"><i class="linearicons-magnifier"></i></a>
                        <div class="search_wrap">
                            <span class="close-search"><i class="ion-ios-close-empty"></i></span>
                            <form>
                                <input type="text" placeholder="Search" class="form-control" id="search_input">
                                <button type="submit" class="search_icon"><i
                                        class="ion-ios-search-strong"></i></button>
                            </form>
                        </div>
                        <div class="search_overlay"></div>
                    </li>

                    <li class="dropdown cart_dropdown">
                        <a class="nav-link cart_trigger" href="#" data-bs-toggle="dropdown">
                            <i class="linearicons-cart"></i>
                            <span class="cart_count">
                                @isset($cartProducts)
                                    {{ count($cartProducts) }}
                                @else
                                    0
                                @endisset
                            </span>

                        </a>
                        <div class="cart_box dropdown-menu dropdown-menu-right">
                            <ul class="cart_list">
                                @isset($cartProducts)
                                    @foreach ($cartProducts as $index => $cartProduct)
                                        <?php
                                        $productQty = App\Models\ProductQty::where('product_id', $cartProduct->product_id)
                                            ->where('current_qty', '!=', 0)
                                            ->where('druft', '!=', 0)
                                            ->first();
                                        ?>
                                        <li>
                                            <a href="#" class="item_remove"><i class="ion-close"></i></a>
                                            <a href="#">
                                                <img src="{{ asset('storage/' . $cartProduct->product->thum_img) }}"
                                                    alt="cart_thumb1">
                                                {{ substr($cartProduct->product->title, 0, 15) }}..
                                            </a>
                                            <span class="cart_quantity">
                                                {{ $cartProduct->quantity }} x
                                                <span class="cart_amount">
                                                    @isset($productQty)
                                                        <span class="price_symbole">$</span>{{ $productQty->unit_price }}
                                                    @endisset
                                                </span>
                                            </span>
                                        </li>
                                    @endforeach
                                @endisset
                            </ul>
                            <div class="cart_footer">
                                <p class="cart_buttons text-end">
                                    <a href="{{ route('viewCart') }}" class="btn btn-fill-line view-cart">View
                                        Cart</a>
                                </p>
                            </div>
                        </div>
                    </li>

                </ul>
            </nav>
        </div>
    </div>
</header>
<!-- END HEADER -->
{{-- <script>
    async function Category(){
        let res=await axios.get("/CategoryList");
        $("#CategoryItem").empty()
        res.data['data'].forEach((item,i)=>{
            let EachItem= ` <li><a class="dropdown-item nav-link nav_item" href="/by-category?id=${item['id']}">${item['categoryName']}</a></li>`
            $("#CategoryItem").append(EachItem);
        })
    }
</script> --}}
