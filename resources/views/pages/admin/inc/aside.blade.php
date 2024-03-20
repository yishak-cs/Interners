<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="#" class="brand-link">
        <span class="brand-text font-weight-light">Admin Dashboard</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img
                @if (Auth::user()->avatar)
                src="{{ asset('uploads/avatar/'.Auth::user()->avatar) }} "
                @else 
                src="{{ asset('assets/dist/img/user.jpg')}}" 
                @endif  
                class="img-circle elevation-2" alt="User Image">
            </div>
            <div class="info">
                <a href="#" class="d-block">{{ Auth::user()->getName() }}</a>
            </div>
        </div>

        <!-- SidebarSearch Form -->
        <div class="form-inline">
            <div class="input-group" data-widget="sidebar-search">
                <input class="form-control form-control-sidebar" type="search" placeholder="Search"
                    aria-label="Search">
                <div class="input-group-append">
                    <button class="btn btn-sidebar">
                        <i class="fas fa-search fa-fw"></i>
                    </button>
                </div>
            </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column nav-child-indent" data-widget="treeview" role="menu"
                data-accordion="false">
                <li class="nav-item">
                    <a href="{{ route('admin.home') }}" class="nav-link {{ (request()->is('admin/home')) ? 'active' : '' }}">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>Dashboard</p>
                    </a>
                </li>
                <li class="nav-item {{ (request()->is('admin/school*')) ? 'menu-open' : '' }}">
                    <a href="#" class="nav-link {{ (request()->is('admin/school*')) ? 'active' : '' }}">
                        <i class="nav-icon fas fa-graduation-cap"></i>
                        <p>
                            Schools
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('admin.school.add') }}" class="nav-link {{ (request()->is('admin/school/add')) ? 'active' : '' }}">
                                <i class="fas fa-plus nav-icon"></i>
                                <p>Add School</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.school.list') }}" class="nav-link  {{ (request()->is('admin/school/list') || request()->is('admin/school/view*') || request()->is('admin/school/edit*')) ? 'active' : '' }}">
                                <i class="fas fa-list nav-icon"></i>
                                <p>Schools List</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item {{ (request()->is('admin/company*')) ? 'menu-open' : '' }}">
                    <a href="#" class="nav-link {{ (request()->is('admin/company*')) ? 'active' : '' }}">
                        <i class="nav-icon fas fa-graduation-cap"></i>
                        <p>
                            Companys
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('admin.company.add') }}" class="nav-link {{ (request()->is('admin/company/add')) ? 'active' : '' }}">
                                <i class="fas fa-plus nav-icon"></i>
                                <p>Add Company</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.company.list') }}" class="nav-link  {{ (request()->is('admin/company/list') || request()->is('admin/company/view*') || request()->is('admin/company/edit*')) ? 'active' : '' }}">
                                <i class="fas fa-list nav-icon"></i>
                                <p>Company List</p>
                            </a>
                        </li>
                    </ul>
                </li>

                <li class="nav-item {{ (request()->is('admin/staff*')) ? 'menu-open' : '' }}">
                    <a href="#" class="nav-link {{ (request()->is('admin/staff*')) ? 'active' : '' }}">
                        <i class="nav-icon fas fa-users"></i>
                        <p>
                            Staffs
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('admin.staff.add') }}" class="nav-link {{ (request()->is('admin/staff/add')) ? 'active' : '' }}">
                                <i class="fas fa-plus nav-icon"></i>
                                <p>Add Staff</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.staff.list') }}" class="nav-link {{ (request()->is('admin/staff/list') || request()->is('admin/staff/view*') || request()->is('admin/staff/edit*')) ? 'active' : '' }}">
                                <i class="fas fa-list nav-icon"></i>
                                <p>Staffs List</p>
                            </a>
                        </li>
                    </ul>
                </li>
        
                <li class="nav-item">
                    <a href="{{ route('admin.profile') }}" class="nav-link {{ (request()->is('admin/profile*')) ? 'active' : '' }}">
                        <i class="nav-icon fas fa-user"></i>
                        <p>
                            Profile
                        </p>
                    </a>
                </li>
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>
