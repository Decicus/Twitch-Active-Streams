@extends('base')

@section('main')
    @if(!empty($success))
        <div class="alert alert-success">
            Successfully updated the stream profile for: <strong>{{ $success }}</strong>.
        </div>
    @endif

    @if(!empty($user))
        <div class="jumbotron">
            <p class="text text-info">This page will allow you to update an already added stream profile for a <i class="fa fa-twitch fa-1x"></i> streamer.</p>

            {!! Form::open(['route' => 'admin.user.update', 'method' => 'post']) !!}
                <div class="form-group">
                    {!! Form::label('username', 'Twitch username:') !!}
                    {!! Form::text('username', $user->name, ['class' => 'form-control', 'required' => 'required', 'placeholder' => Auth::user()->name, 'readonly' => '']) !!}
                </div>

                <div class="form-group">
                    {!! Form::label('bio', 'Stream bio (optional &mdash; Supports BBCode):') !!}
                    {!! Form::textarea('bio', $profile->bio, ['class' => 'form-control', 'placeholder' => 'The bio of the stream - Supports BBCode']) !!}
                </div>

                {!! Form::token() !!}
                {!! Form::submit('Update stream profile', ['class' => 'btn btn-info']) !!}
            {!! Form::close() !!}
        </div>
    @else
        <div class="alert alert-danger">
            Invalid username specified
        </div>
    @endif
@endsection
