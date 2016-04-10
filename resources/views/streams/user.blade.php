@extends('base')

@section('main')
    <div class="panel panel-primary">
        <div class="panel-heading">
            <h3 class="panel-title"><strong>{{ $user->display_name }}</strong></h3>
        </div>

        <div class="panel-body">
            {!! BBCode::parse($profile->bio) !!}
        </div>

        <div class="panel-footer">
            <a href="https://www.twitch.tv/{{ $user->name }}"><i class="fa fa-twitch fa-1x"></i> {{ $user->display_name }}</a>
        </div>
    </div>
@endsection
