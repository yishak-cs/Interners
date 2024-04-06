<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="#" class="brand-link">
        <span class="brand-text font-weight-light">Company Dashboard</span>
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
                <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
                <div class="input-group-append">
                    <button class="btn btn-sidebar">
                        <i class="fas fa-search fa-fw"></i>
                    </button>
                </div>
            </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column nav-child-indent" data-widget="treeview" role="menu" data-accordion="false">
                <li class="nav-item">
                    <a href="{{ route('company.home') }}" class="nav-link {{ (request()->is('company/home')) ? 'active' : '' }}">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>Dashboard</p>
                    </a>
                </li>
                <li class="nav-item {{ (request()->is('company/department*')) ? 'menu-open' : '' }}">
                    <a href="#" class="nav-link {{ (request()->is('company/department*')) ? 'active' : '' }}">
                        <i class="nav-icon fas fa-sitemap"></i>
                        <p>
                            Departments
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('company.department.add') }}" class="nav-link {{ (request()->is('company/department/add')) ? 'active' : '' }}">
                                <i class="fas fa-plus nav-icon"></i>
                                <p>Add Department</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('company.department.list') }}" class="nav-link {{ (request()->is('company/department/list') || request()->is('company/department/view*') || request()->is('company/department/edit*')) ? 'active' : '' }}">
                                <i class="fas fa-list nav-icon"></i>
                                <p>Departments List</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item {{ (request()->is('company/staff*')) ? 'menu-open' : '' }}">
                    <a href="#" class="nav-link {{ (request()->is('company/staff*')) ? 'active' : '' }}">
                        <i class="nav-icon fas fa-users"></i>
                        <p>
                            Staffs
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('company.staff.add') }}" class="nav-link {{ (request()->is('company/staff/add')) ? 'active' : '' }}">
                                <i class="fas fa-plus nav-icon"></i>
                                <p>Add Staff</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('company.staff.list') }}" class="nav-link {{ (request()->is('company/staff/list') || request()->is('company/staff/view*') || request()->is('company/staff/edit*')) ? 'active' : '' }}">
                                <i class="fas fa-list nav-icon"></i>
                                <p>Staffs List</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a href="{{ route('company.internship.list') }}" class="nav-link {{ (request()->is('company/internship*')) ? 'active' : '' }}">
                        <i class="nav-icon fas fa-briefcase"></i>
                        <p>
                            Internships
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('company.application.list') }}" class="nav-link {{ (request()->is('company/application*')) ? 'active' : '' }}">
                        <i class="nav-icon fas fa-file-alt"></i>
                        <p>
                            Applications
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('company.intern.list') }}" class="nav-link {{ (request()->is('company/intern/*')) ? 'active' : '' }}">
                        <i class="nav-icon fas fa-users"></i>
                        <p>
                            Interns
                        </p>
                    </a>
                </li>
                <li class="nav-item {{ (request()->is('company/reports*')) ? 'menu-open' : '' }}">
                    <a href="#" class="nav-link {{ (request()->is('company/reports*')) ? 'active' : '' }}">
                        <i class="nav-icon far fa-file-pdf"></i>
                        <p>
                            Reports
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('company.reports.application') }}" class="nav-link {{ (request()->is('company/reports/application')) ? 'active' : '' }}">
                                <i class="fas fa-file-alt nav-icon"></i>
                                <p>Applications</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('company.reports.internship') }}" class="nav-link {{ (request()->is('company/reports/internship')) ? 'active' : '' }}">
                                <i class="fas fa-briefcase nav-icon"></i>
                                <p>Internship</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a href="{{ route('company.profile') }}" class="nav-link {{ (request()->is('company/profile')) ? 'active' : '' }}">
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
