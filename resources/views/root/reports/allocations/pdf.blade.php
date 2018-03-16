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
                    <th>Item</th>
                    <th>Quantity</th>
                    <th>Occupied</th>
                    <th>Unoccupied</th>
                    <th>Inactive</th>
                    <th>Avg. Occupancy</th>
                    <th>Daily Sales</th>
                    <th>Net Sales</th>
                </tr>
            </thead>

            <tbody>
                @foreach($data as $metadata)
                    <tr>
                        <th scope="row" width="10%;">
                            {{ $metadata['item']->name }}
                        </th>
                        <td>{{ $metadata['quantity'] }}</td>
                        <td>{{ $metadata['occupied'] }}</td>
                        <td>{{ $metadata['unoccupied'] }}</td>
                        <td>{{ $metadata['inactive'] }}</td>
                        <td>{{ Helper::decimalFormat($metadata['average_occupancy']) }}%</td>
                        <td>{{ Helper::decimalFormat($metadata['daily_sales']) }}</td>
                        <td>{{ Helper::decimalFormat($metadata['net_sales']) }}</td>
                    </tr>
                @endforeach
            </tbody>

            <tfoot>
                <tr>
                    <th scope="row">Totals</th>
                    <td>{{ $totals['quantity'] }}</td>
                    <td>{{ $totals['occupied'] }}</td>
                    <td>{{ $totals['unoccupied'] }}</td>
                    <td>{{ $totals['inactive'] }}</td>
                    <td>{{ Helper::decimalFormat($totals['average_occupancy']) }}%</td>
                    <td>{{ Helper::decimalFormat($totals['daily_sales']) }}</td>
                    <td>{{ Helper::decimalFormat($totals['net_sales']) }}</td>
                </tr>
            </tfoot>
        </table>
    </body>
</html>