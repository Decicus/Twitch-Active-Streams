@extends('base')

@section('main')
    <div class="jumbotron">
        <h2>Streams:</h2>
        <p class="text-info">
            Streams are ordered by "last stream" time, which is based off when someone starts their stream.
            <br>
            The database is updated every 5 minutes.
        </p>
        @if(!empty($profiles->first()))
            <div class="list-group">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Name:</th>
                            <th>Last game:</th>
                            <th>Last stream:</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($profiles as $key => $profile)
                            <tr>
                                <th><a href="{{ route('streams.user', ['user' => $profile->user->name]) }}">{{ $profile->user->display_name }}</a></th>
                                <td>{{ $profile->last_game or 'Unknown' }}</td>
                                <td>{{ !empty($profile->last_stream) ? $profile->last_stream . ' UTC' : 'Unknown' }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <p class="text text-warning">
                There are no stream profiles to be listed!
            </p>
        @endif
    </div>
@endsection
