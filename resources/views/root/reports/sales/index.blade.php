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
                    <h3 class="m-portlet__head-text">Sales Report</h3>
                </div>
            </div>
        </div>

        <div class="m-portlet__body m--margin-bottom-20">
            <!-- Filters -->
            <form method="GET" action="{{ route('root.reports.sales') }}" class="m-form m-form--label-align-right m--margin-bottom-30">
                <div class="row align-items-center mb-md-2">
                    <div class="col-xl-8 order-2 order-xl-1">
                        <div class="form-group m-form__group row align-items-center">
                            <!-- Source -->
                            <div class="col-md-4">
                                <div class="m-form__group m-form__group--inline">
                                    <div class="m-form__label">
                                        <label>Source:</label>
                                    </div>
                                    <div class="m-form__control">
                                        <select name="src" id="src" class="form-control m-bootstrap-select">
                                            <option value="" {{ Request::get('src') == null ?
                                                'selected' : '' }}>All</option>
                                            <option value="front" {{ Request::get('src') == 'front' ?
                                                'selected' : '' }}>Customer</option>
                                            <option value="root" {{ Request::get('src') == 'root' ?
                                                'selected' : '' }}>Staff</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="d-md-none m--margin-bottom-10"></div>
                            </div>
                            <!--/. Source -->

                            <!-- Reservation date -->
                            <div class="col-md-4">
                                <div class="m-form__group m-form__group--inline">
                                    <div class="m-form__label">
                                        <label>Date:</label>
                                    </div>
                                    <div class="m-form__control">
                                        <select name="rd" id="rd" class="form-control m-bootstrap-select">
                                            <option value="created_at" {{ Request::get('rd') == 'created_at' ?
                                                'selected' : '' }}>Created</option>
                                            <option value="checkin_date" {{ Request::get('rd') == 'checkin_date' ?
                                                'selected' : '' }}>Check-in</option>
                                            <option value="checkout_date" {{ Request::get('rd') == 'checkout_date' ?
                                                'selected' : '' }}>Check-out</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="d-md-none m--margin-bottom-10"></div>
                            </div>
                            <!--/. Reservation date -->

                            <!-- Date Scope -->
                            <div class="col-md-4">
                                <div class="m-form__group m-form__group--inline">
                                    <div class="m-form__label">
                                        <label>Scope:</label>
                                    </div>
                                    <div class="m-form__control">
                                        <select name="ds" id="ds" class="form-control m-bootstrap-select">
                                            <option value="" {{ Request::get('ds') == null ?
                                                'selected' : '' }}>All</option>
                                            <option value="0" {{ Request::get('ds') == 0 ?
                                                'selected' : '' }}>Today</option>
                                            <option value="1" {{ Request::get('ds') == 1 ?
                                                'selected' : '' }}>Yesterday</option>
                                            <option value="2" {{ Request::get('ds') == 2 ?
                                                'selected' : '' }}>Last 7 Days</option>
                                            <option value="3" {{ Request::get('ds') == 3 ?
                                                'selected' : '' }}>Last 30 Days</option>
                                            <option value="4" {{ Request::get('ds') == 4 ?
                                                'selected' : '' }}>This Month</option>
                                            <option value="5" {{ Request::get('ds') == 5 ?
                                                'selected' : '' }}>Last Month</option>
                                            <option value="6" {{ Request::get('ds') == 6 ?
                                                'selected' : '' }}>Custom Range</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="d-md-none m--margin-bottom-10"></div>
                            </div>
                            <!--/. Date Scope -->
                        </div>
                    </div>

                    <div class="col-xl-4 order-1 order-xl-2 m--align-right">
                        <button type="submit" class="btn btn-primary m-btn m-btn--custom m-btn--icon m-btn--air m-btn--pill">
                            <span><i class="la la-search"></i><span>Filter</span></span>
                        </button>
                        <div class="m-separator m-separator--dashed d-xl-none"></div>
                    </div>
                </div>

                <div class="row align-items-center">
                    <div class="col-md-8">
                        <div class="form-group m-form__group row align-items-center">
                            <!-- From -->
                            <div class="col-md-4 offset-md-4 date-range {{ Request::get('ds') == 6 ? '' : 'd-none' }}">
                                <div class="m-form__group m-form__group--inline">
                                    <div class="m-form__label">
                                        <label>From:</label>
                                    </div>
                                    <div class="m-form__control">
                                        <input type="text" name="from" id="from" class="form-control m-input"
                                            value="{{ Request::get('from') }}" readonly>
                                    </div>
                                </div>
                                <div class="d-md-none m--margin-bottom-10"></div>
                            </div>
                            <!--/. From -->

                            <!-- To -->
                            <div class="col-md-4 date-range {{ Request::get('ds') == 6 ? '' : 'd-none' }}">
                                <div class="m-form__group m-form__group--inline">
                                    <div class="m-form__label">
                                        <label>To:</label>
                                    </div>
                                    <div class="m-form__control">
                                        <input type="text" name="to" id="to" class="form-control m-input"
                                            value="{{ Request::get('to') }}" readonly>
                                    </div>
                                </div>
                                <div class="d-md-none m--margin-bottom-10"></div>
                            </div>
                            <!--/. To -->
                        </div>
                    </div>
                </div>
            </form>
            <!--/. Filters -->

            <div class="m-section">
                <div class="m-section__content">
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>Ref. #</th>
                                    <th>Status</th>
                                    <th>Source</th>
                                    <th>Date</th>
                                    <th>Tax</th>
                                    <th>Discount</th>
                                    <th>Gross Profit</th>
                                    <th>Net Profit</th>
                                    <th>Paid</th>
                                    <th>Balance</th>
                                </tr>
                            </thead>

                            <tbody>
                                @foreach($data as $metadata)
                                    @include('root.reports.sales.sale')
                                @endforeach
                            </tbody>

                            <tfoot>
                                <tr>
                                    <th colspan="4" scope="row">Totals</th>
                                    <td>{{ Helper::moneyString($totals['price_taxable']) }}</td>
                                    <td>{{ Helper::moneyString($totals['price_deductable']) }}</td>
                                    <td>{{ Helper::moneyString($totals['gross_profit']) }}</td>
                                    <td>{{ Helper::moneyString($totals['net_profit']) }}</td>
                                    <td>{{ Helper::moneyString($totals['price_paid']) }}</td>
                                    <td>{{ Helper::moneyString($totals['balance']) }}</td>
                                </tr>
                            </tfoot>
                        </table>

                        <!-- Pagination -->
                        @if(count($data))
                            <div class="d-flex justify-content-center align-items-center mt-5">
                                {{ $data->appends(Request::all())->links() }}
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        var sales = function () {
            var selectsInit = function () {
                var reservation_date = $('select[id=rd]');
                var date_scope = $('select[id=ds]');
                var source = $('select[id=src]');

                reservation_date.selectpicker();
                date_scope.selectpicker();
                source.selectpicker();

                date_scope.on('change', function(e) {
                    var selected_value = $(this).find(':selected').val();
                    if (selected_value == 6) {
                        $('.date-range').removeClass('d-none');
                    } else {
                        $('.date-range').addClass('d-none');
                    }

                    var today = '{{ Carbon::now() }}';
                    var ranges = [
                        [moment(today), moment(today)],
                        [moment(today).subtract(1, 'days'), moment(today).subtract(1, 'days')],
                        [moment(today).subtract(6, 'days'), moment(today)],
                        [moment(today).subtract(29, 'days'), moment(today)],
                        [moment(today).startOf('month'), moment(today).endOf('month')],
                        [moment(today).subtract(1, 'month').startOf('month'),
                                            moment(today).subtract(1, 'month').endOf('month')]
                    ];

                    $('input[id=from]').val(moment(ranges[selected_value][0]).format('Y-MM-DD'));
                    $('input[id=to]').val(moment(ranges[selected_value][1]).format('Y-MM-DD'));
                });
            }

            // dates
            var datesInit = function () {
                var from = $('input[id=from]');
                var to = $('input[id=to]');

                var fromInit = function () {
                    from.datepicker({
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

                var toInit = function () {
                    to.datepicker({
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

                fromInit();
                toInit();
            }
            //. dates

            return {
                init: function() {
                    selectsInit();
                    datesInit();
                }
            };
        }();

        $(document).ready(function() {
            sales.init();
        });
    </script>
@endsection