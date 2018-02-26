<tr>
    <td>{{ $index + 1 }}</td>
    <td>
        <span>
            <img src="{{ Helper::fileUrl($user, 'thumbnail') }}" class="img-fluid rounded-circle">
        </span>
    </td>
    <td>{{ $user->full_name }}</td>
    <td>{{ $user->gender }}</td>
    <td>{{ $user->birthdate }}</td>
    <td>{{ $user->email }}</td>
    <td>{{ $user->phone_number }}</td>
    <td>
        {{ $user->active ? 1 : 2 }}
    </td>
    <td>
        <span class="d-flex" style="overflow: visible;">
            <div class="dropdown">
                <a href="javascript:void(0);" class="btn m-btn m-btn--hover-accent m-btn--icon m-btn--icon-only m-btn--pill" data-toggle="dropdown"><i class="la la-ellipsis-h"></i></a>

                <div class="dropdown-menu dropdown-menu-right">
                    <a href="javascript:void(0);" data-form="#toggleUser" 
                    data-action="{{ route('root.users.toggle', $user) }}" data-toggle="modal" data-target="#toggleUserConfirmation" class="dropdown-item toggle-user" title="Toggle user"><i class="la la-toggle-on"></i>Toggle
                    </a>

                    <a href="{{ route('root.users.image', $user) }}" class="dropdown-item">
                        <i class="la la-image"></i> View image
                    </a>
                </div>
            </div>

            <a href="javascript:void(0);" data-form="#editUser" data-action="{{ route('root.users.edit', $user) }}"
            class="m-portlet__nav-link btn m-btn m-btn--hover-accent m-btn--icon m-btn--icon-only m-btn--pill edit-user" title="Edit user"><i class="la la-edit"></i>
            </a>
        </span>
    </td>
</tr>