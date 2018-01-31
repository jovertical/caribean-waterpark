@extends('root.layouts.main')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-5">

            @if(Session::has('message'))
                @include('root.partials.message')
            @endif

            <div class="card px-4">
                <div class="card-body">
                    <p class="h5 text-center my-4">Superuser login</p>

                    <form method="POST" action="{{ route('root.login') }}">
                        {{ csrf_field() }}

                        <!-- Name -->
                        <div class="md-form">
                            <i class="fa fa-user prefix grey-text"></i>
                            <label for="name">Username</label>
                            <input type="text" name="name" id="name" class="form-control {{
                                $errors->has('name') ? 'invalid' : '' }}" value="{{ old('name') }}">

                            @if($errors->has('name'))
                                <div id="name-error" class="text-right">
                                    <span class="red-text">{{ $errors->first('name') }}</span>
                                </div>
                            @endif
                        </div>
                        <!-- Name -->

                        <!-- Password -->
                        <div class="md-form">
                            <i class="fa fa-lock prefix grey-text"></i>
                            <label for="password">Password</label>
                            <input type="password" name="password" id="password" class="form-control {{
                                $errors->has('password') ? 'invalid' : '' }}">

                            @if($errors->has('password'))
                                <div id="password-error" class="text-right">
                                    <span class="red-text">{{ $errors->first('password') }}</span>
                                </div>
                            @endif
                        </div>
                        <!--/. Password -->

                        <!-- Options -->
                        <div class="row d-flex align-items-center">
                            <!-- Left -->
                            <div class="col-md-6 text-left">
                                <div class="form-group">
                                    <input type="checkbox" name="remember" id="remember" {{
                                        old('remember') ? 'checked' : '' }}>
                                        <label for="remember">
                                            <a href="#" class="blue-text"> Remember me</a></label>
                                </div>
                            </div>
                            <!--/. Left -->

                            <!-- Right -->
                            <div class="col-md-6 text-right">
                                <div class="form-group">
                                    <label>
                                        <a href="{{ route('root.password.request') }}" class="blue-text">
                                        Forgot password?</a>
                                    </label>
                                </div>
                            </div>
                            <!--/. Right -->
                        </div>
                        <!--/. Options -->

                        <div class="text-center my-4">
                            <button class="btn btn-primary">Login</button>
                        </div>

                    </form>
                </div>
            </div>

        </div>
    </div>
@endsection