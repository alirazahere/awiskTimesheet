<!-- Top Navbar -->
<nav class="navbar navbar-expand-xl navbar-light fixed-top hk-navbar hk-navbar-alt">
    <a class="navbar-toggle-btn nav-link-hover navbar-toggler" href="javascript:void(0);" data-toggle="collapse"
       data-target="#navbarCollapseAlt" aria-controls="navbarCollapseAlt" aria-expanded="false"
       aria-label="Toggle navigation"><span class="feather-icon"><i data-feather="menu"></i></span></a>
    <a class="navbar-brand" href="{{route('page.dashboard')}}">
        <img class="brand-img d-inline-block align-top" src="{{asset('dist/img/logo-light.png')}}" alt="brand"/>
    </a>
    <div class="collapse navbar-collapse" id="navbarCollapseAlt">
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link {{ Route::current()->getName() == 'page.dashboard' ? 'active' : '' }} "
                   href="{{route('page.dashboard')}}">Dashboard</a>
            </li>
        </ul>
    </div>
    <ul class="navbar-nav hk-navbar-content">
        <li class="nav-item dropdown dropdown-authentication">
            <a class="nav-link dropdown-toggle no-caret" href="#" role="button" data-toggle="dropdown"
               aria-haspopup="true" aria-expanded="false">
                <div class="media">
                    <div class="media-body">
                        <span>Hi, {{Auth::user()->name}}<i class="zmdi zmdi-chevron-down"></i></span>
                    </div>
                </div>
            </a>
            <div class="dropdown-menu dropdown-menu-right" data-dropdown-in="flipInX" data-dropdown-out="flipOutX">
                <a class="dropdown-item" href="#"><i class="dropdown-icon zmdi zmdi-mail-send"></i><span>Request</span></a>
                <a class="dropdown-item" href="#"><i
                            class="dropdown-icon zmdi zmdi-account-add"></i><span>Create User</span></a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="{{ route('logout') }}"
                   onclick="event.preventDefault();
                                                document.getElementById('logout-form').submit();"><i
                            class="dropdown-icon zmdi zmdi-power"></i><span>Log out</span></a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    {{ csrf_field() }}
                </form>
            </div>
        </li>
    </ul>
</nav>
<!-- /Top Navbar -->