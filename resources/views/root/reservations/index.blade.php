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
                        This is the list of reservations
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
                            <!-- Source -->
                            <div class="col-md-4">
                                <div class="m-form__group m-form__group--inline">
                                    <div class="m-form__label">
                                        <label>Source:</label>
                                    </div>
                                    <div class="m-form__control">
                                        <select class="form-control m-bootstrap-select" id="source">
                                            <option value="">All</option>
                                            <option value="user">Customer</option>
                                            <option value="superuser">Staff</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="d-md-none m--margin-bottom-10"></div>
                            </div>
                            <!--/. Source -->

                            <!-- Status -->
                            <div class="col-md-4">
                                <div class="m-form__group m-form__group--inline">
                                    <div class="m-form__label">
                                        <label>Status:</label>
                                    </div>
                                    <div class="m-form__control">
                                        <select class="form-control m-bootstrap-select" id="status">
                                            <option value="">All</option>
                                            <option value="pending">Pending</option>
                                            <option value="paid">Paid</option>
                                            <option value="cancelled">Reserved</option>
                                            <option value="cancelled">Cancelled</option>
                                            <option value="waiting">Waiting</option>
                                            <option value="void">Void</option>
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
                        <a href="{{ route('root.reservation.search-items') }}" class="btn btn-primary m-btn m-btn--custom m-btn--icon m-btn--air m-btn--pill">
                            <span><i class="la la-plus"></i><span>New reservation</span></span>
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
                        <th title="#">#</th>
                        <th title="Source">Source</th>
                        <th title="Customer">Customer</th>
                        <th title="Checkin">Checkin</th>
                        <th title="Checkout">Checkout</th>
                        <th title="Payable">Payable</th>
                        <th title="Paid">Paid</th>
                        <th title="Status">Status</th>
                        <th title="Actions">Actions</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach($reservations as $index => $reservation)
                        @include('root.reservations.reservation')
                    @endforeach
                </tbody>
            </table>
            <!--/. Categories -->
        </div>
        <!--/. Portlet body -->
    </div>
    <!--/. Portlet -->
@endsection

@section('scripts')
    <script>
        $(document).ready(function() {
            var categories = function() {
                //== Private functions

                // category initializer
                var categoriesInit = function() {

                    var datatable = $('table[id=table]').mDatatable({
                        data: {
                            saveState: { cookie: false },
                        },
                        search: {
                            input: $('#generalSearch'),
                        },
                        layout: {
                            theme: 'default',
                            class: '',
                            scroll: true,
                            height: 350,
                            footer: false
                        },
                        columns: [
                            {
                                field: '#',
                                width: 25
                            },
                            {
                                field: 'Source',
                                width: 75
                            },
                            {
                                field: 'Customer',
                                width: 100
                            },
                            {
                                field: 'Checkin',
                                width: 75
                            },
                            {
                                field: 'Checkout',
                                width: 75
                            },
                            {
                                field: 'Payable',
                                width: 75
                            },
                            {
                                field: 'Paid',
                                width: 75
                            },
                            {
                                field: 'Status',
                                width: 50
                            },
                            {
                                field: 'Actions',
                                width: 100
                            }
                        ],
                    });

                    $('select[id=source]').on('change', function() {
                        datatable.search($(this).val().toLowerCase(), 'Source');
                    });

                    $('select[id=status]').on('change', function() {
                        datatable.search($(this).val().toLowerCase(), 'Status');
                    });

                    $('.m-bootstrap-select').selectpicker();
                };

                return {
                    init: function() {
                        categoriesInit();
                    },
                };
            }();

            categories.init();
        });
    </script>
@endsection