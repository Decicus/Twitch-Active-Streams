@extends('base')

@section('main')
    @if(!empty($success))
        <div class="alert alert-success">
            <div class="alert alert-success">Successfully edited the stream profile for: <strong>{{ $success }}</strong>.</div>
        </div>
    @endif

    <div class="jumbotron">
        @if(!empty($profile))
            {!! Form::open(['route' => ['admin.user.edit', $profile->user->name], 'method' => 'post']) !!}
                @include('admin.user.form-input')

                {!! Form::token() !!}
                <button type="submit" class="btn btn-warning"><i class="fa fa-pencil-square fa-1x"></i> Edit stream profile</button>
            {!! Form::close() !!}
        @else
            <div class="list-group">
                <h3>Available users for edit:</h3>
                @if(!empty($all_profiles) && count($all_profiles) > 0)
                    <div class="list-group">
                        @foreach($all_profiles as $profile)
                            <a href="{{ route('admin.user.edit', $profile->user->name) }}" class="list-group-item list-group-item-info"><img src="{{ $profile->user->avatar }}" alt="{{ $profile->user->display_name }}" title="{{ $profile->user->display_name }}" class="streams-avatar" /> {{ $profile->user->display_name }}</a>
                        @endforeach
                    </div>
                @else
                    <p class="text-warning">
                        There are no users with a stream profile set up.
                    </p>
                @endif
            </div>
        @endif
    </div>
@endsection
