<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="#" class="brand-link">
        <span class="brand-text font-weight-light">Department Dashboard</span>
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
                    <a href="{{ route('udepartment.home') }}" class="nav-link {{ (request()->is('udepartment/home')) ? 'active' : '' }}">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>Dashboard</p>
                    </a>
                </li>
                <li class="nav-item {{ (request()->is('udepartment/internship*')) ? 'menu-open' : '' }}">
                    <a href="#" class="nav-link {{ (request()->is('udepartment/internship*')) ? 'active' : '' }}">
                        <i class="nav-icon fas fa-briefcase"></i>
                        <p>
                            Internships
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('udepartment.internship.add') }}" class="nav-link {{ (request()->is('udepartment/internship/add')) ? 'active' : '' }}">
                                <i class="fas fa-plus nav-icon"></i>
                                <p>Add Internship</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('udepartment.internship.list') }}" class="nav-link {{ (request()->is('udepartment/internship/list') || request()->is('udepartment/internship/view*') || request()->is('udepartment/internship/edit*')) ? 'active' : '' }}">
                                <i class="fas fa-list nav-icon"></i>
                                <p>Internships List</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item {{ (request()->is('udepartment/application*')) ? 'menu-open' : '' }}">
                    <a href="#" class="nav-link {{ (request()->is('udepartment/application*')) ? 'active' : '' }}">
                        <i class="nav-icon fas fa-paper-plane"></i>
                        <p>
                            Applications
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('udepartment.application.list') }}" class="nav-link {{ (request()->is('udepartment/application/list') || request()->is('udepartment/application/view*')) ? 'active' : '' }}">
                                <i class="fas fa-list nav-icon"></i>
                                <p>Applications List</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('udepartment.application.filter') }}" class="nav-link {{ (request()->is('udepartment/application/filter*')) ? 'active' : '' }}">
                                <i class="fas fa-filter nav-icon"></i>
                                <p>Filters</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a href="{{ route('udepartment.intern.list') }}" class="nav-link {{ (request()->is('udepartment/intern/*')) ? 'active' : '' }}">
                        <i class="nav-icon fas fa-users"></i>
                        <p>
                            Interns
                        </p>
                    </a>
                </li>
                
             
               <li class="nav-item">
                <a href="{{ route('udepartment.student.list') }}" class="nav-link {{ (request()->is('udepartment/students/*')) ? 'active' : '' }}">
                    <i class="nav-icon fas fa-users"></i>
                    <p>
                        Students
                    </p>
                </a>
            </li>
               

                <li class="nav-item {{ (request()->is('udepartment/reports*')) ? 'menu-open' : '' }}">
                    <a href="#" class="nav-link {{ (request()->is('udepartment/reports*')) ? 'active' : '' }}">
                        <i class="nav-icon far fa-file-pdf"></i>
                        <p>
                            Reports
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('udepartment.reports.application') }}" class="nav-link {{ (request()->is('udepartment/reports/application')) ? 'active' : '' }}">
                                <i class="fas fa-paper-plane nav-icon"></i>
                                <p>Applications</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('udepartment.reports.internship') }}" class="nav-link {{ (request()->is('udepartment/reports/internship')) ? 'active' : '' }}">
                                <i class="fas fa-briefcase nav-icon"></i>
                                <p>Internship</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a href="{{ route('udepartment.profile') }}" class="nav-link {{ (request()->is('udepartment/profile')) ? 'active' : '' }}">
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
