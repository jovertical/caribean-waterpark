@extends('root.layouts.main')

@section('sidebar')
    @component('root.components.sidebar')
    @endcomponent
@endsection

@section('content')
    <div class="m-portlet">
        <div class="m-portlet__head">
            <div class="m-portlet__head-caption">
                <div class="m-portlet__head-title">
                    <span class="m-portlet__head-icon m--hide"><i class="la la-gear"></i></span>

                    <h3 class="m-portlet__head-text">Create superuser</h3>
                </div>
            </div>
        </div>

        <form method="POST" action="{{ route('root.superusers.store') }}" id="form-superuser-store" class="m-form m-form--fit m-form--label-align-right m-form--group-seperator-dashed m-form--state">
            {{ csrf_field() }}

            <div class="m-portlet__body">
                <!-- Firstname -->
                <div class="form-group m-form__group row {{ $errors->has('first_name') ? 'has-danger' : '' }}">
                    <label for="first_name" class="col-lg-2 col-form-label">
                        Firstname <span class="m--font-danger">*</span>
                    </label>

                    <div class="col-lg-6">
                        <input type="text" name="first_name" id="first_name" class="form-control m-input
                            {{ $errors->has('first_name') ? 'form-control-danger' :'' }}" placeholder="Please enter a firstname"
                                value="{{ old('first_name') }}" required maxlength="255">

                        <div id="first_name-error" class="form-control-feedback">
                            <span class="m--font-danger">{{ $errors->first('first_name') }}</span>
                        </div>

                        <span class="m-form__help"></span>
                    </div>
                </div>
                <!--/. Firstname -->

                <!-- Middlename -->
                <div class="form-group m-form__group row {{ $errors->has('middle_name') ? 'has-danger' : '' }}">
                    <label for="middle_name" class="col-lg-2 col-form-label">
                        Middlename
                    </label>

                    <div class="col-lg-6">
                        <input type="text" name="middle_name" id="middle_name" class="form-control m-input
                            {{ $errors->has('middle_name') ? 'form-control-danger' :'' }}"
                                placeholder="Please enter a middlename" value="{{ old('middle_name') }}" maxlength="255">

                        <div id="middle_name-error" class="form-control-feedback">
                            <span class="m--font-danger">{{ $errors->first('middle_name') }}</span>
                        </div>

                        <span class="m-form__help"></span>
                    </div>
                </div>
                <!--/. Middlename -->

                <!-- Lastname -->
                <div class="form-group m-form__group row {{ $errors->has('last_name') ? 'has-danger' : '' }}">
                    <label for="last_name" class="col-lg-2 col-form-label">
                        Lastname <span class="m--font-danger">*</span>
                    </label>

                    <div class="col-lg-6">
                        <input type="text" name="last_name" id="last_name" class="form-control m-input
                            {{ $errors->has('last_name') ? 'form-control-danger' :'' }}" placeholder="Please enter a lastname"
                                value="{{ old('last_name') }}" required maxlength="255">

                        <div id="last_name-error" class="form-control-feedback">
                            <span class="m--font-danger">{{ $errors->first('last_name') }}</span>
                        </div>

                        <span class="m-form__help"></span>
                    </div>
                </div>
                <!--/. Lastname -->

                <!-- Email -->
                <div class="form-group m-form__group row {{ $errors->has('name') ? 'has-danger' : '' }}">
                    <label for="email" class="col-lg-2 col-form-label">
                        Email <span class="m--font-danger">*</span>
                    </label>

                    <div class="col-lg-6">
                        <input type="email" name="email" id="email" class="form-control m-input
                            {{ $errors->has('email') ? 'form-control-danger' :'' }}" placeholder="Please enter an email"
                                value="{{ old('email') }}" required maxlength="255">

                        <div id="email-error" class="form-control-feedback">
                            <span class="m--font-danger">{{ $errors->first('email') }}</span>
                        </div>

                        <span class="m-form__help"></span>
                    </div>
                </div>
                <!--/. Email -->

                <!-- Birthdate -->
                <div class="form-group m-form__group row {{ $errors->has('birthdate') ? 'has-danger' : '' }}">
                    <label for="birthdate" class="col-lg-2 col-form-label">
                        Birthdate <span class="m--font-danger">*</span>
                    </label>

                    <div class="col-lg-6">
                        <div class="input-group m-input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="la la-calendar"></i></span>
                            </div>

                            <input type="text" name="birthdate" id="birthdate" class="form-control m-input
                                {{ $errors->has('birthdate') ? 'form-control-danger' :'' }}" placeholder="Please enter birthdate"
                                    value="{{ old('birthdate') }}" required readonly>
                        </div>

                        <div id="birthdate-error" class="form-control-feedback">
                            <span class="m--font-danger">{{ $errors->first('birthdate') }}</span>
                        </div>

                        <span class="m-form__help"></span>
                    </div>
                </div>
                <!--/. Birthdate -->

                <!-- Gender -->
                <div class="form-group m-form__group row {{ $errors->has('gender') ? 'has-danger' : '' }}">
                    <label for="gender" class="col-lg-2 col-form-label">
                        Gender <span class="m--font-danger">*</span>
                    </label>

                    <div class="col-lg-6">
                        <select name="gender" id="gender" class="form-control m-bootstrap-select" required>
                            <option value="" disabled selected>Please select gender</option>
                            <option value="male" {{ old('gender') == 'male' ? 'selected' : '' }}>Male</option>
                            <option value="female" {{ old('gender') == 'female' ? 'selected' : '' }}>Female</option>
                        </select>

                        <div id="gender-error" class="form-control-feedback">
                            <span class="m--font-danger">{{ $errors->first('gender') }}</span>
                        </div>

                        <span class="m-form__help"></span>
                    </div>
                </div>
                <!--/. Gender -->

                <!-- Address -->
                <div class="form-group m-form__group row {{ $errors->has('address') ? 'has-danger' : '' }}">
                    <label for="address" class="col-lg-2 col-form-label">
                        Address <span class="m--font-danger">*</span>
                    </label>

                    <div class="col-lg-6">
                        <textarea name="address" id="address" class="form-control m-input" {{ $errors->has('address') ?
                            'form-control-danger' :'' }} required rows="3">{{ old('address') }}</textarea>

                        <div id="address-error" class="form-control-feedback">
                            <span class="m--font-danger">{{ $errors->first('address') }}</span>
                        </div>
                    </div>
                </div>
                <!--/. Address -->

                <!-- Phone number -->
                <div class="form-group m-form__group row {{ $errors->has('last_name') ? 'has-danger' : '' }}">
                    <label for="last_name" class="col-lg-2 col-form-label">Phone number: </label>

                    <div class="col-lg-6">
                        <div class="input-group m-input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="la la-phone"></i></span>
                            </div>

                            <input type="number" name="phone_number" id="phone_number" class="form-control m-input
                                {{ $errors->has('phone_number') ? 'form-control-danger' :'' }}"
                                    placeholder="Please enter phone number" value="{{ old('phone_number') }}" maxlength="255">
                        </div>

                        <div id="phone_number-error" class="form-control-feedback">
                            <span class="m--font-danger">{{ $errors->first('phone_number') }}</span>
                        </div>

                        <span class="m-form__help"></span>
                    </div>
                </div>
                <!--/. Phone number -->

                <!-- Bottom -->
                <div class="m-portlet__foot m-portlet__no-border m-portlet__foot--fit">
                    <div class="m-form__actions m-form__actions--solid">
                        <div class="row">
                            <div class="col-lg-2"></div>
                            <div class="col-lg-6">
                                <button type="submit" id="submit" class="btn btn-brand">Create</button>
                                <a href="{{ route('root.superusers.index') }}" class="btn btn-secondary">Cancel</a>
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
        var superuser = function () {
            // form validate
            var formValidationInit = function () {
                $("form[id=form-superuser-store]").validate({
                    rules: {
                        category: {
                            required: true
                        },

                        name: {
                            required: true,
                            maxlength: 255
                        },

                        description: {
                            maxlength: 500
                        },

                        price: {
                            required: true
                        }
                    },

                    invalidHandler: function(event, validator) {
                        var form = $('form[id=form-superuser-update]');

                        $('button[type=submit]').removeClass('m-loader m-loader--light m-loader--right');

                        mApp.scrollTo(form, -200);
                    },
                });
            }
            //. form validate

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
                $('select[id=gender]').selectpicker({
                    //
                });
            }
            //. select

            return {
                init: function() {
                    formValidationInit();
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