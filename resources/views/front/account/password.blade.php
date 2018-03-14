@extends('front.layouts.main')

@section('content')
    <section class="checkout-section-demo">
        <div class="container">
            <div class="row">
                <div class="col-lg-3">
                    @include('front.partials.sidebar')
                </div>

                <div class="col-lg-9">
                    <div class="checkout-page__content">
                        <div class="yourcart-content">
                            <!-- Message -->
                            @if (Session::has('message'))
                                @component('front.components.alert')
                                    {!! Session::get('message.content') !!}
                                @endcomponent
                            @endif

                            <div class="content-title">
                                <h2><i class="awe-icon awe-icon-key"></i>My password</h2>
                            </div>

                            <div class="woocommerce-billing-fields">
                                <form method="POST" action="{{ route('front.account.password') }}">
                                    {{ method_field('PATCH') }}
                                    {{ csrf_field() }}

                                    <div class="display-inline width-100">
                                        <div class="form-row width-50 padding-x-4">
                                            <label>Old password <span class="text-danger">*</span></label>
                                            <input type="password" name="old_password" id="old_password">
                                            <span id="old_password-error" class="text-danger">
                                                {{ $errors->first('old_password') }}
                                            </span>
                                        </div>
                                    </div>

                                    <div class="display-inline width-100">
                                        <div class="form-row width-50 padding-x-4">
                                            <label>New password <span class="text-danger">*</span></label>
                                            <input type="password" name="password" id="password">
                                            <span id="password-error" class="text-danger">
                                                {{ $errors->first('password') }}
                                            </span>
                                        </div>
                                    </div>

                                    <div class="display-inline width-100">
                                        <div class="form-row width-50 padding-x-4">
                                            <label>Confirm new password <span class="text-danger">*</span></label>
                                            <input type="password" name="password_confirmation" id="password_confirmation">
                                            <span id="password_confirmation-error" class="text-danger">
                                                {{ $errors->first('password_confirmation') }}
                                            </span>
                                        </div>
                                    </div>

                                    <div class="display-inline width-100">
                                        <div class="form-row padding-x-2">
                                            <button type="submit" class="button button-primary">Update</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection