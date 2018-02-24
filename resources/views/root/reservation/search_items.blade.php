@extends('root.layouts.main')

@section('sidebar')
    @component('root.components.sidebar')
        <!-- Cart -->
        <li class="m-menu__item" aria-haspopup="true">
            <a href="{{ route('root.reservation.show-items') }}" class="m-menu__link">
                <i class="m-menu__link-icon la la-shopping-cart"></i>
                <span class="m-menu__link-title">
                    <span class="m-menu__link-wrap">
                        <span class="m-menu__link-text">Cart</span>
                            @if(count($selected_items))
                                <span class="m-menu__link-badge">
                                    <span class="m-badge m-badge--success">{{ count($selected_items) }}</span>
                                </span>
                            @endif
                        </span>
                    </span>
                </span>
            </a>
        </li>
        <!--/. Cart -->
    @endcomponent
@endsection

@section('content')
    <div class="row">
        <div class="col-lg">
            @if(Session::has('message'))
                @component('root.components.alert')
                    {{ Session::get('message') }}
                @endcomponent
            @endif

            <div class="m-portlet">
                <form method="GET" action="{{ route('root.reservation.search-items') }}">
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
            @foreach($available_items as $index => $available_item)
                @if($available_item->calendar_unoccupied > 0)
                    <div class="m-portlet">
                        <div class="m-portlet__body">
                            <div class="m-widget5">
                                <div class="m-widget5__item">
                                    <div class="m-widget5__pic">
                                        <img src="{{ Helper::fileUrl($available_item->images->first(), 'thumbnail') }}" class="m-widget7__img"  alt="Image">
                                    </div>

                                    <div class="m-widget5__content">
                                        <h4 class="m-widget5__title">{{ ucfirst(strtolower($available_item->name)) }}</h4>

                                        <p class="m-widget5__desc">
                                            {!! Str::limit($available_item->description, 50) !!}
                                        </p>

                                        <div class="m-widget5__info">
                                            <label class="m-widget5__info-label">Available:</label>
                                            <span class="m-widget5__info-author m--font-warning">
                                                {{ $available_item->calendar_unoccupied }}</span>
                                            <label class="m-widget5__info-label">Price:</label>
                                            <span class="m-widget5__info-date m--font-info">
                                                {{ Helper::moneyFormat($available_item->calendar_price) }}</span>
                                        </div>
                                    </div>
                                </div>

                                <div data-attribute="confirmable">
                                    <form method="POST" action="{{ route('root.reservation.add-item', $index) }}" class="confirm" data-target="#addItem" data-item-index="{{ $index }}" data-item-name="{{ $available_item->name }}">
                                        {{ csrf_field() }}

                                        <input type="hidden" name="quantity" id="quantity_{{ $index }}" value="1">

                                        <div class="m-widget19__action">
                                            <button type="submit" class="btn m-btn--pill btn-primary m-btn m-btn--hover-brand m-btn--custom" data-toggle="modal" data-target="#addItem">Add</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--/. Item -->
                @endif
            @endforeach

            <!-- Pagination -->
            <div class="d-flex justify-content-center align-items-center mt-4" style="height: 100px;">
                {{ $available_items->appends(Request::all())->links() }}
            </div>
        </div>
    </div>

    @component('root.components.modal')
        @slot('name')
            addItem
        @endslot

        @slot('title')
            Confirm action
        @endslot

        @slot('content_position')
            left
        @endslot

        <div class="form-group">
            <label class="form-control-label">Quantity:</label>

            <input type="number" id="quantity" class="form-control" value="1">
        </div>
    @endcomponent
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

            // modal confirmation
            $('div[data-attribute=confirmable]').on('click', '.confirm', function(e) {
                e.preventDefault();

                var $form = $(this);
                var $modal = $($form.data('target'));
                var $quantity = $('input[id=quantity]');

                $('#modalTitle').text('Add/increase in cart: ' + $form.data('item-name'));

                $quantity.on('keyup change', function() {
                    $('input[id=quantity_' + $form.data('item-index') + ']').val($quantity.val());
                });

                $modal.modal({ backdrop: 'static', keyboard: false}).on('click', '#btn-confirm', function() {
                    $form.submit();
                });
            });
        });
    </script>
@endsection