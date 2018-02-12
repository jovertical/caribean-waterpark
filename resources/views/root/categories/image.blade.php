@extends('root.layouts.main')

@section('content')
    <div class="m-portlet">
        <!-- Head-->
        <div class="m-portlet__head">
            <div class="m-portlet__head-caption">
                <div class="m-portlet__head-title">
                    <span class="m-portlet__head-icon m--hide"><i class="la la-gear"></i></span>

                    <h3 class="m-portlet__head-text">Select image for <em>{{ $category->name }}</em></h3>
                </div>
            </div>
        </div>
        <!--/. Head-->

        <!-- Body-->
        <div class="m-form m-form--fit m-form--label-align-right m-form--group-seperator-dashed m-form--state">

            <div class="m-portlet__body">
                <!-- Image -->
                <div class="form-group m-form__group row">
                    <label class="col-lg-2 col-form-label">Image: </label>

                    <div class="col-lg-6">
                        <form method="POST" action="{{ route('root.categories.image', $category->id) }}" class="m-dropzone dropzone" id="form-category-upload">
                            {{ csrf_field() }}

                            <div class="m-dropzone__msg dz-message">
                                <h3 class="m-dropzone__msg-title">Drop files here or click to upload.</h3>
                                <span class="m-dropzone__msg-desc">File formats supported:
                                    <strong>jpg/jpeg</strong>, <strong>png</strong>, <strong>gif</strong>
                                    <br />
                                    Max file size is <strong>4mb</strong>
                                </span>
                            </div>
                        </form>

                        <span class="m-form__help">This will help in marketing your items.</span>
                    </div>
                </div>
                <!--/. Image -->

                <!-- Bottom -->
                <div class="m-portlet__foot m-portlet__no-border m-portlet__foot--fit">
                    <div class="m-form__actions m-form__actions--solid">
                        <div class="row">
                            <div class="col-lg-2"></div>
                            <div class="col-lg-6">
                                <a type="button" href="{{ route('root.categories.index') }}" class="btn btn-brand">Finish</a>
                            </div>
                        </div>
                    </div>
                </div>
                <!--/. Bottom -->
            </div>
        </div>
        <!--/. Body-->
    </div>
@endsection

@section('scripts')
    <script>
        Dropzone.options.formCategoryUpload = {
            paramName: 'image',
            addRemoveLinks : true,
            maxFiles: 1,
            maxFilesize: 4,
            acceptedFiles: ".jpeg,.jpg,.png,.gif",
            init: function() {
                this.on("success", function(file, response) {
                    // console.log(response);
                });

                this.on("removedfile", function(file) {
                    $.ajax({
                        type: 'DELETE',
                        url: '{{ route('root.categories.image.destroy', $category->id) }}',
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        data: {
                            //
                        },
                        dataType: 'html',
                        success: function(data) {
                            // console.log(data);
                        }
                    });
                });
            }
        };
    </script>
@endsection