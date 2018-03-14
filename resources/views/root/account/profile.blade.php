@extends('root.layouts.main')

@section('content')
    <div class="row">
        <div class="col-xl-3 col-lg-4">
            @include('root.account.partials.sidebar')
        </div>

        <div class="col-xl-9 col-lg-8">
            <div class="m-portlet m-portlet--full-height">
                <div class="m-portlet__head">
                    <div class="m-portlet__head-caption">
                        <div class="m-portlet__head-title">
                            <span class="m-portlet__head-icon m--hide"><i class="la la-gear"></i></span>

                            <h3 class="m-portlet__head-text">Profile</h3>
                        </div>
                    </div>
                </div>

                <form method="POST" action="{{ route('root.account.profile') }}" class="m-form m-form--fit m-form--label-align-right" id="form-profile-update">
                    {{ csrf_field() }}
                    {{ method_field('PATCH') }}

                    <div class="m-portlet__body">
                        <!-- First name -->
                        <div class="form-group m-form__group row">
                            <label for="first_name" class="col-lg-2  col-form-label">
                                First name <span class="m--font-danger">*</span>
                            </label>
                            <div class="col-lg-7">
                                <input type="text" name="first_name" id="first_name" class="form-control m-input"
                                    value="{{ old('first_name') ?? $superuser->first_name }}">

                                @if ($errors->has('first_name'))
                                    <div id="first_name-error" class="form-control-feedback">
                                        <span class="m--font-danger">{{ $errors->first('first_name') }}</span>
                                    </div>
                                @endif
                            </div>
                        </div>
                        <!--/. First name -->

                        <!-- Middle name -->
                       <div class="form-group m-form__group row">
                            <label for="middle_name" class="col-lg-2 col-form-label">
                                Middle name
                            </label>
                            <div class="col-lg-7">
                                <input type="text" name="middle_name" id="middle_name" class="form-control m-input"
                                    value="{{ old('middle_name') ?? $superuser->middle_name }}">

                                @if ($errors->has('middle_name'))
                                    <div id="middle_name-error" class="form-control-feedback">
                                        <span class="m--font-danger">{{ $errors->first('middle_name') }}</span>
                                    </div>
                                @endif
                            </div>
                        </div>
                        <!--/. Middle name -->

                        <!-- Last name -->
                        <div class="form-group m-form__group row">
                            <label for="last_name" class="col-lg-2 col-form-label">
                                Last name <span class="m--font-danger">*</span>
                            </label>

                            <div class="col-lg-7">
                                <input type="text" name="last_name" id="last_name" class="form-control m-input"
                                    value="{{ old('last_name') ?? $superuser->last_name }}">

                                @if ($errors->has('last_name'))
                                    <div id="last_name-error" class="form-control-feedback">
                                        <span class="m--font-danger">{{ $errors->first('last_name') }}</span>
                                    </div>
                                @endif
                            </div>
                        </div>
                        <!--/. Last name -->

                        <!-- Email -->
                        <div class="form-group m-form__group row">
                            <label for="email" class="col-lg-2 col-form-label">
                                Email <span class="m--font-danger">*</span>
                            </label>
                            <div class="col-lg-7">
                                <input type="text" name="email" id="email" class="form-control m-input"
                                    value="{{ old('email') ?? $superuser->email }}">

                                @if ($errors->has('email'))
                                    <div id="email-error" class="form-control-feedback">
                                        <span class="m--font-danger">{{ $errors->first('email') }}</span>
                                    </div>
                                @endif

                                <span class="m-form__help"></span>
                            </div>
                        </div>
                        <!--/. Email -->

                        <!-- Birthdate -->
                        <div class="form-group m-form__group row">
                            <label for="birthdate" class="col-lg-2 col-form-label">Birthdate</label>

                            <div class="col-lg-7">
                                <div class="input-group m-input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="la la-calendar"></i></span>
                                    </div>

                                    <input type="text" name="birthdate" id="birthdate" class="form-control m-input
                                        {{ $errors->has('birthdate') ? 'form-control-danger' :'' }}"
                                            value="{{ old('birthdate') ?? $superuser->birthdate }}" readonly>
                                </div>

                                @if ($errors->has('birthdate'))
                                    <div id="birthdate-error" class="form-control-feedback">
                                        <span class="m--font-danger">{{ $errors->first('birthdate') }}</span>
                                    </div>
                                @endif

                                <span class="m-form__help"><code>yyyy-mm-dd</code></span>
                            </div>
                        </div>
                        <!--/. Birthdate -->

                        <!-- Gender -->
                        <div class="form-group m-form__group row">
                            <label for="gender" class="col-lg-2 col-form-label">Gender</label>
                            <div class="col-lg-7">
                                <select name="gender" id="gender" class="form-control m-bootstrap-select">
                                    <option value="" disabled selected>Please select gender</option>
                                    <option value="male" {{ strtolower(old('gender') ?? $superuser->gender) ==
                                        'male' ? 'selected' : '' }}>Male</option>
                                    <option value="female" {{ strtolower(old('gender') ?? $superuser->gender) ==
                                        'female' ? 'selected' : '' }}>Female</option>
                                </select>

                                @if ($errors->has('gender'))
                                    <div id="gender-error" class="form-control-feedback">
                                        <span class="m--font-danger">{{ $errors->first('gender') }}</span>
                                    </div>
                                @endif

                                <span class="m-form__help"></span>
                            </div>
                        </div>
                        <!--/. Gender -->

                        <!-- Address -->
                        <div class="form-group m-form__group row">
                            <label for="address" class="col-lg-2 col-form-label">Address</label>
                            <div class="col-lg-7">
                                <textarea name="address" id="address" class="form-control m-input"
                                    {{ $errors->has('address') ? 'form-control-danger' :'' }} rows="3">{{
                                        old('address') ?? $superuser->address }}</textarea>

                                @if ($errors->has('address'))
                                    <div id="address-error" class="form-control-feedback">
                                        <span class="m--font-danger">{{ $errors->first('address') }}</span>
                                    </div>
                                @endif

                                <span class="m-form__help"></span>
                            </div>
                        </div>
                        <!--/. Address -->

                        <!-- Phone no. -->
                        <div class="form-group m-form__group row">
                            <label for="phone_number" class="col-lg-2 col-form-label">Phone no.</label>
                            <div class="col-lg-7">
                               <div class="input-group m-input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="la la-phone"></i></span>
                                    </div>
                                    <input type="text" name="phone_number" id="phone_number" class="form-control m-input"
                                        value="{{ old('phone_number') ?? $superuser->phone_number }}">
                                </div>

                                @if ($errors->has('phone_number'))
                                    <div id="phone_number-error" class="form-control-feedback">
                                        <span class="m--font-danger">{{ $errors->first('phone_number') }}</span>
                                    </div>
                                @endif

                                <span class="m-form__help"><code>(+63) 9**-*******</code></span>
                            </div>
                        </div>
                        <!--/. Phone no. -->
                    </div>

                    <!-- Bottom -->
                    <div class="m-portlet__foot m-portlet__no-border m-portlet__foot--fit">
                        <div class="m-form__actions m-form__actions--solid">
                            <div class="row">
                                <div class="col-lg-2"></div>
                                <div class="col-lg-6">
                                    <button type="submit" id="submit" class="btn btn-brand">Update</button>
                                    <a href="{{ route('root.home') }}" class="btn btn-secondary">Cancel</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--/. Bottom -->
                </form>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        var superuser = function () {
            // form validate
            var formValidationInit = function () {
                $("form[id=form-profile-update]").validate({
                    rules: {
                        first_name: {
                            required: true,
                            maxlength: 255
                        },
                        middle_name: {
                            maxlength: 255
                        },
                        last_name: {
                            required: true,
                            maxlength: 255
                        },
                        email: {
                            email: true,
                            required: true,
                            maxlength: 255
                        },
                        address: {
                            maxlength: 510
                        },
                        phone_number: {
                            maxlength: 255
                        }
                    },

                    invalidHandler: function(event, validator) {
                        var form = $('form[id=form-profile-update]');

                        mApp.scrollTo(form, -200);
                    },
                });
            }
            //. form validate

            // input masks
            var inputMasksInit = function () {
                // email
                $('input[id=email]').inputmask({
                    mask: "*{1,20}[.*{1,20}][.*{1,20}][.*{1,20}]@*{1,20}[.*{2,6}][.*{1,2}]",
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
                    "mask": "(+63) ***-*******"
                });
                //. phone number
            }
            // input masks

            // dates
            var datesInit = function () {
                $('input[id=birthdate]').datepicker({
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
            //. dates

            // select
            var selectInit = function () {
                $('select[id=gender]').selectpicker();
            }
            //. select

            return {
                init: function() {
                    formValidationInit();
                    inputMasksInit();
                    datesInit();
                    selectInit();
                }
            };
        }();

        $(document).ready(function() {
            superuser.init();
        });
    </script>
@endsection