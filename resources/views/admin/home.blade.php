@extends('base')

@section('main')
    <div class="jumbotron">
        <h3>List of admin pages:</h3>
        <div class="list-group">
            @foreach($pages as $route => $data)
                <a href="{{ route($route) }}" class="list-group-item {{ $data['class'] }}"><span class="badge"><i class="fa {{ $data['fa'] }} fa-1x"></i></span>{{ $data['text'] }}</a>
            @endforeach
        </div>
    </div>
@endsection
