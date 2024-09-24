<div class="vertical-menu">

    <div data-simplebar class="h-100">

        <!--- Sidemenu -->
        <div id="sidebar-menu">
            <!-- Left Menu Start -->
            <ul class="metismenu list-unstyled" id="side-menu">
                <li class="menu-title" data-key="t-menu">Menu</li>

                <li>
                    {{-- <a href="{{ route('admin.dashboard') }}">
                        <i data-feather="home"></i>
                        <span data-key="t-dashboard">Dashboard</span>
                    </a> --}}
                    <a href="{{ route('admin.dashboard_index') }}">
                        <i data-feather="home"></i>
                        <span data-key="t-dashboard">Dashboard</span>
                    </a>
                </li>


                {{-- @if (Auth::guard('admin')->user()->can('category.menu')) --}}
                <li>
                    <a href="javascript: void(0);" class="has-arrow">
                        <i data-feather="grid"></i>
                        <span data-key="t-apps">Category</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        {{-- @if (Auth::guard('admin')->user()->can('category.all')) --}}
                        <li>
                            <a href="{{ route('admin.all_categories') }}">
                                <span data-key="t-calendar">All Category</span>
                            </a>
                        </li>
                        {{-- @endif --}}
                        {{-- @if (Auth::guard('admin')->user()->can('category.add')) --}}
                        <li>
                            <a href="{{ route('admin.category_create') }}">
                                <span data-key="t-chat">Add Category</span>
                            </a>
                        </li>
                        {{-- @endif --}}
                    </ul>
                </li>
                {{-- @endif --}}

                <li>
                    <a href="javascript: void(0);" class="has-arrow">
                        <i data-feather="grid"></i>
                        <span data-key="t-apps">City</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li>
                            <a href="{{ route('admin.all_cities') }}">
                                <span data-key="t-calendar">All City</span>
                            </a>
                            {{-- <a href="#">
                                <span data-key="t-calendar">All City</span>
                            </a> --}}
                        </li>

                    </ul>
                </li>

                <li>
                    <a href="javascript: void(0);" class="has-arrow">
                        <i data-feather="grid"></i>
                        <span data-key="t-apps">Manage Product</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li>

                            <a href="{{ route('admin.all_products') }}">
                                <span data-key="t-calendar">All Product</span>
                            </a>
                        </li>

                        <li>

                            <a href="{{ route('admin.product_create') }}">
                                <span data-key="t-chat">Add Product</span>
                            </a>
                        </li>

                    </ul>
                </li>


                <li>
                    <a href="javascript: void(0);" class="has-arrow">
                        <i data-feather="grid"></i>
                        <span data-key="t-apps">Manage Restaurant</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li>

                            <a href="{{ route('admin.all_restuarants') }}">
                                <span data-key="t-calendar">All Restaurant </span>
                            </a>
                        </li>
                        <li>

                            <a href="{{ route('admin.add_restuarant') }}">
                                <span data-key="t-calendar">Add Restaurant </span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('admin.pending_restuarants') }}">
                                <span data-key="t-chat">Pending Restaurant</span>
                            </a>
                        </li>

                        <li>
                            <a href="{{ route('admin.approved_restuarants') }}">
                                <span data-key="t-chat">Approve Restaurant</span>
                            </a>
                        </li>


                    </ul>
                </li>

                <li>
                    <a href="javascript: void(0);" class="has-arrow">
                        <i data-feather="grid"></i>
                        <span data-key="t-apps">Manage Banner</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li>

                            <a href="{{ route('admin.all_banners') }}">
                                <span data-key="t-calendar">All Banner </span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('admin.banner_create') }}">
                                <span data-key="t-calendar">Add Banner </span>
                            </a>
                        </li>


                    </ul>
                </li>

                {{-- manage orders --}}
                <li>
                    <a href="javascript: void(0);" class="has-arrow">
                        <i data-feather="grid"></i>
                        <span data-key="t-apps">Manage Orders</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">

                        <li>
                            <a href="{{ route('admin.pending_orders') }}">
                                <span data-key="t-calendar">Pending Orders </span>
                            </a>
                        </li>


                        <li>
                            <a href="{{ route('admin.confirmed_orders') }}">
                                <span data-key="t-calendar">Confirm Orders </span>
                            </a>
                        </li>


                        <li>
                            <a href="{{ route('admin.processing_orders') }}">
                                <span data-key="t-calendar">Processing Orders </span>
                            </a>
                        </li>


                        <li>
                            <a href="{{ route('admin.deliverd_orders') }}">
                                <span data-key="t-calendar">Deliverd Orders </span>
                            </a>
                        </li>

                    </ul>
                </li>


                {{-- <li class="menu-title mt-2" data-key="t-components">Elements</li> --}}

                <li>
                    <a href="javascript: void(0);" class="has-arrow">
                        <i data-feather="briefcase"></i>
                        <span data-key="t-components">Manage Reports</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li>
                            <a href="{{ route('admin.get_all_report') }}" data-key="t-alerts">All Reports</a>

                        </li>


                    </ul>
                </li>


                {{-- review start here --}}
                <li>
                    <a href="javascript: void(0);" class="has-arrow">
                        <i data-feather="gift"></i>
                        <span data-key="t-ui-elements">Manage Review</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li>
                            <a href="{{ route('admin.pending_reviews') }}" data-key="t-lightbox">Pending Review</a>
                        </li>
                        <li>
                            <a href="{{ route('admin.approbed_reviews') }}" data-key="t-range-slider">Approve
                                Review</a>
                        </li>
                    </ul>
                </li>
                {{-- review end here --}}




                <li>
                    <a href="javascript: void(0);" class="has-arrow">
                        <i data-feather="gift"></i>
                        <span data-key="t-ui-elements">Role & Permission</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li>
                            <a href="{{ route('admin.get_all_permissions') }}" data-key="t-lightbox">All Permission</a>

                        </li>
                        <li>
                            {{-- <a href="{{ route('all.roles') }}" data-key="t-range-slider">All Roles</a> --}}
                            <a href="#" data-key="t-range-slider">All Roles</a>

                        </li>
                        <li>
                            {{-- <a href="{{ route('add.roles.permission') }}" data-key="t-range-slider">Role In
                                Permission</a> --}}
                            <a href="#" data-key="t-range-slider">Role In
                                Permission</a>

                        </li>
                        <li>
                            {{-- <a href="{{ route('all.roles.permission') }}" data-key="t-range-slider">All Role In
                                Permission</a> --}}
                            <a href="#" data-key="t-range-slider">All Role In
                                Permission</a>
                        </li>

                    </ul>
                </li>

                <li>
                    <a href="javascript: void(0);" class="has-arrow">
                        <i data-feather="gift"></i>
                        <span data-key="t-ui-elements">Manage Admin</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li>
                            {{-- <a href="{{ route('all.admin') }}" data-key="t-lightbox">All Admin</a> --}}
                            <a href="#" data-key="t-lightbox">All Admin</a>

                        </li>
                        <li>
                            {{-- <a href="{{ route('add.admin') }}" data-key="t-range-slider">Add Admin</a> --}}
                            <a href="#" data-key="t-range-slider">Add Admin</a>

                        </li>


                    </ul>
                </li>


            </ul>

            <div class="card sidebar-alert border-0 text-center mx-4 mb-0 mt-5">
                <div class="card-body">
                    <img src="assets/images/giftbox.png" alt="">
                    <div class="mt-4">
                        <h5 class="alertcard-title font-size-16">Unlimited Access</h5>
                        <p class="font-size-13">Upgrade your plan from a Free trial, to select ‘Business Plan’.</p>

                    </div>
                </div>
            </div>
        </div>
        <!-- Sidebar -->
    </div>
</div>