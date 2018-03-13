<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1,user-scalable=no">
        <meta name="format-detection" content="telephone=no"><meta name="apple-mobile-web-app-capable" content="yes">

        <title>{{ config('app.name') }}</title>

        <!-- App icon -->
        <link rel="shortcut icon" href="/favicon.ico" type="image/x-icon">

        <!-- Fonts -->
        <link href="http://fonts.googleapis.com/css?family=Open+Sans:700,600,400,300" rel="stylesheet" type="text/css">
        <link href="http://fonts.googleapis.com/css?family=Oswald:400" rel="stylesheet" type="text/css">
        <link href="http://fonts.googleapis.com/css?family=Lato:400,700" rel="stylesheet" type="text/css">

        <!-- Styles -->
        <link rel="stylesheet" type="text/css" href="/front/assets/css/lib/bootstrap.min.css">
        <link rel="stylesheet" type="text/css" href="/front/assets/css/lib/font-awesome.min.css">
        <link rel="stylesheet" type="text/css" href="/front/assets/css/lib/awe-booking-font.css">
        <link rel="stylesheet" type="text/css" href="/front/assets/css/lib/owl.carousel.css">
        <link rel="stylesheet" type="text/css" href="/front/assets/css/lib/magnific-popup.css">
        <link rel="stylesheet" type="text/css" href="/front/assets/css/lib/jquery-ui.css">
        <link rel="stylesheet" type="text/css" href="/front/assets/revslider-demo/css/settings.css">
        <link rel="stylesheet" type="text/css" href="/front/assets/css/style.css">
        <link rel="stylesheet" type="text/css" href="/front/assets/css/demo.css">
        <link rel="stylesheet" type="text/css" href="/front/assets/css/colors/blue.css" id="colorreplace">

        <!--[if lt IE 9]><script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
                <script src="http://css3-mediaqueries-js.googlecode.com/svn/trunk/css3-mediaqueries.js"></script><![endif]-->

        <link rel="stylesheet" type="text/css" href="/front/assets/css/main.css">

        @yield('styles')
    </head>

    <body>
        @include('front.partials.header')

        <div id="page-wrap">
            <div class="preloader"></div>
            
            @yield('content')
        </div>

        @include('front.partials.footer')

        <script type="text/javascript" src="/front/assets/js/lib/jquery-1.11.2.min.js"></script>
        <script type="text/javascript" src="/front/assets/js/lib/masonry.pkgd.min.js"></script>
        <script type="text/javascript" src="/front/assets/js/lib/jquery.parallax-1.1.3.js"></script>
        <script type="text/javascript" src="/front/assets/js/lib/jquery.owl.carousel.js"></script>
        <script type="text/javascript" src="/front/assets/js/lib/theia-sticky-sidebar.js"></script>
        <script type="text/javascript" src="/front/assets/js/lib/jquery.magnific-popup.min.js"></script>
        <script type="text/javascript" src="/front/assets/js/lib/jquery-ui.js"></script>
        <script type="text/javascript" src="/front/assets/js/scripts.js"></script>
        <script type="text/javascript" src="/front/assets/revslider-demo/js/jquery.themepunch.revolution.min.js"></script>
        <script type="text/javascript" src="/front/assets/revslider-demo/js/jquery.themepunch.tools.min.js"></script>
        <script type="text/javascript" src="/front/assets/js/lib/moment.min.js"></script>
        <script type="text/javascript" src="/front/assets/js/main.js"></script>

        <script type="text/javascript">
            if($('#slider-revolution').length) {
                $('#slider-revolution').show().revolution({
                    ottedOverlay:"none",
                    delay:10000,
                    startwidth:1600,
                    startheight:650,
                    hideThumbs:200,

                    thumbWidth:100,
                    thumbHeight:50,
                    thumbAmount:5,
                    
                                            
                    simplifyAll:"off",

                    navigationType:"none",
                    navigationArrows:"solo",
                    navigationStyle:"preview4",

                    touchenabled:"on",
                    onHoverStop:"on",
                    nextSlideOnWindowFocus:"off",

                    swipe_threshold: 0.7,
                    swipe_min_touches: 1,
                    drag_block_vertical: false,
                    
                    parallax:"mouse",
                    parallaxBgFreeze:"on",
                    parallaxLevels:[7,4,3,2,5,4,3,2,1,0],
                                            
                                            
                    keyboardNavigation:"off",

                    navigationHAlign:"center",
                    navigationVAlign:"bottom",
                    navigationHOffset:0,
                    navigationVOffset:20,

                    soloArrowLeftHalign:"left",
                    soloArrowLeftValign:"center",
                    soloArrowLeftHOffset:20,
                    soloArrowLeftVOffset:0,

                    soloArrowRightHalign:"right",
                    soloArrowRightValign:"center",
                    soloArrowRightHOffset:20,
                    soloArrowRightVOffset:0,

                    shadow:0,
                    fullWidth:"on",
                    fullScreen:"off",

                    spinner:"spinner2",
                                            
                    stopLoop:"off",
                    stopAfterLoops:-1,
                    stopAtSlide:-1,

                    shuffle:"off",

                    autoHeight:"off",
                    forceFullWidth:"off",
                    
                    hideThumbsOnMobile:"off",
                    hideNavDelayOnMobile:1500,
                    hideBulletsOnMobile:"off",
                    hideArrowsOnMobile:"off",
                    hideThumbsUnderResolution:0,

                    hideSliderAtLimit:0,
                    hideCaptionAtLimit:0,
                    hideAllCaptionAtLilmit:0,
                    startWithSlide:0
                });
            }
        </script>

        @yield('scripts')
    </body>
</html>
