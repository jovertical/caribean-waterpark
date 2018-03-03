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

        <div class="m-portlet__body" style="width: 1000px; overflow: auto;">
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
                                            <option value="frontend">Customer</option>
                                            <option value="root">Staff</option>
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
                                            <option value="1">Pending</option>
                                            <option value="2">Reserved</option>
                                            <option value="3">Paid</option>
                                            <option value="4">Cancelled</option>
                                            <option value="5">Waiting</option>
                                            <option value="6">Void</option>
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

                <div class="row align-items-center mt-2">
                    <div class="col-xl-8 order-2 order-xl-1">
                        <div class="form-group m-form__group row align-items-center">
                            <!-- Date -->
                            <div class="col-md-4">
                                <div class="m-form__group m-form__group--inline">
                                    <div class="m-form__label">
                                        <label>Date:</label>
                                    </div>
                                    <div class="m-form__control">
                                        <select class="form-control m-bootstrap-select" id="status">
                                            <option value="created">Created</option>
                                            <option value="checkin">Checkin</option>
                                            <option value="checkout">Checkout</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="d-md-none m--margin-bottom-10"></div>
                            </div>
                            <!--/. Date -->

                            <!-- From -->
                            <div class="col-md-4">
                                <div class="m-form__group m-form__group--inline">
                                    <div class="m-form__label">
                                        <label>From:</label>
                                    </div>
                                    <div class="m-form__control">
                                        <div class="input-group m-input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="la la-calendar"></i></span>
                                            </div>

                                            <input type="text" name="from" id="from" class="form-control m-input" readonly>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--/. From -->

                            <!-- To -->
                            <div class="col-md-4">
                                <div class="m-form__group m-form__group--inline">
                                    <div class="m-form__label">
                                        <label>To:</label>
                                    </div>
                                    <div class="m-form__control">
                                        <div class="input-group m-input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="la la-calendar"></i></span>
                                            </div>

                                            <input type="text" name="to" id="to" class="form-control m-input" readonly>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--/. To -->
                        </div>
                    </div>

                    <div class="col-xl-4 order-1 order-xl-2 m--align-right"></div>
                </div>
            </div>
            <!--end: Search Form -->

            <!-- Reservations -->
            <div>
                <table id="table" class="m-datatable">
                    <thead>
                        <tr>
                            <th title="#">#</th>
                            <th title="Source">Source</th>
                            <th title="Reference number">Reference #</th>
                            <th title="Customer">Customer</th>
                            <th title="Checkin date">Checkin</th>
                            <th title="Checkout date">Checkout</th>
                            <th title="Price payable">Payable</th>
                            <th title="Price paid">Paid</th>
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
            </div>
            <!--/. Reservations -->
        </div>
        <!--/. Portlet body -->
    </div>
    <!--/. Portlet -->
@endsection

@section('scripts')
    <script>
        $(document).ready(function() {
            var reservations = function() {
                //== Private functions

                // reservations initializer
                var reservationsInit = function() {

                    var datatable = $('.m-datatable').mDatatable({
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
                            footer: false
                        },
                        columns: [
                            {
                                field: '#',
                                width: 30
                            },
                            {
                                field: 'Source',
                                width: 75
                            },
                            {
                                field: 'Reference #',
                                width: 100
                            },
                            {
                                field: 'Customer',
                                width: 175,
                                template: function(data) {
                                    var number = mUtil.getRandomInt(1, 14);
                                    var image;

                                    if (image == '') {
                                        output =    '<div class="m-card-user m-card-user--sm">\
                                                        <div class="m-card-user__pic">\
                                                            <img src="' + image + '" class="m--img-rounded m--marginless" alt="photo">\
                                                        </div>\
                                                        <div class="m-card-user__details">\
                                                            <span class="m-card-user__name">' + data.Customer + '</span>\
                                                            <a href="" class="m-card-user__email m-link">' + data.Customer + '</a>\
                                                        </div>\
                                                    </div>';
                                    } else {
                                        var stateNo = mUtil.getRandomInt(0, 7);

                                        var states = [
                                            'success',
                                            'brand',
                                            'danger',
                                            'accent',
                                            'warning',
                                            'metal',
                                            'primary',
                                            'info'
                                        ];

                                        var state = states[stateNo];
                                    }

                                    output =    '<div class="m-card-user m-card-user--sm">\
                                                    <div class="m-card-user__pic">\
                                                        <div class="m-card-user__no-photo m--bg-fill-' + state + '">\
                                                            <span>' + data.Customer.substring(0, 1) + '</span>\
                                                        </div>\
                                                    </div>\
                                                    <div class="m-card-user__details">\
                                                        <span class="m-card-user__name">' + data.Customer + '</span>\
                                                    </div>\
                                                </div>';

                                    return output;
                                },
                            },
                            {
                                field: 'Checkin',
                                width: 85
                            },
                            {
                                field: 'Checkout',
                                width: 85
                            },
                            {
                                field: 'Payable',
                                width: 100
                            },
                            {
                                field: 'Paid',
                                width: 100
                            },
                            {
                                field: 'Status',
                                width: 75,
                                template: function(row) {
                                    var status = {
                                        1: {'title': 'Pending', 'class': ' m-badge--warning'},
                                        2: {'title': 'Reserved', 'class': ' m-badge--info'},
                                        3: {'title': 'Paid', 'class': ' m-badge--success'},
                                        4: {'title': 'Cancelled', 'class': ' m-badge--danger'},
                                        5: {'title': 'Waiting', 'class': ' m-badge--brand'},
                                        6: {'title': 'Void', 'class': ' m-badge--metal'}
                                    };

                                    return  '<span class="m-badge ' + status[row.Status].class + ' m-badge--wide">' +
                                                '<span class="text-white">' + status[row.Status].title + '</span>' + '</span>';
                                },
                            },
                            {
                                field: 'Actions',
                                width: 100,
                                sortable: false
                            }
                        ],
                    });

                    $('select[id=source]').on('change', function() {
                        datatable.search($(this).val().toLowerCase(), 'Source');
                    });

                    $('select[id=status]').on('change', function() {
                        datatable.search($(this).val().toLowerCase(), 'Status');
                    });

                    $('select[id=date]').on('change', function() {
                        datatable.search($(this).val().toLowerCase(), 'Date');
                    });

                    $('input[id=from]').on('change', function() {
                        datatable.search($(this).val().toLowerCase(), 'Checkin');
                    });

                    $('input[id=to]').on('change', function() {
                        datatable.search($(this).val().toLowerCase(), 'Checkout');
                    });
                };

                // selects
                var selectsInit = function () {
                    $('.m-bootstrap-select').selectpicker({});
                }
                //. selects

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
                        reservationsInit();
                        selectsInit();
                        datesInit();
                    },
                };
            }();

            reservations.init();
        });
    </script>
@endsection