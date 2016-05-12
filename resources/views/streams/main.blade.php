@extends('base')

@section('main')
    <div class="jumbotron">
        <h2>Streams:</h2>
        {{-- TODO: Setup sorting by last_stream --}}
        @if(!empty($profiles->first()))
            <div class="list-group">
                @foreach($profiles as $key => $profile)
                    {{-- TODO: Use relationships. --}}
                    <?php
                        $user = App\User::where(['_id' => $profile->_id])->first();
                    ?>
                    <a class="list-group-item" href="{{ route('streams.user', ['user' => $user->name]) }}">
                        <h4 class="list-group-item-heading"><img src="{{ $user->avatar }}" class="streams-avatar" /> {{ $user->display_name }}</h4>
                        <p class="list-group-item-text">Last stream: {{ $profile->last_stream or 'Unknown' }}</p>
                    </a>
                @endforeach
            </div>
        @else
            <p class="text text-warning">
                There are no stream profiles to be listed!
            </p>
        @endif
    </div>
@endsection
