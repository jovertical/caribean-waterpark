@extends('front.layouts.main')

@section('content')
    <!-- Header -->
    <section>
        <div class="container">
            <div class="breadcrumb">
                <ul>
                    <li>
                        <a href="{{ route('front.welcome') }}">Home</a>
                    </li>

                    <li>
                        <a href="#">Reservation</a>
                    </li>

                    <li>
                        <a href="{{ route('front.reservation.search') }}?ci={{ Request::input('ci') }}&co={{ 
                            Request::input('co') }}&aq={{ Request::input('aq') }}&cq={{ Request::input('cq') }}">Search</a>
                    </li>

                    <li>{{ $item->name }}</li>
                </ul>
            </div>
        </div>
    </section>
    <!--/. Header -->

    <section class="product-detail">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <div class="product-detail__info">
                        <div class="product-title">
                            <h2>{{ $item->name }}</h2>
                            <div class="hotel-star">
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star"></i>
                            </div>
                        </div>
                        <div class="product-email">
                            <i class="fa fa-tag"></i>
                            <a href="#">{{ $item->category->name }}</a>
                        </div>
                        <div class="rating-trip-reviews">
                            <div class="item good">
                                <span class="count">7.5</span>
                                <h6>Average rating</h6>
                                <p>Good</p>
                            </div>
                            <div class="item">
                                <h6>Reviews</h6>
                                <p>No review yet</p>
                            </div>
                        </div>
                        <div class="product-descriptions">
                            <p>{!! $item->description !!}</p>
                        </div>
                        <div class="property-highlights">
                            <h3>Property highlights</h3>
                            <div class="property-highlights__content">
                                <div class="item">
                                    <i class="awe-icon awe-icon-unlock"></i>
                                    <span>Room service</span>
                                </div>
                                <div class="item">
                                    <i class="awe-icon awe-icon-beds"></i>
                                    <span>Bunkbed available</span>
                                </div>
                                <div class="item">
                                    <i class="awe-icon awe-icon-beds"></i>
                                    <span>Bunkbed available</span>
                                </div>
                                <div class="item">
                                    <i class="awe-icon awe-icon-laundry"></i>
                                    <span>Laundry</span>
                                </div>
                                <div class="item">
                                    <i class="awe-icon awe-icon-shower"></i>
                                    <span>Shower</span>
                                </div>
                                <div class="item">
                                    <i class="awe-icon awe-icon-shower"></i>
                                    <span>Shower</span>
                                </div>
                                <div class="item">
                                    <i class="awe-icon awe-icon-pool"></i>
                                    <span>Outside Pool</span>
                                </div>
                                <div class="item">
                                    <i class="awe-icon awe-icon-meal"></i>
                                    <span>Room meal service</span>
                                </div>
                                <div class="item">
                                    <i class="awe-icon awe-icon-meal"></i>
                                    <span>Room meal service</span>
                                </div>
                                <div class="item">
                                    <i class="awe-icon awe-icon-key"></i>
                                    <span>High security</span>
                                </div>
                                <div class="item">
                                    <i class="awe-icon awe-icon-tv"></i>
                                    <span>TV in room</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="product-detail__gallery">
                        <div class="product-slider-wrapper">
                            <div class="product-slider owl-carousel owl-theme">
                                <div class="owl-wrapper-outer autoHeight">
                                    <div class="owl-wrapper">
                                        @foreach($item->images as $item_image)
                                            <div class="owl-item">
                                                <div class="item">
                                                    <img src="{{ Helper::fileUrl($item_image) }}">
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                                <div class="owl-controls">
                                    <div class="owl-buttons">
                                        <div class="owl-prev">
                                            <i class="fa fa-caret-left"></i>
                                        </div>
                                        <div class="owl-next">
                                            <i class="fa fa-caret-right"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="product-slider-thumb-row">
                                <div class="product-slider-thumb owl-carousel owl-theme">
                                    <div class="owl-wrapper-outer">
                                        <div class="owl-wrapper">
                                            @foreach($item->images as $item_image)
                                                <div class="owl-item {{ $loop->iteration == 1 ? 'synced' : '' }}">
                                                    <div class="item">
                                                        <img src="{{ Helper::fileUrl($item_image, 'thumbnail') }}" alt="">
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

            <div class="row" style="transform: none;">
                <div class="col-md-9">
                    <div class="product-tabs tabs ui-tabs ui-widget ui-widget-content ui-corner-all">
                        <ul class="ui-tabs-nav ui-helper-reset ui-helper-clearfix ui-widget-header ui-corner-all" role="tablist">
                            <li class="ui-state-default ui-corner-top ui-tabs-active ui-state-active" role="tab" tabindex="0" aria-controls="tabs-1" aria-labelledby="ui-id-1" aria-selected="true">
                                <a href="#tabs-1" class="ui-tabs-anchor" role="presentation" tabindex="-1" id="ui-id-1">Room detail</a>
                            </li>

                            <li class="ui-state-default ui-corner-top" role="tab" tabindex="-1" aria-controls="tabs-2" aria-labelledby="ui-id-2" aria-selected="false">
                                <a href="#tabs-2" class="ui-tabs-anchor" role="presentation" tabindex="-1" id="ui-id-2">
                                Facilities &amp; freebies</a>
                            </li>

                            <li class="ui-state-default ui-corner-top" role="tab" tabindex="-1" aria-controls="tabs-3" aria-labelledby="ui-id-3" aria-selected="false">
                                <a href="#tabs-3" class="ui-tabs-anchor" role="presentation" tabindex="-1" id="ui-id-3">Good to know
                                </a>
                            </li>

                            <li class="ui-state-default ui-corner-top" role="tab" tabindex="-1" aria-controls="tabs-4" aria-labelledby="ui-id-4" aria-selected="false">
                                <a href="#tabs-4" class="ui-tabs-anchor" role="presentation" tabindex="-1" id="ui-id-4">Review &amp; rating
                                </a>
                            </li>
                        </ul>
                        <div class="product-tabs__content">
                            <div id="tabs-1" aria-labelledby="ui-id-1" class="ui-tabs-panel ui-widget-content ui-corner-bottom" role="tabpanel" aria-expanded="true" aria-hidden="false">
                                <div class="check-availability">
                                    <form>
                                        <div class="form-group">
                                            <div class="form-elements form-checkin">
                                                <label for="ci">Check in</label>
                                                <div class="form-item">
                                                    <i class="awe-icon awe-icon-calendar"></i>
                                                    <input type="text" name="ci" id="ci" class="awe-calendar"
                                                        value="{{ Request::input('ci')}}">
                                                </div>
                                            </div>

                                            <div class="form-elements form-checkout">
                                                <label for="co">Check-out</label>
                                                <div class="form-item">
                                                    <i class="awe-icon awe-icon-calendar"></i>
                                                    <input type="text" name="co" id="co" class="awe-calendar"
                                                        value="{{ Request::input('co')}}">
                                                </div>
                                            </div>

                                            <div class="form-elements form-adult">
                                                <label>Adult</label>
                                                <div class="form-item">
                                                    <div class="awe-select-wrapper">
                                                        <select name="aq" id="aq" class="awe-select">
                                                            <option value="1" {{ Request::input('aq') == '1' ? 'selected' : '' }}>1</option>
                                                            <option value="2" {{ Request::input('aq') == '2' ? 'selected' : '' }}>2</option>
                                                            <option value="3" {{ Request::input('aq') == '3' ? 'selected' : '' }}>3</option>
                                                            <option value="4" {{ Request::input('aq') == '4' ? 'selected' : '' }}>4</option>
                                                            <option value="5" {{ Request::input('aq') == '5' ? 'selected' : '' }}>5</option>
                                                            <option value="6" {{ Request::input('aq') == '6' ? 'selected' : '' }}>6</option>
                                                            <option value="7" {{ Request::input('aq') == '7' ? 'selected' : '' }}>7</option>
                                                            <option value="8" {{ Request::input('aq') == '8' ? 'selected' : '' }}>8</option>
                                                            <option value="9" {{ Request::input('aq') == '9' ? 'selected' : '' }}>9</option>
                                                        </select>
                                                        <i class="fa fa-caret-down"></i>
                                                    </div>
                                                </div>
                                                <span>12 yo and above</span>
                                            </div>
                                            <div class="form-elements form-kids">
                                                <label>Kids</label>
                                                <div class="form-item">
                                                    <div class="awe-select-wrapper">
                                                        <select name="cq" id="cq" class="awe-select">
                                                            <option value="" disabled selected>0</option>
                                                            <option value="1" {{ Request::input('cq') == '1' ? 'selected' : '' }}>1</option>
                                                            <option value="2" {{ Request::input('cq') == '2' ? 'selected' : '' }}>2</option>
                                                            <option value="3" {{ Request::input('cq') == '3' ? 'selected' : '' }}>3</option>
                                                            <option value="4" {{ Request::input('cq') == '4' ? 'selected' : '' }}>4</option>
                                                            <option value="5" {{ Request::input('cq') == '5' ? 'selected' : '' }}>5</option>
                                                            <option value="6" {{ Request::input('cq') == '6' ? 'selected' : '' }}>6</option>
                                                            <option value="7" {{ Request::input('cq') == '7' ? 'selected' : '' }}>7</option>
                                                            <option value="8" {{ Request::input('cq') == '8' ? 'selected' : '' }}>8</option>
                                                            <option value="9" {{ Request::input('cq') == '9' ? 'selected' : '' }}>9</option>
                                                        </select>
                                                        <i class="fa fa-caret-down"></i>
                                                    </div>
                                                </div>
                                                <span>0-11 yo</span>
                                            </div>

                                            <div class="form-actions">
                                                <input type="submit" value="CHECK AVAILABILITY" class="awe-btn awe-btn-style3">
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>

                            <div id="tabs-2" aria-labelledby="ui-id-2" class="ui-tabs-panel ui-widget-content ui-corner-bottom" role="tabpanel" aria-expanded="false" aria-hidden="true" style="display: none;">
                                <table class="facilities-freebies-table">
                                    <tbody>
                                        <tr>
                                            <th>
                                                <p>View</p>
                                            </th>
                                            <td>
                                                <p>City view <em>Beach ( link or gallery)</em></p>
                                            </td>
                                        </tr>

                                        <tr>
                                            <th>
                                                <p>Activities</p>
                                            </th>
                                            <td>
                                                <p>Billiards</p>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>

                            <div id="tabs-3" aria-labelledby="ui-id-3" class="ui-tabs-panel ui-widget-content ui-corner-bottom" role="tabpanel" aria-expanded="false" aria-hidden="true" style="display: none;">
                                <table class="good-to-know-table">
                                    <tbody>
                                        <tr>
                                            <th>
                                                <p>Accepted cards for payment</p>
                                            </th>
                                            <td>
                                                <p><img src="/front/assets/images/paypal2.png" alt=""></p>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>

                            <div id="tabs-4" aria-labelledby="ui-id-4" class="ui-tabs-panel ui-widget-content ui-corner-bottom" role="tabpanel" aria-expanded="false" aria-hidden="true" style="display: none;">
                                <div id="reviews">
                                    <div class="rating-info">
                                        <div class="average-rating-review good">
                                            <span class="count">7.5</span> <em>Average rating</em> <span>Good</span>
                                        </div>

                                        <ul class="rating-review">
                                            <li><em>Facility</em> <span>7.5</span></li>
                                            <li><em>Human</em> <span>9.0</span></li>
                                            <li><em>Service</em> <span>9.5</span></li>
                                            <li><em>Interesting</em> <span>8.7</span></li>
                                        </ul>
                                        <a href="#" class="write-review">Write a review</a>
                                    </div>

                                    <div id="add_review">
                                        <h3 class="comment-reply-title">Add a review</h3>
                                        <form>
                                            <div class="comment-form-author">
                                                <label for="author">Name <span class="required">*</span></label>
                                                <input id="author" type="text">
                                            </div>
                                            <div class="comment-form-email">
                                                <label for="email">Email <span class="required">*</span></label>
                                                <input id="email" type="text"></div>
                                                <div class="comment-form-rating">
                                                    <h4>Your Rating</h4>
                                                    <div class="comment-form-rating__content">
                                                        <div class="item facility"><label>Facility</label>
                                                            <div class="awe-select-wrapper">
                                                                <select class="awe-select">
                                                                    <option>5.0</option>
                                                                    <option>6.5</option>
                                                                    <option>7.5</option>
                                                                    <option>8.5</option>
                                                                    <option>9.0</option>
                                                                    <option>10</option>
                                                                </select>
                                                                <i class="fa fa-caret-down"></i>
                                                            </div>
                                                        </div>

                                                        <div class="item human">
                                                            <label>Human</label>
                                                            <div class="awe-select-wrapper">
                                                                <select class="awe-select">
                                                                    <option>5.0</option>
                                                                    <option>6.5</option>
                                                                    <option>7.5</option>
                                                                    <option>8.5</option>
                                                                    <option>9.0</option>
                                                                    <option>10</option>
                                                                </select>
                                                                <i class="fa fa-caret-down"></i>
                                                            </div>
                                                        </div>
                                                        <div class="item service">
                                                            <label>Service</label>
                                                            <div class="awe-select-wrapper">
                                                                <select class="awe-select">
                                                                    <option>5.0</option>
                                                                    <option>6.5</option>
                                                                    <option>7.5</option>
                                                                    <option>8.5</option>
                                                                    <option>9.0</option>
                                                                    <option>10</option>
                                                                </select>
                                                                <i class="fa fa-caret-down"></i>
                                                            </div>
                                                        </div>
                                                        <div class="item interesting">
                                                            <label>Interesting</label>
                                                            <div class="awe-select-wrapper">
                                                                <select class="awe-select">
                                                                    <option>5.0</option>
                                                                    <option>6.5</option>
                                                                    <option>7.5</option>
                                                                    <option>8.5</option>
                                                                    <option>9.0</option>
                                                                    <option>10</option>
                                                                </select>
                                                                <i class="fa fa-caret-down"></i>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="comment-form-comment">
                                                    <label for="comment">Your Review</label>
                                                    <textarea id="comment"></textarea>
                                                </div>
                                                <div class="form-submit">
                                                    <input type="submit" class="submit" value="Submit">
                                                </div>
                                            </form>
                                        </div>

                                        <div id="comments">
                                            <ol class="commentlist">
                                                <li>
                                                <div class="comment-box">
                                                    <div class="avatar">
                                                        <img src="/front/assets/images/img/demo-thumb.jpg" alt="">
                                                    </div>
                                                    <div class="comment-body">
                                                        <p class="meta">
                                                            <strong>Nguyen Gallahendahry</strong>
                                                            <span class="time">December 10, 2012</span>
                                                        </p>
                                                        <div class="description">
                                                            <p>Takes me back to my youth. I love the design of this soda machine. A bit pricy though..!
                                                            </p>
                                                        </div>
                                                        <div class="rating-info">
                                                            <div class="average-rating-review good">
                                                                <span class="count">7.5</span> <em>Average rating</em>
                                                                <span>Good</span>
                                                            </div>
                                                            <ul class="rating-review">
                                                                <li>
                                                                    <em>Facility</em> <span>7.5</span>
                                                                </li>
                                                                <li>
                                                                    <em>Human</em> <span>9.0</span>
                                                                </li>
                                                                <li>
                                                                    <em>Service</em> <span>9.5</span>
                                                                </li>
                                                                <li>
                                                                    <em>Interesting</em> <span>8.7</span>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </div>
                                            </li>
                                        </ol>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Sidebar -->
                <div class="col-md-3" style="position: relative; overflow: visible; box-sizing: border-box; min-height: 1px;">
                    <div class="theiaStickySidebar" style="padding-top: 1px; padding-bottom: 1px; position: static;">
                        <div class="detail-sidebar">
                            <div class="call-to-book">
                                <i class="awe-icon awe-icon-phone"></i>
                                <em>Call to reserve</em>
                                <span>+1-888-8765-1234</span>
                            </div>

                            <!-- Reservation info -->
                            <div class="booking-info">
                                <h3>Reservation info</h3>
                                <div class="form-group">
                                    <!-- Check-in -->
                                    <div class="form-elements form-checkin">
                                        <label>Check-in</label>
                                        <div class="form-item">
                                            <input type="text" value="{{ Request::input('ci') }}" readonly>
                                        </div>
                                    </div>
                                    <!--/. Check-in -->

                                    <!-- Check-out -->
                                    <div class="form-elements form-checkout">
                                        <label>Check-out</label>
                                        <div class="form-item">
                                            <input type="text" value="{{ Request::input('co') }}" readonly>
                                        </div>
                                    </div>
                                    <!--/. Check-out -->
                                </div>
                                
                                <!-- Guests -->
                                <div class="form-group">
                                    <!-- Adult -->
                                    <div class="form-elements form-checkin">
                                        <label>Adult</label>
                                        <div class="form-item">
                                            <input type="text" value="{{ Request::input('aq') }}" readonly>
                                        </div>
                                    </div>
                                    <!--/. Adult -->

                                    <!-- Children -->
                                    <div class="form-elements form-checkout">
                                        <label>Children</label>
                                        <div class="form-item">
                                            <input type="text" value="{{ Request::input('cq') }}" readonly>
                                        </div>
                                    </div>
                                    <!--/. Children -->
                                </div>
                                <!--/. Guests -->

                                <div class="form-group">
                                    <!-- Quantity -->
                                    <div class="form-elements form-checkin">
                                        <label>Quantity</label>
                                        <div class="form-item">
                                            <input type="text" value="1" readonly>
                                        </div>
                                    </div>
                                    <!--/. Quantity -->
                                </div>

                                <div class="add-room-type">
                                    <a href="#"><i class="awe-icon awe-icon-plus"></i>Add More</a>
                                </div>

                                <div class="price">
                                    <em>Total for this item</em> <span class="amount">$5,923</span>
                                    <div class="cart-added">
                                        <i class="awe-icon awe-icon-check"></i> Added
                                    </div>
                                </div>

                                <div class="reset">
                                    <a href="#">Reset</a>
                                </div>

                                <div class="form-submit">
                                    <div class="add-to-cart">
                                        <button type="submit">
                                            <i class="awe-icon awe-icon-cart"></i>Add this to Cart
                                        </button>
                                    </div>
                                    <div class="view-cart"><a href="#">View cart</a></div>
                                </div>
                            </div>
                            <!--/. Reservation info -->
                        </div>
                    </div>
                </div>
                <!--/. Sidebar -->

            </div>
        </div>
    </section>
@endsection

@section('scripts')
    <script>
        var checkin_date = $("input[id=ci]");
        var checkout_date = $("input[id=co]");

        checkin_date.datepicker({
            dateFormat: 'yy-mm-dd',
            minDate: '{{ $minimum_reservation_date }}',
            maxDate: '{{ $maximum_reservation_date }}',
            showOtherMonths: !0,
            selectOtherMonths: !0,
            dayNamesMin:["Sun","Mon","Tue","Wen","Thu","Fri","Sat"]
        });

        checkout_date.datepicker({
            dateFormat: 'yy-mm-dd',
            minDate: '{{ $minimum_reservation_date }}',
            maxDate: '{{ $maximum_reservation_date }}',
            showOtherMonths: !0,
            selectOtherMonths: !0,
            dayNamesMin:["Sun","Mon","Tue","Wen","Thu","Fri","Sat"]
        });
    </script>
@endsection