@extends('root.layouts.main')

@section('sidebar')
    @component('root.components.sidebar')
    @endcomponent
@endsection

@section('content')
    <div class="m-portlet">
        <!-- Head-->
        <div class="m-portlet__head">
            <div class="m-portlet__head-caption">
                <div class="m-portlet__head-title">
                    <span class="m-portlet__head-icon m--hide"><i class="la la-gear"></i></span>

                    <h3 class="m-portlet__head-text">Select image for <em>{{ $superuser->name }}</em></h3>
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
                        <form method="POST" action="{{ route('root.superusers.image.upload', $superuser) }}" class="m-dropzone dropzone"
                        id="form-superuser-upload">
                            {{ csrf_field() }}

                            <div class="m-dropzone__msg dz-message">
                                <h3 class="m-dropzone__msg-title">Drop files here or click to upload.</h3>
                                <span class="m-dropzone__msg-desc">File formats supported:
                                    <strong>jpg/jpeg</strong>, <strong>png</strong>, <strong>gif</strong>
                                    <br />
                                    Max number of files: <strong>1</strong>
                                    <br />
                                    Max file size: <strong>6mb</strong>
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
                                <a href="{{ route('root.superusers.index') }}" class="btn btn-brand">Finish</a>
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
        Dropzone.options.formSuperuserUpload = {
            paramName: 'image',
            addRemoveLinks : true,
            maxFiles: 1,
            maxFilesize: 6,
            acceptedFiles: ".jpeg,.jpg,.png,.gif",
            init: function() {
                var $myDropzone = this;

                $myDropzone.on('success', function(file, response) {
                    var fileUploaded = file.previewElement.querySelector("[data-dz-name]");
                    fileUploaded.innerHTML = response.file_name;
                });

                $myDropzone.on('removedfile', function(file) {
                    var fileUploaded = file.previewElement.querySelector("[data-dz-name]").innerHTML;

                    $.ajax({
                        type: 'DELETE',
                        url: '{{ route('root.superusers.image.destroy', $superuser) }}',
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        data: {
                            file_name: fileUploaded
                        },
                        dataType: 'html',
                        success: function(data) {
                            //
                        }
                    });
                });

                $.get('{{ route('root.superusers.image.uploaded', $superuser) }}', function(data) {
                    $.each(data.images, function (index, image) {
                        var file = {directory: image.directory, name: image.name, size: image.size};

                        $myDropzone.options.addedfile.call($myDropzone, file);
                        $myDropzone.options.thumbnail.call($myDropzone, file, file.directory + '/' + file.name);
                        $myDropzone.emit("complete", file);
                        $myDropzone.files.push(file);
                    });
                });
            }
        };
    </script>
@endsection