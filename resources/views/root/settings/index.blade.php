@extends('root.layouts.main')

@section('sidebar')
    @component('root.components.sidebar')@endcomponent
@endsection

@section('content')
    <div class="m-portlet m-portlet--full-height m-portlet--tabs">
        <div class="m-portlet__head">
            <div class="m-portlet__head-tools">
                <ul class="nav nav-tabs m-tabs m-tabs-line   m-tabs-line--left m-tabs-line--primary" role="tablist">
                    <li class="nav-item m-tabs__item">
                        <a class="nav-link m-tabs__link" data-toggle="tab" href="#company_tab" role="tab" aria-selected="false">
                            <i class="flaticon-share m--hide"></i>
                            Company
                        </a>
                    </li>
                    <li class="nav-item m-tabs__item">
                        <a class="nav-link m-tabs__link" data-toggle="tab" href="#reservation_tab" role="tab" aria-selected="false">
                            Reservation
                        </a>
                    </li>
                </ul>
            </div>
        </div>

        <!-- Tab content -->
        <div class="tab-content">
            <!-- Company Tab -->
            <div class="tab-pane active" id="company_tab">
                <form method="POST" action="{{ route('root.settings.company.update') }}" class="m-form m-form--fit m-form--label-align-right m-form--group-seperator-dashed" id="form-company-settings-update">
                    @method('PATCH')
                    @csrf

                    <div class="m-portlet__body">
                        <div class="form-group m-form__group row">
                            <div class="col-10 ml-auto">
                                <h3 class="m-form__section">1. Profile</h3>
                            </div>
                        </div>

                        <!-- Name -->
                        <div class="form-group m-form__group row {{ $errors->has('name') ? 'has-danger' : '' }}" required>
                            <label for="name" class="col-lg-2 col-form-label">
                                Name <span class="m--font-danger">*</span>
                            </label>

                            <div class="col-lg-6">
                                <input type="text" name="name" id="name" class="form-control m-input {{ $errors->has('name') ?
                                    'form-control-danger' :'' }}" placeholder="Please enter a company name" 
                                        value="{{ old('name') ?? $settings['company_name'] }}">

                                <div id="name-error" class="form-control-feedback">
                                    <span class="m--font-danger">{{ $errors->first('name') }}</span>
                                </div>

                                <span class="m-form__help">The name of the company.</span>
                            </div>
                        </div>
                        <!--/. Name -->

                        <!-- Email -->
                        <div class="form-group m-form__group row {{ $errors->has('email') ? 'has-danger' : '' }}">
                            <label for="email" class="col-lg-2 col-form-label">
                                Email <span class="m--font-danger">*</span>
                            </label>

                            <div class="col-lg-6">
                                <input type="text" name="email" id="email" class="form-control m-input
                                    {{ $errors->has('email') ? 'form-control-danger' :'' }}" placeholder="Please enter a company email" value="{{ old('email') ?? $settings['company_email'] }}">

                                @if ($errors->has('email'))
                                    <div id="email-error" class="form-control-feedback">
                                        <span class="m--font-danger">{{ $errors->first('email') }}</span>
                                    </div>
                                @endif

                                <span class="m-form__help">
                                    The company email (displayed on client side).
                                </span>
                            </div>
                        </div>
                        <!--/. Email -->

                        <!-- Phone number -->
                        <div class="form-group m-form__group row {{ $errors->has('phone_number') ? 'has-danger' : '' }}">
                            <label for="phone_number" class="col-lg-2 col-form-label">
                                Phone number
                            </label>

                            <div class="col-lg-6">
                                <div class="input-group m-input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="la la-phone"></i></span>
                                    </div>

                                    <input type="text" name="phone_number" id="phone_number" class="form-control m-input
                                        {{ $errors->has('phone_number') ? 'form-control-danger' :'' }}"
                                            placeholder="Please enter phone number" value="{{ old('phone_number') ?? 
                                                $settings['company_phone_number'] }}">
                                </div>

                                @if ($errors->has('phone_number'))
                                    <div id="phone_number-error" class="form-control-feedback">
                                        <span class="m--font-danger">
                                            {{ $errors->first('phone_number') }}
                                        </span>
                                    </div>
                                @endif

                                <span class="m-form__help">
                                    The company phone number (displayed on client side).
                                </span>
                            </div>
                        </div>
                        <!--/. Phone number -->

                        <div class="form-group m-form__group row">
                            <div class="col-10 ml-auto">
                                <h3 class="m-form__section">2. Social Links</h3>
                            </div>
                        </div>

                        <!-- Facebook -->
                        <div class="form-group m-form__group row {{ $errors->has('facebook_url') ? 'has-danger' : '' }}" required>
                            <label for="facebook_url" class="col-lg-2 col-form-label">
                                Facebook
                            </label>

                            <div class="col-lg-6">
                                <input type="text" name="facebook_url" id="facebook_url" class="form-control m-input {{ $errors->has('facebook_url') ? 'form-control-danger' :'' }}" placeholder="Please enter your facebook link" 
                                        value="{{ old('twitter_url') ?? $settings['company_facebook_url'] }}">

                                <div id="facebook_url-error" class="form-control-feedback">
                                    <span class="m--font-danger">
                                        {{ $errors->first('facebook_url') }}
                                    </span>
                                </div>

                                <span class="m-form__help"></span>
                            </div>
                        </div>
                        <!--/. Facebook -->

                        <!-- Twitter -->
                        <div class="form-group m-form__group row {{ $errors->has('twitter_url') ? 'has-danger' : '' }}" required>
                            <label for="twitter_url" class="col-lg-2 col-form-label">
                                Twitter
                            </label>

                            <div class="col-lg-6">
                                <input type="text" name="twitter_url" id="twitter_url" class="form-control m-input {{ $errors->has('twitter_url') ? 'form-control-danger' :'' }}" placeholder="Please enter your twitter link" 
                                        value="{{ old('twitter_url') ?? $settings['company_twitter_url']  }}">

                                <div id="twitter_url-error" class="form-control-feedback">
                                    <span class="m--font-danger">{{ $errors->first('twitter_url') }}</span>
                                </div>

                                <span class="m-form__help"></span>
                            </div>
                        </div>
                        <!--/. Twitter -->

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
            <!--/. Company Tab -->

            <!-- Reservation Tab -->
            <div class="tab-pane" id="reservation_tab">
                <form method="POST" action="{{ route('root.settings.reservation.update') }}" class="m-form m-form--fit m-form--label-align-right m-form--group-seperator-dashed" id="form-settings-reservation-update">
                    @method('PATCH')
                    @csrf

                    <div class="m-portlet__body">
                        <!-- Days prior -->
                        <div class="form-group m-form__group row">
                            <label class="col-form-label col-lg-3 col-sm-12">Days prior: </label>
                            <div class="col-lg-4 col-md-9 col-sm-12">
                                <select name="days_prior" id="days_prior" class="form-control m-bootstrap-select">
                                    <option value="0" selected>0</option>
                                    <option value="1" {{ $settings['days_prior'] == '1' ? 'selected' : '' }}>1</option>
                                    <option value="2" {{ $settings['days_prior'] == '2' ? 'selected' : '' }}>2</option>
                                    <option value="3" {{ $settings['days_prior'] == '3' ? 'selected' : '' }}>3</option>
                                    <option value="4" {{ $settings['days_prior'] == '4' ? 'selected' : '' }}>4</option>
                                    <option value="5" {{ $settings['days_prior'] == '5' ? 'selected' : '' }}>5</option>
                                    <option value="6" {{ $settings['days_prior'] == '6' ? 'selected' : '' }}>6</option>
                                    <option value="7" {{ $settings['days_prior'] == '7' ? 'selected' : '' }}>7</option>
                                    <option value="8" {{ $settings['days_prior'] == '8' ? 'selected' : '' }}>8</option>
                                    <option value="9" {{ $settings['days_prior'] == '9' ? 'selected' : '' }}>9</option>
                                </select>

                                <span class="m-form__help">Allowed number of days prior to today.</span>
                            </div>
                        </div>
                        <!--/. Days prior -->

                        <!-- Minimum reservation length -->
                        <div class="form-group m-form__group row">
                            <label class="col-form-label col-lg-3 col-sm-12">Minimum length: </label>
                            <div class="col-lg-4 col-md-9 col-sm-12">
                                <div class="m-ion-range-slider">
                                    <input type="number" name="minimum_reservation_length" id="minimum_reservation_length"
                                        class="form-control m-input" value="{{ $settings['minimum_reservation_length'] }}">
                                </div>
                                <span class="m-form__help">Minimum number of days for a reservation.</span>
                            </div>
                        </div>
                        <!--/. Minimum reservation length -->

                        <!-- Maximum reservation length -->
                        <div class="form-group m-form__group row">
                            <label class="col-form-label col-lg-3 col-sm-12">Maximum length: </label>
                            <div class="col-lg-4 col-md-9 col-sm-12">
                                <div class="m-ion-range-slider">
                                    <input type="number" name="maximum_reservation_length" id="maximum_reservation_length"
                                        class="form-control m-input" value="{{ $settings['maximum_reservation_length'] }}">
                                </div>
                                <span class="m-form__help">Maximum number of days for a reservation.</span>
                            </div>
                        </div>
                        <!--/. Maximum reservation length -->

                        <!-- Partial payment rate -->
                        <div class="form-group m-form__group row">
                            <label class="col-form-label col-lg-3 col-sm-12">Partial payment rate: </label>
                            <div class="col-lg-4 col-md-9 col-sm-12">
                                <div class="m-ion-range-slider">
                                    <input type="hidden" name="partial_payment_rate" id="partial_payment_rate" data-min-value="1"
                                        data-max-value="100" disabled="disabled" value="{{ $settings['partial_payment_rate'] }}">
                                </div>
                                <span class="m-form__help">Partial payment rate required for a reservation to be reserved.</span>
                            </div>
                        </div>
                        <!--/. Partial payment rate -->

                        <!-- Tax rate -->
                        <div class="form-group m-form__group row">
                            <label class="col-form-label col-lg-3 col-sm-12">Tax rate: </label>
                            <div class="col-lg-4 col-md-9 col-sm-12">
                                <div class="m-ion-range-slider">
                                    <input type="hidden" name="tax_rate" id="tax_rate" data-min-value="1"
                                        data-max-value="100" disabled="disabled" value="{{ $settings['tax_rate'] }}">
                                </div>
                                <span class="m-form__help">Applied tax rate to each items. (inclusive)</span>
                            </div>
                        </div>
                        <!--/. Tax rate -->

                        <!-- Refunds -->
                        <div class="form-group m-form__group row">
                            <label class="col-form-label col-lg-3 col-sm-12">Refunds: </label>
                            <div class="col-lg-4 col-md-9 col-sm-12">
                                <span id="allow_refund_icon" class="m-switch m-switch--lg m-switch--icon
                                    {{ $settings['allow_refund'] ? ' m-switch--success' : ' m-switch--danger' }}  ">
                                    <label>
                                        <input type="checkbox" name="allow_refund" id="allow_refund"
                                            {{ $settings['allow_refund'] ? 'checked="checked"' : '' }}">
                                        <span></span>
                                    </label>
                                </span>
                                <span class="m-form__help"></span>
                            </div>
                        </div>
                        <!--/. Refunds -->

                        <!-- Allow refund block -->
                        <div id="allow_refund_block" style="display: {{ $settings['allow_refund'] ? '' : 'none' }};">
                            <!-- Days refundable -->
                            <div class="form-group m-form__group row">
                                <label class="col-form-label col-lg-3 col-sm-12">Days refundable: </label>
                                <div class="col-lg-4 col-md-9 col-sm-12">
                                    <select name="days_refundable" id="days_refundable" class="form-control m-bootstrap-select">
                                        <option value="0" selected>0</option>
                                        <option value="1" {{ $settings['days_refundable'] == '1' ? 'selected' : '' }}>1</option>
                                        <option value="2" {{ $settings['days_refundable'] == '2' ? 'selected' : '' }}>2</option>
                                        <option value="3" {{ $settings['days_refundable'] == '3' ? 'selected' : '' }}>3</option>
                                        <option value="4" {{ $settings['days_refundable'] == '4' ? 'selected' : '' }}>4</option>
                                        <option value="5" {{ $settings['days_refundable'] == '5' ? 'selected' : '' }}>5</option>
                                        <option value="6" {{ $settings['days_refundable'] == '6' ? 'selected' : '' }}>6</option>
                                        <option value="7" {{ $settings['days_refundable'] == '7' ? 'selected' : '' }}>7</option>
                                        <option value="8" {{ $settings['days_refundable'] == '8' ? 'selected' : '' }}>8</option>
                                        <option value="9" {{ $settings['days_refundable'] == '9' ? 'selected' : '' }}>9</option>
                                    </select>

                                    <span class="m-form__help">
                                        Allowed number of days prior to the reservation checkin date for requested refunds.
                                    </span>
                                </div>
                            </div>
                            <!--/. Days refundable -->

                            <!-- Refundable rate -->
                            <div class="form-group m-form__group row">
                                <label class="col-form-label col-lg-3 col-sm-12">Refundable rate: </label>
                                <div class="col-lg-4 col-md-9 col-sm-12">
                                    <div class="m-ion-range-slider">
                                        <input type="hidden" name="refundable_rate" id="refundable_rate"
                                            data-min-value="1" data-max-value="100" value="{{ $settings['refundable_rate'] }}"
                                                disabled="disabled">
                                    </div>
                                    <span class="m-form__help">Returnable rate of a cancelled reservation.</span>
                                </div>
                            </div>
                            <!--/. Refundable rate -->
                        </div>
                        <!--/. Allow refund block -->

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
        </div>
        <!--/. Tab content -->
    </div>
@endsection

@section('scripts')
    <script>
        var companySettings = function() {
            // form validator init
            var formValidatorInit = function () {
                $("form[id=form-company-settings-update]").validate({
                    rules: {
                        name: {
                            required: true,
                            maxlength: 255
                        },
                        email: {
                            email: true,
                            required: true,
                            maxlength: 255
                        },
                        phone_number: {
                            maxlength: 255
                        }
                    },

                    invalidHandler: function(event, validator) {
                        var form = $('form[id=form-company-settings-update]');

                        mApp.scrollTo(form, -200);
                    },
                });
            }
            // .form validator init

            // input masks
            var inputMasksInit = function () {
                // email
                $('input[id=email]').inputmask({
                    mask: "*{1,50}[.*{1,50}][.*{1,50}][.*{1,50}]@*{1,50}[.*{2,6}][.*{1,2}]",
                    greedy: false,
                    onBeforePaste: function (pastedValue, opts) {
                        pastedValue = pastedValue.toLowerCase();
                        return pastedValue.replace("mailto:", "");
                    },
                    definitions: {
                        '*': {
                            validator: "[0-9A-Za-z!#$%&'*+/=?^_`{|}~\-]",
                            cardinality: 1,
                            casing: "lower"
                        }
                    }
                });
                //. email

                // phone number
                $('input[id=phone_number]').inputmask("mask", {
                    "mask": "(+63) 999-9999999"
                });
                //. phone number
            }
            // input masks

            return {
                init: function() {
                    inputMasksInit();
                    formValidatorInit();
                },
            };
        }();

        var reservationSettings = function() {
            //== Private functions

            // selects initializer
            var selectsInit = function () {
                $('select[id=days_prior]').selectpicker({});
                $('select[id=days_refundable]').selectpicker({});
            }
            //. selects

            // switches initializer
            var switchesInit = function() {
                var allow_refund = $('input[id=allow_refund]');
                var allow_refund_block = $('#allow_refund_block');
                var allow_refund_icon = $('#allow_refund_icon');

                allow_refund.on('change', function() {
                    if ($(this).prop('checked')) {
                        allow_refund_icon.addClass('m-switch--success');
                        allow_refund_icon.removeClass('m-switch--danger');
                        allow_refund_block.css({display: 'block'});
                    } else {
                        allow_refund_icon.addClass('m-switch--danger');
                        allow_refund_icon.removeClass('m-switch--success');
                        allow_refund_block.css({display: 'none'});
                    }
                });
            };

            // sliders initializer
            var slidersInit = function () {
                var partial_payment_rate = $('input[id=partial_payment_rate]');
                var tax_rate = $('input[id=tax_rate]');
                var refundable_rate = $('input[id=refundable_rate]');

                partial_payment_rate.ionRangeSlider({
                    min: 1,
                    max: 100,
                    from: partial_payment_rate.val(),
                    postfix: "%"
                });

                tax_rate.ionRangeSlider({
                    min: 1,
                    max: 100,
                    from: tax_rate.val(),
                    postfix: "%"
                });

                refundable_rate.ionRangeSlider({
                    min: 1,
                    max: 100,
                    from: refundable_rate.val(),
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
            companySettings.init();
            reservationSettings.init();
        });
    </script>
@endsection