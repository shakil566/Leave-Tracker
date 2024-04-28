<?php
$currentControllerFunction = Route::currentRouteAction();
$currentCont = preg_match(
    '/([a-z]*)@/i',
    request()
        ->route()
        ->getActionName(),
    $currentControllerFunction,
);
$currentControllerName = Request::segment(2);
// dd($currentControllerName);
$currentFullRouteName = Route::getFacadeRoot()
    ->current()
    ->uri();
$action = Route::currentRouteAction();
?>

<aside class="main-sidebar sidebar-dark-primary elevation-4">

    <a href="{{ url('/dashboard') }}" class="brand-link">
        <img src="{{ asset('backend') }}/dist/img/AdminLogo.png" alt="Admin Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-light">@lang('english.PROJECT_TITLE')</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <!-- Add icons to the links using the .nav-icon class
           with font-awesome or any other icon font library -->
                <li class="nav-item menu-open">
                    <a href="{{ url('dashboard/admin') }}" class="nav-link active">
                        <i class="nav-icon fa fa-home"></i>
                        <p>
                            @lang('english.DASHBOARD')
                        </p>
                    </a>
                </li>

                @if(Auth::user()->user_group_id != '2')
                <li class="nav-item parent menu-item-has-children <?php echo in_array($currentControllerName, ['userGroup', 'users', 'employees']) ? 'act' : ''; ?>">
                    <a href="#" class="nav-link parent-link">
                        <i class="nav-icon fas fa-user"></i>
                        <p>
                            @lang('english.USER_SETUP')
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview admin-nav sub-menu <?php echo in_array($currentControllerName, ['userGroup', 'users', 'employees']) ? 'visible' : ''; ?>">
                        <li class="nav-item <?php echo $currentControllerName == 'userGroup' ? 'act' : ''; ?>">
                            <a href="{{ URL::to('admin/userGroup') }}" class="nav-link">
                                <i class="fas fa-users nav-icon"></i>
                                <p>@lang('english.USER_GROUP')</p>
                            </a>
                        </li>
                        <li class="nav-item <?php echo $currentControllerName == 'users' ? 'act' : ''; ?>">
                            <a href="{{ URL::to('admin/users') }}" class="nav-link">
                                <i class="nav-icon fas fa-user"></i>
                                <p>@lang('english.USER')</p>
                            </a>
                        </li>
                        <li class="nav-item <?php echo $currentControllerName == 'employees' ? 'act' : ''; ?>">
                            <a href="{{ URL::to('admin/employees') }}" class="nav-link">
                                <i class="nav-icon fas fa-user"></i>
                                <p>@lang('english.EMPLOYEES')</p>
                            </a>
                        </li>
                    </ul>
                </li>

                @endif

                <li class="nav-item parent menu-item-has-children <?php echo in_array($currentControllerName, ['task', 'project', 'assignedTask', 'taskInfo']) ? 'act' : ''; ?>">
                    <a href="#" class="nav-link parent-link">
                        <i class="nav-icon fas fa-project-diagram"></i>
                        <p>
                            @lang('english.LEAVE_MANAGEMENT')
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview admin-nav sub-menu <?php echo in_array($currentControllerName, ['leaveCategory', 'leaveApplication']) ? 'visible' : ''; ?>">
                        @if(Auth::user()->user_group_id != '2')
                        <li class="nav-item <?php echo $currentControllerName == 'leaveCategory' ? 'act' : ''; ?>">
                            <a href="{{ url('admin/leaveCategory') }}" class="nav-link">
                                <i class="fas fa-award"></i>
                                <p>@lang('english.LEAVE_CATEGORY')</p>
                            </a>
                        </li>
                        
                        @endif
                        <li class="nav-item <?php echo $currentControllerName == 'leaveApplication' ? 'act' : ''; ?>">
                            <a href="{{ url('admin/leaveApplication') }}" class="nav-link">
                                <i class="fas fa-tasks"></i>
                                <p>@lang('english.LEAVE_APPLICATION')</p>
                            </a>
                        </li>

                    </ul>
                </li>

            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>