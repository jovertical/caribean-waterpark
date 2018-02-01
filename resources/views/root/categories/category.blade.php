<tr>
    <td></td>
    <td>{{ $category->name }}</td>
    <td>{!! str_limit($category->description, 50) !!}</td>
    <td>
        <div class="dropdown">
            <button type="button" class="btn btn-primary btn-sm dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Actions</button>

            <div class="dropdown-menu dropdown-default">
                <form method="GET" action="{{ route('root.categories.edit', $category->id) }}">
                    {{ method_field('PUT') }}

                    <button type="submit" class="dropdown-item"><i class="fa fa-pencil pr-2"></i>Edit</button>
                </form>

                <div class="dropdown-divider"></div>

                <form method="POST" action="{{ route('root.categories.destroy', $category->id) }}">
                    {{ method_field('DELETE') }}
                    {{ csrf_field() }}

                    <button type="submit" class="dropdown-item"><i class="fa fa-trash pr-2"></i>Delete</button>
                </form>
            </div>
        </div>
    </td>
</tr>