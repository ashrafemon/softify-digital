<aside class="left-sidebar" data-sidebarbg="skin5">
    <!-- Sidebar scroll-->
    <div class="scroll-sidebar">
        <!-- Sidebar navigation-->
        <nav class="sidebar-nav">
            <ul id="sidebarnav" class="pt-4">
                <li class="sidebar-item">
                    <a class="sidebar-link waves-effect waves-dark sidebar-link"
                       href="{{route('admin.dashboard.index')}}" aria-expanded="false">
                        <i class="mdi mdi-view-dashboard"></i>
                        <span class="hide-menu">Dashboard</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a class="sidebar-link has-arrow waves-effect waves-dark"
                       href="javascript:void(0)"
                       aria-expanded="false"
                    >
                        <i class="mdi mdi-receipt"></i>
                        <span class="hide-menu">Categories </span>
                    </a>
                    <ul aria-expanded="false" class="collapse first-level">
                        <li class="sidebar-item">
                            <a href="{{route('admin.categories.index')}}" class="sidebar-link">
                                <i class="mdi mdi-note-plus"></i>
                                <span class="hide-menu">List Category</span>
                            </a>
                        </li>
                        <li class="sidebar-item">
                            <a href="{{route('admin.categories.create')}}" class="sidebar-link">
                                <i class="mdi mdi-note-outline"></i>
                                <span class="hide-menu">Create Category</span>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="sidebar-item">
                    <a class="sidebar-link has-arrow waves-effect waves-dark"
                       href="javascript:void(0)"
                       aria-expanded="false"
                    >
                        <i class="mdi mdi-receipt"></i>
                        <span class="hide-menu">Products </span>
                    </a>
                    <ul aria-expanded="false" class="collapse first-level">
                        <li class="sidebar-item">
                            <a href="{{route('admin.products.index')}}" class="sidebar-link">
                                <i class="mdi mdi-note-plus"></i>
                                <span class="hide-menu">List Products</span>
                            </a>
                        </li>
                        <li class="sidebar-item">
                            <a href="{{route('admin.products.create')}}" class="sidebar-link">
                                <i class="mdi mdi-note-outline"></i>
                                <span class="hide-menu">Create Product</span>
                            </a>
                        </li>
                    </ul>
                </li>

                <li class="sidebar-item">
                    <a class="sidebar-link waves-effect waves-dark sidebar-link"
                       href="{{route('admin.orders.index')}}" aria-expanded="false">
                        <i class="mdi mdi-view-dashboard"></i>
                        <span class="hide-menu">Orders</span>
                    </a>
                </li>

                <li class="sidebar-item">
                    <a class="sidebar-link waves-effect waves-dark sidebar-link"
                       href="{{route('admin.users.index')}}" aria-expanded="false">
                        <i class="mdi mdi-view-dashboard"></i>
                        <span class="hide-menu">User</span>
                    </a>
                </li>
            </ul>
        </nav>
        <!-- End Sidebar navigation -->
    </div>
    <!-- End Sidebar scroll-->
</aside>
