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
        <h1 style="text-align: center;">Reservation Transactions</h1>

        <table style="margin-top: 50px;">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Type</th>
                    <th>Mode</th>
                    <th>Amount</th>
                </tr>
            </thead>

            <tbody>
                @foreach($data as $index => $metadata)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $metadata->type }}</td>
                        <td>{{ $metadata->mode }}</td>
                        <td>{{ Helper::decimalFormat($metadata->amount) }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </body>
</html>