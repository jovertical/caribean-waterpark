<tr>
    <td>{{ $index + 1 }}</td>
    <td>{{ $reservation_transaction->type_code }}</td>
    <td>{{ $reservation_transaction->mode }}</td>
    <td>{{ Helper::moneyString($reservation_transaction->amount) }}</td>
</tr>