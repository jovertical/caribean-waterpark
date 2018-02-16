@extends('root.layouts.main')

@section('content')
    <div class="m-portlet">
        <div class="m-portlet__head">
            <div class="m-portlet__head-caption">
                <div class="m-portlet__head-title">
                    <span class="m-portlet__head-icon m--hide"><i class="la la-gear"></i></span>

                    <h3 class="m-portlet__head-text">Update item</h3>
                </div>
            </div>
        </div>

        <form method="POST" action="{{ route('root.items.update', $item->id) }}" id="form-item-update" class="m-form m-form--fit m-form--label-align-right m-form--group-seperator-dashed m-form--state">
            {{ method_field('PATCH') }}
            {{ csrf_field() }}

            <div class="m-portlet__body">
                <!-- Category -->
                <div class="form-group m-form__group row {{ $errors->has('category') ? 'has-danger' : '' }}">
                    <label for="name" class="col-lg-2 col-form-label">Category: </label>

                    <div class="col-lg-6">
                        <select name="category" id="category" class="form-control m-bootstrap-select" required>
                            <option value="" disabled selected>Please select it's category</option>

                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ $category->id == $item->category_id ? 'selected' : '' }}>
                                    {{ Str::ucfirst($category->name) }}</option>
                            @endforeach
                        </select>

                        <span class="m-form__help">The category this item is under.</span>
                    </div>
                </div>
                <!--/. Category -->

                <!-- Name -->
                <div class="form-group m-form__group row {{ $errors->has('name') ? 'has-danger' : '' }}">
                    <label for="name" class="col-lg-2 col-form-label">Name: </label>

                    <div class="col-lg-6">
                        <input type="text" name="name" id="name" class="form-control m-input {{ $errors->has('name') ?
                            'form-control-danger' :'' }}" placeholder="Please enter a name" value="{{ Str::ucfirst($item->name) }}" required>

                        <div id="name-error" class="form-control-feedback">
                            {{ $errors->first('name') }}
                        </div>

                        <span class="m-form__help">The name of this item.</span>
                    </div>
                </div>
                <!--/. Name -->

                <!-- Description -->
                <div class="form-group m-form__group row {{ $errors->has('description') ? 'has-danger' : '' }}">
                    <label for="description" class="col-lg-2 col-form-label">Description</label>

                    <div class="col-lg-6">
                        <textarea name="description" id="description" class="summernote"
                            {{ $errors->has('description') ? 'form-control-danger' :'' }}>{{ $item->description }}
                        </textarea>

                        <div id="description-error" class="form-control-feedback">
                            {{ $errors->first('description') }}
                        </div>
                    </div>
                </div>
                <!--/. Description -->

                <!-- Price -->
                <div class="form-group m-form__group row {{ $errors->has('price') ? 'has-danger' : '' }}">
                    <label for="price" class="col-lg-2 col-form-label">Price: </label>

                    <div class="col-lg-6">
                        <input type="number" name="price" id="price" class="form-control m-input {{ $errors->has('price') ?
                            'form-control-danger' :'' }}" placeholder="Please enter a price" value="{{ $item->price }}" required>

                        <div id="price-error" class="form-control-feedback">
                            {{ $errors->first('price') }}
                        </div>

                        <span class="m-form__help">The price of this item.</span>
                    </div>
                </div>
                <!--/. Price -->

                <!-- Quantity -->
                <div class="form-group m-form__group row {{ $errors->has('quantity') ? 'has-danger' : '' }}">
                    <label for="quantity" class="col-lg-2 col-form-label">Quantity: </label>

                    <div class="col-lg-6">
                        <input type="number" name="quantity" id="quantity" class="form-control m-input {{ $errors->has('quantity') ?
                            'form-control-danger' :'' }}" placeholder="Please enter a quantity" value="{{ $item->quantity }}">

                        <div id="quantity-error" class="form-control-feedback">
                            {{ $errors->first('quantity') }}
                        </div>

                        <span class="m-form__help">How many are this item. <em><strong>Empty</strong> means no limit.</em></span>
                    </div>
                </div>
                <!--/. Quantity -->

                <!-- Bottom -->
                <div class="m-portlet__foot m-portlet__no-border m-portlet__foot--fit">
                    <div class="m-form__actions m-form__actions--solid">
                        <div class="row">
                            <div class="col-lg-2"></div>
                            <div class="col-lg-6">
                                <button type="submit" id="submit" class="btn btn-brand">Update</button>
                                <a type="button" href="{{ route('root.items.index') }}" class="btn btn-secondary">Cancel</a>
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
        var item = function () {
            // form validate
            var formValidationInit = function () {
                $("form[id=form-item-update]").validate({
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