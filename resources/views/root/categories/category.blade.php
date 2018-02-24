<tr>
    <td>{{ $index + 1 }}</td>
    <td>
        <span>
            <img src="{{ Helper::fileUrl($category, 'thumbnail') }}" class="img-fluid rounded-circle">
        </span>
    </td>
    <td>{{ Str::ucfirst($category->type) }}</td>
    <td>{{ Str::ucfirst($category->name) }}</td>
    <td>{!! Str::limit($category->description, 25) !!}</td>
    <td>{{ $category->items->count() }}</td>
    <td>
        <span class="m-badge m-badge--{{ $category->active ? 'success' : '' }} m-badge--wide text-white">
            {{ $category->active ? 'Active' : 'Inactive' }}
        </span>
    </td>
    <td>
        <span class="d-flex" style="overflow: visible;">
            <div class="dropdown">
                <a href="#" class="btn m-btn m-btn--hover-accent m-btn--icon m-btn--icon-only m-btn--pill" data-toggle="dropdown"><i class="la la-ellipsis-h"></i></a>

                <div class="dropdown-menu dropdown-menu-right">
                    <a href="#" onclick="event.preventDefault();
                        document.getElementById('form-category-{{ $category->id }}').submit();" class="dropdown-item">
                        <i class="la la-toggle-{{ $category->active ? 'on' : 'off' }}"></i> Toggle status
                    </a>

                    <form method="POST" action="{{ route('root.categories.toggle', $category->id) }}"
                        id="form-category-{{ $category->id }}" style="display: none;">
                        {{ method_field('PATCH') }}
                        {{ csrf_field() }}
                    </form>

                    <a href="{{ route('root.categories.image', $category->id) }}" class="dropdown-item">
                        <i class="la la-image"></i> View image
                    </a>
                </div>
            </div>

            <form method="GET" action="{{ route('root.categories.edit', $category->id) }}">
                {{ method_field('PUT') }}
                <button type="submit" class="m-portlet__nav-link btn m-btn m-btn--hover-accent m-btn--icon m-btn--icon-only m-btn--pill" title="Edit category"><i class="la la-edit"></i></button>
            </form>

            <form method="POST" action="{{ route('root.categories.destroy', $category->id) }}" class="confirm">
                {{ method_field('DELETE') }}
                {{ csrf_field() }}
                <button type="submit" data-toggle="modal" data-target="#modalConfirmation" class="m-portlet__nav-link btn m-btn m-btn--hover-danger m-btn--icon m-btn--icon-only m-btn--pill" title="Delete category"><i class="la la-trash"></i></button>
            </form>
        </span>
    </td>
</tr>