<tr>
    <th scope="row" width="10%;">
        <span class="m--font-bolder">
            {{ $metadata['item']->name }}
        </span>
    </th>
    <td>{{ $metadata['quantity'] }}</td>
    <td>{{ $metadata['occupied'] }}</td>
    <td>{{ $metadata['unoccupied'] }}</td>
    <td>{{ $metadata['inactive'] }}</td>
    <td>{{ Helper::decimalFormat($metadata['average_occupancy']) }}%</td>
    <td>{{ Helper::moneyString($metadata['daily_sales']) }}</td>
    <td>{{ Helper::moneyString($metadata['net_sales']) }}</td>
</tr>