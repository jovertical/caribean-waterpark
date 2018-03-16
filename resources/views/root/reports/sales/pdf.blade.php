<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1,user-scalable=no">
        <meta name="format-detection" content="telephone=no"><meta name="apple-mobile-web-app-capable" content="yes">

        <title>{{ config('app.name') }}</title>

        <style>
            table {
                width: 100%;
            }
            td, th {
                padding-top: 10px;
            }
        </style>
    </head>

    <body>
        <h1 style="text-align: center;">Sales Report</h1>

        <table style="margin-top: 50px;">
            <thead>
                <tr>
                    <th>Ref. #</th>
                    <th>Status</th>
                    <th>Source</th>
                    <th>Date</th>
                    <th>Tax</th>
                    <th>Discount</th>
                    <th>Gross Sale</th>
                    <th>Net Sale</th>
                    <th>Paid</th>
                    <th>Balance</th>
                </tr>
            </thead>

            <tbody>
                @isset($data['data'])
                    @foreach($data['data'] as $metadata)
                        <tr>
                            <th scope="row">{{ $metadata['reference_number'] }}</th>
                            <td>{{ $metadata['status'] }}</td>
                            <td>{{ $metadata['source'] }}</td>
                            <td>{{ Carbon::parse($metadata['date'])->toFormattedDateString() }}</td>
                            <td>{{ Helper::decimalFormat($metadata['price_taxable']) }}</td>
                            <td>{{ Helper::decimalFormat($metadata['price_deductable']) }}</td>
                            <td>{{ Helper::decimalFormat($metadata['gross_sale']) }}</td>
                            <td>{{ Helper::decimalFormat($metadata['net_sale']) }}</td>
                            <td>{{ Helper::decimalFormat($metadata['price_paid']) }}</td>
                            <td>{{ Helper::decimalFormat($metadata['balance']) }}</td>
                        </tr>
                    @endforeach
                @endisset
            </tbody>

            <tfoot>
                <tr>
                    <th colspan="4" scope="row">Totals</th>
                    <td>{{ Helper::decimalFormat($data['totals']['price_taxable']) }}</td>
                    <td>{{ Helper::decimalFormat($data['totals']['price_deductable']) }}</td>
                    <td>{{ Helper::decimalFormat($data['totals']['gross_sale']) }}</td>
                    <td>{{ Helper::decimalFormat($data['totals']['net_sale']) }}</td>
                    <td>{{ Helper::decimalFormat($data['totals']['price_paid']) }}</td>
                    <td>{{ Helper::decimalFormat($data['totals']['balance']) }}</td>
                </tr>
            </tfoot>
        </table>
    </body>
</html>