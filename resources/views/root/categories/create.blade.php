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

        <form method="POST" action="{{ route('root.categories.store') }}" id="form-category-store" class="m-form m-form--fit m-form--label-align-right m-form--group-seperator-dashed m-form--state">
            {{ csrf_field() }}

            <div class="m-portlet__body">
                <!-- Type -->
                <div class="form-group m-form__group row {{ $errors->has('type') ? 'has-danger' : '' }}">
                    <label for="name" class="col-lg-2 col-form-label">Type: </label>

                    <div class="col-lg-6">
                        <select name="type" id="type" class="form-control m-bootstrap-select">
                            <option value="" disabled selected>Please select a type</option>
                            <option value="accomodation">Accomodation</option>
                            <option value="miscellaneous">Miscellaneous</option>
                        </select>

                        <span class="m-form__help">It will define the properties of <strong>items</strong> created under this category.</span>
                    </div>
                </div>
                <!--/. Type -->

                <!-- Name -->
                <div class="form-group m-form__group row {{ $errors->has('name') ? 'has-danger' : '' }}">
                    <label for="name" class="col-lg-2 col-form-label">Name: </label>

                    <div class="col-lg-6">
                        <input type="text" name="name" id="name" class="form-control m-input {{ $errors->has('name') ?
                            'form-control-danger' :'' }}" placeholder="Please enter a name" value="{{
                                old('name') }}">

                        <div id="name-error" class="form-control-feedback">
                            {{ $errors->first('name') }}
                        </div>

                        <span class="m-form__help">The name of the category.</span>
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

                        <div id="description-error" class="form-control-feedback">
                            {{ $errors->first('description') }}
                        </div>
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
        var category = function () {
            // form validate
            var formValidationInit = function () {
                $("form[id=form-category-store]").validate({
                    rules: {
                        name: {
                            required: true,
                            maxlength: 255
                        },

                        description: {
                            maxlength: 500
                        },
                    },

                    invalidHandler: function(event, validator) {
                        var form = $('form[id=form-category-update]');

                        mApp.scrollTo(form, -200);
                    },
                });
            }
            //. form validate

            // description
            var descriptionInit = function () {
                $('.summernote').summernote({
                    height: 150
                });
            }
            //. description

            // type
            var typeInit = function () {
                $('select[id=type]').selectpicker({
                    //
                });
            }
            //. type

            return {
                init: function() {
                    formValidationInit();
                    descriptionInit();
                    typeInit();
                }
            };
        }();

        $(document).ready(function() {
            category.init();
        });
    </script>
@endsection