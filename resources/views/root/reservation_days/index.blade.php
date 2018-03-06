@extends('root.layouts.main')

@section('sidebar')
    @component('root.components.sidebar')
        <!-- Print -->
        <li class="m-menu__item" aria-haspopup="true">
            <a href="javascript:void(0);" class="m-menu__link">
                <i class="m-menu__link-icon la la-print"></i>
                <span class="m-menu__link-title">
                    <span class="m-menu__link-text">Print</span>
                </span>
            </a>
        </li>
        <!--/. Print -->
    @endcomponent
@endsection

@section('content')
    <!--begin::Portlet-->
    <div class="m-portlet">
        <div class="m-portlet__head">
            <div class="m-portlet__head-caption">
                <div class="m-portlet__head-title">
                    <h3 class="m-portlet__head-text">Days</h3>
                </div>
            </div>
        </div>

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
                </div>
            </div>
            <!--end: Search Form -->

            <table id="table" class="m-datatable" width="100%">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Date</th>
                        <th>Entered</th>
                        <th>Entered at</th>
                        <th>Exited</th>
                        <th>Exited at</th>
                        <th>Adults</th>
                        <th>Childrens</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach($days as $index => $day)
                        @include('root.reservation_days.day')
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <!--end::Portlet-->
@endsection

@section('scripts')
    <script>
        var reservation_days = function() {
            //== Private functions

            // days initializer
            var reservation_daysInit = function() {

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
                            field: 'Date',
                            width: 100
                        },
                        {
                            field: 'Entered',
                            width: 75, 
                            template: function(row) {
                                var status = {
                                    0: {'title': 'No', 'class': ' m-badge--danger'},
                                    1: {'title': 'Yes', 'class': ' m-badge--success'}
                                };

                                return  '<span class="m-badge ' + status[row.Entered].class + ' m-badge--wide">' +
                                            '<span class="text-white">' + status[row.Entered].title + '</span>' + '</span>';
                            }
                        },
                        {
                            field: 'Entered at',
                            width: 100
                        },
                        {
                            field: 'Exited',
                            width: 75,
                            template: function(row) {
                                var status = {
                                    0: {'title': 'No', 'class': ' m-badge--danger'},
                                    1: {'title': 'Yes', 'class': ' m-badge--success'}
                                };

                                return  '<span class="m-badge ' + status[row.Exited].class + ' m-badge--wide">' +
                                            '<span class="text-white">' + status[row.Exited].title + '</span>' + '</span>';
                            }
                        },
                        {
                            field: 'Exited at',
                            width: 100
                        },
                        {
                            field: 'Adults',
                            width: 75
                        },
                        {
                            field: 'Childrens',
                            width: 75
                        },
                    ]
                });
            };

            return {
                init: function() {
                    reservation_daysInit();
                },
            };
        }();

        $(document).ready(function() {
            reservation_days.init();
        });
    </script>
@endsection