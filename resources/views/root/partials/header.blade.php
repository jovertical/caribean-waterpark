<!--Main Navigation-->
<header>

    <!-- Sidebar navigation -->
    <ul id="slide-out" class="side-nav fixed sn-bg-1 custom-scrollbar">
        <!-- Avatar -->
        <li class="logo-sn waves-effect">
            <div class=" text-center">
                <img src="" class="rounded-circle p-5 img-fluid">
            </div>
        </li>
        <!--/. Avatar -->

        <!-- Side navigation links -->
        <li>
            <ul class="collapsible collapsible-accordion">
                <li>
                    <a href="{{ route('superuser.home') }}" class="collapsible-header waves-effect">
                        <i class="fa fa-tachometer"></i>Dashboard</a>
                </li>

                <!-- Manage -->
                <li>
                    <a class="collapsible-header waves-effect arrow-r">
                        <i class="fa fa-archive"></i> Manage
                        <i class="fa fa-angle-down rotate-icon"></i></a>

                    <div class="collapsible-body">
                        <ul>
                            <li>
                                <a href="/superuser/superusers" class="waves-effect">Superusers</a>
                                <a href="/superuser/users" class="waves-effect">Users</a>
                            </li>
                        </ul>
                    </div>
                </li>
                <!--/. Manage -->
            </ul>
        </li>
        <!--/. Side navigation links -->

        <div class="sidenav-bg mask-strong"></div>
    </ul>
    <!--/. Sidebar navigation -->

    <!-- Navbar -->
    <nav class="navbar fixed-top navbar-toggleable-md navbar-expand-lg scrolling-navbar double-nav">
        <!-- SideNav slide-out button -->
        <div class="float-left">
            <a href="#" data-activates="slide-out" class="button-collapse black-text"><i class="fa fa-bars"></i></a>
        </div>

        <!-- Breadcrumb-->
        <div class="mr-auto">
            <ol class="header-breadcrumb breadcrumb fp-header-breadcrumb clearfix">
                <li class="breadcrumb-item">
                    <a href="{{ route('superuser.home') }}" class="black-text">Home</a>
                </li>

                @for($i = 2; $i <= count(Request::segments()); $i++)
                    <li class="breadcrumb-item">
                        <a href="{{ URL::to(implode( '/',
                            array_slice(Request::segments(), 0 , $i, true))) }}">
                            {{ ucfirst(strtolower(Request::segment($i))) }}</a>
                    </li>
                @endfor
            </ol>
        </div>
        <!-- Breadcrumb-->

        <!--Navbar links-->
        <ul class="nav navbar-nav nav-flex-icons ml-auto">

            <!-- Notifications -->
            <li class="nav-item dropdown notifications-nav">
                <a class="nav-link dropdown-toggle waves-effect" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <span class="badge red">1</span><i class="fa fa-bell"></i>
                    <span class="d-none d-md-inline-block">Notifications</span></a>

                <div class="dropdown-menu dropdown-menu-right dropdown-primary">
                    <a href="#" class="dropdown-item"><span>Some Notification</span></a>
                </div>
            </li>
            <!--/. Notifications -->

            <!-- Account -->
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle waves-effect" href="#" id="userDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="fa fa-user-circle"></i>
                    <span class="clearfix d-none d-sm-inline-block">{{ Auth::user()->name }}</span></a>

                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userDropdown">
                    <form method="GET" action="">
                        {{ method_field('PUT') }}

                        <button class="dropdown-item waves-effect">My account</button>
                    </form>

                    <a href="#" class="dropdown-item waves-effect" onclick="
                        event.preventDefault();
                            document.getElementById('form-logout').submit();">Log-out</a>

                    <form method="POST" action="{{ route('superuser.logout') }}" id="form-logout" class="d-none">
                        {{ csrf_field() }}
                    </form>
                </div>
            </li>
            <!--/. Account -->

        </ul>
        <!--/Navbar links-->

    </nav>
    <!-- /.Navbar -->

</header>
<!--Main Navigation-->