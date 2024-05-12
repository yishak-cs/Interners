<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="#" class="brand-link">
        <span class="brand-text font-weight-light">Faculty Dashboard</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img @if (Auth::user()->avatar) src="{{ asset('uploads/avatar/' . Auth::user()->avatar) }} "
                @else 
                src="{{ asset('assets/dist/img/user.jpg') }}" @endif
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
                    <a href="{{ route('faculty.home') }}"
                        class="nav-link {{ request()->is('faculty/home') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>Dashboard</p>
                    </a>
                </li>
                {{-- department --}}
                <li class="nav-item {{ request()->is('faculty/department*') ? 'menu-open' : '' }}">
                    <a href="#" class="nav-link {{ request()->is('faculty/department*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-sitemap"></i>
                        <p>
                            Departments
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('faculty.department.add') }}"
                                class="nav-link {{ request()->is('faculty/department/add') ? 'active' : '' }}">
                                <i class="fas fa-plus nav-icon"></i>
                                <p>Add Department</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('faculty.department.list') }}"
                                class="nav-link {{ request()->is('faculty/department/list') || request()->is('faculty/department/view*') || request()->is('faculty/department/edit*') ? 'active' : '' }}">
                                <i class="fas fa-list nav-icon"></i>
                                <p>Departments List</p>
                            </a>
                        </li>
                    </ul>
                </li>
                {{-- department --}}
                <li class="nav-item">
                    <a href="{{ route('faculty.student.list') }}"
                        class="nav-link {{ request()->is('faculty/students/*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-users"></i>
                        <p>
                            Students
                        </p>
                    </a>
                </li>
                {{-- evaluation trial --}}
                <li class="nav-item {{ request()->is('faculty/evaluation*') ? 'menu-open' : '' }}">
                    <a href="#" class="nav-link {{ request()->is('faculty/evaluation*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-clipboard-list"></i>
                        <p>
                            Evaluations
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('faculty.evaluation.add') }}"
                                class="nav-link {{ request()->is('faculty/evaluations/add') ? 'active' : '' }}">
                                <i class="fas fa-plus nav-icon"></i>
                                <p>Evaluation Add</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('faculty.evaluation.list') }}"
                                class="nav-link {{ request()->is('faculty/evaluations/list*')||request()->is('faculty/evaluations/view*') ? 'active' : '' }}">
                                <i class="fas fa-list nav-icon"></i>
                                <p>Evaluation list</p>
                            </a>
                        </li>
                    </ul>
                </li>
                {{-- end evaluation --}}

                {{-- evaluation response --}}

                <li class="nav-item">
                    <a href="{{ route('faculty.response.list') }}" class="nav-link {{ !(request()->routeIs('faculty.response*')) ?: 'active' }}">
                        <i class="nav-icon fas fa-reply"></i>
                        <p>{{ __("Responses") }}</p>
                    </a>
                </li>

                {{-- end --}}
                <li class="nav-item {{ request()->is('faculty/reports*') ? 'menu-open' : '' }}">
                    <a href="{{ route('faculty.reports.application') }}" class="nav-link {{ request()->is('faculty/reports*') ? 'active' : '' }}">
                        <i class="nav-icon far fa-file-pdf"></i>
                        <p>
                            Reports
                        
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('faculty.profile') }}"
                        class="nav-link {{ request()->is('faculty/profile') ? 'active' : '' }}">
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
