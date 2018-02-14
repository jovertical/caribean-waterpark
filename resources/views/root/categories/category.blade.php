<tr>
    <td>{{ $index + 1 }}</td>
    <td>
        <span>
            <img src="{{ URL::to("{$category->file_directory}/thumbnails/{$category->file_name}") }}" class="img-fluid rounded-circle">
        </span>
    </td>
    <td>{{ Str::ucfirst($category->type) }}</td>
    <td>{{ Str::ucfirst($category->name) }}</td>
    <td>{!! Str::limit($category->description, 50) !!}</td>
    <td>
        <span class="d-flex">
            <a href="{{ route('root.categories.image', $category->id) }}" class="m-portlet__nav-link btn m-btn m-btn--hover-accent m-btn--icon m-btn--icon-only m-btn--pill" title="View image"><i class="la la-image"></i></a>

            <form method="GET" action="{{ route('root.categories.edit', $category->id) }}">
                {{ method_field('PUT') }}

                <button type="submit" class="m-portlet__nav-link btn m-btn m-btn--hover-accent m-btn--icon m-btn--icon-only m-btn--pill" title="Edit category"><i class="la la-edit"></i></button>
            </form>

            <form method="POST" action="{{ route('root.categories.destroy', $category->id) }}" class="form-confirm">
                {{ method_field('DELETE') }}
                {{ csrf_field() }}

                <button type="submit" data-toggle="modal" data-target="#modal" class="m-portlet__nav-link btn m-btn m-btn--hover-danger m-btn--icon m-btn--icon-only m-btn--pill" title="Delete category"><i class="la la-trash"></i></button>
            </form>
        </span>
    </td>
</tr>