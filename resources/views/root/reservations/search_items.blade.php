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
                                <label for="ci">Checkin: </label>
                                <input type="text" name="ci" id="ci" class="form-control m-input" placeholder="Enter check-in date" value="{{ Request::input('ci') }}">
                            </div>

                            <div class="form-group m-form__group">
                                <label for="co">Checkout: </label>
                                <input type="text" name="co" id="co" class="form-control m-input" placeholder="Enter check-out date" value="{{ Request::input('co') }}">
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
                                <label for="mp">Maximum price: </label>

                                <div class="m-ion-range-slider">
                                    <input type="hidden" name="mp" id="mp" data-max-value="49999"
                                        value="{{ Request::input('mp') }}">
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
            @foreach($items as $item)
                <div class="m-portlet">
                    <div class="m-portlet__body">
                        <div class="m-widget5">
                            <div class="m-widget5__item">
                                <div class="m-widget5__pic">
                                    <img class="m-widget7__img" src="{{ URL::to("{$item->images->first()->file_directory}/thumbnails/{$item->images->first()->file_name}") }}" alt="Image">
                                </div>

                                <div class="m-widget5__content">
                                    <h4 class="m-widget5__title">
                                        {{ ucfirst(strtolower($item->name)) }}
                                    </h4>
                                    <span class="m-widget5__desc">
                                    {{ Str::limit($item->description, 100) }}
                                    </span>
                                </div>

                                <div class="m-widget5__stats1">
                                    <span class="m-widget5__number m--font-warning">{{ $item->calendar_quantity }}</span>
                                    <br>
                                    <span class="m-widget5__sales">Available</span>
                                </div>
                                <div class="m-widget5__stats2">
                                    <span class="m-widget5__number m--font-info">₱{{ number_format($item->price, 2) }}</span>
                                    <br>
                                    <span class="m-widget5__votes">Per day</span>
                                </div>
                            </div>
                            
                            <form method="POST" action="">
                                {{ csrf_field() }}

                                <div class="m-widget19__action">
                                    <button type="submit" class="btn m-btn--pill btn-primary m-btn m-btn--hover-brand m-btn--custom">
                                        Add</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <!--/. Item -->
            @endforeach

            <!-- Pagination -->
            <div class="d-flex justify-content-center align-items-center mt-4" style="height: 100px;">
                {{ $items->appends(Request::all())->links() }}
            </div>

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

            var filtersInit = function () {
                var $max_price = $('input[id=mp]');

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