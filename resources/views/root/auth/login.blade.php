@extends('root.layouts.main')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-5">

            <div class="card p-2">
                <div class="card-body">
                    <p class="py-2 text-center">Superuser Login</p>

                    <form method="POST" action="{{ route('superuser.login') }}">
                        {{ csrf_field() }}

                        <!-- Name -->
                        <label class="mt-4">Username</label>

                        <div class="">
                            <div class="form-group">
                                <input type="text" name="name" id="name" class="form-control" placeholder="Enter username" value="{{ old('name') }}">
                            </div>
                        </div>
                        <!-- Name -->

                        <!-- Password -->
                        <label class="mt-4">Password</label>

                        <div class="">
                            <div class="form-group">
                                <input type="password" name="password" id="password"
                                class="form-control" placeholder="Enter password">
                            </div>
                        </div>
                        <!--/. Password -->

                        <!-- Submit -->
                        <div class="d-flex my-4">
                            <div class="form-group ml-auto">
                                <button type="submit" class="btn btn-primary">Login</button>
                            </div>
                        </div>
                        <!--/. Submit -->

                    </form>
                </div>
            </div>

        </div>
    </div>
@endsection