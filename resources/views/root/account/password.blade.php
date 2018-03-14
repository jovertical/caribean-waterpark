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

                            <h3 class="m-portlet__head-text">Password</h3>
                        </div>
                    </div>
                </div>

                <form method="POST" action="{{ route('root.account.password') }}"
                    class="m-form m-form--fit m-form--label-align-right" id="form-password-update">
                    {{ csrf_field() }}
                    {{ method_field('PATCH') }}

                    <div class="m-portlet__body">
                        <!-- Old Password -->
                        <div class="form-group m-form__group row">
                            <label for="old_password" class="col-lg-2  col-form-label">
                                Old password <span class="m--font-danger">*</span>
                            </label>

                            <div class="col-lg-7">
                                <input type="password" name="old_password" id="old_password" class="form-control m-input">

                                @if ($errors->has('old_password'))
                                    <div id="old_password-error" class="form-control-feedback">
                                        <span class="m--font-danger">{{ $errors->first('old_password') }}</span>
                                    </div>
                                @endif
                            </div>
                        </div>
                        <!--/. Old Password -->

                        <!-- New Password -->
                        <div class="form-group m-form__group row">
                            <label for="password" class="col-lg-2 col-form-label">
                                New password <span class="m--font-danger">*</span>
                            </label>
                            <div class="col-lg-7">
                                <input type="password" name="password" id="password" class="form-control m-input">

                                @if ($errors->has('password'))
                                    <div id="password-error" class="form-control-feedback">
                                        <span class="m--font-danger">{{ $errors->first('password') }}</span>
                                    </div>
                                @endif
                            </div>
                        </div>
                        <!--/. New Password -->

                        <!-- Password confirmation -->
                        <div class="form-group m-form__group row">
                            <label for="password_confirmation" class="col-lg-2 col-form-label">
                                Password confirmation <span class="m--font-danger">*</span>
                            </label>

                            <div class="col-lg-7">
                                <input type="password" name="password_confirmation" id="password_confirmation"
                                    class="form-control m-input">

                                @if ($errors->has('password_confirmation'))
                                    <div id="password_confirmation-error" class="form-control-feedback">
                                        <span class="m--font-danger">{{ $errors->first('password_confirmation') }}</span>
                                    </div>
                                @endif
                            </div>
                        </div>
                        <!--/. Password confirmation -->
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
        var password = function () {
            // form validate
            var formValidationInit = function () {
                $("form[id=form-password-update]").validate({
                    rules: {
                        old_password: {
                            required: true,
                            minlength: 6
                        },
                        password: {
                            required: true,
                            minlength: 6,
                        },
                        password_confirmation: {
                            required: true,
                            minlength: 6,
                            equalTo: '#password'
                        }
                    },

                    invalidHandler: function(event, validator) {
                        var form = $('form[id=form-password-update]');

                        mApp.scrollTo(form, -200);
                    },
                });
            }
            //. form validate

            // input masks
            var inputMasksInit = function () {

            }
            // input masks

            return {
                init: function() {
                    formValidationInit();
                    inputMasksInit();
                }
            };
        }();

        $(document).ready(function() {
            password.init();
        });
    </script>
@endsection