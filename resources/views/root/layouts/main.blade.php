<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name') }}</title>

        <!-- Web font -->
        <script src="https://ajax.googleapis.com/ajax/libs/webfont/1.6.16/webfont.js"></script>

        <script>
            WebFont.load({
                google: {"families":["Poppins:300,400,500,600,700","Roboto:300,400,500,600,700"]},
                active: function() {
                    sessionStorage.fonts = true;
                }
          });
        </script>
        <!--/. Web font -->

        <!-- App icon -->
        <link rel="shortcut icon" href="/root/assets/demo/demo2/media/img/logo/favicon.ico" />

        <!-- Vendor bundle -->
        <link href="/root/assets/vendors/base/vendors.bundle.css" rel="stylesheet" type="text/css" />

        <!-- Demo 2 bundle -->
        <link href="/root/assets/demo/demo2/base/style.bundle.css" rel="stylesheet" type="text/css" />


        <!-- Page specific stylesheets -->
        @yield('styles')
    </head>

    <body class="m-page--wide m-header--fixed m-header--fixed-mobile m-aside-left--enabled m-aside-left--offcanvas m-footer--push m-aside--offcanvas-default">

        <div class="m-grid m-grid--hor m-grid--root m-page">

            @auth
                @include('root.partials.header')
            @endauth

            <div class="m-grid__item m-grid__item--fluid  m-grid m-grid--ver-desktop m-grid--desktop m-container m-container--responsive m-container--xxl m-page__container m-body">
                <!-- BEGIN: Left Aside -->
                <button class="m-aside-left-close m-aside-left-close--skin-light" id="m_aside_left_close_btn">
                    <i class="la la-close"></i></button>

                <div id="m_aside_left" class="m-grid__item m-aside-left ">
                    <!-- BEGIN: Aside Menu -->
                    <div id="m_ver_menu" class="m-aside-menu  m-aside-menu--skin-light m-aside-menu--submenu-skin-light" data-menu-vertical="true" data-menu-scrollable="false" data-menu-dropdown-timeout="500">
                        <ul class="m-menu__nav  m-menu__nav--dropdown-submenu-arrow ">
                            <li class="m-menu__section">
                                <h4 class="m-menu__section-text">Departments</h4>
                                <i class="m-menu__section-icon flaticon-more-v3"></i>
                            </li>
                            <li class="m-menu__item  m-menu__item--submenu" aria-haspopup="true"  data-menu-submenu-toggle="hover">
                        </ul>
                    </div>
                </div>

                <div class="m-grid__item m-grid__item--fluid m-wrapper">
                    <!-- BEGIN: Subheader -->
                    <div class="m-subheader">
                        <div class="d-flex align-items-center">
                            <div class="mr-auto">
                                <h3 class="m-subheader__title m-subheader__title--separator">
                                    {{ Str::ucfirst(Request::segment(count(Request::segments()))) }}
                                </h3>

                                <ul class="m-subheader__breadcrumbs m-nav m-nav--inline">
                                    <li class="m-nav__item m-nav__item--home">
                                        <a href="{{ route('root.home') }}" class="m-nav__link m-nav__link--icon">
                                           <i class="m-nav__link-icon la la-home"></i>
                                        </a>
                                    </li>

                                    @for($i = 2; $i < 3; $i++)
                                        <li class="m-nav__separator">-</li>

                                        <li class="m-nav__item">
                                            <a href="{{ URL::to(implode( '/',
                                                array_slice(Request::segments(),0, $i, true))) }}" class="m-nav__link">
                                                    <span class="m-nav__link-text">
                                                        {{ ucfirst(Request::segment($i)) }}</span>
                                            </a>
                                        </li>
                                    @endfor
                                </ul>
                            </div>

                        </div>
                    </div>
                    <!-- END: Subheader -->

                    <div class="m-content">
                        @yield('content')
                    </div>
                </div>
            </div>

            @auth
                @include('root.partials.footer')
            @endauth

        </div>

        <!-- Vendor bundle -->
        <script src="/root/assets/vendors/base/vendors.bundle.js" type="text/javascript"></script>

        <!-- Demo 2 bundle -->
        <script src="/root/assets/demo/demo2/base/scripts.bundle.js" type="text/javascript"></script>

        {!! Toastr::message() !!}

        <!-- Page specific scripts -->
        @yield('scripts')

    </body>
</html>