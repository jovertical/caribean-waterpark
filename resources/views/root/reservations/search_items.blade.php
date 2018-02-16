@extends('root.layouts.main')

@section('content')
    <ul>
        @foreach($items as $item)
            <li>{{ $item->name }}</li>
        @endforeach
    </ul>
@endsection