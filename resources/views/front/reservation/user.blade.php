@extends('front.layouts.main')

@section('content')
    <section class="checkout-section-demo">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="checkout-page__top">
                        <div class="title">
                            <h1 class="text-uppercase">CHECKOUT</h1>
                        </div>
                        <span class="phone">Support Call: {{ $company_phone_number }}</span>
                    </div>
                </div>
                <div class="col-lg-3">
                    <div class="checkout-page__sidebar">
                        <ul>
                            <li>
                                <a href="{{ route('front.reservation.cart.index') }}">Your Cart</a>
                            </li>
                            <li class="current">
                                <a href="javascript:void(0);">Customer information</a>
                            </li>
                            <li>
                                <a href="javascript:void(0);">Complete reservation</a>
                            </li>
                        </ul>
                    </div>
                </div>

                <div class="col-lg-9">
                    <div class="checkout-page__content">
                        <div class="customer-content">
                            <!-- Message -->
                            @if (Session::has('message'))
                                @component('front.components.alert')
                                    {!! Session::get('message.content') !!}
                                @endcomponent
                            @endif

                            @guest
                                <div class="woocommerce-info">
                                    An account is required to see payment methods.
                                </div>

                                @if(! Request::input('existing'))
                                    <div class="woocommerce-info">Returning customer? Welcome back!
                                        <a href="{{ route('front.reservation.user').'?existing=true' }}" class="showlogin">
                                            Click here to login.</a>
                                    </div>
                                @else
                                    <div class="woocommerce-info">New customer? You are welcome!
                                        <a href="{{ route('front.reservation.user') }}" class="showlogin">
                                            Click here to register</a>
                                    </div>
                                @endif

                                <div class="woocommerce-billing-fields">
                                    <h3>Customer info</h3>

                                    @if(! Request::input('existing'))
                                        <form method="POST" action="{{ route('front.register') }}">
                                            {{ csrf_field() }}

                                            <!-- Random password -->
                                            <input type="hidden" name="password"
                                                value="{{ $password = Helper::createPassword() }}">

                                            <!-- Random password confirmation  -->
                                            <input type="hidden" name="password_confirmation" value="{{ $password }}">

                                            <div class="display-inline width-100">
                                                <div class="form-row width-33 padding-x-4">
                                                    <label>First name <span class="text-danger">*</span></label>
                                                    <input type="text" name="first_name" id="first_name"
                                                        value="{{ old('first_name') }}">
                                                    <span id="first_name-error" class="text-danger">
                                                        {{ $errors->first('first_name') }}
                                                    </span>
                                                </div>

                                                <div class="form-row width-33 padding-x-4">
                                                    <label>Middle name</label>
                                                    <input type="text" name="middle_name" id="middle_name"
                                                        value="{{ old('middle_name') }}">
                                                    <span id="middle_name-error" class="text-danger">
                                                        {{ $errors->first('middle_name') }}
                                                    </span>
                                                </div>

                                                <div class="form-row width-33 padding-x-4">
                                                    <label>Last name <span class="text-danger">*</span></label>
                                                    <input type="text" name="last_name" id="last_name"
                                                        value="{{ old('last_name') }}">
                                                    <span id="last_name-error" class="text-danger">
                                                        {{ $errors->first('last_name') }}
                                                    </span>
                                                </div>
                                            </div>

                                            <div class="display-inline width-100">
                                                <div class="form-row width-50 padding-x-4">
                                                    <label>Email <span class="text-danger">*</span></label>
                                                    <input type="text" name="email" id="email"
                                                        value="{{ old('email') }}">
                                                    <span id="email-error" class="text-danger">
                                                        {{ $errors->first('email') }}
                                                    </span>
                                                </div>
                                            </div>

                                            <div class="display-inline width-100">
                                                <div class="form-row width-33 padding-x-4">
                                                    <label>Gender</label>
                                                    <select name="gender" id="gender" class="width-100 bg-color-grey">
                                                        <option value="" disabled selected>Please select a gender</option>
                                                        <option value="male" {{ old('gender') == 'male' ? 'selected' : '' }}>
                                                            Male</option>
                                                        <option value="female" {{ old('gender') == 'female' ? 'selected' : '' }}>
                                                            Female</option>
                                                    </select>
                                                    <span id="gender-error" class="text-danger">
                                                        {{ $errors->first('gender') }}
                                                    </span>
                                                </div>

                                                <div class="form-row width-33 padding-x-4">
                                                    <label>Birthdate</label>
                                                    <input type="text" name="birthdate" id="birthdate" class="awe-calendar"
                                                        value="{{ old('birthdate') }}">
                                                    <span id="birthdate-error" class="text-danger">
                                                        {{ $errors->first('birthdate') }}
                                                    </span>
                                                </div>

                                                <div class="form-row width-33 padding-x-4">
                                                    <label>Phone number</label>
                                                    <input type="number" name="phone_number" id="phone_number"
                                                        value="{{ old('phone_number') }}">
                                                    <span id="phone_number-error" class="text-danger">
                                                        {{ $errors->first('phone_number') }}
                                                    </span>
                                                </div>
                                            </div>

                                            <div class="display-inline width-100">
                                                <div class="form-row width-50" id="order_comments_field">
                                                    <label>Address</label>
                                                    <textarea name="address" id="address">{{ old('address') }}</textarea>
                                                </div>
                                                <span id="address-error" class="text-danger">
                                                    {{ $errors->first('address') }}
                                                </span>
                                            </div>

                                            <div class="display-inline width-100">
                                                <div class="form-row padding-x-3">
                                                    By registering, you are accepting our
                                                    <a href="#" class="terms-conditions">Terms &amp; Conditions</a>
                                                </div>
                                            </div>

                                            <div class="form-row place-order width-100">
                                                <button type="submit" class="button button-primary">
                                                    Register</button>
                                            </div>
                                        </form>
                                    @else
                                        <form method="POST" action="{{ route('front.login') }}">
                                            {{ csrf_field() }}

                                            <!-- Name -->
                                            <div class="display-inline width-100">
                                                <div class="form-row width-33 padding-x-4">
                                                    <label>Email or username <span class="text-danger">*</span></label>
                                                    <input type="text" name="name" id="name" value="{{ old('name') }}">
                                                    <span id="name-error" class="text-danger">
                                                        {{ $errors->first('name') }}
                                                    </span>
                                                </div>
                                            </div>
                                            <!--/. Name -->

                                            <!-- Password -->
                                            <div class="display-inline width-100">
                                                <div class="form-row width-33 padding-x-4">
                                                    <label>Password <span class="text-danger">*</span></label>
                                                    <input type="password" name="password" id="password">
                                                    <span id="password-error" class="text-danger">
                                                        {{ $errors->first('password') }}
                                                    </span>
                                                </div>
                                            </div>
                                            <!--/. Password -->

                                            <div class="form-row place-order width-100">
                                                <button type="submit" class="button button-primary">
                                                    Login</button>
                                            </div>
                                        </form>
                                    @endif
                                </div>

                            @else
                                <div class="woocommerce-info">You're almost done, please make sure you have read our
                                    <a href="{{ route('front.terms') }}">
                                        Terms &amp; Conditions</a>
                                </div>

                                <form method="POST" action="{{ route('front.reservation.store') }}">
                                    {{ csrf_field() }}
                                    <div id="payment">
                                        <h3>Payment method</h3>
                                        <ul class="payment_methods methods">
                                            <li class="payment_method_bacs">
                                                <input id="payment_method_bacs" type="radio" name="payment_mode" value="cash">
                                                <label for="payment_method_bacs">Direct Cash Payment</label>
                                                <div class="payment_box payment_method_bacs">
                                                    <p>Make your payment directly at the resort. Please save your Reference Number (will be created shortly) as we will be looking it by the time you visit us. Your reservation will be on pending state, please wait for our email and calls.</p>
                                                </div>
                                            </li>

                                            <li class="payment_method_paypal">
                                                <input id="payment_method_paypal" type="radio" name="payment_mode"
                                                    value="paypal_express">
                                                <label for="payment_method_paypal">PayPal
                                                    <img src="/front/assets/images/paypal.png" alt="">
                                                    <a href="https://www.paypal.com" class="about_paypal">What is PayPal?</a>
                                                </label>

                                                <div class="payment_box payment_method_paypal">
                                                    <p>Pay via PayPal; you can pay with your credit card if you don’t have a PayPal account.</p>
                                                </div>
                                            </li>
                                        </ul>

                                        <div class="form-row place-order">
                                            <button type="submit" class="button button-primary">Place reservation</button>
                                        </div>
                                    </div>
                                </form>
                            @endguest
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('scripts')
    <script>
        var birthdate = $("input[id=birthdate]");

        birthdate.datepicker({
            dateFormat: 'yy-mm-dd',
            maxDate: 'today',
            defaultDate: moment().subtract(15, 'years').format('YYYY-MM-DD'),
            showOtherMonths: !0,
            selectOtherMonths: !0,
            dayNamesMin:["Sun","Mon","Tue","Wen","Thu","Fri","Sat"]
        });
    </script>
@endsection