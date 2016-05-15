@extends('base')

@section('main')
    @if(!empty($success))
        <div class="alert alert-info">
            Successfully restored the stream profile for: <strong>{{ $success }}</strong>.
        </div>
    @endif

    <div class="jumbotron">
        <p>This page is dedicated to restoring previously <abbr title="Soft-deleting removes the streams from all public pages, but are still stored in the database together with the previous information.">soft-deleted</abbr> stream profiles.</p>
        {!! Form::open(['route' => 'admin.user.restore', 'method' => 'post']) !!}
            <div class="form-group">
                <label for="user">Username:</label>
                <div class="input-group">
                    <span class="input-group-addon"><i class="fa fa-user-secret fa-1x"></i></span>
                    <select class="form-control" name="user" {{ $trashed_profiles->isEmpty() ? 'disabled=""' : '' }}>
                        @if($trashed_profiles->isEmpty())
                            <option>There are no soft-deleted profiles.</option>
                        @else
                            @foreach($trashed_profiles as $profile)
                                <option value="{{ $profile->_id }}">{{ $profile->user->display_name }}</option>
                            @endforeach
                        @endif
                    </select>
                </div>
            </div>

            {!! Form::token() !!}
            <button type="submit" class="btn btn-info"><i class="fa fa-user-secret fa-1x"></i> Restore stream profile</button>
        {!! Form::close() !!}
    </div>
@endsection
