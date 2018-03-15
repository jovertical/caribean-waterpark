@extends('front.layouts.main')

@section('content')
    <section class="hero-section">
        <div id="slider-revolution">
            <ul>
                <li data-slotamount="7" data-masterspeed="500" data-title="Slide title 1">
                    <img src="/front/assets/images/bg/1.jpg" data-bgposition="left center" data-duration="14000" data-bgpositionend="right center" alt="">

                    <div class="tp-caption sfb fadeout slider-caption-sub slider-caption-sub-1" data-x="center" data-y="230" data-speed="700" data-start="1500" data-easing="easeOutBack">Caribbean Waterpark Resort
                    </div>

                    <div class="tp-caption sfb fadeout slider-caption slider-caption-1" data-x="center" data-y="280" data-speed="700" data-easing="easeOutBack" data-start="2000">Feel like at home
                    </div>

                    <a href="{{ route('front.reservation.search') }}" class="tp-caption sfb fadeout awe-btn awe-btn-style3 awe-btn-slider" data-x="center" data-y="380" data-easing="easeOutBack" data-speed="700" data-start="2200">Welcome</a>
                </li>

                <li data-slotamount="7" data-masterspeed="500" data-title="Slide title 2">
                    <img src="/front/assets/images/bg/2.jpg" data-bgposition="left center" data-duration="14000" data-bgpositionend="right center" alt="">

                    <div class="tp-caption sft fadeout slider-caption-sub slider-caption-sub-2" data-x="center" data-y="220" data-speed="700" data-start="1500" data-easing="easeOutBack">Check out the top weekly destination
                    </div>

                    <div class="tp-caption sft fadeout slider-caption slider-caption-2" data-x="center" data-y="260" data-speed="700" data-easing="easeOutBack" data-start="2000">Travel with us
                    </div>
                    <a href="#" class="tp-caption sft fadeout awe-btn awe-btn-style3 awe-btn-slider" data-x="center" data-y="370" data-easing="easeOutBack" data-speed="700" data-start="2200">Details</a>
                </li>

                <li data-slotamount="7" data-masterspeed="500" data-title="Slide title 3">
                    <img src="/front/assets/images/bg/3.jpg" data-bgposition="left center" data-duration="14000" data-bgpositionend="right center" alt="">

                    <div class="tp-caption lfl fadeout slider-caption slider-caption-3" data-x="center" data-y="260" data-speed="700" data-easing="easeOutBack" data-start="1500">Relax
                    </div>

                    <div href="#" class="tp-caption lfr fadeout slider-caption-sub slider-caption-sub-3" data-x="center" data-y="365" data-easing="easeOutBack" data-speed="700" data-start="2000">We will help you appreciate life more
                    </div>
                </li>
            </ul>
        </div>
    </section>

    <section>
        <div class="container">
            <div class="awe-search-tabs tabs">
                <ul style="display: none;">
                    <li><a href="#awe-search-tabs-1"><i class="awe-icon awe-icon-hotel"></i></a></li>
                </ul>

                <div class="awe-search-tabs__content tabs__content">
                    <div id="awe-search-tabs-1" class="search-bus ui-tabs-panel ui-widget-content ui-corner-bottom">
                        <h2>Share your precious time with us?</h2>

                        <form method="GET" action="{{ route('front.reservation.search') }}">
                            <div class="form-group">
                                <!-- Check-in -->
                                <div class="form-elements">
                                    <label>Check-in</label>
                                    <div class="form-item">
                                        <i class="awe-icon awe-icon-calendar"></i>
                                        <input type="text" name="ci" id="ci" class="awe-calendar"
                                            value="{{ Request::input('ci') }}">
                                    </div>
                                </div>
                                <!--/. Check-in -->

                                <!-- Check-out -->
                                <div class="form-elements">
                                    <label>Check-out</label>
                                    <div class="form-item">
                                        <i class="awe-icon awe-icon-calendar"></i>
                                        <input type="text" name="co" id="co" class="awe-calendar"
                                            value="{{ Request::input('co') }}">
                                    </div>
                                </div>
                                <!--/. Check-out -->
                            </div>

                            <div class="form-group">
                                <!-- Adult -->
                                <div class="form-elements">
                                    <label for="aq">Adult</label>
                                    <div class="form-item">
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
                                    </div>
                                    <span>12 y/o and above</span>
                                </div>
                                <!--/. Adult -->

                                <!-- Children -->
                                <div class="form-elements">
                                    <label for="cq">Children</label>
                                    <div class="form-item">
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
                                    </div>
                                    <span>0-11 y/o</span>
                                </div>
                                <!--/. Children -->
                            </div>

                            <div class="form-actions">
                                <input type="submit" value="Search">
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="masonry-section-demo">
        <div class="container">
            <div class="destination-grid-content">
                <div class="section-title">
                    <h3>About <a href="#">{{ $items->count() }} Accomodations</a> to stay with.</h3>
                </div>
                <div class="row">
                    <div class="awe-masonry">
                        @foreach($items->take(Request::get('mc') ?? 5) as $index => $item)
                            <div class="awe-masonry__item">
                                <a href="#">
                                    <div class="image-wrap image-cover">
                                        <img src="{{ Helper::fileUrl($item->images->first()) }}" alt="">
                                    </div>
                                </a>
                                <div class="item-title">
                                    <h2>
                                        <a href="{{ route('front.items.show', $item) }}">
                                            {{ $item->name }}
                                        </a>
                                    </h2>
                                    <div class="item-cat">
                                        <ul>
                                            <li>
                                                <a href="#">
                                                    {{ $item->category->name }}
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="item-available">
                                    <span class="count">{{ $item->quantity }}</span> items
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                @if(count($items->take($mc = Request::get('mc') ?? 5)) >= $mc)
                    <div class="more-destination">
                        <a href="{{ route('front.welcome').'?mc='.($mc == null ? 10 : ($mc + 5)) }}">
                            More Accomodations
                        </a>
                    </div>
                @endif

            </div>
        </div>
    </section>

    <section class="sale-flights-section-demo">
        <div class="container">
            <div class="row">
                <div class="col-md-8">
                    <div class="sale-flights-tabs tabs">
                        <ul>
                            <li>
                                <a href="#best-selling">Best selling</a>
                            </li>

                            <li>
                                <a href="#top-rated">Top rated</a>
                            </li>
                        </ul>

                        <div class="sale-flights-tabs__content tabs__content">
                            <!-- Best selling -->
                            <div id="best-selling">
                                @foreach($best_selling_items as $item)
                                    <div class="trip-item">
                                        <div class="item-media">
                                            <div class="image-cover">
                                                <img src="{{ Helper::fileUrl($item->images->first()) }}" alt="img">
                                            </div>
                                        </div>
                                        <div class="item-body">
                                            <div class="item-title">
                                                <h2>
                                                    <a href="{{ route('front.items.show', $item) }}">
                                                        {{ $item->name }}
                                                    </a>
                                                </h2>
                                            </div>

                                            <div class="item-description">
                                                {!! Str::limit($item->description, 50) !!}
                                            </div>

                                            <div class="item-footer">
                                                <div class="item-rate">
                                                    <span>
                                                        {{ $item->order_count }} Customer usage
                                                    </span>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="item-price-more">
                                            <div class="price">One day from
                                                <ins>
                                                    <span class="amount">
                                                        {{ Helper::moneyString($item->price) }}
                                                    </span>
                                                </ins>
                                            </div>

                                            <a href="{{ route('front.items.show', $item) }}" class="awe-btn">Details</a>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            <!--/. Best selling -->

                            <!-- Top rated -->
                            <div id="top-rated">
                                @foreach($top_rated_items as $item)
                                    <div class="trip-item">
                                        <div class="item-media">
                                            <div class="image-cover">
                                                <img src="{{ Helper::fileUrl($item->images->first()) }}" alt="img">
                                            </div>
                                        </div>
                                        <div class="item-body">
                                            <div class="item-title">
                                                <h2>
                                                    <a href="{{ route('front.items.show', $item) }}">
                                                        {{ $item->name }}
                                                    </a>
                                                </h2>
                                            </div>

                                            <div class="item-description">
                                                {!! Str::limit($item->description, 50) !!}
                                            </div>

                                            <div class="item-footer">
                                                <div class="item-rate">
                                                    <span>
                                                        {{ Helper::decimalFormat($item->average_rating, 1) }}
                                                        {{ ucfirst($item->rating_remark) }}
                                                    </span>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="item-price-more">
                                            <div class="price">One day from
                                                <ins>
                                                    <span class="amount">
                                                        {{ Helper::moneyString($item->price) }}
                                                    </span>
                                                </ins>
                                            </div>

                                            <a href="{{ route('front.items.show', $item) }}" class="awe-btn">Details</a>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            <!--/. Top rated -->
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="awe-services">
                        <h2>Why caribbean waterpark?</h2>
                        <ul class="awe-services__list">
                            <li>
                                <a href="#">
                                    <i class="awe-icon awe-icon-check"></i>
                                    <i class="awe-icon awe-icon-arrow-right"></i>
                                    Wide array of accomodations
                                    <span>{{ $items->count() }} to choose from</span>
                                </a>
                            </li>

                            <li>
                                <a href="#">
                                    <i class="awe-icon awe-icon-check"></i>
                                    <i class="awe-icon awe-icon-arrow-right"></i> 100% trusted reviews
                                    <span>{{ $item_reviews->count() }} customer reviews in total</span>
                                </a>
                            </li>

                            <li>
                                <a href="#">
                                    <i class="awe-icon awe-icon-check"></i>
                                    <i class="awe-icon awe-icon-arrow-right"></i>
                                    Excellent support
                                    <span>Our customers are the top priority</span>
                                </a>
                            </li>

                            <li>
                                <a href="#">
                                    <i class="awe-icon awe-icon-check"></i>
                                    <i class="awe-icon awe-icon-arrow-right"></i>
                                    Manage your reservation online
                                    <span>We will contact you back</span>
                                </a>
                            </li>

                            <li>
                                <a href="#">
                                    <i class="awe-icon awe-icon-check"></i>
                                    <i class="awe-icon awe-icon-arrow-right"></i>
                                    Variety of payment options
                                    <span>We support paypal and cash payments</span>
                                </a>
                            </li>
                        </ul>
                        <div class="video-wrapper embed-responsive embed-responsive-16by9">
                            <iframe class="embed-responsive-item" src=""></iframe>
                        </div>
                    </div>
                </div>
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