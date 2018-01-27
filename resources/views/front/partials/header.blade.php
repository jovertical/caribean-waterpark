<header id="header-page">
    <div class="header-page__inner">
        <div class="container">
            <div class="logo">
                <a href="index.html"><img src="/front/assets/images/logo.png" alt=""></a>
            </div>

            <nav class="navigation awe-navigation" data-responsive="1200">
                <ul class="menu-list">
                    <li class="menu-item current-menu-parent">
                        <a href="{{ route('front.welcome') }}">Home</a>
                    </li>

                    <li class="menu-item-has-children"><a href="destinations-list.html">Destinations</a>
                        <ul class="sub-menu">
                            <li><a href="destinations-list.html">List</a></li>
                            <li><a href="destinations-grid.html">Grid</a></li>
                            <li class="menu-item-has-children">
                                <a href="destinations-trip.html">Detail</a>
                                <ul class="sub-menu">
                                    <li><a href="destinations-trip.html">Trips in destination</a></li>
                                    <li><a href="destinations-hotel.html">Hotels in destination</a></li>
                                    <li><a href="destinations-attraction.html">Attraction in destination</a></li>
                                    <li><a href="destinations-flight.html">Flights in destination</a></li>
                                    <li><a href="destinations-train.html">Train in destination</a></li>
                                </ul>
                            </li>

                            <li class="menu-item-has-children">
                                <a href="destinations-trip.html">Detail (Dark)</a>
                                <ul class="sub-menu">
                                    <li><a href="destinations-trip-dark.html">Trips in destination</a></li>
                                    <li><a href="destinations-hotel-dark.html">Hotels in destination</a></li>
                                    <li><a href="destinations-attraction-dark.html">Attraction in destination</a></li>
                                    <li><a href="destinations-flight-dark.html">Flights in destination</a></li>
                                    <li><a href="destinations-train-dark.html">Train in destination</a></li>
                                </ul>
                            </li>
                        </ul>
                    </li>

                    <li class="menu-item-has-children">
                        <a href="trip.html">Trips</a>
                        <ul class="sub-menu"><li><a href="trip.html">Trips</a></li>
                            <li><a href="trip-detail.html">Trips Detail</a></li>
                            <li><a href="trip-dark.html">Trips (Dark)</a></li>
                            <li><a href="trip-detail-dark.html">Trips Detail (Dark)</a></li>
                        </ul>
                    </li>
                </ul>
            </nav>

            <div class="search-box">
                <span class="searchtoggle"><i class="awe-icon awe-icon-search"></i></span>
                <form class="form-search">
                    <div class="form-item">
                        <input type="text" value="Search &amp; hit enter">
                    </div>
                </form>
            </div>

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