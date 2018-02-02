@extends('root.layouts.main')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-8">

            <div class="card">
                <div class="card-body">
                    <p class="h5 mb-5">Select picture for <em>{{ $category->name }}</em></p>

                    <form method="POST" action="{{ route('root.categories.store') }}" enctype="multipart/form-data">
                        {{ csrf_field() }}

                        <!-- Picture -->
                        
                        <!--/. Picture -->

                        <!-- Submit -->
                        <div class="form-group text-right">
                            <a type="button" href="{{ route('root.categories.index') }}" class="btn btn-flat">Cancel</a>
                            <button type="submit" class="btn btn-primary">Upload</button>
                        </div>
                        <!--/. Submit -->
                    </form>
                </div>
            </div>

        </div>
    </div>
@endsection