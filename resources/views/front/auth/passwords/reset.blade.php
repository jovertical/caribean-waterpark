@extends('front.layouts.main')

@section('content')
    <section class="awe-parallax login-page-demo">
        <div class="awe-overlay"></div>
        <div class="container">
            <div class="login-register-page__content">
                <div class="content-title" style="margin-bottom: 25px;">
                    <span style="color: #fff;">Reset password</span>
                    <h2></h2>
                </div>
                
                <!-- Message -->
                @if (Session::has('message'))
                    @component('front.components.alert')
                        {{ Session::get('message.content') }}
                    @endcomponent
                @endif

                <form method="POST" action="{{ route('front.password.reset', $token) }}">
                    {{ csrf_field() }}
                    
                    <!-- Password -->
                    <div class="form-item">
                        <label for="password">Password</label>
                        <input type="password" name="password" id="password"
                            required minlength="6" maxlength="255">
                        <span class="text-danger">{{ $errors->first('password') }}</span>
                    </div>
                    <!--/. Password -->

                    <!-- Password confirmation -->
                    <div class="form-item">
                        <label for="password_confirmation">Password confirmation</label>
                        <input type="password" name="password_confirmation" id="password_confirmation"
                            required minlength="6" maxlength="255">
                        <span class="text-danger">{{ $errors->first('password_confirmation') }}</span>
                    </div>
                    <!--/. Password confirmation -->

                    <a href="{{ route('front.login') }}" class="forgot-password">Back to login</a>

                    <div class="form-actions">
                        <input type="submit" value="Reset password">
                    </div>
                </form>
            </div>
        </div>
    </section>
@endsection