<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="Content-Type" content="text/html">
        <meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1,user-scalable=no">

        <title>{{ config('app.name') }}</title>

        <!-- Vendor bundle -->
        <link href="{{ asset('/root/assets/vendors/base/vendors.bundle.css') }}" type="text/css" media="all" />

        <!-- Demo 2 bundle -->
        <link href="{{ asset('/root/assets/demo/demo2/base/style.bundle.css') }}" type="text/css" media="all" />
    </head>

    <body>
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
                            <a href="javascript:void(0);">
                                <img src="/root/assets/app/media/img/misc/invoice_logo.png" style="width: 200px;">
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
            </div>
        </div>
    </body>
</html>