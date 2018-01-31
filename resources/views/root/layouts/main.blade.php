<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name') }}</title>

        <!-- Fontawesome -->
        <link href="/root/assets/css/font-awesome.min.css" rel="stylesheet">

        <!-- Bootstrap -->
        <link href="/root/assets/css/bootstrap.min.css" rel="stylesheet">

        <!-- MDB -->
        <link href="/root/assets/css/mdb.min.css" rel="stylesheet">
        
        <!-- App -->
        <link href="/root/assets/css/app.css" rel="stylesheet">

        <!-- Page specific stylesheets -->
        @yield('styles')
    </head>

    <body class="fixed-sn black-skin">

        <div id="container">

            <!-- Preloader animation -->
            <div id="mdb-preloader" class="flex-center"><div id="preloader-markup"></div></div>

            @auth
                <div id="header">
                    @include('root.partials.header')
                </div>
            @endauth

            <main>
                <div id="body" class="container-fluid">
                    @yield('content')
                </div>
            </main>

            @auth
                <div id="footer">
                    @include('root.partials.footer')
                </div>
            @endauth
        </div>

        <!-- jQuery -->
        <script src="/root/assets/js/jquery.min.js"></script>

        <!-- Theter -->
        <script src="/root/assets/js/popper.min.js"></script>

        <!-- Bootstrap -->
        <script src="/root/assets/js/bootstrap.js"></script>

        <!-- MDB -->
        <script src="/root/assets/js/mdb.min.js"></script>

        <!-- App -->
        <script src="/root/assets/js/app.js"></script>

        {!! Toastr::message() !!}

        <!-- Page specific scripts -->
        @yield('scripts')

    </body>
</html>