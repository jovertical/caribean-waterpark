<tr>
    <td>{{ $category->id }}</td>
    <td>
        <div class="text-center">
            <img src="{{ "{$category->file_path}/{$category->file_name}" }}" class="rounded-circle img-fluid">
        </div>
    </td>
    <td>{{ $category->name }}</td>
    <td>{!! Str::limit($category->description, 50) !!}</td>
    <td>
        <span class="d-flex">
            <form method="GET" action="{{ route('root.categories.edit', $category->id) }}">
                {{ method_field('PUT') }}

                <button type="submit" class="m-portlet__nav-link btn m-btn m-btn--hover-accent m-btn--icon m-btn--icon-only m-btn--pill" title="Edit category"><i class="la la-edit"></i></button>
            </form>

            <form method="POST" action="{{ route('root.categories.destroy', $category->id) }}">
                {{ method_field('DELETE') }}
                {{ csrf_field() }}

                <button type="submit" class="m-portlet__nav-link btn m-btn m-btn--hover-danger m-btn--icon m-btn--icon-only m-btn--pill" title="Delete category"><i class="la la-trash"></i></button>
            </form>
        </span>
    </td>
</tr>


