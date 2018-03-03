<tr>
    <td>{{ $index + 1 }}</td>
    <td>{{ $reservation->source }}</td>
    <td>{{ $reservation->reference_number }}</td>
    <td data-image="{{ URL::to("{$reservation->user->file_directory}/thumbnails/{$reservation->user->file_name}") }}">
        {{ $reservation->user->full_name }}
    </td>
    <td>{{ $reservation->checkin_date }}</td>
    <td>{{ $reservation->checkout_date }}</td>
    <td>{{ Helper::moneyFormat($reservation->price_payable) }}</td>
    <td>{{ Helper::moneyFormat($reservation->price_paid) }}</td>
    <td>{{ $reservation->status_code }}</td>
    <td></td>
</tr>