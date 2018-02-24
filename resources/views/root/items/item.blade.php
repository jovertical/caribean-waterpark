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
    <td>₱{{ Helper::moneyFormat($item->price) }}</td>
    <td>{{ $item->quantity }}</td>
    <td>
        <span class="m-badge m-badge--{{ $item->active ? 'success' : '' }} m-badge--wide text-white">
            {{ $item->active ? 'Active' : 'Inactive' }}
        </span>
    </td>
    <td>
        <span class="d-flex" style="overflow: visible;">
            <div class="dropdown">
                <a href="#" class="btn m-btn m-btn--hover-accent m-btn--icon m-btn--icon-only m-btn--pill" data-toggle="dropdown"><i class="la la-ellipsis-h"></i></a>

                <div class="dropdown-menu dropdown-menu-right">
                    <a href="#" onclick="event.preventDefault();
                        document.getElementById('form-item-{{ $item->id }}').submit();" class="dropdown-item">
                        <i class="la la-toggle-{{ $item->active ? 'on' : 'off' }}"></i> Toggle status
                    </a>

                    <form method="POST" action="{{ route('root.items.toggle', $item->id) }}"
                        id="form-item-{{ $item->id }}" style="display: none;">
                        {{ method_field('PATCH') }}
                        {{ csrf_field() }}
                    </form>

                    <a href="{{ route('root.items.image', $item->id) }}" class="dropdown-item">
                        <i class="la la-image"></i> View image
                    </a>
                </div>
            </div>

            <form method="GET" action="{{ route('root.items.edit', $item->id) }}">
                {{ method_field('PUT') }}

                <button type="submit" class="m-portlet__nav-link btn m-btn m-btn--hover-accent m-btn--icon m-btn--icon-only m-btn--pill" title="Edit item"><i class="la la-edit"></i></button>
            </form>

            <form method="POST" action="{{ route('root.items.destroy', $item->id) }}" class="confirm">
                {{ method_field('DELETE') }}
                {{ csrf_field() }}

                <button type="submit" data-toggle="modal" data-target="#modalConfirmation" class="m-portlet__nav-link btn m-btn m-btn--hover-danger m-btn--icon m-btn--icon-only m-btn--pill" title="Delete item"><i class="la la-trash"></i>
                </button>
            </form>
        </span>
    </td>
</tr>