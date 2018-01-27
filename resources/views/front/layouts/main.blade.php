<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>{{ config('app.name') }}</title>

        <link rel="shortcut icon" href="/favicon.ico" type="image/x-icon">
        <!-- CSS FILES -->
        <link rel="stylesheet" href="/css/bootstrap.min.css">
        <link rel="stylesheet" href="/css/supersized.css">
        <link rel="stylesheet" href="/css/supersized.shutter.css">
        <link rel="stylesheet" href="/css/flexslider.css">
        <link rel="stylesheet" href="/css/prettyPhoto.css">
        <link rel="stylesheet" href="/css/datepicker.css">
        <link rel="stylesheet" href="/css/selectordie.css">
        <link rel="stylesheet" href="/css/main.css">
        <link rel="stylesheet" href="/css/2035.responsive.css">

        <script src="/front/assets//front/assets/js/vendor/modernizr-2.8.3-respond-1.1.0.min.js"></script>
        <!-- Respond.js IE8 support of HTML5 elements and media queries -->
        <!--[if lt IE 9]>
          <script src="js/respond.min.js"></script>
        <![endif]-->
        @yield('styles')
    </head>

    <body>
        @include('front.partials.header')

        <div id="app">
            @yield('content')
        </div>

        @include('front.partials.footer')

        <!-- JS FILES -->
        <script src="/js/vendor/jquery-1.11.1.min.js"></script>
        <script src="/js/vendor/bootstrap.min.js"></script>
        <script src="/js/retina-1.1.0.min.js"></script>
        <script src="/js/jquery.flexslider-min.js"></script>
        <script src="/js/superfish.pack.1.4.1.js"></script>
        <script src="/js/jquery.slicknav.min.js"></script>
        <script src="/js/bootstrap-datepicker.js"></script>
        <script src="/js/selectordie.min.js"></script>
        <script src="/js/jquery.parallax-1.1.3.js"></script>
        <script src="/js/jquery.prettyPhoto.js"></script>
        <script src="/js/supersized.3.2.7.min.js"></script>
        <script src="/js/supersized.shutter.min.js"></script>
        <script src="/js/main.js"></script>
        <script type="text/javascript">
            jQuery(function($) {
            $.supersized({
                slideshow           :1,         // Slideshow on/off
                autoplay            :1,         // Slideshow starts playing automatically
                slide_interval      :4000,      // Length between transitions
                transition          :1,             // 0-None, 1-Fade, 2-Slide Top, 3-Slide Right, 4-Slide Bottom, 5-Slide Left, 6-Carousel Right, 7-Carousel Left
                transition_speed    :1000,      // Speed of transition
                pause_hover         :0,         // Pause slideshow on hover
                performance         :1,         // 0-Normal, 1-Hybrid speed/quality, 2-Optimizes image quality, 3-Optimizes transition speed // (Only works for Firefox/IE, not Webkit)
                image_protect       :1,         // Disables image dragging and right click with Javascript
                slides              :[          // Slideshow Images
                                        {image : 'temp/sli-2.jpg'},
                                        {image : 'temp/sli-1.jpg'}
                                     ]
                });
            });
        </script>

        @yield('scripts')
    </body>
</html>
