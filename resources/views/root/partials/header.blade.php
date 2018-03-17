<!-- begin::Header -->
<header class="m-grid__item m-header" data-minimize="minimize" data-minimize-offset="200" data-minimize-mobile-offset="200">
    <!-- begin::Header top -->
    <div class="m-header__top">
        <div class="m-container m-container--responsive m-container--xxl m-container--full-height m-page__container">
            <div class="m-stack m-stack--ver m-stack--desktop">
                <!-- begin::Brand -->
                <div class="m-stack__item m-brand">
                    <div class="m-stack m-stack--ver m-stack--general m-stack--inline">
                        <div class="m-stack__item m-stack__item--middle m-brand__logo">
                            <a href="{{ route('root.home') }}" class="m-brand__logo-wrapper">
                                <img src="/root/assets/demo/demo2/media/img/logo/logo.png" alt=""/>
                            </a>
                        </div>

                        <div class="m-stack__item m-stack__item--middle m-brand__tools">
                            <!-- BEGIN: Responsive Aside Left Menu Toggler -->
                            <a href="javascript:;" id="m_aside_left_offcanvas_toggle" class="m-brand__icon m-brand__toggler m-brand__toggler--left m--visible-tablet-and-mobile-inline-block">
                                <span></span>
                            </a>

                            <!-- begin::Responsive Header Menu Toggler-->
                             <a id="m_aside_header_menu_mobile_toggle" href="javascript:;" class="m-brand__icon m-brand__toggler m--visible-tablet-and-mobile-inline-block m-brand__toggler--active">
                                <span></span>
                            </a>
                            <!-- end::Responsive Header Menu Toggler-->

                            <!-- begin::Topbar Toggler-->
                            <a id="m_aside_header_topbar_mobile_toggle" href="javascript:;" class="m-brand__icon m--visible-tablet-and-mobile-inline-block">
                                <i class="flaticon-more"></i>
                            </a>
                            <!--end::Topbar Toggler-->
                        </div>
                    </div>
                </div>
                <!-- end::Brand -->

                <!-- begin::Topbar -->
                <div class="m-stack__item m-stack__item--fluid m-header-head" id="m_header_nav">
                    <div id="m_header_topbar" class="m-topbar  m-stack m-stack--ver m-stack--general">
                        <div class="m-stack__item m-topbar__nav-wrapper">
                            <ul class="m-topbar__nav m-nav m-nav--inline">
                                <!-- Profile -->
                                <li class="m-nav__item m-topbar__user-profile m-topbar__user-profile--img  m-dropdown m-dropdown--medium m-dropdown--arrow m-dropdown--header-bg-fill m-dropdown--align-right m-dropdown--mobile-full-width m-dropdown--skin-light" data-dropdown-toggle="click">
                                    <a href="#" class="m-nav__link m-dropdown__toggle">
                                        <span class="m-topbar__userpic m--hide">
                                            <img src="{{ Helper::fileUrl(Auth::user(), 'thumbnail') }}" class="m--img-rounded m--marginless m--img-centered" alt=""/>
                                        </span>
                                        <span class="m-topbar__welcome">Hello,&nbsp;</span>
                                        <span class="m-topbar__username">{{ Auth::user()->name }}</span>
                                    </a>
                                    <div class="m-dropdown__wrapper">
                                        <span class="m-dropdown__arrow m-dropdown__arrow--right m-dropdown__arrow--adjust"></span>
                                        <div class="m-dropdown__inner">
                                            <div class="m-dropdown__header m--align-center"
                                                style="background: url(/root/assets/app/media/img/misc/user_profile_bg.jpg); background-size: cover;">
                                                <div class="m-card-user m-card-user--skin-dark">
                                                    <div class="m-card-user__pic">
                                                        <img src="{{ Helper::fileUrl(Auth::user(), 'thumbnail') }}" class="m--img-rounded m--marginless" alt=""/>
                                                    </div>
                                                    <div class="m-card-user__details">
                                                        <span class="m-card-user__name m--font-weight-500">
                                                            {{ Auth::user()->full_name }}
                                                        </span>

                                                        <a href="javascript:void(0);" class="m-card-user__email m--font-weight-300 m-link">
                                                            {{ Str::limit(Auth::user()->email, 25) }}
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="m-dropdown__body">
                                                <div class="m-dropdown__content">
                                                    <ul class="m-nav m-nav--skin-light">
                                                        <li class="m-nav__section m--hide">
                                                            <span class="m-nav__section-text">Section</span>
                                                        </li>
                                                        <!-- Profile -->
                                                        <li class="m-nav__item">
                                                            <a href="{{ route('root.account.profile') }}" class="m-nav__link">
                                                                <i class="m-nav__link-icon flaticon-profile-1"></i>
                                                                <span class="m-nav__link-title">
                                                                    <span class="m-nav__link-text">Profile</span>
                                                                </span>
                                                            </a>
                                                        </li>
                                                        <!--/. Profile -->

                                                        <!-- Password -->
                                                        <li class="m-nav__item">
                                                            <a href="{{ route('root.account.password') }}" class="m-nav__link">
                                                                <i class="m-nav__link-icon flaticon-lock"></i>
                                                                <span class="m-nav__link-title">
                                                                    <span class="m-nav__link-text">Password</span>
                                                                </span>
                                                            </a>
                                                        </li>
                                                        <!--/. Password -->

                                                        <li class="m-nav__separator m-nav__separator--fit"></li>

                                                        <li class="m-nav__item">
                                                            <a href="#" onclick="event.preventDefault();
                                                                document.getElementById('form-logout').submit();"
                                                                    class="btn m-btn--pill btn-secondary m-btn m-btn--custom m-btn--label-brand m-btn--bolder">Logout
                                                            </a>
                                                        </li>

                                                        <form method="POST" action="{{ route('root.logout') }}" id="form-logout" style="display: none;">
                                                            {{ csrf_field() }}
                                                        </form>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                                <!--/. Profile -->

                                <!-- Notifications -->
                                <li class="m-nav__item m-topbar__quick-actions m-topbar__quick-actions--img m-dropdown m-dropdown--large m-dropdown--header-bg-fill m-dropdown--arrow m-dropdown--align-right m-dropdown--align-push m-dropdown--mobile-full-width m-dropdown--skin-light" data-dropdown-toggle="click" data-dropdown-persistent="true">
                                    <a href="#" class="m-nav__link m-dropdown__toggle" id="m_topbar_notification_icon">
                                        @if(Auth::user()->unreadNotifications()->count())
                                            <span class="m-nav__link-badge m-badge m-badge--dot m-badge--dot-small m-badge--danger">
                                            </span>
                                        @endif

                                        <span class="m-nav__link-icon">
                                            <span class="m-nav__link-icon-wrapper">
                                                <i class="flaticon-music-2"></i>
                                            </span>
                                        </span>
                                    </a>
                                    <div class="m-dropdown__wrapper">
                                        <span class="m-dropdown__arrow m-dropdown__arrow--right"></span>
                                        <div class="m-dropdown__inner">
                                            <div class="m-dropdown__header m--align-center"
                                                style="background: url(/root/assets/app/media/img/misc/notification_bg.jpg); background-size: cover;">
                                                <span class="m-dropdown__header-title">
                                                    {{ Auth::user()->unreadNotifications->count() }}
                                                </span>
                                                <span class="m-dropdown__header-subtitle">New Notification(s)</span>
                                            </div>
                                            <div class="m-dropdown__body">
                                                <div class="m-dropdown__content">
                                                    <div class="m-scrollable" data-scrollable="true" data-max-height="250" data-mobile-max-height="200">
                                                        <div class="m-list-timeline m-list-timeline--skin-light">
                                                            <div class="m-list-timeline__items">
                                                                @foreach(Auth::user()->unreadNotifications as $notification)
                                                                    <div class="m-list-timeline__item">
                                                                        <span class="m-list-timeline__badge"></span>
                                                                        <a href="{{ $notification->data['redirect_to'] }}"
                                                                            id="read_notification"
                                                                            data-action="{{ route(
                                                                                'root.notification.read', Auth::user()
                                                                            ) }}"
                                                                            data-id="{{ $notification->id }}"
                                                                            class="m-list-timeline__text">
                                                                            <span>{{ $notification->data['subject'] }}</span>

                                                                            @if($notification->data['has_badge'])
                                                                                <span class="m-badge m-badge--wide
                                                                                m-badge--{{ $notification->data['badge']['class'] }}">
                                                                                    {{ $notification->data['badge']['text'] }}
                                                                                </span>
                                                                            @endif
                                                                        </a>
                                                                        <span class="m-list-timeline__time">
                                                                            {{ $notification->created_at->diffForHumans() }}
                                                                        </span>
                                                                    </div>
                                                                @endforeach
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="py-2 text-center">
                                                        <a href="javascript:vod(0);" class="m-link m--font-bold"
                                                            onclick="event.preventDefault();
                                                                document.getElementById('form-notifications.read').submit();">
                                                                    Mark all as read</a>
                                                        <form method="POST" action="{{
                                                            route('root.notifications.read', Auth::user()) }}"
                                                                id="form-notifications.read">
                                                            @method('PATCH')
                                                            @csrf
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                                <!--/. Notifications -->

                                <!-- Quick Actions -->
                                <li class="m-nav__item m-topbar__quick-actions m-topbar__quick-actions--img m-dropdown m-dropdown--large m-dropdown--header-bg-fill m-dropdown--arrow m-dropdown--align-right m-dropdown--align-push m-dropdown--mobile-full-width m-dropdown--skin-light"  data-dropdown-toggle="click">
                                    <a href="#" class="m-nav__link m-dropdown__toggle">
                                        <span class="m-nav__link-badge m-badge m-badge--dot m-badge--info m--hide"></span>
                                        <span class="m-nav__link-icon">
                                            <span class="m-nav__link-icon-wrapper">
                                                <i class="flaticon-share"></i>
                                            </span>
                                        </span>
                                    </a>
                                    <div class="m-dropdown__wrapper">
                                        <span class="m-dropdown__arrow m-dropdown__arrow--right m-dropdown__arrow--adjust"></span>
                                        <div class="m-dropdown__inner">
                                            <div class="m-dropdown__header m--align-center"
                                                style="background: url(/root/assets/app/media/img/misc/quick_actions_bg.jpg); background-size: cover;">
                                                <span class="m-dropdown__header-title">Quick Actions</span>
                                                <span class="m-dropdown__header-subtitle">Shortcuts</span>
                                            </div>
                                            <div class="m-dropdown__body m-dropdown__body--paddingless">
                                                <div class="m-dropdown__content">
                                                    <div class="m-scrollable" data-scrollable="false" data-max-height="380" data-mobile-max-height="200">
                                                        <div class="m-nav-grid m-nav-grid--skin-light">
                                                            <div class="m-nav-grid__row">
                                                                <a href="#" class="m-nav-grid__item">
                                                                    <i class="m-nav-grid__icon flaticon-time"></i>
                                                                    <span class="m-nav-grid__text">Add New Event</span>
                                                                </a>
                                                                <a href="{{ route('root.reservation.search') }}" class="m-nav-grid__item">
                                                                    <i class="m-nav-grid__icon flaticon-time"></i>
                                                                    <span class="m-nav-grid__text">Create Reservation</span>
                                                                </a>
                                                            </div>
                                                            <div class="m-nav-grid__row">
                                                                <a href="#" class="m-nav-grid__item">
                                                                    <i class="m-nav-grid__icon flaticon-folder"></i>
                                                                    <span class="m-nav-grid__text">Create New Task</span>
                                                                </a>
                                                                <a href="#" class="m-nav-grid__item">
                                                                    <i class="m-nav-grid__icon flaticon-clipboard"></i>
                                                                    <span class="m-nav-grid__text">Completed Tasks</span>
                                                                </a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                                <!--/. Quick Actions -->
                            </ul>
                        </div>
                    </div>
                </div>
                <!-- end::Topbar -->
            </div>
        </div>
    </div>
    <!-- end::Header top -->

    <!-- begin::Header bottom -->
    <div class="m-header__bottom">
        <div class="m-container m-container--responsive m-container--xxl m-container--full-height m-page__container">
            <div class="m-stack m-stack--ver m-stack--desktop">
                <!-- begin::Horizontal Menu -->
                <div class="m-stack__item m-stack__item--middle m-stack__item--fluid">
                    <button class="m-aside-header-menu-mobile-close  m-aside-header-menu-mobile-close--skin-light " id="m_aside_header_menu_mobile_close_btn"><i class="la la-close"></i></button>

                    <div id="m_header_menu" class="m-header-menu m-aside-header-menu-mobile m-aside-header-menu-mobile--offcanvas  m-header-menu--skin-dark m-header-menu--submenu-skin-light m-aside-header-menu-mobile--skin-light m-aside-header-menu-mobile--submenu-skin-light">
                        <ul class="m-menu__nav  m-menu__nav--submenu-arrow">
                            <!-- Dashboard -->
                            <li class="m-menu__item {{ Helper::activeMenu(Request::segment(2)) == 'dashboard' ?
                                'm-menu__item--active' : '' }}"  aria-haspopup="true">
                                <a href="{{ route('root.home') }}" class="m-menu__link">
                                    <span class="m-menu__item-here"></span>
                                    <span class="m-menu__link-text">Dashboard</span>
                                </a>
                            </li>
                            <!--/. Dashboard -->

                            <!-- Inventory -->
                            <li class="m-menu__item  m-menu__item--submenu m-menu__item--rel
                                {{ Helper::activeMenu(Request::segment(2)) == 'inventory' ? 'm-menu__item--active' : '' }}"
                                    data-menu-submenu-toggle="click" aria-haspopup="true">
                                <a href="#" class="m-menu__link m-menu__toggle">
                                    <span class="m-menu__item-here"></span>
                                    <span class="m-menu__link-text">Inventory</span>
                                    <i class="m-menu__hor-arrow la la-angle-down"></i>
                                    <i class="m-menu__ver-arrow la la-angle-right"></i>
                                </a>

                                <div class="m-menu__submenu m-menu__submenu--classic m-menu__submenu--left">
                                    <span class="m-menu__arrow m-menu__arrow--adjust"></span>
                                    <ul class="m-menu__subnav">
                                        <li class="m-menu__item" aria-haspopup="true">
                                            <a href="{{ route('root.categories.index') }}" class="m-menu__link">
                                                <i class="m-menu__link-icon flaticon-interface-9"></i>
                                                <span class="m-menu__link-text">Categories</span>
                                            </a>
                                        </li>

                                        <li class="m-menu__item" aria-haspopup="true">
                                            <a href="{{ route('root.items.index') }}" class="m-menu__link">
                                                <i class="m-menu__link-icon flaticon-business"></i>
                                                <span class="m-menu__link-text">Items</span>
                                            </a>
                                        </li>

                                        <li class="m-menu__item" aria-haspopup="true">
                                            <a href="{{ route('root.coupons.index') }}" class="m-menu__link">
                                                <i class="m-menu__link-icon flaticon-gift"></i>
                                                <span class="m-menu__link-text">Coupons</span>
                                            </a>
                                        </li>

                                    </ul>
                                </div>
                            </li>
                            <!--/. Inventory -->

                            <!-- Reservations -->
                            <li class="m-menu__item  m-menu__item--submenu m-menu__item--rel
                                {{ Helper::activeMenu(Request::segment(2)) == 'reservation' ? 'm-menu__item--active' : '' }}"
                                    data-menu-submenu-toggle="click" aria-haspopup="true">
                                <a href="#" class="m-menu__link m-menu__toggle">
                                    <span class="m-menu__item-here"></span>
                                    <span class="m-menu__link-text">Reservation</span>
                                    <i class="m-menu__hor-arrow la la-angle-down"></i>
                                    <i class="m-menu__ver-arrow la la-angle-right"></i>
                                </a>

                                <div class="m-menu__submenu m-menu__submenu--classic m-menu__submenu--left">
                                    <span class="m-menu__arrow m-menu__arrow--adjust"></span>
                                    <ul class="m-menu__subnav">
                                        <!-- Reservations -->
                                        <li class="m-menu__item" aria-haspopup="true">
                                            <a href="{{ route('root.reservations.index') }}" class="m-menu__link ">
                                                <i class="m-menu__link-icon flaticon-interface-1"></i>
                                                <span class="m-menu__link-text">Reservations</span>
                                            </a>
                                        </li>
                                        <!--/. Reservations -->

                                        <!-- Item Calendar -->
                                        <li class="m-menu__item" aria-haspopup="true">
                                            <a href="{{ route('root.reservations.index') }}" class="m-menu__link ">
                                                <i class="m-menu__link-icon flaticon-calendar-3"></i>
                                                <span class="m-menu__link-text">Item Calendar</span>
                                            </a>
                                        </li>
                                        <!--/. Item Calendar -->
                                    </ul>
                                </div>
                            </li>
                            <!--/. Reservation -->

                            <!-- Reports -->
                            <li class="m-menu__item  m-menu__item--submenu m-menu__item--rel"  data-menu-submenu-toggle="click" aria-haspopup="true">
                                <a href="#" class="m-menu__link m-menu__toggle">
                                    <span class="m-menu__item-here"></span>
                                    <span class="m-menu__link-text">Reports</span>
                                    <i class="m-menu__hor-arrow la la-angle-down"></i>
                                    <i class="m-menu__ver-arrow la la-angle-right"></i>
                                </a>

                                <div class="m-menu__submenu m-menu__submenu--classic m-menu__submenu--left">
                                    <span class="m-menu__arrow m-menu__arrow--adjust"></span>
                                    <ul class="m-menu__subnav">
                                        <li class="m-menu__item" aria-haspopup="true">
                                            <a href="{{ route('root.reports.sales').'?src=&rd=&ds=0&from='.
                                                Carbon::now()->format('Y-m-d').'&to='.Carbon::now()->format('Y-m-d') }}"
                                                    class="m-menu__link">
                                                <i class="m-menu__link-icon flaticon-diagram"></i>
                                                <span class="m-menu__link-text">Sales</span>
                                            </a>
                                        </li>

                                        <li class="m-menu__item" aria-haspopup="true">
                                            <a href="{{ route('root.reports.allocations').'?src=&rd=&ds=0&from='.
                                                Carbon::now()->format('Y-m-d').'&to='.Carbon::now()->format('Y-m-d') }}"
                                                    class="m-menu__link">
                                                <i class="m-menu__link-icon flaticon-pie-chart"></i>
                                                <span class="m-menu__link-text">Allocation &amp; Occupancy</span>
                                            </a>
                                        </li>

                                    </ul>
                                </div>
                            </li>
                            <!--/. Reports -->

                            <!-- Manage -->
                            <li class="m-menu__item  m-menu__item--submenu m-menu__item--rel
                                {{ Helper::activeMenu(Request::segment(2)) == 'manage' ?
                                    'm-menu__item--active' : '' }}"  data-menu-submenu-toggle="click" aria-haspopup="true">
                                <a href="#" class="m-menu__link m-menu__toggle">
                                    <span class="m-menu__item-here"></span>
                                    <span class="m-menu__link-text">Manage</span>
                                    <i class="m-menu__hor-arrow la la-angle-down"></i>
                                    <i class="m-menu__ver-arrow la la-angle-right"></i>
                                </a>

                                <div class="m-menu__submenu m-menu__submenu--classic m-menu__submenu--left">
                                    <span class="m-menu__arrow m-menu__arrow--adjust"></span>
                                    <ul class="m-menu__subnav">
                                        <li class="m-menu__item" aria-haspopup="true">
                                            <a href="{{ route('root.users.index') }}" class="m-menu__link">
                                                <i class="m-menu__link-icon flaticon-users"></i>
                                                <span class="m-menu__link-text">Customers</span>
                                            </a>
                                        </li>

                                        <li class="m-menu__item" aria-haspopup="true">
                                            <a href="{{ route('root.superusers.index') }}" class="m-menu__link">
                                                <i class="m-menu__link-icon flaticon-users"></i>
                                                <span class="m-menu__link-text">Staffs</span>
                                            </a>
                                        </li>

                                        <li class="m-menu__item" aria-haspopup="true">
                                            <a href="{{ route('root.settings.index') }}" class="m-menu__link">
                                                <i class="m-menu__link-icon flaticon-settings"></i>
                                                <span class="m-menu__link-text">Settings</span>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </li>
                            <!--/. Manage -->

                            <!-- More -->
                            <li class="m-menu__item  m-menu__item--submenu m-menu__item--rel m-menu__item--more m-menu__item--icon-only" data-menu-submenu-toggle="click" data-redirect="true" aria-haspopup="true">
                                <a href="javascript:void(0);" class="m-menu__link m-menu__toggle">
                                    <span class="m-menu__item-here"></span>
                                    <i class="m-menu__link-icon flaticon-more-v3"></i>
                                    <span class="m-menu__link-text"></span>
                                </a>

                                <div class="m-menu__submenu m-menu__submenu--classic m-menu__submenu--left m-menu__submenu--pull">
                                    <span class="m-menu__arrow m-menu__arrow--adjust"></span>

                                    <ul class="m-menu__subnav">
                                        <li class="m-menu__item "  data-redirect="true" aria-haspopup="true">
                                            <a  href="#" class="m-menu__link ">
                                                <i class="m-menu__link-icon flaticon-clock-1"></i>
                                                <span class="m-menu__link-text">Activity Log</span>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </li>
                            <!-- More -->

                        </ul>
                    </div>
                </div>
                <!-- end::Horizontal Menu -->
            </div>
        </div>
    </div>
    <!-- end::Header bottom -->

</header>
<!-- end::Header -->