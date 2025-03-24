<li class="{{ $request->segment(1) == 'home' ? 'active' : '' }}">
    <a href="{{ url('/admin') }}"> <i class="fa fa-wrench"></i> <span
            class="title">@lang('quickadmin.qa_dashboard')</span> </a>
</li>
@can('user_management_access')
    <li class="treeview">
        <a href="#"> <i class="fa fa-users"></i> <span class="title">@lang('quickadmin.user-management.title')</span>
            <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
        </a>
        <ul class="treeview-menu">

            @can('role_access')
                <li class="{{ $request->segment(2) == 'roles' ? 'active active-sub' : '' }}">
                    <a href="{{ route('admin.roles.index') }}"> <i class="fa fa-briefcase"></i> <span class="title">
                                @lang('quickadmin.roles.title')
                            </span> </a>
                </li>
            @endcan

            @can('user_access')
                <li class="{{ $request->segment(2) == 'users' ? 'active active-sub' : '' }}">
                    <a href="{{ route('admin.users.index') }}"> <i class="fa fa-user"></i> <span class="title">
                                @lang('quickadmin.users.title')
                            </span> </a>
                </li>
            @endcan
        </ul>
    </li>
@endcan
