<tr>
    <td>{{ $index + 1 }}</td>
    <td>{{ $day->date }}</td>
    <td>{{ $day->entered ? 1 : 0 }}</td>
    <td>{{ $day->entered_at }}</td>
    <td>{{ $day->exited ? 1 : 0 }}</td>
    <td>{{ $day->exited_at }}</td>
    <td>{{ $day->adult_quantity }}</td>
    <td>{{ $day->children_quantity }}</td>
</tr>