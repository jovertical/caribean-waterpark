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
                            <h3 class="m-login__title">Superuser Login</h3>
                        </div>

                        <form method="POST" action="{{ route('root.login') }}" class="m-login__form m-form">
                            {{ csrf_field() }}

                            <!-- Username -->
                            <div class="form-group m-form__group {{ $errors->has('name') ? 'has-danger' : '' }}">
                                <input type="text" name="name" id="name" class="form-control m-input" placeholder="Username or email" autocomplete="off" value="{{ old('name') }}">

                                <div class="form-control-feedback">{{ $errors->first('name') }}</div>
                            </div>
                            <!--/. Username -->

                            <!-- Password -->
                            <div class="form-group m-form__group {{ $errors->has('password') ? 'has-danger' : '' }}">
                                <input type="password" name="password" id="password" class="form-control m-input m-login__form-input--last" placeholder="Password">

                                <div class="form-control-feedback">{{ $errors->first('password') }}</div>
                            </div>
                            <!--/. Password -->

                            <div class="row m-login__form-sub">
                                <div class="col m--align-left m-login__form-left">
                                    <label class="m-checkbox  m-checkbox--focus">
                                        <input type="checkbox" name="" id="" {{ old('remember') ? 'checked' : '' }}>
                                            Remember me<span></span>
                                    </label>
                                </div>
                                <div class="col m--align-right m-login__form-right">
                                    <a href="{{ route('root.password.request') }}" class="m-link">Forget Password ?</a>
                                </div>
                            </div>

                            <!-- Submit -->
                            <div class="m-login__form-action">
                                <button id="m_login_signin_submit" class="btn btn-focus m-btn m-btn--pill m-btn--custom m-btn--air m-login__btn m-login__btn--primary">Login</button>
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

@section('scripts')
    <script src="/root/assets/demo/default/custom/components/forms/validation/form-controls.js"></script>
@endsection