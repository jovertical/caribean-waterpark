@extends('root.layouts.lite')

@section('content')
    <!-- begin:: Page -->
    <div class="m-grid m-grid--hor m-grid--root m-page">
        <div class="m-grid__item m-grid__item--fluid m-grid m-grid--hor m-login m-login--signin m-login--2 m-login-2--skin-2" id="m_login" style="background-image: url(/root/assets/app/media/img/bg/bg-3.jpg);">
            <div class="m-grid__item m-grid__item--fluid    m-login__wrapper">
                <div class="m-login__container">
                    <div class="m-login__logo">
                        <a href="#">
                            <img src="/root/assets/app/media/img/logos/logo-1.png">
                        </a>
                    </div>

                    <div class="m-login__signin">
                        <div class="m-login__head">
                            <h3 class="m-login__title">Forgot password?</h3>
                        </div>

                        <form method="POST" action="{{ route('root.password.email') }}" class="m-login__form m-form">
                            {{ csrf_field() }}

                            <!-- Message -->
                            @if (Session::has('message'))
                                <div class="m-section__content">
                                    <div class="alert alert-info alert-dismissible" role="alert">
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"></button>
                                        {{ Session::get('message.content') }}
                                    </div>
                                </div>
                            @endif

                            <!-- Email -->
                            <div class="form-group m-form__group {{ $errors->has('email') ? 'has-danger' : '' }}">
                                <input type="email" name="email" id="email" class="form-control m-input" placeholder="Enter your email" autocomplete="off" value="{{ old('email') }}">

                                <div class="form-control-feedback">{{ $errors->first('email') }}</div>
                            </div>
                            <!--/. Email -->

                            <div class="row m-login__form-sub">
                                <div class="col m--align-right m-login__form-right">
                                    <a href="{{ route('root.login') }}" class="m-link">Back to login</a>
                                </div>
                            </div>

                            <!-- Submit -->
                            <div class="m-login__form-action">
                                <button type="submit" class="btn btn-focus m-btn m-btn--pill m-btn--custom m-btn--air m-login__btn m-login__btn--primary">Send link</button>
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