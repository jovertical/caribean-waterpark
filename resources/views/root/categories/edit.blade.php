@extends('root.layouts.main')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-8">

            <div class="card">
                <div class="card-body">
                    <p class="h5 mb-5">Edit category</p>

                    <form method="POST" action="{{ route('root.categories.update', $category->id) }}">
                        {{ method_field('PATCH') }}
                        {{ csrf_field() }}

                        <!-- Name -->
                        <div class="form-group">
                            <label for="name">Name</label>

                            <input type="text" name="name" id="name" class="form-control {{ $errors->has('name') ?
                                'invalid' : '' }}" placeholder="The name of the category" value="{{ $category->name }}">

                            @if($errors->has('name'))
                                <div id="name-error" class="text-right">
                                    <span class="red-text">{{ $errors->first('name') }}</span>
                                </div>
                            @endif
                        </div>
                        <!-- Name -->

                        <!-- Description -->
                        <div class="form-group">
                            <label for="description">Description</label>

                            <textarea type="text" name="description" id="description" class="md-textarea {{
                                $errors->has('name') ? 'description' : '' }}">{{ $category->description }}</textarea>

                            @if($errors->has('description'))
                                <div id="description-error" class="text-right">
                                    <span class="red-text">{{ $errors->first('description') }}</span>
                                </div>
                            @endif
                        </div>
                        <!-- Description -->

                        <!-- Submit -->
                        <div class="form-group text-right">
                            <a type="button" href="{{ route('root.categories.index') }}" class="btn btn-flat">Cancel</a>
                            <button type="submit" class="btn btn-primary">Update</button>
                        </div>
                        <!--/. Submit -->

                    </form>
                </div>
            </div>

        </div>
    </div>
@endsection

@section('scripts')
    <!-- Ckeditor -->
    <script src="/root/assets/ckeditor/ckeditor.js"></script>

    <script>
        $(document).ready(function() {

            CKEDITOR.replace('description');
        });
    </script>
@endsection