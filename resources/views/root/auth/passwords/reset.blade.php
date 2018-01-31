@extends('root.layouts.main')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-5">

            <div class="card px-4">
                <div class="card-body">
                    <p class="h5 text-center my-4">Reset password</p>

                    <form method="POST" action="{{ route('root.password.reset', $token) }}">
                        {{ csrf_field() }}

                        <!-- Password -->
                        <div class="md-form">
                            <i class="fa fa-lock prefix grey-text"></i>
                            <label for="password">Password</label>
                            <input type="password" name="password" id="password" class="form-control {{
                                $errors->has('password') ? 'invalid' : '' }}" value="{{ old('password') }}">

                            @if($errors->has('password'))
                                <div id="password-error" class="text-right">
                                    <span class="red-text">{{ $errors->first('password') }}</span>
                                </div>
                            @endif
                        </div>
                        <!--/. Password -->

                        <!-- Confirm password -->
                        <div class="md-form">
                            <i class="fa fa-lock prefix grey-text"></i>
                            <label for="password_confirmation">Confirm password</label>
                            <input type="password" name="password_confirmation" id="password_confirmation" class="form-control {{ $errors->has('password_confirmation') ? 'invalid' : '' }}">

                            @if($errors->has('password_confirmation'))
                                <div id="password_confirmation-error" class="text-right">
                                    <span class="red-text">{{ $errors->first('password_confirmation') }}</span>
                                </div>
                            @endif
                        </div>
                        <!--/. Confirm -->

                        <!-- Options -->
                        <div class="row d-flex align-items-center">
                            <!-- Right -->
                            <div class="col-md text-right">
                                <div class="form-group">
                                    <label>
                                        <a href="{{ route('root.login') }}" class="blue-text">Back to login</a>
                                    </label>
                                </div>
                            </div>
                            <!--/. Right -->
                        </div>
                        <!--/. Options -->

                        <div class="text-center my-4">
                            <button class="btn btn-primary">Reset</button>
                        </div>

                    </form>
                </div>
            </div>

        </div>
    </div>
@endsection