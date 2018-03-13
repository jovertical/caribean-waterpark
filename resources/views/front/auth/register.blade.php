@extends('front.layouts.main')

@section('content')
    <section class="awe-parallax register-page-demo">
        <div class="awe-overlay"></div>
        <div class="container">
            <div class="login-register-page__content">
                <div class="content-title" style="margin-bottom: 25px;">
                    <span style="color: #fff;">Don’t stay at home</span>
                    <h2 style="color: #fff;">JOIN US !</h2>
                </div>

                <form method="POST" action="{{ route('front.register') }}">
                    {{ csrf_field() }}

                    <div class="row">
                        <div class="col-md-6">
                            <!-- Firstname -->
                            <div class="form-item">
                                <label>Firstname</label>

                                <input type="text" name="first_name" id="first_name" value="{{ old('first_name') }}"
                                    required maxlength="255">

                                <span id="first_name-error" class="text-danger">
                                    {{ $errors->first('first_name') }}
                                </span>
                            </div>
                            <!--/. Firstname -->
                        </div>

                        <div class="col-md-6">
                            <!-- Lastname -->
                            <div class="form-item">
                                <label>Lastname</label>

                                <input type="text" name="last_name" id="last_name" value="{{ old('last_name') }}"
                                    required maxlength="255">

                                <span id="last_name-error" class="text-danger">
                                    {{ $errors->first('last_name') }}
                                </span>
                            </div>
                            <!--/. Lastname -->
                        </div>
                    </div>

                    <!-- Email -->
                    <div class="form-item">
                        <label>Email</label>

                        <input type="email" name="email" id="email" value="{{ old('email') }}"
                            required minlength="6" maxlength="255">

                        <span id="email-error" class="text-danger">
                            {{ $errors->first('email') }}
                        </span>
                    </div>
                    <!--/. Email -->

                    <!-- Password -->
                    <div class="form-item">
                        <label>Password</label>

                        <input type="password" name="password" id="password" 
                            required minlength="6" maxlength="255">

                        <span id="password-error" class="text-danger">
                            {{ $errors->first('password') }}
                        </span>
                    </div>
                    <!--/. Password -->
                    
                    <!-- Confirm password -->
                    <div class="form-item">
                        <label>Confirm password</label>

                        <input type="password" name="password_confirmation" id="password_confirmation"
                            required minlength="6" maxlength="255">

                        <span id="password_confirmation-error" class="text-danger">
                            {{ $errors->first('password_confirmation') }}
                        </span>
                    </div>
                    <!--/. Confirm password -->

                    <a href="#" class="terms-conditions">By registering, you are accepting our Terms &amp; Conditions</a>

                    <div class="form-actions">
                        <input type="submit" value="Register">
                    </div>
                </form>

                <div class="login-register-link">
                    Already have Account? <a href="{{ route('front.login') }}">Login HERE</a>
                </div>
            </div>
        </div>
    </section>
@endsection