<!-- Top Navbar -->
<nav class="navbar navbar-expand-xl navbar-light fixed-top hk-navbar hk-navbar-alt">
    <a class="navbar-toggle-btn nav-link-hover navbar-toggler" href="javascript:void(0);" data-toggle="collapse"
       data-target="#navbarCollapseAlt" aria-controls="navbarCollapseAlt" aria-expanded="false"
       aria-label="Toggle navigation"><span class="feather-icon"><i data-feather="menu"></i></span></a>
    <a class="navbar-brand" href="{{route('page.dashboard')}}">
        <img class="brand-img img-responsive d-inline-block align-top" style="width:100px;height:34px;"
             src="{{asset('dist/img/logo.png')}}" alt="brand"/>
    </a>
    <div class="collapse navbar-collapse" id="navbarCollapseAlt">
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link {{ Route::current()->getName() == 'page.dashboard' ? 'active' : '' }} "
                   href="{{route('page.dashboard')}}">Dashboard</a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ Route::current()->getName() == 'request.index' ? 'active' : '' }} "
                   href="{{route('request.index')}}">Requests</a>
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
            <div class="dropdown-menu dropdown-menu-right">
                <a class="dropdown-item {{ Route::current()->getName() == 'user.index' ? 'active text-white' : '' }} "
                   href="{{route('user.index')}}"><i
                            class="dropdown-icon zmdi zmdi-account-add"></i><span>Manage Users</span></a>
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