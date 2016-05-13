@extends('base')

@section('main')
    @if(!empty($success))
        <div class="alert alert-success">
            Successfully updated the stream profile for: <strong>{{ $success }}</strong>.
        </div>
    @endif

    <div class="jumbotron">
        <p>This page will allow you to add a stream profile for a <i class="fa fa-twitch fa-1x"></i> streamer.</p>

        {!! Form::open(['route' => 'admin.user.add', 'method' => 'post']) !!}
            @include('admin.user.form-input')

            {!! Form::token() !!}
            <button type="submit" class="btn btn-success"><i class="fa fa-user-plus fa-1x"></i> Add stream profile</button>
        {!! Form::close() !!}
    </div>
@endsection
