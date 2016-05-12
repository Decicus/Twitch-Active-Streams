<div class="form-group">
    {!! Form::label('username', 'Twitch username:') !!}
    <div class="input-group">
        <span class="input-group-addon"><i class="fa fa-twitch fa-1x"></i></span>
        {!! Form::text('username', (!empty($profile) ? $profile->user->name : null), ['class' => 'form-control', 'required' => 'required', 'placeholder' => Auth::user()->name]) !!}
    </div>
</div>

<div class="form-group">
    {!! Form::label('bio', 'Stream bio:') !!}
    <div class="input-group">
        <span class="input-group-addon"><i class="fa fa-pencil-square-o fa-1x"></i></span>
        {!! Form::textarea('bio', (!empty($profile) ? $profile->bio : null), ['class' => 'form-control', 'required' => 'required', 'placeholder' => 'The bio of the stream - Supports BBCode']) !!}
    </div>
</div>
