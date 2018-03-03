<tr>
    <td>{{ $index + 1 }}</td>
    <td>
        <span>
            <img src="{{ Helper::fileUrl($superuser, 'thumbnail') }}" class="img-fluid rounded-circle">
        </span>
    </td>
    <td>{{ $superuser->full_name }}</td>
    <td>{{ $superuser->birthdate }}</td>
    <td>{{ $superuser->gender }}</td>
    <td>{{ $superuser->address }}</td>
    <td>{{ $superuser->email }}</td>
    <td>{{ $superuser->phone_number }}</td>
    <td>
        {{ $superuser->active ? 1 : 2 }}
    </td>
    <td>
        <span class="d-flex" style="overflow: visible;">
            <div class="dropdown">
                <a href="javascript:void(0);" class="btn m-btn m-btn--hover-accent m-btn--icon m-btn--icon-only m-btn--pill" data-toggle="dropdown"><i class="la la-ellipsis-h"></i></a>

                <div class="dropdown-menu dropdown-menu-right">
                    <a href="javascript:void(0);" data-form="#toggleSuperuser" 
                    data-action="{{ route('root.superusers.toggle', $superuser) }}" data-toggle="modal" data-target="#toggleSuperuserConfirmation" class="dropdown-item toggle-superuser" title="Toggle superuser">
                        <i class="la la-toggle-{{ $superuser->active ? 'on' : 'off' }}"></i>Toggle
                    </a>

                    <a href="{{ route('root.superusers.image', $superuser) }}" class="dropdown-item">
                        <i class="la la-image"></i> Image
                    </a>
                </div>
            </div>

            <a href="javascript:void(0);" data-form="#editSuperuser" data-action="{{ route('root.superusers.edit', $superuser) }}"
            class="m-portlet__nav-link btn m-btn m-btn--hover-accent m-btn--icon m-btn--icon-only m-btn--pill edit-superuser" title="Edit superuser"><i class="la la-edit"></i>
            </a>
        </span>
    </td>
</tr>