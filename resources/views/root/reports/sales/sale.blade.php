<tr>
    <th scope="row" width="10%;">{{ $metadata['reference_number'] }}</th>
    <td>
        <span class="m-badge m-badge--wide m-badge--{{ $metadata['status_class'] }}">
            <span class="text-white">{{ $metadata['status'] }}</span>
        </span>
    </td>
    <td width="15%;">
        <span class="m--font-bolder">
            {{ $metadata['source_user'] }}
        </span>&nbsp;({{ $metadata['source'] }})
    </td>
    <td>{{ Carbon::parse($metadata['date'])->toFormattedDateString() }}</td>
    <td>{{ Helper::moneyString($metadata['price_taxable']) }}</td>
    <td>{{ Helper::moneyString($metadata['price_deductable']) }}</td>
    <td>{{ Helper::moneyString($metadata['gross_sale']) }}</td>
    <td>{{ Helper::moneyString($metadata['net_sale']) }}</td>
    <td>{{ Helper::moneyString($metadata['price_paid']) }}</td>
    <td>{{ Helper::moneyString($metadata['balance']) }}</td>
</tr>