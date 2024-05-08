<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img src="https://img.freepik.com/free-psd/3d-illustration-person-with-sunglasses_23-2149436188.jpg"
                    class="img-circle elevation-2">
            </div>
            <div class="info">
                <a href="#" class="d-block">{{ auth()->user()->name }}</a>
            </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                data-accordion="false">

                <li class="nav-item">
                    <a href="{{ route('admin.dashboard') }}"
                        class="nav-link @if (request()->is('admin/dashboard')) active @endif">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>Dashboard</p>
                    </a>
                </li>

                <li class="nav-item @if (request()->is('admin/category', 'admin/subCategory', 'admin/childCategory', 'admin/brand')) menu-is-opening menu-open @endif">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-copy"></i>
                        <p>
                            {{-- menu-is-opening menu-open --}}
                            Category
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview ml-3" @if (request()->is('admin/category', 'admin/subCategory', 'admin/childCategory', 'admin/brand')) style="display: block;" @endif>

                        <li class="nav-item">
                            <a href="{{ route('admin.category') }}"
                                class="nav-link @if (request()->is('admin/category') || request()->is('admin/category/*')) active @endif">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Category</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.subCategory') }}"
                                class="nav-link @if (request()->is('admin/subCategory') || request()->is('admin/subCategory/*')) active @endif">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Sub Category</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.childCategory') }}"
                                class="nav-link @if (request()->is('admin/childCategory') || request()->is('admin/childCategory/*')) active @endif">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Child Category</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.brand') }}"
                                class="nav-link @if (request()->is('admin/brand') || request()->is('admin/brand/*')) active @endif">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Brand</p>
                            </a>
                        </li>
                    </ul>

                </li>

                <li class="nav-item">
                    <a href="{{ route('settings.sizeIndex') }}"
                        class="nav-link @if (request()->is('admin/settings/size') || request()->is('admin/settings/size/*')) active @endif">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Size Setting</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('settings.colorIndex') }}"
                        class="nav-link @if (request()->is('admin/settings/color') || request()->is('admin/settings/color/*')) active @endif">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Color Settings</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('products.index') }}"
                        class="nav-link @if (request()->is('admin/products') || request()->is('admin/products/*')) active @endif">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Products</p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{ route('settings.countryIndex') }}"
                        class="nav-link @if (request()->is('admin/settings/available-country') || request()->is('admin/settings/available-country/*')) active @endif">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Shipping </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('ordersIndex') }}"
                        class="nav-link @if (request()->is('admin/orders') || request()->is('admin/orders/*')) active @endif">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Orders</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('delivariedProduct') }}"
                        class="nav-link @if (request()->is('admin/delivariedProduct') || request()->is('admin/delivariedProduct/*')) active @endif">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Delivaried</p>
                    </a>
                </li>
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>
