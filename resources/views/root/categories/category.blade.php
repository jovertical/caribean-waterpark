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
        {{ $category->active ? 1 : 2 }}
    </td>
    <td>
        <span class="d-flex" style="overflow: visible;">
            <div class="dropdown">
                <a href="javascript:void(0);" class="btn m-btn m-btn--hover-accent m-btn--icon m-btn--icon-only m-btn--pill" data-toggle="dropdown"><i class="la la-ellipsis-h"></i></a>

                <div class="dropdown-menu dropdown-menu-right">
                    <a href="javascript:void(0);" data-form="#toggleCategory" data-action="{{ route('root.categories.toggle', $category->id) }}" data-toggle="modal" data-target="#toggleCategoryConfirmation" class="dropdown-item toggle-category" title="Toggle category"><i class="la la-toggle-on"></i>Toggle
                    </a>

                    <a href="{{ route('root.categories.image', $category->id) }}" class="dropdown-item">
                        <i class="la la-image"></i> View image
                    </a>
                </div>
            </div>

            <a href="javascript:void(0);" data-form="#editCategory" data-action="{{ route('root.categories.edit', $category->id) }}" class="m-portlet__nav-link btn m-btn m-btn--hover-accent m-btn--icon m-btn--icon-only m-btn--pill edit-category" title="Edit category"><i class="la la-edit"></i>
            </a>

            <a href="javascript:void(0);" data-form="#destroyCategory" data-action="{{ route('root.categories.destroy', $category->id) }}" data-toggle="modal" data-target="#destroyCategoryConfirmation" class="m-portlet__nav-link btn m-btn m-btn--hover-danger m-btn--icon m-btn--icon-only m-btn--pill destroy-category" title="Delete category">
                <i class="la la-trash"></i>
            </a>
        </span>
    </td>
</tr>