@extends('root.layouts.main')

@section('content')
    <div class="row">
        <div class="col-lg-4">
            <form method="GET" action="{{ route('root.item-calendars.search') }}">
                <!-- Dates -->
                <div class="m-portlet m-portlet--head-sm" data-portlet="true" id="dates">
                    <div class="m-portlet__head">
                        <div class="m-portlet__head-caption">
                            <div class="m-portlet__head-title">
                                <span class="m-portlet__head-icon">
                                    <i class="flaticon-calendar"></i>
                                </span>

                                <h3 class="m-portlet__head-text">Dates</h3>
                            </div>
                        </div>
                    </div>

                    <!-- Form -->
                    <div class="m-form m-form--fit m-form--label-align-right">
                        <div class="m-portlet__body">
                            <div class="form-group m-form__group m--margin-top-10">
                                <label for="checkin_date">Checkin: </label>
                                <input type="text" name="checkin_date" id="checkin_date" class="form-control m-input" placeholder="Enter check-in date" value="{{ Request::input('checkin_date') }}">
                            </div>

                            <div class="form-group m-form__group">
                                <label for="checkout_date">Checkout: </label>
                                <input type="text" name="checkout_date" id="checkout_date" class="form-control m-input" placeholder="Enter check-out date" value="{{ Request::input('checkout_date') }}">
                            </div>
                        </div>

                        <div class="m-portlet__foot m-portlet__foot--fit">
                            <div class="m-form__actions">
                                <button type="submit" class="btn btn-primary">Search</button>
                                <button type="reset" class="btn btn-secondary">Cancel</button>
                            </div>
                        </div>
                    </div>
                    <!-- Form -->
                </div>
                <!--/. Dates -->

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

                    <!--/. Form -->
                    <div class="m-form m-form--fit m-form--label-align-right">
                        <div class="m-portlet__body">
                            <div class="form-group m-form__group">
                                <label for="max_price">Maximum price: </label>

                                <div class="m-ion-range-slider">
                                    <input type="hidden" name="max_price" id="max_price" data-max-value="49999"
                                        value="{{ Request::input('max_price') }}">
                                </div>
                            </div>
                        </div>

                        <div class="m-portlet__foot m-portlet__foot--fit">
                            <div class="m-form__actions">
                                <button type="submit" class="btn btn-primary">Apply</button>
                                <button type="reset" class="btn btn-secondary">Cancel</button>
                            </div>
                        </div>
                    </div>
                    <!-- Form -->
                </div>
                <!--/. Filters -->
            </form>
        </div>

        <div class="col-lg">
            <ul>
                @foreach($items as $item)
                    <li>Name: <strong>{{ $item->name }}</strong> &nbsp
                        Price: <strong>{{ number_format($item->calendar['price'], 2) }}</strong></li>
                @endforeach
            </ul>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        var search = function () {
            var datesInit = function () {
                $('input[id=checkin_date]').datepicker({
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

                $('input[id=checkout_date]').datepicker({
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

            var filtersInit = function () {
                var $max_price = $('input[id=max_price]');

                $max_price.ionRangeSlider({
                    min: 0,
                    max: $max_price.data('max-value'),
                    from: $max_price.val()
                });
            };

            return {
                init: function() {
                    datesInit();
                    filtersInit();
                }
            }
        }();

        $(document).ready(function() {
            search.init();
        });
    </script>
@endsection