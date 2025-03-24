@inject('request', 'Illuminate\Http\Request')
<!-- Left side column. contains the sidebar -->
<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="/" class="brand-link">
        <span class="brand-text font-weight-light">Calendar</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu">
                <!-- Add icons to the links using the .nav-icon class
                     with font-awesome or any other icon font library -->
                <li class="nav-item menu-open">
                    <ul class="nav nav-treeview">
                        @can('role-list')
                            <li class="nav-item">
                                <a href="{{ route('admin.roles.index') }}" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>@lang('quickadmin.roles.name')</p>
                                </a>
                            </li>
                        @endcan
                        @can('permission-list')
                            <li class="nav-item">
                                <a href="{{ route('admin.permissions.index') }}" class="nav-link">
                                    <i class="fab fa-keycdn nav-icon"></i>
                                    <p>@lang('quickadmin.permissions.name')</p>
                                </a>
                            </li>
                        @endcan
                        @can('user-list')
                            <li class="nav-item">
                                <a href="{{ route('admin.users.index') }}" class="nav-link">
                                    <i class="fas fa-user nav-icon"></i>
                                    <p>@lang('quickadmin.users.title')</p>
                                </a>
                            </li>
                        @endcan
                        @can('group-list')
                            <li class="nav-item">
                                <a href="{{ route('admin.groups.index') }}" class="nav-link">
                                    <i class="far fa-object-group nav-icon"></i>
                                    <p>@lang('quickadmin.groups.title')</p>
                                </a>
                            </li>
                        @endcan
                        @can('color-list')
                            <li class="nav-item">
                                <a href="{{ route('admin.colors.index') }}" class="nav-link">
                                    <i class="far fa-object-group nav-icon"></i>
                                    <p>@lang('quickadmin.colors.title')</p>
                                </a>
                            </li>
                        @endcan
                        @can('event-list')
                            <li class="nav-item menu-open">
                                <a href="#" class="nav-link">
                                    <i class="nav-icon fas fa-table"></i>
                                    <p>
                                        @lang('quickadmin.events.event')
                                        <i class="fas fa-angle-double-down right"></i>
                                    </p>
                                </a>
                                <ul class="nav-treeview nav-child-indent" style="display: block;">
                                    <li class="nav-item">
                                        <a href="{{ route('admin.events.index') }}" class="nav-link">
                                            <i class="far fa-calendar-alt nav-icon"></i>
                                            <p>@lang('quickadmin.events.calendar')</p>

                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="{{ route('admin.events.list') }}" class="nav-link">
                                            <i class="far fa-calendar-alt nav-icon"></i>
                                            <p>@lang('quickadmin.events.agenda')</p>

                                        </a>
                                    </li>
                                </ul>
                            </li>
                        @endcan

                    </ul>
                </li>

            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>

