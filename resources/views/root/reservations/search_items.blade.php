@extends('root.layouts.main')

@section('sidebar')
    @component('root.components.sidebar')@endcomponent
@endsection

@section('content')
    <div class="row">
        <div class="col-lg">
            <div class="m-portlet">
                <form method="GET" action="{{ route('root.item-calendars.search') }}">
                    <div class="m-portlet__body">
                        <div class="form-group m-form__group row justify-content-center">

                            <div class="col-lg-3">
                                <label for="ci">Checkin:</label>
                                <div class="input-group m-input-group m-input-group--square">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="la la-calendar"></i></span>
                                    </div>
                                    <input type="text" name="ci" id="ci" class="form-control m-input"
                                        value="{{ Request::input('ci') }}">
                                </div>
                            </div>

                            <div class="col-lg-3">
                                <label for="co">Checkout:</label>

                                <div class="input-group m-input-group m-input-group--square">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="la la-calendar"></i></span>
                                    </div>
                                    <input type="text" name="co" id="co" class="form-control m-input"
                                        value="{{ Request::input('co') }}">
                                </div>
                            </div>

                            <div class="col-lg-2 h-100 mt-auto">
                                <br>

                                <button type="submit" class="btn btn-primary">Search</button>
                            </div>
                        </div>
                    </div>
                </form>
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
                            <button type="reset" class="btn btn-secondary">Reset</button>
                        </div>
                    </div>
                </div>
                <!-- Form -->
            </div>
            <!--/. Filters -->
        </div>

        <div class="col-lg">
            @foreach($items as $item)
                <div class="m-portlet">
                    <div class="m-portlet__body">
                        <div class="m-widget5">
                            <div class="m-widget5__item">
                                <div class="m-widget5__pic">
                                    <img class="m-widget7__img" src="{{ Helper::fileUrl($item->images->first(), 'thumbnail') }}" alt="Image">
                                </div>

                                <div class="m-widget5__content">
                                    <h4 class="m-widget5__title">{{ ucfirst(strtolower($item->name)) }}</h4>

                                    <p class="m-widget5__desc">
                                        {!! Str::limit($item->description, 50) !!}
                                    </p>

                                    <div class="m-widget5__info">
                                        <label class="m-widget5__info-label">Available:</label>
                                        <span class="m-widget5__info-author m--font-warning">
                                            {{ $item->calendar_quantity }}</span>
                                        <label class="m-widget5__info-label">Price:</label>
                                        <span class="m-widget5__info-date m--font-info">
                                            ₱{{ number_format($item->calendar_price, 2) }}</span>
                                    </div>
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