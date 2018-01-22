<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name') }}</title>

        <!-- Bootstrap -->
        <link href="/root/bootstrap/css/bootstrap.min.css" rel="stylesheet">

        <!-- MDB -->
        <link href="/root/mdb/css/mdb.min.css" rel="stylesheet">

        <!-- Fontawesome -->
        <link href="/root/fontawesome/css/font-awesome.min.css" rel="stylesheet">

        <!-- Page specific stylesheets -->
        @yield('styles')
    </head>

    <body class="fixed-sn white-skin">

        <div id="app">

            <!-- Preloader animation -->
            <div id="mdb-preloader" class="flex-center"><div id="preloader-markup"></div></div>

            @auth
                @include('root.partials.nav')
            @endauth

            <main>
                <div class="container">
                    @yield('content')
                </div>
            </main>

            @auth
                @include('root.partials.footer')
            @endauth
        </div>

        <!-- jQuery -->
        <script src="/root/jquery/js/jquery.min.js"></script>

        <!-- Theter -->
        <script src="/root/bootstrap/js/popper.min.js"></script>

        <!-- Bootstrap -->
        <script src="/root/bootstrap/js/bootstrap.js"></script>

        <!-- MDB -->
        <script src="/root/mdb/js/mdb.min.js"></script>

        <!-- Inline Script -->
        <script>
            $(document).ready(function() {
                // SideNav Init
                $(".button-collapse").sideNav();

                // 
                $('#mdb-preloader').css({ display: 'none' });

                //
                $('button[type=submit]').on('click', function() {
                    $('button').addClass('disabled');
                });
            });
        </script>
        <!--/. Inline Script -->

        <!-- Page specific scripts -->
        @yield('scripts')

    </body>
</html>