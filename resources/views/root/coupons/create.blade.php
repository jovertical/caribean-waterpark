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

                    <h3 class="m-portlet__head-text">Create coupon</h3>
                </div>
            </div>
        </div>

        <form method="POST" action="{{ route('root.coupons.store') }}" id="form-category-store" class="m-form m-form--fit m-form--label-align-right m-form--group-seperator-dashed m-form--state">
            {{ csrf_field() }}

            <div class="m-portlet__body">
                <!-- Name -->
                <div class="form-group m-form__group row {{ $errors->has('name') ? 'has-danger' : '' }}" required>
                    <label for="name" class="col-lg-2 col-form-label">
                        Name <span class="m--font-danger">*</span>
                    </label>

                    <div class="col-lg-6">
                        <input type="text" name="name" id="name" class="form-control m-input {{ $errors->has('name') ?
                            'form-control-danger' :'' }}" placeholder="Please enter a name" value="{{
                                old('name') }}">

                        <div id="name-error" class="form-control-feedback">
                            <span class="m--font-danger">{{ $errors->first('name') }}</span>
                        </div>

                        <span class="m-form__help">The name of this coupon.</span>
                    </div>
                </div>
                <!--/. Name -->

                <!-- Description -->
                <div class="form-group m-form__group row {{ $errors->has('description') ? 'has-danger' : '' }}">
                    <label for="description" class="col-lg-2 col-form-label">
                        Description
                    </label>

                    <div class="col-lg-6">
                        <textarea name="description" id="description" class="summernote"
                            {{ $errors->has('description') ? 'form-control-danger' :'' }}>{{ old('description') }}
                        </textarea>

                        <div id="description-error" class="form-control-feedback">
                            <span class="m--font-danger">{{ $errors->first('description') }}</span>
                        </div>
                    </div>
                </div>
                <!--/. Description -->

                <!-- Price -->
                <div class="form-group m-form__group row {{ $errors->has('amount_deductable') ? 'has-danger' : '' }}">
                    <label for="amount_deductable" class="col-lg-2 col-form-label">
                        Price <span class="m--font-danger">*</span>
                    </label>   

                    <div class="col-lg-6">
                        <div class="input-group m-input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="la la-money"></i></span>
                            </div>

                            <input type="number" name="amount_deductable" id="amount_deductable" class="form-control m-input
                                {{ $errors->has('amount_deductable') ? 'form-control-danger' :'' }}" placeholder="Please enter a price"
                                    value="{{ old('amount_deductable') }}" required>
                        </div>

                        <div id="price-error" class="form-control-feedback">
                            <span class="m--font-danger">{{ $errors->first('amount_deductable') }}</span>
                        </div>

                        <span class="m-form__help">The amount deducted for this coupon.</span>
                    </div>
                </div>
                <!--/. Price -->

                <!-- From -->
                <div class="form-group m-form__group row {{ $errors->has('amount_deductable') ? 'has-danger' : '' }}">
                    <label for="amount_deductable" class="col-lg-2 col-form-label">
                        Valid From: <span class="m--font-danger">*</span>
                    </label>

                    <div class="col-lg-6">
                        <div class="input-group m-input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="la la-calendar"></i></span>
                                </div>
                                <input type="text" name="valid_from" id="valid_from" class="form-control m-input"
                                {{ $errors->has('valid_from') ? 'form-control-danger' :'' }}" placeholder="Please select a date"
                                    value="{{ old('valid_from') }}" required>
                        </div>

                        <div id="price-error" class="form-control-feedback">
                            <span class="m--font-danger">{{ $errors->first('valid_from') }}</span>
                        </div>
                    </div>
                </div>
                <!--/. From -->

                <!-- Until -->
                <div class="form-group m-form__group row {{ $errors->has('valid_until') ? 'has-danger' : '' }}">
                    <label for="valid_until" class="col-lg-2 col-form-label">
                        Valid Until: <span class="m--font-danger">*</span>
                    </label>

                    <div class="col-lg-6">
                        <div class="input-group m-input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="la la-calendar"></i></span>
                                </div>
                                <input type="text" name="valid_until" id="valid_until" class="form-control m-input"
                                {{ $errors->has('valid_until') ? 'form-control-danger' :'' }}" placeholder="Please select a date"
                                    value="{{ old('valid_until') }}" required>
                        </div>

                        <div id="price-error" class="form-control-feedback">
                            <span class="m--font-danger">{{ $errors->first('valid_until') }}</span>
                        </div>
                    </div>
                </div>
                <!--/. Until -->

                <!-- Bottom -->
                <div class="m-portlet__foot m-portlet__no-border m-portlet__foot--fit">
                    <div class="m-form__actions m-form__actions--solid">
                        <div class="row">
                            <div class="col-lg-2"></div>
                            <div class="col-lg-6">
                                <button type="submit" id="submit" class="btn btn-brand">Create</button>
                                <a href="{{ route('root.coupons.index') }}" class="btn btn-secondary">Cancel</a>
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
                            maxlength: 510
                        },
                    },

                    invalidHandler: function(event, validator) {
                        var form = $('form[id=form-category-update]');

                        mApp.scrollTo(form, -200);
                    },
                });
            }
            //. form validate

            // summernote
            var summernoteInit = function () {
                $('.summernote').summernote({
                    height: 150
                });
            }
            //. summernote
            // dates
            var datesInit = function () {
                $('input[id=from]').datepicker({
                    format: 'yyyy-mm-dd',
                    orientation: "bottom left",
                    todayBtn: "linked",
                    clearBtn: true,
                    todayHighlight: true,
                    templates: {
                        leftArrow: '<i class="la la-angle-left"></i>',
                        rightArrow: '<i class="la la-angle-right"></i>'
                    }
                });

                $('input[id=to]').datepicker({
                    format: 'yyyy-mm-dd',
                    orientation: "bottom left",
                    todayBtn: "linked",
                    clearBtn: true,
                    todayHighlight: true,
                    templates: {
                        leftArrow: '<i class="la la-angle-left"></i>',
                        rightArrow: '<i class="la la-angle-right"></i>'
                    }
                });
            }
            //. dates


            return {
                init: function() {
                    formValidationInit();
                    summernoteInit();
                    datesInit();
                }
            };
        }();

        $(document).ready(function() {
            category.init();
        });
    </script>
@endsection