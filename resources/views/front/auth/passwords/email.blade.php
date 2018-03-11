@extends('front.layouts.main')

@section('content')
    <section class="awe-parallax login-page-demo">
        <div class="awe-overlay"></div>
        <div class="container">
            <div class="login-register-page__content">
                <div class="content-title" style="margin-bottom: 25px;">
                    <span style="color: #fff;">Forgot password?</span>
                    <h2></h2>
                </div>
                
                <!-- Message -->
                @if (Session::has('message'))
                    @component('front.components.alert')
                        {{ Session::get('message.content') }}
                    @endcomponent
                @endif

                <form method="POST" action="{{ route('front.password.email') }}">
                    {{ csrf_field() }}

                    <div class="form-item">
                        <label for="email"> Email</label>
                        <input type="email" name="email" id="email" value="{{ old('email') }}"
                            required minlength="6" maxlength="255">
                        <span class="text-danger">{{ $errors->first('email') }}</span>
                    </div>

                    <a href="{{ route('front.login') }}" class="forgot-password">Back to login</a>

                    <div class="form-actions">
                        <input type="submit" value="Send link">
                    </div>
                </form>
            </div>
        </div>
    </section>
@endsection