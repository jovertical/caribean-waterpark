<tr>
    <td>{{ $index + 1 }}</td>
    <td>
        <span>
            <img src="/root/assets/app/media/img/users/user4.jpg" class="img-fluid rounded-circle">
        </span>
    </td>
    <td>{{ Str::ucfirst($superuser->last_name).', '.Str::ucfirst($superuser->first_name) }}</td>
    <td>{{ Str::ucfirst($superuser->gender) }}</td>
    <td>{{ $superuser->birthdate }}</td>
    <td>{{ $superuser->email }}</td>
    <td>{{ $superuser->phone_number }}</td>
    <td>
        <span class="d-flex">
            <a href="{{ route('root.superusers.image', $superuser->id) }}" class="m-portlet__nav-link btn m-btn m-btn--hover-accent m-btn--icon m-btn--icon-only m-btn--pill" title="View image"><i class="la la-image"></i></a>

            <form method="GET" action="{{ route('root.superusers.edit', $superuser->id) }}">
                {{ method_field('PUT') }}

                <button type="submit" class="m-portlet__nav-link btn m-btn m-btn--hover-accent m-btn--icon m-btn--icon-only m-btn--pill" title="Edit superuser"><i class="la la-edit"></i></button>
            </form>

            <form method="POST" action="{{ route('root.superusers.destroy', $superuser->id) }}" class="form-confirm">
                {{ method_field('DELETE') }}
                {{ csrf_field() }}

                <button type="submit" data-toggle="modal" data-target="#modal" class="m-portlet__nav-link btn m-btn m-btn--hover-danger m-btn--icon m-btn--icon-only m-btn--pill" title="Delete superuser">
                    <i class="la la-trash"></i></button>
            </form>
        </span>
    </td>
</tr>