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
                            <div class="item {{ $item->rating_remark }}">
                                <span class="count">{{ Helper::decimalFormat($item->average_rating, 1) }}</span>
                                <h6>Average rating</h6>
                                <p>{{ ucfirst($item->rating_remark) }}</p>
                            </div>
                            <div class="item">
                                <h6>Reviews</h6>
                                <p>{{ $item->reviews->count() }}</p>
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
                            <li class="ui-state-default ui-corner-top" role="tab" tabindex="-1" aria-controls="tabs-1" aria-labelledby="ui-id-1" aria-selected="false">
                                <a href="#tabs-1" class="ui-tabs-anchor" role="presentation" tabindex="-1" id="ui-id-1">
                                    Facilities
                                </a>
                            </li>

                            <li class="ui-state-default ui-corner-top" role="tab" tabindex="-1" aria-controls="tabs-2" aria-labelledby="ui-id-2" aria-selected="false">
                                <a href="#tabs-2" class="ui-tabs-anchor" role="presentation" tabindex="-1" id="ui-id-2">
                                    Review &amp; rating
                                </a>
                            </li>
                        </ul>

                        <div class="product-tabs__content">
                            <!-- Facilities & Freebies -->
                            <div id="tabs-1" aria-labelledby="ui-id-1" class="ui-tabs-panel ui-widget-content ui-corner-bottom" role="tabpanel" aria-expanded="false" aria-hidden="true" style="display: none;">
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
                            <!--/. Facilities & Freebies -->

                            <!-- Review & Rating -->
                            <div id="tabs-2" aria-labelledby="ui-id-2" class="ui-tabs-panel ui-widget-content ui-corner-bottom" role="tabpanel" aria-expanded="false" aria-hidden="true" style="display: none;">
                                <div id="reviews">
                                    <div class="rating-info">
                                        <div class="average-rating-review {{ $item->rating_remark }}">
                                            <span class="count">
                                                {{ Helper::decimalFormat($item->average_rating, 1) }}
                                            </span>
                                            <em>Average rating</em>
                                            <span>{{ ucfirst($item->rating_remark) }}</span>
                                        </div>

                                        <ul class="rating-review">
                                            <li>
                                                <em>Facility</em>
                                                <span>{{ Helper::decimalFormat($item->facility_rating, 1) }}</span>
                                            </li>
                                            <li>
                                                <em>Service</em>
                                                <span>{{ Helper::decimalFormat($item->service_rating, 1) }}</span>
                                            </li>
                                            <li>
                                                <em>Cleanliness</em>
                                                <span>{{ Helper::decimalFormat($item->cleanliness_rating, 1) }}</span>
                                            </li>
                                            <li>
                                                <em>Value for money</em>
                                                <span>{{ Helper::decimalFormat($item->value_for_money_rating, 1) }}</span>
                                            </li>
                                        </ul>

                                        <a href="#" class="write-review">Write a review</a>
                                    </div>

                                    <div id="add_review">
                                        @guest
                                            @component('front.components.alert')
                                                Hello our beloved guest, We need to know who you are.
                                                <a href="{{ route('front.login') }}">Already a member?</a> or
                                                <a href="{{ route('front.register') }}">Newcomer?</a>
                                            @endcomponent
                                        @else
                                            @if(! $item->reviewable)
                                                @component('front.components.alert')
                                                    Hello {{ Auth::user()->titled_full_name }}, 
                                                    You are not eligible to review this item.
                                                @endcomponent
                                            @else
                                                <h3 class="comment-reply-title">Add a review</h3>
                                                <form method="POST" action="{{ route('front.item-reviews.store', $item) }}">
                                                    {{ csrf_field() }}

                                                    <div class="comment-form-email">
                                                        <label for="title">Title <span class="required">*</span></label>
                                                        <input type="text" name="title" id="title" required>

                                                        <span id="title-error" class="text-danger">
                                                            {{ $errors->first('title') }}
                                                        </span>
                                                    </div>

                                                    <div class="comment-form-rating" style="width: 100%;">
                                                        <h4>Your Rating</h4>
                                                        <div class="comment-form-rating__content">
                                                            <!-- Facility rating -->
                                                            <div class="item service">
                                                                <label>Facility</label>
                                                                <div class="awe-select-wrapper">
                                                                    <select name="facility_rating" id="facility_rating" class="awe-select" value="{{ $facility_rating = old('facility_rating') }}">
                                                                        <option value="8" style="display: none;">8</option>
                                                                        <option value="5" {{ $facility_rating == 5 ?
                                                                            'selected' : '' }}>5</option>
                                                                        <option value="6" {{ $facility_rating == 6 ?
                                                                            'selected' : '' }}>6</option>
                                                                        <option value="7" {{ $facility_rating == 7 ?
                                                                            'selected' : '' }}>7</option>
                                                                        <option value="8" {{ $facility_rating == 8 ?
                                                                            'selected' : '' }}>8</option>
                                                                        <option value="9" {{ $facility_rating == 9 ?
                                                                            'selected' : '' }}>9</option>
                                                                        <option value="10" {{ $facility_rating == 10 ?
                                                                            'selected' : '' }}>10</option>
                                                                    </select>
                                                                    <i class="fa fa-caret-down"></i>

                                                                    <span id="facility_rating-error" class="text-danger">
                                                                        {{ $errors->first('facility_rating') }}
                                                                    </span>
                                                                </div>
                                                            </div>
                                                            <!--/. Facility rating -->

                                                            <!-- Service rating -->
                                                            <div class="item service">
                                                                <label>Service</label>
                                                                <div class="awe-select-wrapper">
                                                                    <select name="service_rating" id="service_rating" 
                                                                        class="awe-select" value="{{ $service_rating = 
                                                                            old('service_rating') }}">
                                                                        <option value="8" style="display: none;">8</option>
                                                                        <option value="5" {{ $service_rating == 5 ?
                                                                            'selected' : '' }}>5</option>
                                                                        <option value="6" {{ $service_rating == 6 ?
                                                                            'selected' : '' }}>6</option>
                                                                        <option value="7" {{ $service_rating == 7 ?
                                                                            'selected' : '' }}>7</option>
                                                                        <option value="8" {{ $service_rating == 8 ?
                                                                            'selected' : '' }}>8</option>
                                                                        <option value="9" {{ $service_rating == 9 ?
                                                                            'selected' : '' }}>9</option>
                                                                        <option value="10" {{ $service_rating == 10 ?
                                                                            'selected' : '' }}>10</option>
                                                                    </select>
                                                                    <i class="fa fa-caret-down"></i>

                                                                    <span id="service_rating-error" class="text-danger">
                                                                        {{ $errors->first('service_rating') }}
                                                                    </span>
                                                                </div>
                                                            </div>
                                                            <!--/. Service rating -->

                                                            <!-- Cleanliness rating -->
                                                            <div class="item service">
                                                                <label>Cleanliness</label>
                                                                <div class="awe-select-wrapper">
                                                                    <select name="cleanliness_rating" id="cleanliness_rating"
                                                                        class="awe-select" value="{{ $cleanliness_rating =
                                                                            old('cleanliness_rating') }}">
                                                                        <option value="8" style="display: none;">8</option>
                                                                        <option value="5" {{ $cleanliness_rating == 5 ?
                                                                            'selected' : '' }}>5</option>
                                                                        <option value="6" {{ $cleanliness_rating == 6 ?
                                                                            'selected' : '' }}>6</option>
                                                                        <option value="7" {{ $cleanliness_rating == 7 ?
                                                                            'selected' : '' }}>7</option>
                                                                        <option value="8" {{ $cleanliness_rating == 8 ?
                                                                            'selected' : '' }}>8</option>
                                                                        <option value="9" {{ $cleanliness_rating == 9 ?
                                                                            'selected' : '' }}>9</option>
                                                                        <option value="10" {{ $cleanliness_rating == 10 ?
                                                                            'selected' : '' }}>10</option>
                                                                    </select>
                                                                    <i class="fa fa-caret-down"></i>

                                                                    <span id="cleanliness_rating-error" class="text-danger">
                                                                        {{ $errors->first('cleanliness_rating') }}
                                                                    </span>
                                                                </div>
                                                            </div>
                                                            <!--/. Cleanliness rating -->

                                                            <!-- Value for money rating -->
                                                            <div class="item service">
                                                                <label>Value for money</label>
                                                                <div class="awe-select-wrapper">
                                                                    <select name="value_for_money_rating" id="value_for_money_rating"
                                                                        class="awe-select" value="{{ $value_for_money_rating =
                                                                            old('value_for_money_rating') }}">
                                                                        <option value="8" style="display: none;">8</option>
                                                                        <option value="5" {{ $value_for_money_rating == 5 ?
                                                                            'selected' : '' }}>5</option>
                                                                        <option value="6" {{ $value_for_money_rating == 6 ?
                                                                            'selected' : '' }}>6</option>
                                                                        <option value="7" {{ $value_for_money_rating == 7 ?
                                                                            'selected' : '' }}>7</option>
                                                                        <option value="8" {{ $value_for_money_rating == 8 ?
                                                                            'selected' : '' }}>8</option>
                                                                        <option value="9" {{ $value_for_money_rating == 9 ?
                                                                            'selected' : '' }}>9</option>
                                                                        <option value="10" {{ $value_for_money_rating == 10 ?
                                                                            'selected' : '' }}>10</option>
                                                                    </select>
                                                                    <i class="fa fa-caret-down"></i>

                                                                    <span id="value_for_money_rating-error" class="text-danger">
                                                                        {{ $errors->first('value_for_money_rating') }}
                                                                    </span>
                                                                </div>
                                                            </div>
                                                            <!--/. Value for money rating -->
                                                        </div>
                                                    </div>
                                                    <div class="comment-form-comment">
                                                        <label for="body">Your Review</label>

                                                        <textarea name="body" id="body"></textarea>

                                                        <span id="body-error" class="text-danger">
                                                            {{ $errors->first('body') }}
                                                        </span>
                                                    </div>

                                                    <div class="form-submit">
                                                        <input type="submit" class="submit" value="Submit">
                                                    </div>
                                                </form>
                                            @endif
                                        @endguest
                                    </div>

                                    <div id="comments">
                                        <ol class="commentlist">
                                            @foreach($item_reviews as $item_review)
                                                <li>
                                                    <div class="comment-box">
                                                        <div class="avatar">
                                                            <img src="{{ Helper::fileUrl($item_review->user, 'thumbnail') }}">
                                                        </div>
                                                        <div class="comment-body">
                                                            <p class="meta">
                                                                <strong>{{ $item_review->user->titled_full_name }}</strong>
                                                                <span class="time">
                                                                    {{ $item_review->created_at->diffForHumans() }}
                                                                </span>
                                                            </p>
                                                            <div class="description">
                                                                <span>{{ $item_review->title }}</span>
                                                                <p>{{ $item_review->body }}</p>
                                                            </div>
                                                            <div class="rating-info">
                                                                <div class="average-rating-review
                                                                    {{ $item_review->rating_remark }}">
                                                                    <span class="count">
                                                                        {{ Helper::decimalFormat(
                                                                                $item_review->average_rating, 1) }}
                                                                    </span>
                                                                    <em>Average rating</em>
                                                                    <span>{{ ucfirst($item_review->rating_remark) }}</span>
                                                                </div>
                                                                <ul class="rating-review">
                                                                    <li>
                                                                        <em>Facility</em>
                                                                        <span>{{ Helper::decimalFormat(
                                                                            $item_review->facility_rating, 1) }}</span>
                                                                    </li>
                                                                    <li>
                                                                        <em>Service</em>
                                                                        <span>{{ Helper::decimalFormat(
                                                                            $item_review->service_rating, 1) }}</span>
                                                                    </li>
                                                                    <li>
                                                                        <em>Cleanliness</em>
                                                                        <span>{{ Helper::decimalFormat(
                                                                            $item_review->cleanliness_rating, 1) }}</span>
                                                                    </li>
                                                                    <li>
                                                                        <em>Value for money</em>
                                                                        <span>{{ Helper::decimalFormat(
                                                                            $item_review->value_for_money_rating, 1) }}</span>
                                                                    </li>
                                                                </ul>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </li>
                                            @endforeach
                                        </ol>
                                    </div>

                                    <!-- Pagination -->
                                    <div class="display-flex margin-y-5 justify-content-center">
                                        @if (count($item_reviews))
                                            {{ $item_reviews->appends(Request::all())->links('front.components.pagination') }}
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <!--/. Review & Rating -->
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
                                <form method="GET" action="{{ route('front.reservation.search', $item) }}">
                                    <input type="hidden" name="item" value="{{ $item->slug }}">

                                    <div class="form-group">
                                        <!-- Check-in -->
                                        <div class="form-elements form-checkin">
                                            <label>Check-in</label>
                                            <div class="form-item">
                                                <input type="text" name="ci" id="ci" class="awe-calendar"
                                                    value="{{ Request::input('co')}}">
                                            </div>
                                        </div>
                                        <!--/. Check-in -->

                                        <!-- Check-out -->
                                        <div class="form-elements form-checkout">
                                            <label>Check-out</label>
                                            <div class="form-item">
                                                <input type="text" name="co" id="co" class="awe-calendar"
                                                    value="{{ Request::input('co')}}">
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
                                                <div class="awe-select-wrapper">
                                                    <select name="aq" id="aq" class="awe-select"
                                                        value={{ $aq = Request::input('aq') }}>
                                                        <option value="1" {{ $aq == '1' ? 'selected' : '' }}>1</option>
                                                        <option value="2" {{ $aq == '2' ? 'selected' : '' }}>2</option>
                                                        <option value="3" {{ $aq == '3' ? 'selected' : '' }}>3</option>
                                                        <option value="4" {{ $aq == '4' ? 'selected' : '' }}>4</option>
                                                        <option value="5" {{ $aq == '5' ? 'selected' : '' }}>5</option>
                                                        <option value="6" {{ $aq == '6' ? 'selected' : '' }}>6</option>
                                                        <option value="7" {{ $aq == '7' ? 'selected' : '' }}>7</option>
                                                        <option value="8" {{ $aq == '8' ? 'selected' : '' }}>8</option>
                                                        <option value="9" {{ $aq == '9' ? 'selected' : '' }}>9</option>
                                                    </select>
                                                    <i class="fa fa-caret-down"></i>
                                                </div>
                                            </div>
                                            <span>12 yo and above</span>
                                        </div>
                                        <!--/. Adult -->

                                        <!-- Children -->
                                        <div class="form-elements form-checkout">
                                            <label>Children</label>
                                            <div class="form-item">
                                                <div class="awe-select-wrapper">
                                                    <select name="cq" id="cq" class="awe-select"
                                                        value={{ $cq = Request::input('cq') }}>
                                                        <option value="" disabled selected>0</option>
                                                        <option value="1" {{ $cq == '1' ? 'selected' : '' }}>1</option>
                                                        <option value="2" {{ $cq == '2' ? 'selected' : '' }}>2</option>
                                                        <option value="3" {{ $cq == '3' ? 'selected' : '' }}>3</option>
                                                        <option value="4" {{ $cq == '4' ? 'selected' : '' }}>4</option>
                                                        <option value="5" {{ $cq == '5' ? 'selected' : '' }}>5</option>
                                                        <option value="6" {{ $cq == '6' ? 'selected' : '' }}>6</option>
                                                        <option value="7" {{ $cq == '7' ? 'selected' : '' }}>7</option>
                                                        <option value="8" {{ $cq == '8' ? 'selected' : '' }}>8</option>
                                                        <option value="9" {{ $cq == '9' ? 'selected' : '' }}>9</option>
                                                    </select>
                                                    <i class="fa fa-caret-down"></i>
                                                </div>
                                            </div>
                                            <span>0-11 yo</span>
                                        </div>
                                        <!--/. Children -->
                                    </div>
                                    <!--/. Guests -->

                                    <div class="form-group">
                                        <!-- Quantity -->
                                        <div class="form-elements form-checkin">
                                            <label>Quantity</label>
                                            <div class="form-item">
                                                <div class="awe-select-wrapper">
                                                    <select name="quantity" id="quantity" class="awe-select">
                                                        <option value="1">1</option>
                                                        <option value="2">2</option>
                                                        <option value="3">3</option>
                                                        <option value="4">4</option>
                                                        <option value="5">5</option>
                                                        <option value="6">6</option>
                                                        <option value="7">7</option>
                                                        <option value="8">8</option>
                                                        <option value="9">9</option>
                                                    </select>
                                                    <i class="fa fa-caret-down"></i>
                                                </div>
                                            </div>
                                        </div>
                                        <!--/. Quantity -->
                                    </div>

                                    <div class="form-submit">
                                        <div class="add-to-cart">
                                            <button type="submit">Check availability</button>
                                        </div>
                                    </div>
                                </form>
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