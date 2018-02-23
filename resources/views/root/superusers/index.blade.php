@extends('root.layouts.main')

@section('content')
    <!-- Portlet -->
    <div class="m-portlet m-portlet--mobile">

        <!-- Portlet head -->
        <div class="m-portlet__head">
            <div class="m-portlet__head-caption">
                <div class="m-portlet__head-title">
                    <h3 class="m-portlet__head-text">
                        This is the list of superusers
                    </h3>
                </div>
            </div>
        </div>
        <!--/. Portlet head -->

        <!-- Portlet body -->
        <div class="m-portlet__body">
            <!--begin: Search Form -->
            <div class="m-form m-form--label-align-right m--margin-top-20 m--margin-bottom-30">
                <div class="row align-items-center">
                    <div class="col-xl-8 order-2 order-xl-1">
                        <div class="form-group m-form__group row align-items-center">
                            <!-- Search -->
                            <div class="col-md-4">
                                <div class="m-input-icon m-input-icon--left">
                                    <input type="text" class="form-control m-input" placeholder="Search..." id="generalSearch">
                                    <span class="m-input-icon__icon m-input-icon__icon--left">
                                        <span><i class="la la-search"></i></span>
                                    </span>
                                </div>
                            </div>
                            <!--/. Search -->
                        </div>
                    </div>

                    <div class="col-xl-4 order-1 order-xl-2 m--align-right">
                        <a href="{{ route('root.superusers.create') }}" class="btn btn-primary m-btn m-btn--custom m-btn--icon m-btn--air m-btn--pill">
                            <span><i class="la la-plus"></i><span>New superuser</span></span>
                        </a>
                        <div class="m-separator m-separator--dashed d-xl-none"></div>
                    </div>
                </div>
            </div>
            <!--end: Search Form -->

            <!-- Superusers -->
            <table id="table" class="m-datatable" width="100%" data-form="table">
                <thead>
                    <tr>
                        <th title="#">#</th>
                        <th title="Image">Image</th>
                        <th title="Name">Name</th>
                        <th title="Gender">Gender</th>
                        <th title="Birthdate">Birthdate</th>
                        <th title="Email">Email</th>
                        <th title="Phone">Phone</th>
                        <th title="Actions">Actions</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach($superusers as $index => $superuser)
                        @include('root.superusers.superuser')
                    @endforeach
                </tbody>
            </table>
            <!--/. Superusers -->
        </div>
        <!--/. Portlet body -->
    </div>
    <!--/. Portlet -->

    @component('root.components.modal_confirmation')
        @slot('title')
            Confirm action
        @endslot

        You can't undo this action. Are you sure?
    @endcomponent
@endsection

@section('scripts')
    <script>
        $(document).ready(function() {
            var superusers = function() {
                //== Private functions

                // superusers initializer
                var superusersInit = function() {

                    var datatable = $('#table').mDatatable({
                        data: {
                            saveState: { cookie: false },
                        },
                        layout: {
                            theme: 'default',
                            class: '',
                            scroll: true,
                            height: 350,
                            footer: false
                        },
                        search: {
                            input: $('#generalSearch'),
                        },
                        columns: [
                            {
                                field: '#',
                                width: 25
                            },
                            {
                                field: 'Image',
                                width: 50
                            },
                            {
                                field: 'Name',
                                width: 100
                            },
                            {
                                field: 'Gender',
                                width: 50
                            },
                            {
                                field: 'Birthdate',
                                width: 75
                            },
                            {
                                field: 'Email',
                                width: 100
                            },                           
                            {
                                field: 'Phone',
                                width: 100
                            },
                            {
                                field: 'Actions',
                                width: 100
                            }
                        ],
                    });
                };

                return {
                    init: function() {
                        superusersInit();
                    },
                };
            }();

            superusers.init();
        });
    </script>
@endsection