@extends('root.layouts.main')

@section('content')
    <!-- begin:: Page -->
    <div class="m-grid m-grid--hor m-grid--root m-page">
        <div class="m-grid__item m-grid__item--fluid m-grid m-grid--hor m-login m-login--signin m-login--2 m-login-2--skin-2" id="m_login" style="background-image: url(/root/assets/app/media/img//bg/bg-3.jpg);">
            <div class="m-grid__item m-grid__item--fluid    m-login__wrapper">
                <div class="m-login__container">
                    <div class="m-login__logo">
                        <a href="#">
                            <img src="/root/assets/app/media/img//logos/logo-1.png">
                        </a>
                    </div>

                    <div class="m-login__signin">
                        <div class="m-login__head">
                            <h3 class="m-login__title">Reset password</h3>
                        </div>

                        <form method="POST" action="{{ route('root.password.reset', $token) }}" class="m-login__form m-form">
                            {{ csrf_field() }}

                            <!-- Password -->
                            <div class="form-group m-form__group {{ $errors->has('password') ? 'has-danger' : '' }}">
                                <input type="password" name="password" id="password" class="form-control m-input" placeholder="New password" autocomplete="off">

                                <div class="form-control-feedback">{{ $errors->first('password') }}</div>
                            </div>
                            <!--/. Password -->

                            <!-- Password confirmation -->
                            <div class="form-group m-form__group {{ $errors->has('password_confirmation') ? 'has-danger' : '' }}">
                                <input type="password" name="password_confirmation" id="password_confirmation" class="form-control m-input" placeholder="Confirm new password" autocomplete="off">

                                <div class="form-control-feedback">{{ $errors->first('password_confirmation') }}</div>
                            </div>
                            <!--/. Password confirmation -->

                            <div class="row m-login__form-sub">
                                <div class="col m--align-right m-login__form-right">
                                    <a href="{{ route('root.login') }}" class="m-link">Back to login</a>
                                </div>
                            </div>

                            <!-- Submit -->
                            <div class="m-login__form-action">
                                <button type="submit" class="btn btn-focus m-btn m-btn--pill m-btn--custom m-btn--air m-login__btn m-login__btn--primary">Reset</button>
                            </div>
                            <!--/. Submit -->

                        </form>
                    </div>

                </div>
            </div>
        </div>

    </div>
    <!-- end:: Page -->
@endsection