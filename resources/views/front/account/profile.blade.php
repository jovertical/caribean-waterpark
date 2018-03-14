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
                        <div class="customer-content">
                            <!-- Message -->
                            @if (Session::has('message'))
                                @component('front.components.alert')
                                    {!! Session::get('message.content') !!}
                                @endcomponent
                            @endif

                            <div class="content-title">
                                <h2><i class="awe-icon awe-icon-user"></i>My profile</h2>
                            </div>

                            <div class="woocommerce-billing-fields">
                                <form method="POST" action="{{ route('front.account.profile') }}">
                                    {{ method_field('PATCH') }}
                                    {{ csrf_field() }}

                                    <div class="display-inline width-100">
                                        <div class="form-row width-33 padding-x-4">
                                            <label>First name <span class="text-danger">*</span></label>
                                            <input type="text" name="first_name" id="first_name"
                                                value="{{ old('first_name') ?? $user->first_name }}">
                                            <span id="first_name-error" class="text-danger">
                                                {{ $errors->first('first_name') }}
                                            </span>
                                        </div>

                                        <div class="form-row width-33 padding-x-4">
                                            <label>Middle name</label>
                                            <input type="text" name="middle_name" id="middle_name"
                                                value="{{ old('middle_name') ?? $user->middle_name }}">
                                            <span id="middle_name-error" class="text-danger">
                                                {{ $errors->first('middle_name') }}
                                            </span>
                                        </div>

                                        <div class="form-row width-33 padding-x-4">
                                            <label>Last name <span class="text-danger">*</span></label>
                                            <input type="text" name="last_name" id="last_name"
                                                value="{{ old('last_name') ?? $user->last_name }}">
                                            <span id="last_name-error" class="text-danger">
                                                {{ $errors->first('last_name') }}
                                            </span>
                                        </div>
                                    </div>

                                    <div class="display-inline width-100">
                                        <div class="form-row width-50 padding-x-4">
                                            <label>Email <span class="text-danger">*</span></label>
                                            <input type="text" name="email" id="email"
                                                value="{{ old('email') ?? $user->email }}">
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
                                                <option value="male" {{ old('gender') ?? strtolower($user->gender) == 
                                                    'male' ? 'selected' : '' }}>Male</option>
                                                <option value="female" {{ old('gender') ?? strtolower($user->gender) == 
                                                    'female' ? 'selected' : '' }}>Female</option>
                                            </select>
                                            <span id="gender-error" class="text-danger">
                                                {{ $errors->first('gender') }}
                                            </span>
                                        </div>

                                        <div class="form-row width-33 padding-x-4">
                                            <label>Birthdate</label>
                                            <input type="text" name="birthdate" id="birthdate" class="awe-calendar"
                                                value="{{ old('birthdate') ?? $user->birthdate }}">
                                            <span id="birthdate-error" class="text-danger">
                                                {{ $errors->first('birthdate') }}
                                            </span>
                                        </div>

                                        <div class="form-row width-33 padding-x-4">
                                            <label>Phone number</label>
                                            <input type="number" name="phone_number" id="phone_number"
                                                value="{{ old('phone_number') ?? $user->phone_number }}">
                                            <span id="phone_number-error" class="text-danger">
                                                {{ $errors->first('phone_number') }}
                                            </span>
                                        </div>
                                    </div>

                                    <div class="display-inline width-100">
                                        <div class="form-row width-50" id="order_comments_field">
                                            <label>Address</label>
                                            <textarea name="address" id="address">{{ old('address') ?? $user->address }}</textarea>
                                        </div>
                                        <span id="address-error" class="text-danger">
                                            {{ $errors->first('address') }}
                                        </span>
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