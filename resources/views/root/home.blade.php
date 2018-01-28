@extends('root.layouts.main')

@section('content')
    <!--Section: Button icon-->
    <section>

        <!--Grid row-->
        <div class="row">

            <!--Grid column-->
            <div class="col-xl-3 col-md-6 mb-r">

                <!--Card-->
                <div class="card">

                    <!--Card Data-->
                    <div class="row mt-3">
                        <div class="col-md-5 col-5 text-left pl-4">
                            <a type="button" class="btn-floating btn-lg primary-color ml-4"><i class="fa fa-eye" aria-hidden="true"></i></a>
                        </div>

                        <div class="col-md-7 col-7 text-right pr-5">
                            <h5 class="ml-4 mt-4 mb-2 font-bold">4,567 </h5>
                            <p class="font-small grey-text">Unique Visitors</p>
                        </div>
                    </div>
                    <!--/.Card Data-->

                    <!--Card content-->
                    <div class="row my-3">
                        <div class="col-md-7 col-7 text-left pl-4">
                            <p class="font-small dark-grey-text font-up ml-4 font-bold">Last month</p>
                        </div>

                        <div class="col-md-5 col-5 text-right pr-5">
                            <p class="font-small grey-text">145,567</p>
                        </div>
                    </div>
                    <!--/.Card content-->

                </div>
                <!--/.Card-->

            </div>
            <!--Grid column-->

            <!--Grid column-->
            <div class="col-xl-3 col-md-6 mb-r">

                <!--Card-->
                <div class="card">

                    <!--Card Data-->
                    <div class="row mt-3">
                        <div class="col-md-5 col-5 text-left pl-4">
                            <a type="button" class="btn-floating btn-lg warning-color ml-4"><i class="fa fa-user" aria-hidden="true"></i></a>
                        </div>

                        <div class="col-md-7 col-7 text-right pr-5">
                            <h5 class="ml-4 mt-4 mb-2 font-bold">4,567 </h5>
                            <p class="font-small grey-text">New Users</p>
                        </div>
                    </div>
                    <!--/.Card Data-->

                    <!--Card content-->
                    <div class="row my-3">
                        <div class="col-md-7 col-7 text-left pl-4">
                            <p class="font-small dark-grey-text font-up ml-4 font-bold">Last month</p>
                        </div>

                        <div class="col-md-5 col-5 text-right pr-5">
                            <p class="font-small grey-text">145,567</p>
                        </div>
                    </div>
                    <!--/.Card content-->

                </div>
                <!--/.Card-->

            </div>
            <!--Grid column-->

            <!--Grid column-->
            <div class="col-xl-3 col-md-6 mb-r">

                <!--Card-->
                <div class="card">

                    <!--Card Data-->
                    <div class="row mt-3">
                        <div class="col-md-5 col-5 text-left pl-4">
                            <a type="button" class="btn-floating btn-lg light-blue lighten-1 ml-4"><i class="fa fa-dollar" aria-hidden="true"></i></a>
                        </div>

                        <div class="col-md-7 col-7 text-right pr-5">
                            <h5 class="ml-4 mt-4 mb-2 font-bold">4,567 </h5>
                            <p class="font-small grey-text">Total Sales</p>
                        </div>
                    </div>
                    <!--/.Card Data-->

                    <!--Card content-->
                    <div class="row my-3">
                        <div class="col-md-7 col-7 text-left pl-4">
                            <p class="font-small dark-grey-text font-up ml-4 font-bold">Last month</p>
                        </div>

                        <div class="col-md-5 col-5 text-right pr-5">
                            <p class="font-small grey-text">145,567</p>
                        </div>
                    </div>
                    <!--/.Card content-->

                </div>
                <!--/.Card-->

            </div>
            <!--Grid column-->

            <!--Grid column-->
            <div class="col-xl-3 col-md-6 mb-r">

                <!--Card-->
                <div class="card">

                    <!--Card Data-->
                    <div class="row mt-3">
                        <div class="col-md-5 col-5 text-left pl-4">
                            <a type="button" class="btn-floating btn-lg red accent-2 ml-4"><i class="fa fa-database" aria-hidden="true"></i></a>
                        </div>

                        <div class="col-md-7 col-7 text-right pr-5">
                            <h5 class="ml-4 mt-4 mb-2 font-bold">4,567</h5>
                            <p class="font-small grey-text">Order Amount</p>
                        </div>
                    </div>
                    <!--/.Card Data-->

                    <!--Card content-->
                    <div class="row my-3">
                        <div class="col-md-7 col-7 text-left pl-4">
                            <p class="font-small dark-grey-text font-up ml-4 font-bold">Last week</p>
                        </div>

                        <div class="col-md-5 col-5 text-right pr-5">
                            <p class="font-small grey-text">145,567</p>
                        </div>
                    </div>
                    <!--/.Card content-->

                </div>
                <!--/.Card-->

            </div>
            <!--Grid column-->

        </div>
        <!--Grid row-->

    </section>
    <!--/Section: Button icon-->

    <div style="height: 5px"></div>

    <!--Section: Analytical panel-->
    <section class="mb-5">

        <!--Card-->
        <div class="card card-cascade narrower">

            <!--Section: Chart-->
            <section>

                <!--Grid row-->
                <div class="row">

                    <!--Grid column-->
                    <div class="col-xl-5 col-md-12 mr-0">

                        <!--Card image-->
                        <div class="view gradient-card-header light-blue lighten-1">
                            <h4 class="h4-responsive mb-0 font-bold">Traffic</h4>
                        </div>
                        <!--/Card image-->

                        <!--Card content-->
                        <div class="card-body pb-0">

                            <!--Panel data-->
                            <div class="row card-body pt-3">

                                <!--First column-->
                                <div class="col-md-12">

                                    <!--Date select-->
                                    <h4><span class="badge big-badge light-blue lighten-1">Data range</span></h4>
                                    <select class="mdb-select">
                                                    <option value="" disabled selected>Choose time period</option>
                                                    <option value="1">Today</option>
                                                    <option value="2">Yesterday</option>
                                                    <option value="3">Last 7 days</option>
                                                    <option value="3">Last 30 days</option>
                                                    <option value="3">Last week</option>
                                                    <option value="3">Last month</option>
                                                </select>
                                    <br>

                                    <!--Date pickers-->
                                    <h5><span class="badge big-badge light-blue lighten-1">Custom date</span></h4>
                                        <br>
                                        <div class="d-flex justify-content-between">
                                            <div class="md-form">
                                                <input placeholder="Selected date" type="text" id="from" class="form-control datepicker">
                                                <label for="date-picker-example">From</label>
                                            </div>
                                            <div class="md-form">
                                                <input placeholder="Selected date" type="text" id="to" class="form-control datepicker">
                                                <label for="date-picker-example">To</label>
                                            </div>
                                        </div>

                                </div>
                                <!--/First column-->

                            </div>
                            <!--/Panel data-->

                        </div>
                        <!--/.Card content-->

                    </div>
                    <!--Grid column-->

                    <!--Grid column-->
                    <div class="col-xl-7 col-md-12 mb-r">

                        <!--Card image-->
                        <div class="view gradient-card-header white">

                            <!-- Chart -->
                            <canvas id="barChart"></canvas>

                        </div>
                        <!--/Card image-->

                    </div>
                    <!--Grid column-->

                </div>
                <!--Grid row-->

            </section>
            <!--Section: Chart-->

        </div>
        <!--/.Card-->

    </section>
    <!--Section: Analytical panel-->

    <!-- Section: data tables -->
    <section class="section">

        <div class="row">
            <div class="col-md-12 col-lg-4 ">

                <div class="card mb-r">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table large-header">
                                <thead>
                                    <tr>
                                        <th class="font-bold dark-grey-text"><strong>Keywords</strong></th>
                                        <th class="font-bold dark-grey-text"><strong>Visits</strong></th>
                                        <th class="font-bold dark-grey-text"><strong>Pages</strong></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>Design</td>
                                        <td>15</td>
                                        <td>307</td>
                                    </tr>
                                    <tr>
                                        <td>Bootstrap</td>
                                        <td>32</td>
                                        <td>504</td>
                                    </tr>
                                    <tr>
                                        <td>MDBootstrap</td>
                                        <td>41</td>
                                        <td>613</td>
                                    </tr>
                                    <tr>
                                        <td>Frontend</td>
                                        <td>14</td>
                                        <td>208</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <button class="btn-flat grey lighten-3 btn-rounded waves-effect float-right font-bold dark-grey-text">View full report</button>

                    </div>

                </div>

            </div>

            <div class="col-lg-8 col-md-12">

                <div class="card mb-r">
                    <div class="card-body">
                        <table class="table large-header">
                            <thead>
                                <tr>
                                    <th class="font-bold dark-grey-text"><strong>Browser</strong></th>
                                    <th class="font-bold dark-grey-text"><strong>Visits</strong></th>
                                    <th class="font-bold dark-grey-text"><strong>Pages</strong></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Google Chrome</td>
                                    <td>15</td>
                                    <td>307</td>
                                </tr>
                                <tr>
                                    <td>Mozilla Firefox</td>
                                    <td>32</td>
                                    <td>504</td>
                                </tr>
                                <tr>
                                    <td>Safari</td>
                                    <td>41</td>
                                    <td>613</td>
                                </tr>
                                <tr>
                                    <td>Opera</td>
                                    <td>14</td>
                                    <td>208</td>
                                </tr>

                            </tbody>
                        </table>

                        <button class="btn-flat grey lighten-3 btn-rounded waves-effect font-bold dark-grey-text float-right">View full report</button>

                    </div>

                </div>

            </div>
        </div>

    </section>
    <!-- /.Section: data tables -->

    <!--Section: Cards color-->
    <section class="mt-2">

        <!--Grid row-->
        <div class="row">

            <!--Grid column-->
            <div class="col-xl-3 col-md-6 mb-r">

                <!--Panel-->
                <div class="card">
                    <div class="card-header white-text primary-color">
                        Orders
                    </div>

                    <h6 class="ml-4 mt-5 dark-grey-text font-bold"><i class="fa fa-long-arrow-up blue-text mr-3" aria-hidden="true"></i> 2000</h6>
                    <!--/.Card Data-->

                    <!--Card content-->
                    <div class="card-body">
                        <div class="progress">
                            <div class="progress-bar grey darken-2" role="progressbar" style="width: 45%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                        <!--Text-->
                        <p class="font-small grey-text">Better than last week (25%)</p>
                    </div>
                    <!--/.Card content-->

                </div>
                <!--/.Panel-->

            </div>
            <!--Grid column-->

            <!--Grid column-->
            <div class="col-xl-3 col-md-6 mb-r">

                <!--Panel-->
                <div class="card">
                    <div class="card-header white-text warning-color">
                        Monthly sales
                    </div>

                    <h6 class="ml-4 mt-5 dark-grey-text font-bold"><i class="fa fa-long-arrow-up blue-text mr-3" aria-hidden="true"></i> $ 2000</h6>
                    <!--/.Card Data-->

                    <!--Card content-->
                    <div class="card-body">
                        <div class="progress">
                            <div class="progress-bar grey darken-2" role="progressbar" style="width: 65%" aria-valuenow="65" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                        <!--Text-->
                        <p class="font-small grey-text">Better than last week (25%)</p>
                    </div>
                    <!--/.Card content-->

                </div>
                <!--/.Panel-->

            </div>
            <!--Grid column-->

            <!--Grid column-->
            <div class="col-xl-3 col-md-6 mb-r">

                <!--Panel-->
                <div class="card">
                    <div class="card-header white-text light-blue lighten-1">
                        Sales
                    </div>

                    <h6 class="ml-4 mt-5 dark-grey-text font-bold"><i class="fa fa-long-arrow-down red-text mr-3" aria-hidden="true"></i> $ 2000</h6>
                    <!--/.Card Data-->

                    <!--Card content-->
                    <div class="card-body">
                        <div class="progress">
                            <div class="progress-bar grey darken-2" role="progressbar" style="width: 25%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                        <!--Text-->
                        <p class="font-small grey-text">Better than last week (25%)</p>
                    </div>
                    <!--/.Card content-->

                </div>
                <!--/.Panel-->

            </div>
            <!--Grid column-->

            <!--Grid column-->
            <div class="col-xl-3 col-md-6 mb-r">

                <!--Panel-->
                <div class="card">
                    <div class="card-header white-text red accent-2">
                        Daily Sales
                    </div>

                    <h6 class="ml-4 mt-5 dark-grey-text font-bold"><i class="fa fa-long-arrow-down red-text mr-3" aria-hidden="true"></i> $ 2000</h6>
                    <!--/.Card Data-->

                    <!--Card content-->
                    <div class="card-body">
                        <div class="progress">
                            <div class="progress-bar grey darken-2" role="progressbar" style="width: 45%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                        <!--Text-->
                        <p class="font-small grey-text">Better than last week (25%)</p>
                    </div>
                    <!--/.Card content-->

                </div>
                <!--/.Panel-->


            </div>
            <!--Grid column-->
        </div>
        <!--Grid row-->

    </section>
    <!--Section: Cards color-->

    <!--Section: Panels-->
    <section>

        <!--Grid row-->
        <div class="row">

            <!--Grid column-->
            <div class="col-xl-5 col-md-12">

                <!--Card-->
                <div class="card mb-r">

                    <!--Card Data-->
                    <div class="row">
                        <div class="col-md-12 text-center">
                            <h5 class="mt-4 mb-4 font-bold">Monthly Sales</h5>
                        </div>

                    </div>

                    <!--Card content-->
                    <div class="card-body">
                        <div class="progress mb-2 mt-1">
                            <div class="progress-bar warning-color" role="progressbar" style="width: 55%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                        <!--Text-->
                        <p class="font-small grey-text mb-4">January</p>

                        <div class="progress mb-2">
                            <div class="progress-bar red accent-2" role="progressbar" style="width: 35%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                        <!--Text-->
                        <p class="font-small grey-text mb-4">Febuary</p>

                        <div class="progress mb-2">
                            <div class="progress-bar primary-color" role="progressbar" style="width: 85%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                        <!--Text-->
                        <p class="font-small grey-text mb-4">March</p>

                        <div class="progress mb-2">
                            <div class="progress-bar light-blue lighten-1" role="progressbar" style="width: 70%" aria-valuenow="25" aria-valuemin="0"
                                aria-valuemax="100"></div>
                        </div>
                        <!--Text-->
                        <p class="font-small grey-text mb-2">April</p>
                    </div>
                    <!--/.Card content-->

                </div>
                <!--/.Card-->

            </div>
            <!--Grid column-->


            <!--Grid column-->
            <div class="col-xl-3 col-md-6 mb-2">

                <!--Card-->
                <div class="card">

                    <!--Card Data-->
                    <div class="row mt-4 mb-3">
                        <div class="col-md-3 col-3 text-left pl-4">
                            <!--Facebook-->
                            <a class="icons-sm fb-ic"><i class="fa fa-facebook fa-2x blue-text"> </i></a>
                        </div>

                        <div class="col-md-9 col-9 text-right pr-5">
                            <p class="font-small grey-text mb-1">Facebook Users</p>
                            <h5 class="ml-4 mb-2 font-bold">4,567 </h5>

                        </div>
                    </div>
                    <!--/.Card Data-->

                </div>
                <!--/.Card-->

                <!--Card-->
                <div class="card mt-4">

                    <!--Card Data-->
                    <div class="row mt-4 mb-3">
                        <div class="col-md-3 col-3 text-left pl-4">
                            <!--Facebook-->
                            <a class="icons-sm fb-ic"><i class="fa fa-google-plus fa-2x red-text"> </i></a>
                        </div>

                        <div class="col-md-9 col-9 text-right pr-5">
                            <p class="font-small grey-text mb-1">Google+ Users</p>
                            <h5 class="ml-4 mb-2 font-bold">2,669 </h5>

                        </div>
                    </div>
                    <!--/.Card Data-->

                </div>
                <!--/.Card-->

                <!--Card-->
                <div class="card mt-4 mb-r">

                    <!--Card Data-->
                    <div class="row mt-4 mb-3">
                        <div class="col-md-3 col-3 text-left pl-4">
                            <!--Facebook-->
                            <a class="icons-sm fb-ic"><i class="fa fa-twitter fa-2x cyan-text"> </i></a>
                        </div>

                        <div class="col-md-9 col-9 text-right pr-5">
                            <p class="font-small grey-text mb-1">Twitter Users</p>
                            <h5 class="ml-4 mb-2 font-bold">3,562 </h5>

                        </div>
                    </div>
                    <!--/.Card Data-->

                </div>
                <!--/.Card-->

            </div>
            <!--Grid column-->

            <!--Grid column-->
            <div class="col-xl-4 col-md-6 mb-2">

                <!--Card-->
                <div class="card mb-r">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table large-header mb-1">
                                <thead>
                                    <tr>
                                        <th class="font-bold dark-grey-text"><strong>Month</strong></th>
                                        <th class="font-bold dark-grey-text"><strong>Visits</strong></th>
                                        <th class="font-bold dark-grey-text"><strong>Sales</strong></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>January</td>
                                        <td>15</td>
                                        <td>307</td>
                                    </tr>
                                    <tr>
                                        <td>Febuary</td>
                                        <td>32</td>
                                        <td>504</td>
                                    </tr>
                                    <tr>
                                        <td>March</td>
                                        <td>41</td>
                                        <td>613</td>
                                    </tr>

                                </tbody>
                            </table>
                        </div>

                        <button class="btn-flat grey lighten-3 btn-rounded waves-effect float-right font-bold dark-grey-text">View full report</button>

                    </div>

                </div>
                <!--/.Card-->


            </div>
            <!--Grid column-->

        </div>
        <!--Grid row-->

    </section>
    <!--Section: Panels-->
@endsection

@section('scripts')
    <script>
        $(document).ready(function() {
            // Data Picker Initialization
            $('.datepicker').pickadate();

            // Material Select Initialization
            $('.mdb-select').material_select();

            // Small chart
            $(function () {
                $('.min-chart#chart-sales').easyPieChart({
                    barColor: "#4285F4",
                    onStep: function (from, to, percent) {
                        $(this.el).find('.percent').text(Math.round(percent));
                    }
                });
            });

            //bar
            var ctxB = document.getElementById("barChart").getContext('2d');
            var myBarChart = new Chart(ctxB, {
                type: 'bar',
                data: {
                    labels: ["January", "Febuary", "March", "April", "May"],
                    datasets: [{
                        label: '# of Votes',
                        data: [13, 19, 8, 11, 5],
                        backgroundColor: [
                            'rgba(255, 99, 132, 0.3)',
                            'rgba(41, 182, 246, 0.3)',
                            'rgba(255, 187, 51, 0.3)',
                            'rgba(66, 133, 244, 0.3)',
                            'rgba(153, 102, 255, 0.3)',

                        ],
                        borderColor: [
                            'rgba(255,99,132,1)',
                            'rgba(41, 182, 246, 1)',
                            'rgba(255, 187, 51, 1)',
                            'rgba(66, 133, 244, 1)',
                            'rgba(153, 102, 255, 1)',

                        ],
                        borderWidth: 2
                    }]
                },
                optionss: {
                    scales: {
                        yAxes: [{
                            ticks: {
                                beginAtZero: true
                            }
                        }]
                    }
                }
            });
        });
    </script>
@endsection