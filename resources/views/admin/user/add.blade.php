@extends('base')

@section('main')
    @if(!empty($success))
        <div class="alert alert-success">
            Successfully added the stream profile for: <strong>{{ $success }}</strong>.
        </div>
    @endif

    <div class="jumbotron">
        <p class="text text-info">This page will allow you to add a stream profile for a <i class="fa fa-twitch fa-1x"></i> streamer.</p>

        {!! Form::open(['route' => 'admin.user.add', 'method' => 'post']) !!}
            <div class="form-group">
                {!! Form::label('username', 'Twitch username:') !!}
                {!! Form::text('username', null, ['class' => 'form-control', 'required' => 'required', 'placeholder' => Auth::user()->name]) !!}
            </div>

            <div class="form-group">
                {!! Form::label('bio', 'Stream bio (optional &mdash; Supports BBCode):') !!}
                {!! Form::textarea('bio', null, ['class' => 'form-control', 'required' => 'required', 'placeholder' => 'The bio of the stream - Supports BBCode']) !!}
            </div>

            {!! Form::token() !!}
            {!! Form::submit('Add stream profile', ['class' => 'btn btn-success']) !!}
        {!! Form::close() !!}
    </div>
@endsection
