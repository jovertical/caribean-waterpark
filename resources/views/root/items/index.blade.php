@extends('root.layouts.main')

@section('content')
    <!-- Portlet -->
    <div class="m-portlet m-portlet--mobile">

        <!-- Portlet head -->
        <div class="m-portlet__head">
            <div class="m-portlet__head-caption">
                <div class="m-portlet__head-title">
                    <h3 class="m-portlet__head-text">
                        This is the list of items
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
                            <!-- Category -->
                            <div class="col-md-4">
                                <div class="m-form__group m-form__group--inline">
                                    <div class="m-form__label">
                                        <label>Category:</label>
                                    </div>
                                    <div class="m-form__control">
                                        <select id="category" class="form-control m-bootstrap-select">
                                            <option value="">All</option>
                                            @foreach($categories as $category)
                                                <option value="{{ $category->name }}">{{ Str::ucfirst($category->name) }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="d-md-none m--margin-bottom-10"></div>
                            </div>
                            <!--/. Category -->

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
                        <a href="{{ route('root.items.create') }}" class="btn btn-primary m-btn m-btn--custom m-btn--icon m-btn--air m-btn--pill">
                            <span><i class="la la-plus"></i><span>New item</span></span>
                        </a>
                        <div class="m-separator m-separator--dashed d-xl-none"></div>
                    </div>
                </div>
            </div>
            <!--end: Search Form -->

            <!-- Categories -->
            <table id="table" class="m-datatable" width="100%" data-form="table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Image</th>
                        <th>Category</th>
                        <th>Name</th>
                        <th>Description</th>
                        <th>Price</th>
                        <th>Quantity</th>
                        <th>Actions</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach($items as $index => $item)
                        @include('root.items.item')
                    @endforeach
                </tbody>
            </table>
            <!--/. Categories -->
        </div>
        <!--/. Portlet body -->
    </div>
    <!--/. Portlet -->

    @component('root.components.modal')
        @slot('title')
            Confirm action
        @endslot

        You can't undo this action. Are you sure?
    @endcomponent
@endsection

@section('scripts')
    <script>
        $(document).ready(function() {
            var items = function() {
                //== Private functions

                // category initializer
                var itemsInit = function() {

                    var datatable = $('.m-datatable').mDatatable({
                        data: {
                            saveState: { cookie: false }
                        },
                        layout: {
                            scroll: true,
                        },
                        search: {
                            input: $('#generalSearch'),
                        },
                        columns: [
                            {
                                field: '#',
                                title: '#',
                                width: 15
                            },
                            {
                                field: 'Image',
                                title: 'image',
                                width: 50
                            },
                            {
                                field: 'Category',
                                title: 'category'
                            },
                            {
                                field: 'Name',
                                title: 'name'
                            },
                            {
                                field: 'Description',
                                title: 'name'
                            },
                            {
                                field: 'Price',
                                title: 'price'
                            },
                            {
                                field: 'Quantity',
                                title: 'quantity'
                            }
                        ],
                    });

                    $('select[id=category]').on('change', function() {
                        datatable.search($(this).val().toLowerCase(), 'Category');
                    });

                    $('select[id=category]').selectpicker();
                };

                return {
                    init: function() {
                        itemsInit();
                    },
                };
            }();

            items.init();
        });
    </script>
@endsection