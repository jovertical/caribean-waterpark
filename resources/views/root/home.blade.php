<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name') }}</title>

        <!-- Web font -->
        <script src="https://ajax.googleapis.com/ajax/libs/webfont/1.6.16/webfont.js"></script>

        <script>
            WebFont.load({
                google: {"families":["Poppins:300,400,500,600,700","Roboto:300,400,500,600,700"]},
                active: function() {
                    sessionStorage.fonts = true;
                }
            });
        </script>
        <!--/. Web font -->

        <!-- App icon -->
        <link rel="shortcut icon" href="/root/assets/demo/demo2/media/img/logo/favicon.ico" />

        <!-- Vendor bundle -->
        <link href="/root/assets/vendors/base/vendors.bundle.css" rel="stylesheet" type="text/css" />

        <!-- Demo 2 bundle -->
        <link href="/root/assets/demo/demo2/base/style.bundle.css" rel="stylesheet" type="text/css" />
    </head>

    <body id="body" class="m-page--wide m-header--fixed m-header--fixed-mobile m-aside-left--enabled m-aside-left--offcanvas m-footer--push m-aside--offcanvas-default">

        <script>document.body.style.display = "none";</script>

        <!-- begin:: Page -->
        <div class="m-grid m-grid--hor m-grid--root m-page">
            @include('root.partials.header')

            <!-- begin::Body -->
            <div class="m-grid__item m-grid__item--fluid m-grid m-grid--ver-desktop m-grid--desktop m-container m-container--responsive m-container--xxl m-page__container m-body">

                <div class="m-grid__item m-grid__item--fluid m-wrapper" style="overflow: auto; padding-right: 2%;">
                    <div class="m-subheader">
                        <div class="d-flex align-items-center">
                            <div class="mr-auto">
                                <h3 class="m-subheader__title ">Dashboard</h3>
                            </div>
                            <div>
                                <span class="m-subheader__daterange" id="m_dashboard_daterangepicker">
                                    <span class="m-subheader__daterange-label">
                                        <span class="m-subheader__daterange-title"></span>
                                        <span class="m-subheader__daterange-date m--font-brand"></span>
                                    </span>
                                    <a href="javascript:void(0);" class="btn btn-sm btn-brand m-btn m-btn--icon m-btn--icon-only m-btn--custom m-btn--pill">
                                        <i class="la la-angle-down"></i>
                                    </a>
                                </span>
                            </div>
                        </div>
                    </div>

                    <div class="m-content">
                        <!--begin:: Widgets/Stats-->
                        <div class="m-portlet ">
                            <div class="m-portlet__body  m-portlet__body--no-padding">
                                <div class="row m-row--no-padding m-row--col-separator-xl">
                                    <!-- Profit -->
                                    <div class="col-md-12 col-lg-6 col-xl-3">
                                        <div class="m-widget24">
                                            <div class="m-widget24__item">
                                                <h4 class="m-widget24__title">
                                                    Profit
                                                </h4><br>
                                                <span class="m-widget24__desc">
                                                    Net profit
                                                </span>
                                                <span class="m-widget24__stats m--font-brand">
                                                    {{ Helper::moneyString($totals['profit']['active']) }}
                                                </span>
                                                <div class="m--space-10"></div>
                                                <div class="progress m-progress--sm">
                                                    <div class="progress-bar m--bg-brand" role="progressbar" style="width: 78%;" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                                                </div>
                                                <span class="m-widget24__change">
                                                    Change
                                                </span>
                                                <span class="m-widget24__number">
                                                    {{ $totals['profit']['change'] }}%
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    <!--/. Profit -->

                                    <div class="col-md-12 col-lg-6 col-xl-3">
                                        <!--begin::New Feedbacks-->
                                        <div class="m-widget24">
                                             <div class="m-widget24__item">
                                                <h4 class="m-widget24__title">
                                                    Feedbacks
                                                </h4><br>
                                                <span class="m-widget24__desc">
                                                    Customer Review
                                                </span>
                                                <span class="m-widget24__stats m--font-info">
                                                    {{ $totals['feedbacks']['active'] }}
                                                </span>
                                                <div class="m--space-10"></div>
                                                <div class="progress m-progress--sm">
                                                    <div class="progress-bar m--bg-info" role="progressbar" style="width: 84%;" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                                                </div>
                                                <span class="m-widget24__change">
                                                    Change
                                                </span>
                                                <span class="m-widget24__number">
                                                    {{ $totals['feedbacks']['change'] }}%
                                                </span>
                                            </div>
                                        </div>
                                        <!--end::New Feedbacks-->
                                    </div>

                                    <!-- Reservations -->
                                    <div class="col-md-12 col-lg-6 col-xl-3">
                                        <div class="m-widget24">
                                            <div class="m-widget24__item">
                                                <h4 class="m-widget24__title">
                                                    Reservations
                                                </h4><br>
                                                <span class="m-widget24__desc">
                                                    Paid and reserved
                                                </span>
                                                <span class="m-widget24__stats m--font-danger">
                                                    {{ $totals['reservations']['active'] }}
                                                </span>
                                                <div class="m--space-10"></div>
                                                <div class="progress m-progress--sm">
                                                    <div class="progress-bar m--bg-danger" role="progressbar" style="width: 69%;" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                                                </div>
                                                <span class="m-widget24__change">
                                                    Change
                                                </span>
                                                <span class="m-widget24__number">
                                                    {{ $totals['reservations']['change'] }}%
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    <!--/. Reservations -->

                                    <!-- Users -->
                                    <div class="col-md-12 col-lg-6 col-xl-3">
                                        <div class="m-widget24">
                                             <div class="m-widget24__item">
                                                <h4 class="m-widget24__title">
                                                    Customers
                                                </h4><br>
                                                <span class="m-widget24__desc">
                                                    Active customers
                                                </span>
                                                <span class="m-widget24__stats m--font-success">
                                                    {{ $totals['users']['active'] }}
                                                </span>
                                                <div class="m--space-10"></div>
                                                <div class="progress m-progress--sm">
                                                    <div class="progress-bar m--bg-success" role="progressbar" style="width: 90%;" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                                                </div>
                                                <span class="m-widget24__change">
                                                    Change
                                                </span>
                                                <span class="m-widget24__number">
                                                    {{ $totals['users']['change'] }}%
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    <!--/. Users -->
                                </div>
                            </div>
                        </div>
                        <!--end:: Widgets/Stats-->
                    </div>
                </div>
            </div>
            <!-- end::Body -->

            <!-- Footer -->
            @include('root.partials.footer')
        </div>
        <!-- end:: Page -->

        <!-- Vendor bundle -->
        <script src="/root/assets/vendors/base/vendors.bundle.js" type="text/javascript"></script>

        <!-- Demo 2 bundle -->
        <script src="/root/assets/demo/demo2/base/scripts.bundle.js" type="text/javascript"></script>

        <!-- Main -->
        <script src="/root/assets/app/js/main.js" type="text/javascript"></script>

        <script>
            var dates;

            var dashboard = function () {
                var daterangepickerInit = function() {
                    if ($('#m_dashboard_daterangepicker').length == 0) {
                        return;
                    }

                    var picker = $('#m_dashboard_daterangepicker');
                    var start = moment();
                    var end = moment();

                    function cb(start, end, label) {
                        var title = '';
                        var range = '';
                        var selected = '';

                        if ((end - start) < 100) {
                            range = start.format('MMM D');
                            selected = 0;
                        } else if (label == 'Yesterday') {
                            range = start.format('MMM D');
                            selected = 1;
                        } else if (label == 'Last 7 Days') {
                            selected = 2;
                        } else if (label == 'Last 30 Days') {
                            selected = 3;
                        } else if (label == 'This Month') {
                            selected = 4;
                        } else if (label == 'Last Month') {
                            selected = 5;
                        } else {
                            range = start.format('MMM D') + ' - ' + end.format('MMM D');
                            selected = 6;
                        }

                        picker.find('.m-subheader__daterange-date').html(range);

                        dates = {
                            'selected': selected,
                            'from': start.format('Y-MM-DD'),
                            'to': end.format('Y-MM-DD')
                        };
                    }

                    picker.daterangepicker({
                        startDate: start,
                        endDate: end,
                        opens: 'left',
                        ranges: {
                            'Today': [moment(), moment()],
                            'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                            'Last 7 Days': [moment().subtract(6, 'days'), moment()],
                            'Last 30 Days': [moment().subtract(29, 'days'), moment()],
                            'This Month': [moment().startOf('month'), moment().endOf('month')],
                            'Last Month': [moment().subtract(1, 'month').startOf('month'),
                                                moment().subtract(1, 'month').endOf('month')]
                        }
                    }, cb);

                    cb(start, end, '');
                }

                return {
                    init: function() {
                        daterangepickerInit();
                    }
                };
            }();

            $(document).ready(function() {
                $('body').fadeIn('slow');

                dashboard.init();

                var picker = $('#m_dashboard_daterangepicker');
                var from = moment('{{ Request::input('from') ?? date('Y-m-d H:i:s') }}');
                var to = moment('{{ Request::input('to') ?? date('Y-m-d H:i:s') }}');
                var range = from.format('MMM D') + ' - ' + to.format('MMM D');

                picker.find('.m-subheader__daterange-date').html(range);

                picker.on('click', function(e) {
                    $('.ranges ul').children().eq(0).attr('class', '');
                    $('.ranges ul').children().eq({{ Request::input('selected') }}).attr('class', 'active');
                    $('.ranges ul').children().eq(6).addClass('d-none');
                    $('.applyBtn, .cancelBtn').css({display: 'none'});
                });

                $('.ranges').on('click', function(e) {
                    window.location.href='?from=' + dates.from + '&to=' + dates.to + '&selected=' + dates.selected;
                });
            });
        </script>

    </body>
</html>