@extends('root.layouts.main')

@section('sidebar')
    @component('root.components.sidebar')
    @endcomponent
@endsection

@section('content')
    <div class="m-portlet">
        <div class="m-portlet__head">
            <div class="m-portlet__head-caption">
                <div class="m-portlet__head-title">
                    <span class="m-portlet__head-icon m--hide"><i class="la la-gear"></i></span>

                    <h3 class="m-portlet__head-text">Create superuser</h3>
                </div>
            </div>
        </div>

        <form method="POST" action="{{ route('root.superusers.store') }}" id="form-item-store" class="m-form m-form--fit m-form--label-align-right m-form--group-seperator-dashed m-form--state">
            {{ csrf_field() }}

            <div class="m-portlet__body">
                <!-- Name -->
                <div class="form-group m-form__group row {{ $errors->has('name') ? 'has-danger' : '' }}">
                    <label for="name" class="col-lg-2 col-form-label">Name: </label>

                    <div class="col-lg-6">
                        <input type="text" name="name" id="name" class="form-control m-input {{ $errors->has('name') ?
                            'form-control-danger' :'' }}" placeholder="Please enter a name" value="{{ old('name') }}" required>

                        <div id="name-error" class="form-control-feedback">
                            {{ $errors->first('name') }}
                        </div>

                        <span class="m-form__help">The name of the user.</span>
                    </div>
                </div>
                <!--/. Name -->

                <!-- Bottom -->
                <div class="m-portlet__foot m-portlet__no-border m-portlet__foot--fit">
                    <div class="m-form__actions m-form__actions--solid">
                        <div class="row">
                            <div class="col-lg-2"></div>
                            <div class="col-lg-6">
                                <button type="submit" id="submit" class="btn btn-brand">Create</button>
                                <a type="button" href="{{ route('root.superusers.index') }}" class="btn btn-secondary">Cancel</a>
                            </div>
                        </div>
                    </div>
                </div>
                <!--/. Bottom -->
            </div>
    </div>
@endsection

@section('scripts')
    <script>
        var item = function () {
            // form validate
            var formValidationInit = function () {
                $("form[id=form-item-store]").validate({
                    rules: {
                        category: {
                            required: true
                        },

                        name: {
                            required: true,
                            maxlength: 255
                        },

                        description: {
                            maxlength: 500
                        },

                        price: {
                            required: true
                        }
                    },

                    invalidHandler: function(event, validator) {
                        var form = $('form[id=form-item-update]');

                        $('button[type=submit]').removeClass('m-loader m-loader--light m-loader--right');

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

            // category
            var categoryInit = function () {
                $('select[id=category]').selectpicker({
                    //
                });
            }
            //. category

            return {
                init: function() {
                    formValidationInit();
                    descriptionInit();
                    categoryInit();
                }
            };
        }();

        $(document).ready(function() {
            item.init();
        });
    </script>
@endsection