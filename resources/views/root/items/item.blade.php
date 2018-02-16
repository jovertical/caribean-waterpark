<tr>
    <td>{{ $index + 1 }}</td>
    <td>
        <span>
            @if(count($item->images))
                <img src="{{ URL::to("{$item->images->first()->file_directory}/thumbnails/{$item->images->first()->file_name}") }}" class="img-fluid rounded-circle">
            @endif
        </span>
    </td>
    <td>{{ Str::ucfirst($item->type) }}</td>
    <td>{{ Str::ucfirst($item->name) }}</td>
    <td>{!! Str::limit($item->description, 50) !!}</td>
    <td>{{ $item->price }}</td>
    <td>{{ $item->quantity }}</td>
    <td>
        <span class="d-flex">
            <a href="{{ route('root.items.image', $item->id) }}" class="m-portlet__nav-link btn m-btn m-btn--hover-accent m-btn--icon m-btn--icon-only m-btn--pill" title="View image"><i class="la la-image"></i></a>

            <form method="GET" action="{{ route('root.items.edit', $item->id) }}">
                {{ method_field('PUT') }}

                <button type="submit" class="m-portlet__nav-link btn m-btn m-btn--hover-accent m-btn--icon m-btn--icon-only m-btn--pill" title="Edit item"><i class="la la-edit"></i></button>
            </form>

            <form method="POST" action="{{ route('root.items.destroy', $item->id) }}" class="form-confirm">
                {{ method_field('DELETE') }}
                {{ csrf_field() }}

                <button type="submit" data-toggle="modal" data-target="#modal" class="m-portlet__nav-link btn m-btn m-btn--hover-danger m-btn--icon m-btn--icon-only m-btn--pill" title="Delete item"><i class="la la-trash"></i></button>
            </form>
        </span>
    </td>
</tr>