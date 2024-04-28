<nav class="main-header navbar navbar-expand navbar-dark">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
        </li>

    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">

        <li class="nav-item">
            <a class="nav-link" data-widget="fullscreen" href="#" role="button">
                <i class="fas fa-expand-arrows-alt"></i>
            </a>
        </li>

        <li class="nav-item dropdown">

            <a class="nav-link" data-toggle="dropdown" href="#">
                @if (!empty(Auth::user()->photo))
                    <img class="img-circle user-icon"
                        src="{{ URL::to('/') }}/uploads/user/{{ Auth::user()->photo }}"
                        alt="{{ Auth::user()->official_name }}">
                @else
                    <img class="img-circle user-icon" src="{{ URL::to('/') }}/img/unknown.png" alt="">
                @endif
                <span class="nav-username">{{ Auth::user()->name }} <i
                        class="fas fa-angle-down"></i></span>
            </a>
            <div class="dropdown-menu dropdown-menu-sm dropdown-menu-right">

                <a href="{{ url('admin/users/profile') }}" class="dropdown-item">
                    <i class="fa fa-user"></i> @lang('english.MY_PROFILE')
                </a>

                <div class="dropdown-divider"></div>
                <a class=" dropdown-item" href="{{ route('logout.perform') }}">
                    <i class="fas fa-sign-out-alt"></i> @lang('english.LOGOUT')
                </a>


            </div>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ route('logout.perform') }}" title="{{ __('english.LOGOUT') }}">
                <i class="fas fa-sign-out-alt"></i>
            </a>

        </li>
    </ul>
</nav>
