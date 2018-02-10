@extends('root.layouts.main')

@section('content')
    <div class="m-portlet">
        <div class="m-portlet__head">
            <div class="m-portlet__head-caption">
                <div class="m-portlet__head-title">
                    <span class="m-portlet__head-icon m--hide"><i class="la la-gear"></i></span>

                    <h3 class="m-portlet__head-text">Create category</h3>
                </div>
            </div>
        </div>

        <form method="POST" action="{{ route('root.categories.store') }}" id="form-category" class="m-form m-form--fit m-form--label-align-right m-form--group-seperator-dashed m-form--state" enctype="multipart/form-data">
            {{ csrf_field() }}

            <div class="m-portlet__body">
                <!-- Name -->
                <div class="form-group m-form__group row {{ $errors->has('name') ? 'has-danger' : '' }}">
                    <label for="name" class="col-lg-2 col-form-label">Name: </label>

                    <div class="col-lg-6">
                        <input type="text" name="name" id="name" class="form-control m-input {{ $errors->has('name') ?
                            'form-control-danger' :'' }}" placeholder="The name of the category" value="{{
                                old('name') }}">

                        <div class="form-control-feedback">{{ $errors->first('name') }}</div>
                    </div>
                </div>
                <!--/. Name -->

                <!-- Description -->
                <div class="form-group m-form__group row {{ $errors->has('description') ? 'has-danger' : '' }}">
                    <label for="description" class="col-lg-2 col-form-label">Description</label>

                    <div class="col-lg-6">
                        <textarea name="description" id="description" class="summernote"
                            {{ $errors->has('description') ? 'form-control-danger' :'' }}>{{ old('description') }}
                        </textarea>

                        <div class="form-control-feedback">{{ $errors->first('description') }}</div>
                    </div>
                </div>
                <!--/. Description -->

                <!-- Bottom -->
                <div class="m-portlet__foot m-portlet__no-border m-portlet__foot--fit">
                    <div class="m-form__actions m-form__actions--solid">
                        <div class="row">
                            <div class="col-lg-2"></div>
                            <div class="col-lg-6">
                                <button type="submit" id="submit" class="btn btn-brand">Create</button>
                                <a type="button" href="{{ route('root.categories.index') }}" class="btn btn-secondary">Cancel</a>
                            </div>
                        </div>
                    </div>
                </div>
                <!--/. Bottom -->
            </div>

        </form>
    </div>
@endsection

@section('scripts')
    <script>
        $('.dropzone').dropzone({
            uploadMultiple: true,
            maxFiles: 1,
            maxFileSize: 5,
            acceptedFiles: "image/*",
            accept: function(file, done) {
                done();
            },
            init: function() {
                var image = this;

                $('button[id=submit]').on("click", function(e) {
                    image.processQueue();
                });
            },
        });

        var category = function () {
            // form validate
            var formValidationInit = function () {
                $("form[id=form-category]").validate({
                    rules: {
                        name: {
                            required: true,
                            maxlength: 255
                        },

                        description: {
                            maxlength: 500
                        },
                    },

                    //display error alert on form submit
                    invalidHandler: function(event, validator) {
                        mApp.scrollTo("form[id=form-category]");

                        swal({
                            "title": "",
                            "text": "There are some errors in your submission. Please correct them.",
                            "type": "error",
                            "confirmButtonClass": "btn btn-secondary m-btn m-btn--wide"
                        });
                    },
                });
            }
            //. form validate

            // summernote
            var descriptionInit = function () {
                $('.summernote').summernote({
                    height: 150
                });
            }
            //. summernote

            return {
                init: function() {
                    formValidationInit();
                    descriptionInit();
                }
            };
        }();

        $(document).ready(function() {
            category.init();
        });
    </script>
@endsection