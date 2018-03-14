<header id="header-page">
    <div class="header-page__inner">
        <div class="container">
            <div class="logo">
                <a href="{{ route('front.welcome') }}">
                    <img src="/front/assets/images/logo.png" alt="">
                </a>
            </div>

            <nav class="navigation awe-navigation" data-responsive="1200">
                <ul class="menu-list">
                    <li class="menu-item">
                        <a href="{{ route('front.items.index') }}">Accomodations</a>
                    </li>

                    <li class="menu-item">
                        <a href="#">Facilities</a>
                    </li>

                    <li class="menu-item menu-item-has-children
                        {{ Helper::activeMenu(Request::segment(2)) == 'reservation' ? 'current-menu-parent' : ''}}">
                        <a href="javascript:void(0);">Reservation</a>
                        <ul class="sub-menu">
                            <li>
                                <a href="{{ route('front.reservation.search') }}">Search</a>
                            </li>
                            <li>
                                <a href="{{ route('front.reservation.cart.index') }}">My Cart
                                    <span style="float: right;">
                                        {{ session()->has('reservation.selected_items') ?
                                            count(session()->get('reservation.selected_items')) : 0 }}
                                    </span>
                                </a>
                            </li>
                        </ul>
                    </li>

                    <li class="menu-item-has-children">
                        <a href="#">My account</a>
                        <ul class="sub-menu">
                            @guest
                                <li><a href="{{ route('front.login') }}">Login</a></li>
                                <li><a href="{{ route('front.register') }}">Register</a></li>
                            @else
                                <li><a href="{{ route('front.home') }}">Dashboard</a></li>
                                <li><a href="{{ route('front.account.profile') }}">Profile</a></li>
                                <li><a href="{{ route('front.account.password') }}">Password</a></li>
                                <li><a href="{{ route('front.reservations.index') }}">Reservations</a></li>
                                <li>
                                    <a href="javascript:void(0);" onclick="event.preventDefault();
                                        document.getElementById('form-logout').submit();">Logout</a>
                                </li>

                                <form method="POST" action="{{ route('front.logout') }}" id="form-logout" style="display: none;">
                                    {{ csrf_field() }}
                                </form>
                            @endguest
                        </ul>
                    </li>
                </ul>
            </nav>

            <a class="toggle-menu-responsive" href="#">
                <div class="hamburger">
                    <span class="item item-1"></span>
                    <span class="item item-2"></span>
                    <span class="item item-3"></span>
                </div>
            </a>
        </div>
    </div>
</header>