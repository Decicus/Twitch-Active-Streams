@extends('base')

@section('main')
    <div class="panel panel-primary">
        <div class="panel-heading">
            <h3 class="panel-title">
                @if(!empty($user->avatar))
                    <img src="{{ $user->avatar }}" class="streams-avatar" alt="{{ $user->display_name }}" title="{{ $user->display_name }}" />
                @endif
                <strong>{{ !empty($user->display_name) ? $user->display_name : $user->name }}</strong>
            </h3>
        </div>

        <div class="panel-body">
            {!! BBCode::parse($profile->bio) !!}
        </div>

        <div class="panel-footer">
            <a href="https://www.twitch.tv/{{ $user->name }}" target="_blank"><i class="fa fa-twitch fa-1x"></i> {{ $user->display_name }}</a>
        </div>
    </div>
@endsection
