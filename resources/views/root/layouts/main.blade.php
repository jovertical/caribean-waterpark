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

        <!-- Main -->
        <link href="/root/assets/app/css/main.css" rel="stylesheet" type="text/css" />

        <!-- Page specific stylesheets -->
        @yield('styles')
    </head>

    <body class="m-page--wide m-header--fixed m-header--fixed-mobile m-aside-left--enabled m-aside-left--offcanvas m-footer--push m-aside--offcanvas-default">

        <!-- begin:: Page -->
        <div class="m-grid m-grid--hor m-grid--root m-page">
            @include('root.partials.header')

            <!-- begin::Body -->
            <div class="m-grid__item m-grid__item--fluid m-grid m-grid--ver-desktop m-grid--desktop m-container m-container--responsive m-container--xxl m-page__container m-body">
                @yield('sidebar')

                <div class="m-grid__item m-grid__item--fluid m-wrapper" style="overflow: auto; padding-right: 2%;">
                    @include('root.partials.sub_header')

                    <div class="m-content">
                        @yield('content')
                    </div>
                </div>
            </div>
            <!-- end::Body -->

            <!-- Footer -->
            @include('root.partials.footer')
        </div>
        <!-- end:: Page -->

        <!-- Vendor bundle -->
        <script src="/root/assets/vendors/base/vendors.bundle.js" type="text/javascript"></script>

        <!-- Demo 2 bundle -->
        <script src="/root/assets/demo/demo2/base/scripts.bundle.js" type="text/javascript"></script>

        <!-- Main -->
        <script src="/root/assets/app/js/main.js" type="text/javascript"></script>

        {!! Toastr::message() !!}

        <!-- Page specific scripts -->
        @yield('scripts')

    </body>
</html>