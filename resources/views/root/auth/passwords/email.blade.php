@extends('root.layouts.main')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-5">

            @if(Session::has('message'))
                @include('root.partials.message')
            @endif

            <div class="card px-4">
                <div class="card-body">
                    <p class="h5 text-center my-4">Forgot password</p>

                    <form method="POST" action="{{ route('root.password.email') }}">
                        {{ csrf_field() }}

                        <!-- Email -->
                        <div class="md-form">
                            <i class="fa fa-envelope prefix grey-text"></i>
                            <label for="email">Email</label>
                            <input type="email" name="email" id="email" class="form-control {{
                                $errors->has('email') ? 'invalid' : '' }}" value="{{ old('email') }}">

                            @if($errors->has('email'))
                                <div id="email-error" class="text-right">
                                    <span class="red-text">{{ $errors->first('email') }}</span>
                                </div>
                            @endif
                        </div>
                        <!-- Email -->

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
                            <button type="submit" class="btn btn-primary">Send Link</button>
                        </div>

                    </form>
                </div>
            </div>

        </div>
    </div>
@endsection