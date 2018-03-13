@extends('front.layouts.main')

@section('content')
    <section class="awe-parallax login-page-demo">
        <div class="awe-overlay"></div>
        <div class="container">
            <div class="login-register-page__content">
                <div class="content-title" style="margin-bottom: 25px;">
                    <span style="color: #fff;">Welcome back! Our BELOVED</span>
                    <h2 style="color: #fff;">Guest</h2>
                </div>

                <!-- Message -->
                @if (Session::has('message'))
                    @component('front.components.alert')
                        {!! Session::get('message.content') !!}
                    @endcomponent
                @endif

                @if(count($errors))
                    @component('front.components.alert')
                        We cannot authenticate you. This may be due to wrong credentials or
                        your account has not yet been confirmed. Please try again.
                    @endcomponent
                @endif

                <form method="POST" action="{{ route('front.login') }}">
                    {{ csrf_field() }}

                    <div class="form-item">
                        <label for="name">Username or email</label>
                        <input type="text" name="name" id="name" value="{{ old('name') }}" required minlength="6" maxlength="255">
                        <span class="text-danger">{{ $errors->first('name') }}</span>
                    </div>

                    <div class="form-item">
                        <label for="password">Password</label>
                        <input type="password" name="password" id="password" required minlength="6" maxlength="255">
                        <span class="text-danger">{{ $errors->first('password') }}</span>
                    </div>

                    <a href="{{ route('front.password.request') }}" class="forgot-password">Forgot Password</a>
                    <div class="form-actions">
                        <input type="submit" value="Login">
                    </div>
                </form>

                <div class="login-register-link">Dont have account yet?
                    <a href="{{ route('front.register') }}">Register HERE</a>
                </div>
            </div>
        </div>
    </section>
@endsection