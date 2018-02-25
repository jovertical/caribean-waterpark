<tr>
    <td>{{ $index + 1 }}</td>
    <td>
        <span>
            <img src="{{ Helper::fileUrl($superuser, 'thumbnail') }}" class="img-fluid rounded-circle">
        </span>
    </td>
    <td>{{ ucfirst($superuser->last_name).', '.ucfirst($superuser->first_name) }}</td>
    <td>{{ ucfirst($superuser->gender) }}</td>
    <td>{{ $superuser->birthdate }}</td>
    <td>{{ $superuser->email }}</td>
    <td>{{ $superuser->phone_number }}</td>
    <td>
        <span class="m-badge m-badge--{{ $superuser->active ? 'success' : '' }} m-badge--wide text-white">
            {{ $superuser->active ? 'Active' : 'Inactive' }}
        </span>
    </td>
    <td>
        <span class="d-flex" style="overflow: visible;">
            <a href="{{ route('root.superusers.image', $superuser->id) }}" class="m-portlet__nav-link btn m-btn m-btn--hover-accent m-btn--icon m-btn--icon-only m-btn--pill" title="View image"><i class="la la-image"></i></a>

            <a href="#" data-form="#editSuperuser" data-action="{{ route('root.superusers.edit', $superuser->id) }}" class="m-portlet__nav-link btn m-btn m-btn--hover-accent m-btn--icon m-btn--icon-only m-btn--pill submit" title="Edit superuser"><i class="la la-edit"></i>
            </a>

            <a href="#" data-form="#destroySuperuser" data-action="{{ route('root.superusers.destroy', $superuser->id) }}" data-toggle="modal" data-target="#destroySuperuserConfirmation" class="m-portlet__nav-link btn m-btn m-btn--hover-danger m-btn--icon m-btn--icon-only m-btn--pill confirm-submit" title="Delete superuser">
                <i class="la la-trash"></i>
            </a>
        </span>
    </td>
</tr>