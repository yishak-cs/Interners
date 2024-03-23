<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="#" class="brand-link">
        <span class="brand-text font-weight-light">University Dashboard</span>
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
                    <a href="{{ route('university.home') }}" class="nav-link {{ (request()->is('university/home')) ? 'active' : '' }}">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>Dashboard</p>
                    </a>
                </li>
                <li class="nav-item {{ (request()->is('university/faculty*')) ? 'menu-open' : '' }}">
                    <a href="#" class="nav-link {{ (request()->is('university/faculty*')) ? 'active' : '' }}">
                        <i class="nav-icon fas fa-th"></i>
                        <p>
                        Faculties
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('university.faculty.add') }}" class="nav-link {{ (request()->is('university/faculty/add')) ? 'active' : '' }}">
                                <i class="fas fa-plus nav-icon"></i>
                                <p>Add Faculty</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('university.faculty.list') }}" class="nav-link {{ (request()->is('university/faculty/list') || request()->is('university/faculty/view*') || request()->is('university/faculty/edit*')) ? 'active' : '' }}">
                                <i class="fas fa-list nav-icon"></i>
                                <p>Faculty List</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item {{ (request()->is('university/staff*')) ? 'menu-open' : '' }}">
                    <a href="#" class="nav-link {{ (request()->is('university/staff*')) ? 'active' : '' }}">
                        <i class="nav-icon fas fa-users"></i>
                        <p>
                            Staffs
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('university.staff.add') }}" class="nav-link {{ (request()->is('university/staff/add')) ? 'active' : '' }}">
                                <i class="fas fa-plus nav-icon"></i>
                                <p>Add Staff</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('university.staff.list') }}" class="nav-link {{ (request()->is('university/staff/list') || request()->is('university/staff/view*') || request()->is('university/staff/edit*')) ? 'active' : '' }}">
                                <i class="fas fa-list nav-icon"></i>
                                <p>Staffs List</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a href="{{ route('university.internship.list') }}" class="nav-link {{ (request()->is('university/internship*')) ? 'active' : '' }}">
                        <i class="nav-icon fas fa-briefcase"></i>
                        <p>
                            Internships
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('university.application.list') }}" class="nav-link {{ (request()->is('university/application*')) ? 'active' : '' }}">
                        <i class="nav-icon fas fa-file-alt"></i>
                        <p>
                            Applications
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('university.intern.list') }}" class="nav-link {{ (request()->is('university/intern/*')) ? 'active' : '' }}">
                        <i class="nav-icon fas fa-users"></i>
                        <p>
                            Interns
                        </p>
                    </a>
                </li>
                <li class="nav-item {{ (request()->is('university/reports*')) ? 'menu-open' : '' }}">
                    <a href="#" class="nav-link {{ (request()->is('university/reports*')) ? 'active' : '' }}">
                        <i class="nav-icon far fa-file-pdf"></i>
                        <p>
                            Reports
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('university.reports.application') }}" class="nav-link {{ (request()->is('university/reports/application')) ? 'active' : '' }}">
                                <i class="fas fa-file-alt nav-icon"></i>
                                <p>Applications</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('university.reports.internship') }}" class="nav-link {{ (request()->is('university/reports/internship')) ? 'active' : '' }}">
                                <i class="fas fa-briefcase nav-icon"></i>
                                <p>Internship</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a href="{{ route('university.profile') }}" class="nav-link {{ (request()->is('university/profile')) ? 'active' : '' }}">
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
