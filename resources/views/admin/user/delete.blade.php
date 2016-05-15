@extends('base')

@section('main')
    @if(!empty($success))
        <div class="alert alert-danger">
            Successfully deleted the stream profile for: <strong>{{ $success }}</strong>.
        </div>
    @endif

    <div class="jumbotron">
        <p>Deleting a stream profile only <abbr title="Soft-deleting removes the streams from all public pages, but are still stored in the database together with the previous information.">soft-deletes</abbr>. You can <a href="{{ route('admin.user.restore') }}">restore a profile</a>, or add a new one (which overwrites any previously deleted profiles).</p>

        {!! Form::open(['route' => 'admin.user.delete', 'method' => 'post']) !!}
            <div class="form-group">
                <label for="user">Username:</label>
                <div class="input-group">
                    <span class="input-group-addon"><i class="fa fa-user-times fa-1x"></i></span>
                    <select class="form-control" name="user">
                        @foreach($all_profiles as $profile)
                            <option value="{{ $profile->_id }}">{{ $profile->user->display_name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            {!! Form::token() !!}
            <button type="submit" class="btn btn-danger"><i class="fa fa-user-times fa-1x"></i> Delete stream profile</button>
        {!! Form::close() !!}
    </div>
@endsection
