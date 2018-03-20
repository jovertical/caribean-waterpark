@extends('root.layouts.main')

@section('sidebar')
    @component('root.components.sidebar')
    @endcomponent
@endsection

@section('content')
    <!-- Portlet -->
    <div class="m-portlet m-portlet--mobile">

        <!-- Portlet head -->
        <div class="m-portlet__head">
            <div class="m-portlet__head-caption">
                <div class="m-portlet__head-title">
                    <h3 class="m-portlet__head-text">
                        This is the list of coupons
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
                            <!-- Status -->
                            <div class="col-md-4">
                                <div class="m-form__group m-form__group--inline">
                                    <div class="m-form__label">
                                        <label>Status:</label>
                                    </div>
                                    <div class="m-form__control">
                                        <select class="form-control m-bootstrap-select" id="status">
                                            <option value="">All</option>
                                            <option value="1">Active</option>
                                            <option value="2">Inactive</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="d-md-none m--margin-bottom-10"></div>
                            </div>
                            <!--/. Status -->

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
                        <a href="{{ route('root.coupons.create') }}" class="btn btn-primary m-btn m-btn--custom m-btn--icon m-btn--air m-btn--pill">
                            <span><i class="la la-plus"></i><span>New coupon</span></span>
                        </a>
                        <div class="m-separator m-separator--dashed d-xl-none"></div>
                    </div>
                </div>
            </div>
            <!--end: Search Form -->

            <!-- Categories -->
            <table id="table" class="m-datatable" width="100%">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Image</th>
                        <th>Name</th>
                        <th>Description</th>
                        <th>Amount Deducted</th>
                        <th>Valid From</th>
                        <th>Valid Until</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach($coupons as $index => $coupon)
                        @include('root.coupons.coupon')
                    @endforeach
                </tbody>
            </table>
            <!--/. Categories -->
        </div>
        <!--/. Portlet body -->
    </div>
    <!--/. Portlet -->

    <!-- Edit Form -->
    <form method="GET" action="" id="editCoupon" style="display: none;">
        {{ method_field('PUT') }}
    </form>

    <!-- Destroy Form -->
    <form method="POST" action="" id="destroyCoupon" style="display: none;">
        {{ method_field('DELETE') }}
        {{ csrf_field() }}
    </form>

    <!-- Destroy Modal -->
    @component('root.components.modal')
        @slot('name')
            destroyCouponConfirmation
        @endslot

        You are deleting this coupon. Doing so will also delete the items under it. You can't undo this action!
    @endcomponent

    <!-- Toggle Form -->
    <form method="POST" action="" id="toggleCoupon" style="display: none;">
        {{ method_field('PATCH') }}
        {{ csrf_field() }}
    </form>

    <!-- Toggle Modal -->
    @component('root.components.modal')
        @slot('name')
            toggleCouponConfirmation
        @endslot

        You are toggling this coupon. This will affect the status of items under it.
    @endcomponent
@endsection

@section('scripts')
    <script>
        var categories = function() {
            //== Private functions

            // coupon initializer
            var categoriesInit = function() {

                var datatable = $('table[id=table]').mDatatable({
                    data: {
                        saveState: { cookie: false },
                    },
                    layout: {
                        theme: 'default',
                        class: '',
                        scroll: false,
                        footer: false
                    },
                    search: {
                        input: $('#generalSearch'),
                    },
                    columns: [
                        {
                            field: '#',
                            width: 30,
                            type: 'number'
                        },
                        {
                            field: 'Image',
                            width: 50,
                            sortable: false
                        },
                        {
                            field: 'Name',
                            width: 100
                        },
                        {
                            field: 'Description',
                            width: 100
                        },
                        {
                            field: 'Items',
                            width: 50
                        },
                        {
                            field: 'Status',
                            width: 75,
                            template: function(row) {
                                var status = {
                                    1: {'title': 'Active', 'class': 'm-badge--success'},
                                    2: {'title': 'Inactive', 'class': ' m-badge--metal'},
                                };

                                return '<span class="m-badge ' + status[row.Status].class + ' m-badge--wide">' +
                                            status[row.Status].title + '</span>';
                            },
                        },
                        {
                            field: 'Actions',
                            width: 100,
                            sortable: false
                        }
                    ]
                });

                $('select[id=status]').on('change', function() {
                    datatable.search($(this).val().toLowerCase(), 'Status');
                }).selectpicker();
            };

            return {
                init: function() {
                    categoriesInit();
                },
            };
        }();

        $(document).ready(function() {
            categories.init();

            // edit
            $('.edit-coupon').on('click', function(e) {
                e.preventDefault();

                var link = $(this);
                var form = $(link.data('form'));
                var action = link.data('action');

                // assign action to hidden form action attribute.
                form.attr({action: action});

                form.submit();
            });

            // delete confirmation
            $('.destroy-coupon').on('click', function(e) {
                e.preventDefault();

                var link = $(this);
                var form = $(link.data('form'));
                var action = link.data('action');
                var modal = $(link.data('target'));

                // assign action to hidden form action attribute.
                form.attr({action: action});

                modal.modal({ backdrop: 'static', keyboard: false}).on('click', '#btn-confirm', function() {
                    form.submit();
                });
            });

            // toggle
            $('.toggle-coupon').on('click', function(e) {
                e.preventDefault();

                var link = $(this);
                var form = $(link.data('form'));
                var action = link.data('action');
                var modal = $(link.data('target'));

                // assign action to hidden form action attribute.
                form.attr({action: action});

                modal.modal({ backdrop: 'static', keyboard: false}).on('click', '#btn-confirm', function() {
                    form.submit();
                });
            });
        });
    </script>
@endsection