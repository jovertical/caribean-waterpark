@extends('front.layouts.main')

@section('content')
    <!-- Header -->
    <section class="awe-parallax category-heading-section-demo" style="background-position: 50% 12px;">
        <div class="awe-overlay"></div>

        <div class="container">
            <div class="category-heading-content category-heading-content__2 text-uppercase">
                <div class="breadcrumb">
                    <ul>
                        <li>
                            <a href="{{ route('front.welcome') }}">Home</a>
                        </li>

                        <li>
                            <a href="#">Reservation</a>
                        </li>
                    </ul>
                </div>

                <div class="find">
                    <h2 class="text-center">Reservation</h2>

                    <!-- Search Form -->
                    <form method="GET" action="{{ route('front.reservation.search') }}">
                        <div class="form-group">
                            <!-- Check-in -->
                            <div class="form-elements">
                                <label for="ci">Check-in</label>
                                <div class="form-item">
                                    <i class="awe-icon awe-icon-calendar"></i>
                                    <input type="text" name="ci" id="ci" class="awe-calendar"
                                        value="{{ Request::input('ci')}}">
                                </div>
                            </div>
                            <!--/. Check-in -->

                            <!-- Check-out -->
                            <div class="form-elements">
                                <label for="co">Check-out</label>
                                <div class="form-item">
                                    <i class="awe-icon awe-icon-calendar"></i>
                                    <input type="text" name="co" id="co" class="awe-calendar"
                                        value="{{ Request::input('co')}}">
                                </div>
                            </div>
                            <!--/. Check-out -->

                            <!-- Adult -->
                            <div class="form-elements">
                                <label for="aq">Adult</label>
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
                            </div>
                            <!--/. Adult -->

                            <!-- Children -->
                            <div class="form-elements">
                                <label for="cq">Children</label>
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
                            </div>
                            <!--/. Children -->

                            <div class="form-actions">
                                <input type="submit" value="Search">
                            </div>
                        </div>
                    </form>
                    <!--/. Search Form -->

                </div>
            </div>
        </div>
    </section>
    <!--/. Header -->

    <!-- Results -->
    <section class="filter-page">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="page-top">
                        <div class="awe-select-wrapper">
                            <select class="awe-select">
                                <option>Best Match</option>
                                <option>Best Rate</option>
                            </select>
                            <i class="fa fa-caret-down"></i>
                        </div>
                    </div>
                </div>

                <!-- Available items -->
                <div class="col-md-9 col-md-push-3">
                    <div class="filter-page__content">
                        <div class="filter-item-wrapper">
                            @foreach($available_items as $index => $available_item)
                                @if($available_item->calendar_unoccupied > 0)
                                    @include('front.items.item')
                                @endif
                            @endforeach
                            <!-- Available items -->
                        </div>
                        
                        <!-- Pagination -->
                        @if (count($available_items))
                            {{ $available_items->appends(Request::all())->links('front.components.pagination') }}
                        @endif
                    </div>
                </div>
                <!--/. Available items -->
                
                <!-- Filters -->
                <div class="col-md-3 col-md-pull-9">
                    <div class="page-sidebar">
                        <div class="sidebar-title">
                            <h2>Hotel filter</h2>
                            <div class="clear-filter">
                                <a href="#">Clear all</a>
                            </div>
                        </div>
                        <div class="widget widget_has_radio_checkbox">
                            <h3>Hotel Type</h3>
                            <ul>
                                <li>
                                    <label><input type="checkbox"> <i class="awe-icon awe-icon-check"></i> Hotel</label>
                                </li>
                                <li>
                                    <label><input type="checkbox"> <i class="awe-icon awe-icon-check"></i> Hostel</label>
                                </li>
                                <li>
                                    <label><input type="checkbox"> <i class="awe-icon awe-icon-check"></i> Motel</label>
                                </li>
                                <li>
                                    <label><input type="checkbox"> <i class="awe-icon awe-icon-check"></i> Homestay</label>
                                </li>
                            </ul>
                        </div>
                        <div class="widget widget_price_filter">
                            <h3>Price Level</h3>
                            <div class="price-slider-wrapper">
                                <div class="price-slider ui-slider ui-slider-horizontal ui-widget ui-widget-content ui-corner-all" _vimium-has-onclick-listener="" aria-disabled="false">
                                    <div class="ui-slider-range ui-widget-header ui-corner-all" style="left:0%;width:100%;">
                                    </div>
                                    <a class="ui-slider-handle ui-state-default ui-corner-all" href="#" style="left: 0%;">
                                    </a>
                                    <a class="ui-slider-handle ui-state-default ui-corner-all" href="#" style="left: 100%;"></a>
                                </div>
                                <div class="price_slider_amount">
                                    <div class="price_label">
                                        <span class="from">$0</span> - <span class="to">$10000</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="widget widget_has_radio_checkbox">
                            <h3>Star Rating</h3>
                            <ul>
                                <li>
                                    <label>
                                        <input type="checkbox"> 
                                        <i class="awe-icon awe-icon-check"></i> 
                                        <span class="rating">
                                            <i class="fa fa-star"></i> 
                                            <i class="fa fa-star"></i> 
                                            <i class="fa fa-star"></i> 
                                            <i class="fa fa-star"></i> 
                                            <i class="fa fa-star"></i>
                                        </span>
                                    </label>
                                </li>

                                <li>
                                    <label>
                                        <input type="checkbox"> 
                                        <i class="awe-icon awe-icon-check"></i> 
                                        <span class="rating">
                                            <i class="fa fa-star"></i> 
                                            <i class="fa fa-star"></i> 
                                            <i class="fa fa-star"></i> 
                                            <i class="fa fa-star"></i>
                                        </span>
                                    </label>
                                </li>

                                <li>
                                    <label>
                                        <input type="checkbox"> 
                                        <i class="awe-icon awe-icon-check"></i> 
                                        <span class="rating">
                                            <i class="fa fa-star"></i> 
                                            <i class="fa fa-star"></i> 
                                            <i class="fa fa-star"></i>
                                        </span>
                                    </label>
                                </li>

                                <li>
                                    <label>
                                        <input type="checkbox">
                                        <i class="awe-icon awe-icon-check"></i> 
                                        <span class="rating">
                                            <i class="fa fa-star"></i> 
                                            <i class="fa fa-star"></i>
                                        </span>
                                    </label>
                                </li>

                                <li>
                                    <label>
                                        <input type="checkbox"> 
                                        <i class="awe-icon awe-icon-check"></i> 
                                        <span class="rating">
                                            <i class="fa fa-star"></i>
                                        </span>
                                    </label>
                                </li>

                                <li>
                                    <label>
                                        <input type="checkbox"> 
                                        <i class="awe-icon awe-icon-check"></i> 
                                        <span class="rating">Unrated</span>
                                    </label>
                                </li>
                            </ul>
                        </div>

                        <div class="widget widget_has_radio_checkbox">
                            <h3>Distance</h3>
                            <ul>
                                <li>
                                    <label>
                                        <input type="checkbox"> 
                                        <i class="awe-icon awe-icon-check"></i> Near Airport
                                    </label>
                                </li>

                                <li>
                                    <label>
                                        <input type="checkbox"> <i class="awe-icon awe-icon-check"></i> Near Shopping District
                                    </label>
                                </li>

                                <li>
                                    <label>
                                        <input type="checkbox"> 
                                        <i class="awe-icon awe-icon-check"></i> Near Attractions
                                    </label>
                                </li>

                                <li>
                                    <label>
                                        <input type="checkbox"> 
                                        <i class="awe-icon awe-icon-check"></i> Near Traffic station
                                    </label>
                                </li>
                            </ul>
                        </div>

                        <div class="widget widget_has_radio_checkbox">
                            <h3>Service Include</h3>
                            <ul>
                                <li>
                                    <label>
                                        <input type="checkbox"> <i class="awe-icon awe-icon-check"></i> Room service
                                    </label>
                                </li>

                                <li>
                                    <label>
                                        <input type="checkbox"> <i class="awe-icon awe-icon-check"></i> Laundry
                                    </label>
                                </li>

                                <li>
                                    <label>
                                        <input type="checkbox"> <i class="awe-icon awe-icon-check"></i> Meal at room
                                    </label>
                                </li>

                                <li>
                                    <label>
                                        <input type="checkbox"> <i class="awe-icon awe-icon-check"></i> Wifi &amp; internet
                                    </label>
                                </li>

                                <li>
                                    <label>
                                        <input type="checkbox"> <i class="awe-icon awe-icon-check"></i> Parking lot
                                    </label>
                                </li>

                                <li>
                                    <label>
                                        <input type="checkbox"> <i class="awe-icon awe-icon-check"></i> TV and appliances
                                    </label>
                                </li>

                                <li>
                                    <label>
                                        <input type="checkbox"> <i class="awe-icon awe-icon-check"></i> Pool
                                    </label>
                                </li>

                                <li>
                                    <label>
                                        <input type="checkbox"> <i class="awe-icon awe-icon-check"></i> Gym and Spa
                                    </label>
                                </li>
                            </ul>
                        </div>

                        <div class="widget widget_product_tag_cloud">
                            <h3>Tags</h3><div class="tagcloud">
                                <a href="#">Hotel</a> 
                                <a href="#">Motel</a> 
                                <a href="#">Hostel</a> 
                                <a href="#">Homestay</a>
                            </div>
                        </div>
                    </div>
                </div>
                <!--/. Filters -->
            </div>
        </div>
    </section>
    <!--/. Results -->
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