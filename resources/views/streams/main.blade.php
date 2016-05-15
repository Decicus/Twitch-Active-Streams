@extends('base')

@section('main')
    <div class="jumbotron">
        <h2>Streams:</h2>
        <p class="text-info">
            Streams are ordered by their "last updated" and "last stream started" times, which only update when they are live.
            <br>
            The database is updated every 5 minutes.
            <br>
            Times are shown in your local time.
        </p>
        @if(!empty($profiles->first()))
            <div class="list-group">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Name:</th>
                            <th>Last game:</th>
                            <th>Last stream started:</th>
                            <th>Last updated:</th>
                            <th>Status:</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($profiles as $key => $profile)
                            <tr>
                                <th><img src="{{ !empty($profile->user->avatar) ? $profile->user->avatar : 'https://static-cdn.jtvnw.net/jtv_user_pictures/xarth/404_user_150x150.png' }}" alt="{{ $profile->user->display_name }}" class="streams-avatar" /> <a href="{{ route('streams.user', ['user' => $profile->user->name]) }}">{{ !empty($profile->user->display_name) ? $profile->user->display_name : $profile->user->name }}</a></th>
                                <td>{{ !empty($profile->last_game) ? $profile->last_game: 'Unknown' }}</td>
                                <td id="{{ $profile->user->name }}-last_stream">Unknown</td>
                                <td id="{{ $profile->user->name }}-updated">Unknown</td>
                                <td id="{{ $profile->user->name }}-status"></td>
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

@section('footer')
    <script type="text/javascript">
        $(document).ready(function() {
            var profiles = {!! $info !!};

            $.each(profiles, function(i, user) {
                var username = user.user.name;
                $.ajax({
                    method: "get",
                    url: "https://api.twitch.tv/kraken/streams/" + username,
                    dataType: "json",
                    headers: {
                        'Client-ID': '{{ env('TWITCH_CLIENT_ID') }}',
                    },
                    success: function(data) {
                        var username = user.user.name;
                        var cls = '';
                        if (data.stream) {
                            cls = 'stream-online';
                        } else {
                            cls = 'stream-offline';
                        }
                        $('#' + username + '-status').html('<i class="' + cls + ' fa fa-circle fa-1x"></i>');
                        console.log('Status update: ' + username);
                    }
                });

                var last_stream = user.last_stream;
                var updated = user.updated_at;

                if (last_stream) {
                    last_stream = moment.utc(last_stream).local().format('MMMM Do YYYY h:mm:ss A z');
                    $('#' + username + '-last_stream').html(last_stream);
                }

                if (updated) {
                    updated = moment.utc(updated).local().format('MMMM Do YYYY h:mm:ss A z');
                    $('#' + username + '-updated').html(updated);
                }
            });
        });
    </script>
@endsection
