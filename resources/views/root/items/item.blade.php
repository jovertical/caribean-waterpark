<tr>
    <td>{{ $index + 1 }}</td>
    <td>
        <span>
            <img src="{{ Helper::fileUrl(count($item->images) ? $item->images->first() : null, 'thumbnail') }}"
                class="img-fluid rounded-circle">
        </span>
    </td>
    <td>{{ Str::ucfirst($item->category->name) }}</td>
    <td>{{ Str::ucfirst($item->name) }}</td>
    <td>{!! Str::limit($item->description, 25) !!}</td>
    <td>{{ Helper::moneyFormat($item->price) }}</td>
    <td>{{ $item->quantity }}</td>
    <td>
        {{ $item->active ? 1 : 2 }}
    </td>
    <td>
        <span class="d-flex" style="overflow: visible;">
            <div class="dropdown">
                <a href="javascript:void(0);" class="btn m-btn m-btn--hover-accent m-btn--icon m-btn--icon-only m-btn--pill" data-toggle="dropdown"><i class="la la-ellipsis-h"></i></a>

                <div class="dropdown-menu dropdown-menu-right">
                    <a href="javascript:void(0);" data-form="#toggleItem" data-action="{{ route('root.items.toggle', $item->id) }}" data-toggle="modal" data-target="#toggleItemConfirmation" class="dropdown-item toggle-item" title="Toggle item"><i class="la la-toggle-on"></i>Toggle
                    </a>

                    <a href="{{ route('root.items.image', $item->id) }}" class="dropdown-item">
                        <i class="la la-image"></i> View image
                    </a>
                </div>
            </div>

            <a href="javascript:void(0);" data-form="#editItem" data-action="{{ route('root.items.edit', $item->id) }}" class="m-portlet__nav-link btn m-btn m-btn--hover-accent m-btn--icon m-btn--icon-only m-btn--pill edit-item" title="Edit item"><i class="la la-edit"></i>
            </a>

            <a href="javascript:void(0);" data-form="#destroyItem" data-action="{{ route('root.items.destroy', $item->id) }}" data-toggle="modal" data-target="#destroyItemConfirmation" class="m-portlet__nav-link btn m-btn m-btn--hover-danger m-btn--icon m-btn--icon-only m-btn--pill destroy-item" title="Delete item">
                <i class="la la-trash"></i>
            </a>
        </span>
    </td>
</tr>