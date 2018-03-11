@extends('root.layouts.main')

@section('sidebar')
    @component('root.components.sidebar')
        <!-- Cart -->
        <li class="m-menu__item" aria-haspopup="true">
            <a href="{{ route('root.reservation.cart') }}" class="m-menu__link">
                <i class="m-menu__link-icon la la-shopping-cart"></i>
                <span class="m-menu__link-title">
                    <span class="m-menu__link-wrap">
                        <span class="m-menu__link-text">Cart</span>
                            <span class="m-menu__link-badge">
                                <span class="m-badge m-badge--success">{{ count($selected_items) }}</span>
                            </span>
                        </span>
                    </span>
                </span>
            </a>
        </li>
        <!--/. Cart -->
    @endcomponent
@endsection

@section('content')
    <form method="GET" action="{{ route('root.reservation.search') }}">
        <div class="row">
            <div class="col-lg">
                @if(Session::has('message'))
                    @component('root.components.alert')
                        {{ Session::get('message') }}
                    @endcomponent
                @endif

                <div class="m-portlet">
                    <div class="m-portlet__body">
                        <div class="form-group m-form__group row justify-content-center">

                            <!-- Checkin date -->
                            <div class="col-lg-3">
                                <label for="ci">Checkin date:</label>
                                <div class="input-group m-input-group m-input-group--square">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="la la-calendar"></i></span>
                                    </div>
                                    <input type="text" name="ci" id="ci" class="form-control m-input"
                                        value="{{ Request::input('ci') }}" readonly>
                                </div>
                            </div>
                            <!--/. Checkin date -->

                            <!-- Checkout date -->
                            <div class="col-lg-3">
                                <label for="co">Checkout date:</label>

                                <div class="input-group m-input-group m-input-group--square">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="la la-calendar"></i></span>
                                    </div>
                                    <input type="text" name="co" id="co" class="form-control m-input"
                                        value="{{ Request::input('co') }}" readonly>
                                </div>
                            </div>
                            <!--/. Checkout date -->

                            <!-- Adult quantity -->
                            <div class="col-lg-2">
                                <label for="aq">Adult:</label>

                                <select name="aq" id="aq" class="form-control m-bootstrap-select">
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
                            <!--/. Adult quantity -->

                            <!-- Children quantity -->
                            <div class="col-lg-2">
                                <label for="cq">Children:</label>

                                <select name="cq" id="cq" class="form-control m-bootstrap-select">
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
                            <!--/. Children quantity -->

                            <div class="col-lg-2 h-100 mt-auto">
                                <br>

                                <button type="submit" class="btn btn-primary w-100">Search</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-4">
                <!-- Filters -->
                <div class="m-portlet m-portlet--head-sm" data-portlet="true" id="filters">
                    <div class="m-portlet__head">
                        <div class="m-portlet__head-caption">
                            <div class="m-portlet__head-title">
                                <span class="m-portlet__head-icon">
                                    <i class="flaticon-interface-3"></i>
                                </span>

                                <h3 class="m-portlet__head-text">Filters</h3>
                            </div>
                        </div>
                    </div>

                    <div class="m-form m-form--fit m-form--label-align-right">
                        <div class="m-portlet__body">
                            <!-- Minimum price -->
                            <div class="form-group m-form__group">
                                <label for="mnp">Minimum price: </label>

                                <div class="m-ion-range-slider">
                                    <input type="hidden" name="mnp" id="mnp" data-max-value="1"
                                        value="{{ Request::input('mnp') ?? 1 }}">
                                </div>
                            </div>
                            <!--/. Minimum price -->

                            <!-- Maximum price -->
                            <div class="form-group m-form__group">
                                <label for="mxp">Maximum price: </label>

                                <div class="m-ion-range-slider">
                                    <input type="hidden" name="mxp" id="mxp" data-max-value="99999"
                                        value="{{ Request::input('mxp') ?? 99999 }}">
                                </div>
                            </div>
                            <!--/. Maximum price -->
                        </div>

                        <div class="m-portlet__foot m-portlet__foot--fit">
                            <div class="m-form__actions">
                                <button type="submit" class="btn btn-primary">Apply</button>
                                <a href="#" class="btn btn-secondary">Clear</a>
                            </div>
                        </div>
                    </div>
                </div>
                <!--/. Filters -->
            </div>
        </form>

        <div class="col-lg-8">
            <!-- Search result count -->
            @if(count($available_items))
                <p class="text-right">
                    Your search found <span class="m--font-boldest">{{ count($available_items) }}</span> items.
                </p>
            @endif
            <!--/. Search result count -->

            @foreach($available_items as $index => $available_item)
                @if($available_item->calendar_unoccupied > 0)
                    <div class="m-portlet">
                        <div class="m-portlet__body">
                            <div class="m-widget5">
                                <div class="m-widget5__item">
                                    <div class="m-widget5__pic">
                                        <img src="{{ Helper::fileUrl($available_item->item->images->first(), 'thumbnail') }}"
                                            class="m-widget7__img"  alt="Image">
                                    </div>

                                    <div class="m-widget5__content">
                                        <h4 class="m-widget5__title">{{ $available_item->item->name }}</h4>

                                        <p class="m-widget5__desc">
                                            {!! Str::limit($available_item->item->description, 50) !!}
                                        </p>

                                        <div class="m-widget5__info">
                                            <label class="m-widget5__info-label">Available:</label>
                                            <span class="m-widget5__info-author m--font-warning">
                                                {{ $available_item->calendar_unoccupied }}</span>
                                            <label class="m-widget5__info-label">Price:</label>
                                            <span class="m-widget5__info-date m--font-info">
                                                {{ Helper::moneyString($available_item->calendar_price) }}</span>
                                        </div>
                                    </div>
                                </div>

                                <form method="POST" action="{{ route('root.reservation.add-item', $index) }}">
                                    {{ csrf_field() }}

                                    <div class="row">
                                        <div class="col-lg-6 col-md-6 col-sm-9 col-xs-12">
                                            <div class="input-group m-input-group">
                                                <div class="input-group-append">
                                                    <button type="button" class="btn btn-secondary decrement_item_count"
                                                        data-item-index="{{ $index }}">
                                                        <i class="la la-minus"></i>
                                                    </button>
                                                </div>

                                                <input type="number" name="quantity" class="form-control m-input" value="1" readonly
                                                    data-item-index="{{ $index }}"
                                                    data-item-unoccupied={{ $available_item->calendar_unoccupied }}
                                                    >

                                                <div class="input-group-prepend">
                                                    <button type="button" class="btn btn-secondary increment_item_count"
                                                        data-item-index="{{ $index }}">
                                                        <i class="la la-plus"></i>
                                                    </button>
                                                </div>

                                                <button type="submit" class="ml-2 btn btn-primary">Add</button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <!--/. Item -->
                @endif
            @endforeach

            <!-- Pagination -->
            @if (count($available_items))
                <div class="d-flex justify-content-center align-items-center mt-4" style="height: 100px;">
                    {{ $available_items->appends(Request::all())->links() }}
                </div>
            @endif
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        var search = function () {
            var datesInit = function () {
                $('input[id=ci]').datepicker({
                    format: 'yyyy-mm-dd',
                    orientation: "bottom left",
                    todayBtn: "linked",
                    clearBtn: true,
                    todayHighlight: true,
                    templates: {
                        leftArrow: '<i class="la la-angle-left"></i>',
                        rightArrow: '<i class="la la-angle-right"></i>'
                    }
                });

                $('input[id=co]').datepicker({
                    format: 'yyyy-mm-dd',
                    orientation: "bottom left",
                    todayBtn: "linked",
                    clearBtn: true,
                    todayHighlight: true,
                    templates: {
                        leftArrow: '<i class="la la-angle-left"></i>',
                        rightArrow: '<i class="la la-angle-right"></i>'
                    }
                });
            }

            // selects
            var selectsInit = function () {
                $('select[id=aq]').selectpicker({});
                $('select[id=cq]').selectpicker({});
            }
            //. selects

            var slidersInit = function () {
                var minimum_price = $('input[id=mnp]');
                var maximum_price = $('input[id=mxp]');

                minimum_price.ionRangeSlider({
                    min: 1,
                    max: maximum_price.val(),
                    from: minimum_price.val(),
                    prefix: "₱"
                });

                maximum_price.ionRangeSlider({
                    min: minimum_price.val(),
                    max: maximum_price.data('max-value'),
                    from: maximum_price.val(),
                    prefix: "₱"
                });
            };

            return {
                init: function() {
                    datesInit();
                    selectsInit();
                    slidersInit();
                }
            }
        }();

        $(document).ready(function() {
            search.init();

            // increment item count.
            $('.increment_item_count').on('click', function(e) {
                var increment_button = $(this);
                var decrement_button = $(".decrement_item_count, button[data-item-index="+ $(this).data('item-index') +"]");
                var item_index = increment_button.data('item-index');
                var input = $('input[data-item-index='+ item_index +']');
                var item_counter = parseInt(input.val())

                if (item_counter < input.data('item-unoccupied')) {
                    decrement_button.attr('disabled', false);
                    input.val(item_counter + 1);
                } else {
                    increment_button.attr('disabled', true);
                }
            });

            // decrement item count.
            $('.decrement_item_count').on('click', function(e) {
                var decrement_button = $(this);
                var increment_button = $(".increment_item_count, button[data-item-index="+ $(this).data('item-index') +"]");
                var item_index = decrement_button.data('item-index');
                var input = $('input[data-item-index='+ item_index +']');
                var item_counter = parseInt(input.val())

                if (item_counter > 1) {
                    increment_button.attr('disabled', false);
                    input.val(item_counter - 1);
                } else {
                    decrement_button.attr('disabled', true);
                }
            });
        });
    </script>
@endsection