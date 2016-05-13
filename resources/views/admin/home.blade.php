@extends('base')

@section('main')
    <div class="jumbotron">
        <h3>List of admin pages:</h3>
        <div class="list-group">
            @foreach($pages as $route => $data)
                <a href="{{ route($route) }}" class="list-group-item"><span class="badge"><i class="fa {{ $data['fa'] }} fa-1x"></i></span> <span class="{{ $data['class'] }}">{{ $data['text'] }}</span></a>
            @endforeach
        </div>
    </div>
@endsection
