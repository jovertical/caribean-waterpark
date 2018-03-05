@extends('root.layouts.main')

@section('sidebar')
    @component('root.components.sidebar')@endcomponent
@endsection

@section('content')
    <div class="m-portlet">
        <div class="m-portlet__head">
            <div class="m-portlet__head-caption">
                <div class="m-portlet__head-title">
                    <h3 class="m-portlet__head-text">
                        Reservation
                    </h3>
                </div>
            </div>
        </div>

        <form method="POST" action="" class="m-form m-form--fit m-form--label-align-right m-form--group-seperator-dashed" id="form-settings-update">
            {{ csrf_field() }}

            <div class="m-portlet__body">
                <!-- Days prior -->
                <div class="form-group m-form__group row">
                    <label class="col-form-label col-lg-3 col-sm-12">Days prior: </label>
                    <div class="col-lg-4 col-md-9 col-sm-12">
                        <select name="days_prior" id="days_prior" class="form-control m-bootstrap-select">
                            <option value="0" selected>0</option>
                            <option value="1" {{ '1' == '1' ? '' : '' }}>1</option>
                            <option value="2" {{ '2' == '2' ? '' : '' }}>2</option>
                            <option value="3" {{ '3' == '3' ? '' : '' }}>3</option>
                            <option value="4" {{ '4' == '4' ? '' : '' }}>4</option>
                            <option value="5" {{ '5' == '5' ? '' : '' }}>5</option>
                            <option value="6" {{ '6' == '6' ? '' : '' }}>6</option>
                            <option value="7" {{ '7' == '7' ? '' : '' }}>7</option>
                            <option value="8" {{ '8' == '8' ? '' : '' }}>8</option>
                            <option value="9" {{ '9' == '9' ? '' : '' }}>9</option>
                        </select>

                        <span class="m-form__help">Allowed number of days prior to today.</span>
                    </div>
                </div>
                <!--/. Days prior -->

                <!-- Minimum reserve rate -->
                <div class="form-group m-form__group row">
                    <label class="col-form-label col-lg-3 col-sm-12">Minimum reserve rate: </label>
                    <div class="col-lg-4 col-md-9 col-sm-12">
                        <div class="m-ion-range-slider">
                            <input type="hidden" name="minimum_reserve_rate" id="minimum_reserve_rate" 
                                data-min-value="1" data-max-value="100" value="1" disabled="disabled">
                        </div>
                        <span class="m-form__help">Minimum rate required to reserve items of a reservation.</span>
                    </div>
                </div>
                <!--/. Minimum reserve rate -->

                <!-- Refunds -->
                <div class="form-group m-form__group row">
                    <label class="col-form-label col-lg-3 col-sm-12">Refunds: </label>
                    <div class="col-lg-4 col-md-9 col-sm-12">
                        <input type="checkbox" name="allow_refund" id="allow_refund" data-switch="false" 
                                data-on-color="success" data-off-color="danger" data-on-text="Enabled" data-off-text="Disabled">
                        <span class="m-form__help"></span>
                    </div>
                </div>
                <!--/. Refunds -->

                <!-- Pre-reservation refund rate -->
                <div id="allow_refund_block" style="display: none;">
                    <div class="form-group m-form__group row">
                        <label class="col-form-label col-lg-3 col-sm-12">Pre-reservation refund rate: </label>
                        <div class="col-lg-4 col-md-9 col-sm-12">
                            <div class="m-ion-range-slider">
                                <input type="hidden" name="pre_reservation_refund_rate" id="pre_reservation_refund_rate" 
                                    data-min-value="1" data-max-value="100" value="1" disabled="disabled">
                            </div>
                            <span class="m-form__help">Returnable rate of a cancelled inactive reservation.</span>
                        </div>
                    </div>
                    <!--/.Pre-reservation refund rate -->

                    <!-- Post-reservation refund rate -->
                    <div class="form-group m-form__group row">
                        <label class="col-form-label col-lg-3 col-sm-12">Post-reservation refund rate: </label>
                        <div class="col-lg-4 col-md-9 col-sm-12">
                            <div class="m-ion-range-slider">
                                <input type="hidden" name="post_reservation_refund_rate" id="post_reservation_refund_rate" 
                                    data-min-value="1" data-max-value="100" value="1" disabled="disabled">
                            </div>
                            <span class="m-form__help">Returnable rate of a cancelled active reservation.</span>
                        </div>
                    </div>
                    <!--/.Post-reservation refund rate -->
                </div>

                <!-- Bottom -->
                <div class="m-portlet__foot m-portlet__no-border m-portlet__foot--fit">
                    <div class="m-form__actions m-form__actions--solid">
                        <div class="row">
                            <div class="col-lg-2"></div>
                            <div class="col-lg-6">
                                <button type="submit" id="submit" class="btn btn-brand">Update</button>
                                <a href="{{ URL::previous() }}" class="btn btn-secondary">Cancel</a>
                            </div>
                        </div>
                    </div>
                </div>
                <!--/. Bottom -->
            </div>
        </form>
    </div>
@endsection

@section('scripts')
    <script>
        var settings = function() {
            //== Private functions

            // selects initializer
            var selectsInit = function () {
                $('select[id=days_prior]').selectpicker({});
            }
            //. selects

            // switches initializer
            var switchesInit = function() {
                var allow_refund = $('input[id=allow_refund]').bootstrapSwitch();
                var allow_refund_block = $('#allow_refund_block');

                allow_refund.on('switchChange.bootstrapSwitch', function(e, data) {
                    if ($(this).prop('checked')) {
                        allow_refund_block.css({display: 'block'});
                    } else {
                        allow_refund_block.css({display: 'none'});
                    }
                });
            };

            // sliders initializer
            var slidersInit = function () {
                var minimum_reserve_rate = $('input[id=minimum_reserve_rate]');
                var pre_reservation_refund_rate = $('input[id=pre_reservation_refund_rate]');
                var post_reservation_refund_rate = $('input[id=post_reservation_refund_rate]');

                minimum_reserve_rate.ionRangeSlider({
                    min: 1,
                    max: 100,
                    from: minimum_reserve_rate.val(),
                    postfix: "%"
                });

                pre_reservation_refund_rate.ionRangeSlider({
                    min: 1,
                    max: 100,
                    from: pre_reservation_refund_rate.val(),
                    postfix: "%"
                });

                post_reservation_refund_rate.ionRangeSlider({
                    min: 1,
                    max: 100,
                    from: post_reservation_refund_rate.val(),
                    postfix: "%"
                });
            };
            //. sliders initializer

            return {
                init: function() {
                    selectsInit();
                    switchesInit();
                    slidersInit();
                },
            };
        }();

        $(document).ready(function() {
            settings.init();
        });
    </script>
@endsection