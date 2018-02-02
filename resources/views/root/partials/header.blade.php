<!--Main Navigation-->
<header>

    <!-- Sidebar navigation -->
    <ul id="slide-out" class="side-nav fixed sn-bg-1 custom-scrollbar">
        <!-- Avatar -->
        <li class="logo-sn waves-effect">
            <div class="text-center">
                <img src="/root/assets/app/images/avatar1.png" class="rounded-circle p-3 img-fluid">
            </div>
        </li>
        <!--/. Avatar -->

        <!-- Side navigation links -->
        <li>
            <ul class="collapsible collapsible-accordion">
                <!-- My account -->
                <li>
                    <a class="collapsible-header waves-effect arrow-r">
                        <i class="fa fa-user-circle"></i> {{ Auth::user()->email }}
                        <i class="fa fa-angle-down rotate-icon"></i></a>

                    <div class="collapsible-body">
                        <ul>
                            <li>
                                <a href="#" class="waves-effect"><i class="fa fa-lock"></i>Lock</a>

                                <a href="#" onclick="event.preventDefault();
                                                document.getElementById('form-logout').submit();" class="waves-effect">
                                                    <i class="fa fa-sign-out"></i>Log-out</a>

                                <form method="POST" action="{{ route('root.logout') }}" id="form-logout" class="d-none">
                                    {{ csrf_field() }}
                                </form>
                            </li>
                        </ul>
                    </div>
                </li>
                <!--/. My account -->

                <hr>

                <!-- Dashboard -->
                <li>
                    <a href="{{ route('root.home') }}" class="collapsible-header waves-effect">
                        <i class="fa fa-tachometer"></i>Dashboard</a>
                </li>
                <!--/. Dashboard -->

                <hr>

                <!-- Categories -->
                <li>
                    <a class="collapsible-header waves-effect arrow-r">
                        <i class="fa fa-th"></i> Categories
                        <i class="fa fa-angle-down rotate-icon"></i></a>

                    <div class="collapsible-body">
                        <ul>
                            <li>
                                <a href="/superuser/categories/create" class="waves-effect">
                                    <i class="fa fa-plus"></i>New category</a>
                                <a href="/superuser/categories" class="waves-effect">
                                    <i class="fa fa-list"></i>All categories</a>
                            </li>
                        </ul>
                    </div>
                </li>
                <!--/. Categories -->

                <!-- Items -->
                <li>
                    <a class="collapsible-header waves-effect arrow-r">
                        <i class="fa fa-cube"></i> Items
                        <i class="fa fa-angle-down rotate-icon"></i></a>

                    <div class="collapsible-body">
                        <ul>
                            <li>
                                <a href="/superuser/items/create" class="waves-effect">
                                    <i class="fa fa-plus"></i>New item</a>
                                <a href="/superuser/items" class="waves-effect">
                                    <i class="fa fa-list"></i>All items</a>
                            </li>
                        </ul>
                    </div>
                </li>
                <!--/. Items -->

                <!-- Coupons -->
                <li>
                    <a class="collapsible-header waves-effect arrow-r">
                        <i class="fa fa-tags"></i> Coupons
                        <i class="fa fa-angle-down rotate-icon"></i></a>

                    <div class="collapsible-body">
                        <ul>
                            <li>
                                <a href="/superuser/coupons/create" class="waves-effect">
                                    <i class="fa fa-plus"></i>New coupon</a>
                                <a href="/superuser/coupons" class="waves-effect">
                                    <i class="fa fa-list"></i>All coupons</a>
                            </li>
                        </ul>
                    </div>
                </li>
                <!--/. Coupons -->

                <hr>

                <!-- Reservations -->
                <li>
                    <a class="collapsible-header waves-effect arrow-r">
                        <i class="fa fa-hotel"></i> Reservations
                        <i class="fa fa-angle-down rotate-icon"></i></a>

                    <div class="collapsible-body">
                        <ul>
                            <li>
                                <a href="/superuser/reservations/create" class="waves-effect">
                                    <i class="fa fa-plus"></i>New reservation</a>
                                <a href="/superuser/reservations" class="waves-effect">
                                    <i class="fa fa-list"></i>All reservations</a>
                            </li>
                        </ul>
                    </div>
                </li>
                <!--/. Reservations -->

                <!-- Calendar -->
                <li>
                    <a href="#" class="collapsible-header waves-effect">
                        <i class="fa fa-calendar"></i>Calendar</a>
                </li>
                <!--/. Calendar -->

                <!-- Reports -->
                <li>
                    <a class="collapsible-header waves-effect arrow-r">
                        <i class="fa fa-line-chart"></i> Reports
                        <i class="fa fa-angle-down rotate-icon"></i></a>

                    <div class="collapsible-body">
                        <ul>
                            <li>
                                <a href="#" class="waves-effect">Sales</a>
                                <a href="#" class="waves-effect">Monthly Reservation</a>
                                <a href="#" class="waves-effect">Occupancy</a>
                            </li>
                        </ul>
                    </div>
                </li>
                <!--/. Reports -->

                <hr>

                <!-- Users -->
                <li>
                    <a class="collapsible-header waves-effect arrow-r">
                        <i class="fa fa-users"></i> Users
                        <i class="fa fa-angle-down rotate-icon"></i></a>

                    <div class="collapsible-body">
                        <ul>
                            <li>
                                <a href="/superuser/superusers/create" class="waves-effect">
                                    <i class="fa fa-plus"></i>New superuser</a>
                                <a href="/superuser/superusers" class="waves-effect">
                                    <i class="fa fa-list"></i>All superusers</a>
                            </li>
                        </ul>
                    </div>
                </li>
                <!--/. Users -->

                <!-- Setup -->
                <li>
                    <a href="#" class="collapsible-header waves-effect">
                        <i class="fa fa-wrench"></i>Setup</a>
                </li>
                <!--/. Setup -->

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
            <a href="#" data-activates="slide-out" class="button-collapse"><i class="fa fa-bars"></i></a>
        </div>

        <!-- Breadcrumb-->
        <div class="mr-auto">
            <ol class="header-breadcrumb breadcrumb fp-header-breadcrumb clearfix">
                <li class="breadcrumb-item">
                    <a href="{{ route('root.home') }}">Home</a>
                </li>

                @for($i = 2; $i < 3; $i++)
                    <li class="breadcrumb-item">
                        <a href="{{ URL::to(implode( '/',
                            array_slice(Request::segments(), 0, $i, true))) }}">
                                {{ ucfirst(Request::segment($i)) }}</a>
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

        </ul>
        <!--/Navbar links-->

    </nav>
    <!-- /.Navbar -->

</header>
<!--Main Navigation-->