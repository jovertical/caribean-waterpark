@extends('front.layouts.main')

@section('content')
<!--[if lt IE 7]>
    <p class="chromeframe">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> or <a href="http://www.google.com/chromeframe/?redirect=true">activate Google Chrome Frame</a> to improve your experience.</p>
<![endif]-->
<div id="wrapper">
    <div id="home">
        <div class="header"><!-- Header Section -->
            <div class="pre-header"><!-- Pre-header -->
                <div class="container">
                    <div class="row">
                        <div class="pull-left pre-address-b"><p><i class="fa fa-map-marker"></i> Manhattan square. 124 avenue. Bodrum</p></div>
                        <div class="pull-right">
                            <div class="pull-left">
                                <ul class="pre-link-box">
                                    <li><a href="about.html">About</a></li>
                                    <li><a href="contact.html">Contact</a></li>
                                    <li><a href="#">Add Your Link</a></li>
                                </ul>
                            </div>
                            <div class="pull-right">
                                <div class="language-box">
                                    <ul>
                                        <li><a href="#"><img alt="language" src="/front/assets/temp/english.png"><span class="language-text">ENGLISH</span></a></li>
                                        <li><a href="#"><img alt="language" src="/front/assets/temp/germany.png"><span class="language-text">DEUTSCH</span></a></li>
                                        <li><a href="#"><img alt="language" src="/front/assets/temp/france.png"><span class="language-text">FRANÇAIS</span></a></li>
                                        <li><a href="#"><img alt="language" src="/front/assets/temp/poland.png"><span class="language-text">POLSKI</span></a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="main-header"><!-- Main-header -->
                <div class="container">
                    <div class="row">
                        <div class="pull-left">
                            <div class="logo">
                                <a href="index.html"><img alt="Logo" src="/front/assets/img/logo-light.png" class="img-responsive" /></a>
                            </div>
                        </div>
                        <div class="pull-right">
                            <div class="pull-left">
                                <nav class="nav">
                                    <ul id="navigate" class="sf-menu navigate">
                                        <li class="parent-menu active"><a href="index.html">HOMEPAGE</a>
                                            <ul>
                                                <li><a href="index.html">Slider Homepage</a></li>
                                                <li><a href="index-full-screen.html">Full Screen Homepage</a></li>
                                                <li><a href="http://www.2035themes.com/luxen/boxed/">Boxed Homepage</a></li>
                                            </ul>
                                        </li>
                                        <li class="parent-menu"><a href="#">FEATURES</a>
                                            <ul>
                                                <li><a href="#">2 Homepages</a></li>
                                                <li><a href="#">Ajax/PHP Booking Form</a></li>
                                                <li><a href="#">Ultra Responsive</a></li>
                                                <li><a href="under-construction.html">Countdown Page</a></li>
                                                <li><a href="#">2 Category Pages</a></li>
                                                <li><a href="404.html">404 Page</a></li>
                                            </ul>
                                        </li>
                                        <li class="parent-menu"><a href="#">PAGES</a>
                                            <ul>
                                                <li><a href="about.html">About</a></li>
                                                <li><a href="category-grid.html">Category Grid</a></li>
                                                <li><a href="category-list.html">Category List</a></li>
                                                <li><a href="room-single.html">Room Details</a></li>
                                                <li><a href="gallery.html">Gallery</a></li>
                                                <li><a href="blog.html">Blog</a></li>
                                                <li><a href="blog-details.html">Blog Single</a></li>
                                                <li><a href="left-sidebar-page.html">Left Sidebar Page</a></li>
                                                <li><a href="right-sidebar-page.html">Right Sidebar Page</a></li>
                                                <li><a href="under-construction.html">Under Construction</a></li>
                                                <li><a href="404.html">404 Page</a></li>
                                            </ul>
                                        </li>
                                        <li><a href="blog.html">NEWS</a></li>
                                        <li><a href="contact.html">CONTACT</a></li>
                                    </ul>
                                </nav>
                            </div>
                            <div class="pull-right">
                                <div class="button-style-1 margint45">
                                    <a href="reservation-form-dark.html"><i class="fa fa-calendar"></i>BOOK NOW</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="book-slider">
            <div class="container">
                <div class="row pos-center">
                    <div class="reserve-form-area">
                        <form action="#" method="post" id="ajax-reservation-form">
                            <ul class="clearfix">
                                <li class="li-input">
                                    <label>ARRIVAL</label>
                                    <input type="text" id="dpd1" name="dpd1" class="date-selector" placeholder="&#xf073;" />
                                </li>
                                <li class="li-input">
                                    <label>DEPARTURE</label>
                                    <input type="text" id="dpd2" name="dpd2" class="date-selector" placeholder="&#xf073;" />
                                </li>
                                <li class="li-select">
                                    <label>ROOMS</label>
                                    <select name="rooms" class="pretty-select">
                                        <option selected="selected" value="1" >1</option>
                                        <option value="2">2</option>
                                        <option value="3">3</option>
                                        <option value="4">4</option>
                                        <option value="5">5</option>
                                    </select>
                                </li>
                                <li class="li-select">
                                    <label>ADULT</label>
                                    <select name="adult" class="pretty-select">
                                        <option selected="selected" value="1" >1</option>
                                        <option value="2">2</option>
                                        <option value="3">3</option>
                                        <option value="4">4</option>
                                        <option value="5">5</option>
                                    </select>
                                </li>
                                <li class="li-select">
                                    <label>CHILDREN</label>
                                    <select name="children" class="pretty-select">
                                        <option selected="selected" value="0" >0</option>
                                        <option value="1">1</option>
                                        <option value="2">2</option>
                                        <option value="3">3</option>
                                        <option value="4">4</option>
                                        <option value="5">5</option>
                                    </select>
                                </li>
                                <li>
                                    <div class="button-style-1">
                                        <a id="res-submit" href="#"><i class="fa fa-search"></i>SEARCH</a>
                                    </div>
                                </li>
                            </ul>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="bottom-book-slider">
            <div class="container">
                <div class="row pos-center">
                    <ul>
                        <li><i class="fa fa-shopping-cart"></i> WOOCOMMERCE COMPATIBLE</li>
                        <li><i class="fa fa-globe"></i> LANGUAGE COMPATIBLE</li>
                        <li><i class="fa fa-coffee"></i> COFFEE & BREAKFAST FREE</li>
                        <li><i class="fa fa-windows"></i> FREE WI-FI ALL ROOM</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <div class="content"><!-- Content Section -->
        <div class="about clearfix"><!-- About Section -->
            <div class="container">
                <div class="row">
                    <div class="about-title pos-center margint60">
                        <h2>WELCOME TO PARADISE</h2>
                        <div class="title-shape"><img alt="Shape" src="/front/assets/img/shape.png"></div>
                        <p>Nullam quis risus eget urna mollis ornare vel eu leo. Cras mattis consectetur purus sit amet fermentum. Praesent <span class="active-color">commodo</span> cursus magna, vel scelerisque nisl .Nulleget urna mattis consectetur purus sit amet fermentum</p>
                    </div>
                    <div class="otel-info margint60">
                        <div class="col-lg-4 col-sm-12">
                            <div class="title-style-1 marginb40">
                                <h5>GALLERY</h5>
                                <hr>
                            </div>
                            <div class="flexslider">
                                <ul class="slides">
                                    <li><img alt="Slider 1" class="img-responsive" src="/front/assets/temp/otel-info-image-1.jpg" /></li>
                                    <li><img alt="Slider 1" class="img-responsive" src="/front/assets/temp/otel-info-image-2.jpg" /></li>
                                </ul>
                            </div>
                        </div>
                        <div class="col-lg-4 col-sm-6">
                            <div class="title-style-1 marginb40">
                                <h5>ABOUT US</h5>
                                <hr>
                            </div>
                            <p>Sed posuere consectetur est at lobortis. Aenean lacinia bibendum nulla sed consectetur. Duis mollis, est non commodo luctus, nisi erat porttitor ligula, eget laci. Maecenas faucibus mollis interdum.</p>
                            <p>Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fer condimentum nibh, ut fermentum massa justo sit amet risus. mentum massa justo sit amet risus.</p>
                            <p>Fusce dapibus, tellus ac cursus commodo ut fermentum massa. mentum massa justo sit amet risus.</p>
                        </div>
                        <div class="col-lg-4 col-sm-6">
                            <div class="title-style-1 marginb40">
                                <h5>OUR NEWS</h5>
                                <hr>
                            </div>
                            <div class="home-news">
                                <div class="news-box clearfix">
                                    <div class="news-time pull-left">
                                        <div class="news-date pos-center"><div class="date-day">20<hr></div>MAY</div>
                                    </div>
                                    <div class="news-content pull-left">
                                        <h6><a href="#">News from us from now</a></h6>
                                        <p class="margint10">Donec ullamcorper nulla non metus auctor fringilla. Donec sed odio dui <a class="active-color" href="#">[...]</a></p>
                                    </div>
                                </div>
                                <div class="news-box clearfix">
                                    <div class="news-time pull-left">
                                        <div class="news-date pos-center"><div class="date-day">20<hr></div>MAY</div>
                                    </div>
                                    <div class="news-content pull-left">
                                        <h6><a href="#">News from us from now</a></h6>
                                        <p class="margint10">Donec ullamcorper nulla non metus auctor fringilla. Donec sed odio dui. Nulla vitae elit libero, a pharetra augue <a class="active-color" href="#">[...]</a></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="explore-rooms margint30 clearfix"><!-- Explore Rooms Section -->
            <div class="container">
                <div class="row">   
                    <div class="title-style-2 marginb40 pos-center">
                        <h3>EXPLORE ROOMS</h3>
                        <hr>
                    </div>
                    <div class="col-lg-4 col-sm-6">
                        <div class="home-room-box">
                            <div class="room-image">
                                <img alt="Room Images" class="img-responsive" src="/front/assets/temp/room-image-1.jpg">
                                <div class="home-room-details">
                                    <h5><a href="#">The luxury room in Istanbul</a></h5>
                                    <div class="pull-left">
                                        <ul>
                                            <li><i class="fa fa-calendar"></i></li>
                                            <li><i class="fa fa-flask"></i></li>
                                            <li><i class="fa fa-umbrella"></i></li>
                                            <li><i class="fa fa-laptop"></i></li>
                                        </ul>
                                    </div>
                                    <div class="pull-right room-rating">
                                        <ul>
                                            <li><i class="fa fa-star"></i></li>
                                            <li><i class="fa fa-star"></i></li>
                                            <li><i class="fa fa-star"></i></li>
                                            <li><i class="fa fa-star"></i></li>
                                            <li><i class="fa fa-star inactive"></i></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="room-details">
                                <p>Vestibulum id ligula porta felis euismod semper. Aenean eu leo quam. Pellentesque ornare sem lacinia quam venenatis vestibulum. Curabitur blandit tibulum at ero[...]</p>
                            </div>
                            <div class="room-bottom">
                                <div class="pull-left"><h4>89$<span class="room-bottom-time">/ Day</span></h4></div>
                                <div class="pull-right">
                                    <div class="button-style-1">
                                        <a href="#">BOOK NOW</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-sm-6">
                        <div class="home-room-box">
                            <div class="room-image">
                                <img alt="Room Images" class="img-responsive" src="/front/assets/temp/room-image-6.jpg">
                                <div class="home-room-details">
                                    <h5><a href="#">The King Room</a></h5>
                                    <div class="pull-left">
                                        <ul>
                                            <li><i class="fa fa-calendar"></i></li>
                                            <li><i class="fa fa-flask"></i></li>
                                            <li><i class="fa fa-umbrella"></i></li>
                                            <li><i class="fa fa-laptop"></i></li>
                                        </ul>
                                    </div>
                                    <div class="pull-right room-rating">
                                        <ul>
                                            <li><i class="fa fa-star"></i></li>
                                            <li><i class="fa fa-star"></i></li>
                                            <li><i class="fa fa-star"></i></li>
                                            <li><i class="fa fa-star"></i></li>
                                            <li><i class="fa fa-star inactive"></i></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="room-details">
                                <p>Vestibulum id ligula porta felis euismod semper. Aenean eu leo quam. Pellentesque ornare sem lacinia quam venenatis vestibulum. Curabitur blandit tibulum at ero[...]</p>
                            </div>
                            <div class="room-bottom">
                                <div class="pull-left"><h4>89$<span class="room-bottom-time">/ Day</span></h4></div>
                                <div class="pull-right">
                                    <div class="button-style-1">
                                        <a href="#">BOOK NOW</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-sm-6">
                        <div class="home-room-box">
                            <div class="room-image">
                                <div class="room-features">FEATURED</div>
                                <img alt="Room Images" class="img-responsive" src="/front/assets/temp/room-image-3.jpg">
                                <div class="home-room-details">
                                    <h5><a href="#">Awesome Suits</a></h5>
                                    <div class="pull-left">
                                        <ul>
                                            <li><i class="fa fa-calendar"></i></li>
                                            <li><i class="fa fa-flask"></i></li>
                                            <li><i class="fa fa-umbrella"></i></li>
                                            <li><i class="fa fa-laptop"></i></li>
                                        </ul>
                                    </div>
                                    <div class="pull-right room-rating">
                                        <ul>
                                            <li><i class="fa fa-star"></i></li>
                                            <li><i class="fa fa-star"></i></li>
                                            <li><i class="fa fa-star"></i></li>
                                            <li><i class="fa fa-star"></i></li>
                                            <li><i class="fa fa-star inactive"></i></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="room-details">
                                <p>Vestibulum id ligula porta felis euismod semper. Aenean eu leo quam. Pellentesque ornare sem lacinia quam venenatis vestibulum. Curabitur blandit tibulum at ero[...]</p>
                            </div>
                            <div class="room-bottom">
                                <div class="pull-left"><h4>89$<span class="room-bottom-time">/ Day</span></h4></div>
                                <div class="pull-right">
                                    <div class="button-style-1">
                                        <a href="#">BOOK NOW</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div id="parallax123" class="parallax parallax-one clearfix margint60"><!-- Parallax Section -->
            <div class="support-section">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-4 col-sm-4">
                            <div class="flip-container">
                                <div class="flipper">
                                    <div class="support-box pos-center front">
                                        <div class="support-box-title"><i class="fa fa-phone"></i></div>
                                        <h4>CALL US</h4>
                                        <p class="margint20">Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut ferme fentum</p>
                                    </div>
                                    <div class="support-box pos-center back">
                                        <div class="support-box-title"><i class="fa fa-phone"></i></div>
                                        <h4>PHONE NUMBER</h4>
                                        <p class="margint20">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Minima, et.<br />+61 3 8376 6284</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-sm-4">
                            <div class="flip-container">
                                <div class="flipper">
                                    <div class="support-box pos-center front">
                                        <div class="support-box-title"><i class="fa fa-envelope"></i></div>
                                        <h4>SEND US E-MAIL</h4>
                                        <p class="margint20">Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut ferme fentum</p>
                                    </div>
                                    <div class="support-box pos-center back">
                                        <div class="support-box-title"><i class="fa fa-envelope"></i></div>
                                        <h4>E-MAIL ADDRESS</h4>
                                        <p class="margint20">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Minima, et.<br />luxen@2035themes.com</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-sm-4">
                            <div class="flip-container">
                                <div class="flipper">
                                    <div class="support-box pos-center front">
                                        <div class="support-box-title"><i class="fa fa-home"></i></div>
                                        <h4>VISIT US</h4>
                                        <p class="margint20">Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut ferme fentum</p>
                                    </div>
                                    <div class="support-box pos-center back">
                                        <div class="support-box-title"><i class="fa fa-home"></i></div>
                                        <h4>COMPANY ADDRESS</h4>
                                        <p class="margint20">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Minima, et.<br />Manhattan square. 124 avenue. Bodrum</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="newsletter-section"><!-- Newsletter Section -->
            <div class="container">
                <div class="row">
                    <div class="newsletter-top pos-center margint30">
                        <img alt="Shape Image" src="/front/assets/img/shape.png" >
                    </div>
                    <div class="newsletter-form margint40 pos-center">
                        <div class="newsletter-wrapper">
                            <div class="pull-left">
                                <h2>Sign up newsletter</h2>
                            </div>
                            <div class="pull-left">
                                <form action="#" method="post" id="ajax-contact-form">
                                    <input type="text" placeholder="Enter a e-mail address">
                                    <input type="submit" value="SUBSCRIBE" >
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="footer margint40"><!-- Footer Section -->
            <div class="main-footer">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-2 col-sm-2 footer-logo">
                            <img alt="Logo" src="/front/assets/img/logo.png" class="img-responsive" >
                        </div>
                        <div class="col-lg-10 col-sm-10">
                            <div class="col-lg-3 col-sm-3">
                                <h6>TOUCH WITH US</h6>
                                <ul class="footer-links">
                                    <li><a href="#">Facebook</a></li>
                                    <li><a href="#">Twitter</a></li>
                                    <li><a href="#">Google +</a></li>
                                    <li><a href="#">otels.com</a></li>
                                    <li><a href="#">Tripadvisor</a></li>
                                </ul>
                            </div>
                            <div class="col-lg-3 col-sm-3">
                                <h6>ABOUT LUXEN</h6>
                                <ul class="footer-links">
                                    <li><a href="404.html">Error Page</a></li>
                                    <li><a href="about.html">About</a></li>
                                    <li><a href="blog.html">Blog</a></li>
                                    <li><a href="blog-details.html">Blog Single</a></li>
                                    <li><a href="category-grid.html">Category Grid</a></li>
                                    <li><a href="category-list.html">Category List</a></li>
                                </ul>
                            </div>
                            <div class="col-lg-3 col-sm-3">
                                <h6>PAGES SITE</h6>
                                <ul class="footer-links">
                                    <li><a href="contact.html">Contact</a></li>
                                    <li><a href="gallery.html">Gallery</a></li>
                                    <li><a href="index-full-screen.html">Home Full Screen</a></li>
                                    <li><a href="left-sidebar-page.html">Left Sidebar Page</a></li>
                                    <li><a href="right-sidebar-page.html">Right Sidebar Page</a></li>
                                    <li><a href="room-single.html">Room Single</a></li>
                                    <li><a href="under-construction.html">Under Construction</a></li>
                                </ul>
                            </div>
                            <div class="col-lg-3 col-sm-3">
                                <h6>CONTACT</h6>
                                <ul class="footer-links">
                                    <li><p><i class="fa fa-map-marker"></i> Lorem ipsum dolor sit amet lorem Victoria 8011 Australia </p></li>
                                    <li><p><i class="fa fa-phone"></i> +61 3 8376 6284 </p></li>
                                    <li><p><i class="fa fa-envelope"></i> <a href="mailto:info@2035themes.com">info@2035themes.com</a></p></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="pre-footer">
                <div class="container">
                    <div class="row">
                        <div class="pull-left"><p>© LUXEN OTELS 2015</p></div>
                        <div class="pull-right">
                            <ul>
                                <li><p>CONNECT WITH US</p></li>
                                <li><a><img alt="Facebook" src="/front/assets/temp/orkut.png" ></a></li>
                                <li><a><img alt="Tripadvisor" src="/front/assets/temp/tripadvisor.png" ></a></li>
                                <li><a><img alt="Yelp" src="/front/assets/temp/hyves.png" ></a></li>
                                <li><a><img alt="Twitter" src="/front/assets/temp/skype.png" ></a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection