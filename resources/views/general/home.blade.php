@extends('base')

@section('main')
    <div class="jumbotron">
        @if(!Auth::check())
            <a href="{{ URL::route('auth.twitch') }}" class="btn btn-twitch"><i class="fa fa-twitch fa-1x"></i> Connect with Twitch</a>
        @else
            <div class="alert alert-success">
                Welcome {{ Auth::user()->display_name }}. You have successfully logged in.
            </div>
        @endif
    </div>
@endsection
