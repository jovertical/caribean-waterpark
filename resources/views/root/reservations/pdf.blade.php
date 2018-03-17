<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
    <head>
<<<<<<< HEAD
        <meta http-equiv="Content-Type" content="text/html" charset="utf-8"/>

        <title>{{ config('app.name') }}</title>

        <!-- Vendor bundle -->
        <link href="/root/assets/vendors/base/vendors.bundle.css" type="text/css" rel="stylesheet">

        <!-- Demo 2 bundle -->
        <link href="/root/assets/demo/demo2/base/style.bundle.css" type="text/css" rel="stylesheet">
=======
        <meta charset="utf-8">
        <meta http-equiv="Content-Type" content="text/html">
        <meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1,user-scalable=no">
        <title>{{ config('app.name') }}</title>
        <style type="text/css">
        #invoice-title { font-size: 55px; font-weight: bold;}
        #meta { margin-top: 0px; width: 400px; float: right; font-size: 45px;}
        #right { margin-top: 100px; width: 400px; float: right; font-size: 20px;}
        #metas { margin-top: 1px; width: 100%; float: left; }
        #metas1 { margin-top: 40px; width: 400px; float: right; }
        #meta td { text-align: right;  }
        #meta td.meta-head { text-align: left; background: #eee; }
        #meta td textarea { width: 100%; height: 20px; text-align: right; }
        table {   
        border-collapse: collapse;
        width: 100%;
        }
        th, td {
        text-align: center;
        padding: 18px;
        }s
        tr:nth-child(even){background-color: #f2f2f2}
        th {
        background-color: #0091EA;
        color: white;
        }
        </style>
>>>>>>> b77d623ab2ebc44298d3bb956f002995671ce8e8
    </head>
    <body>
<<<<<<< HEAD
        <div class="m-invoice-1">
            <div class="m-invoice__wrapper">
                <div class="m-invoice__head">
                    <div class="d-flex justify-content-end p-4">
                        <span>{{ $reservation->status }}</span>
                    </div>

                    <div class="m-invoice__container m-invoice__container--centered">
                        <div class="m-invoice__logo">
                            <a href="javascript:void(0);">
                                <h1>INVOICE</h1>
                            </a>
                        </div>
                        <span class="m-invoice__desc">
                            <span>{{ $reservation->creator->full_name }}, 80 Parang, Pulong Sampaloc</span>
                            <span>Doña Remedios Trinidad, Bulacan</span>
                        </span>
                        <div class="m-invoice__items">
                            <div class="m-invoice__item">
                                <span class="m-invoice__subtitle">CREATED</span>
                                <span class="m-invoice__text">
                                    {{ Carbon::parse($reservation->created_at)->toFormattedDateString() }}
                                </span>
                            </div>
                            <div class="m-invoice__item">
                                <span class="m-invoice__subtitle">REFERENCE NO.</span>
                                <span class="m-invoice__text">
                                    {{ $reservation->name }}
                                </span>
                            </div>
                            <div class="m-invoice__item">
                                <span class="m-invoice__subtitle">INVOICE TO:</span>
                                <span class="m-invoice__text">
                                    {{ $reservation->user->full_name }}, <br>
                                    {{ $reservation->user->address }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="m-invoice__body m-invoice__body--centered">
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>DESCRIPTION</th>
                                    <th>QUANTITY</th>
                                    <th>UNIT PRICE</th>
                                    <th>TOTAL PRICE</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($reservation->items as $index => $item)
                                    <tr>
                                        <th scope="row" style="width: 5%;">{{ $index + 1 }}</th>
                                        <td>{{ $item->item->name }}</td>
                                        <td>{{ $item->quantity }}</td>
                                        <td>{{ Helper::moneyString($item->price_original) }}</td>
                                        <td>{{ Helper::moneyString($item->price_payable) }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="m-invoice__footer">
                    <div class="m-invoice__container m-invoice__container--centered">
                        <div class="m-invoice__content">
                            <span>RESERVATION</span>
                            <span>
                                <span>Check-in date:</span>
                                <span>
                                    {{ Carbon::parse($reservation->checkin_date)->toFormattedDateString() }}
                                </span>
                            </span>

                            <span>
                                <span>Check-out date:</span>
                                <span>
                                    {{ Carbon::parse($reservation->checkout_date)->toFormattedDateString() }}
                                </span>
                            </span>
                            <span>
                                <span>Days:</span>
                                <span>{{ $reservation->day_count }}</span>
                            </span>
                        </div>
                        <div class="m-invoice__content">
                            <span>TOTAL</span>
                            <span class="m-invoice__price">{{ Helper::moneyString($reservation->price_payable) }}</span>
                            <span>*Taxes Included</span>
                        </div>
                    </div>
                </div>
=======
        <div id="status">
            Status:{{ $reservation->status }}
        </div>
        <div id="invoice-title">INVOICE
            <div id="meta">
                CARIBBEAN <br>
                WATERPARK<br>
                RESORT
>>>>>>> b77d623ab2ebc44298d3bb956f002995671ce8e8
            </div>
        </div>
        <div id = "right">
            {{ $reservation->creator->full_name }}, 80 Parang, Pulong Sampaloc
            Doña Remedios Trinidad, Bulacan
        </div>
        
        <br><br><br>
        <table>
            <thead>
                <tr>
                    <th>Created</th>
                    <th>Reference No</th>
                    <th>Invoice To</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>{{ Carbon::parse($reservation->created_at)->toFormattedDateString() }}</td>
                    <td>{{ $reservation->name }}</td>
                    <td>{{ $reservation->user->full_name }}</td>
                </tr>
            </tbody>
        </table>
        <br><br>
        <table>
            <thead>
                <tr>
                    <th>#</th>
                    <th>Description</th>
                    <th>Quantity</th>
                    <th>Unit Price</th>
                    <th>Total Price</th>
                </tr>
            </thead>
            <tbody>
                @foreach($reservation->items as $index => $item)
                <tr>
                    <td  style="width: 5%;">{{ $index + 1 }}</td>
                    <td>{{ $item->item->name }}</td>
                    <td>{{ $item->quantity }}</td>
                    <td>{{ Helper::decimalFormat($item->price_original) }}</td>
                    <td>{{ Helper::decimalFormat($item->price_payable) }}</td>
                </tr>
                @endforeach
            </tbody>
            <br><br>
        </table>
        <table id="metas">
            <tr>
                <th></th>
                <th>Reservation</th>
                <th></th>
            </tr>
            <tr>
                <td class="meta-head">Check-in date</td>
                <td>{{ Carbon::parse($reservation->checkin_date)->toFormattedDateString() }}</td>
                <td>TOTAL</td>
            </tr>
            <tr>
                <td class="meta-head">Check-out date:</td>
                <td>{{ Carbon::parse($reservation->checkout_date)->toFormattedDateString() }}</td>
                <td>{{ Helper::decimalFormat($reservation->price_payable) }}</td>
            </tr>
            <tr>
                <td class="meta-head">Days</td>
                <td>{{ $reservation->day_count }}</td>
                <td>*Taxes Included</td>
            </tr>
        </table>
        
    </body>
</html>