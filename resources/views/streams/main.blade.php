@extends('base')

@section('main')
    <div class="jumbotron">
        <h2>Streams:</h2>
        {{-- TODO: Setup sorting by last_stream --}}
        @if(!empty($profiles->first()))
            <ul class="list-group">
                @foreach($profiles as $profile)
                    <?php
                        $user = App\User::where(['_id' => $profile->_id])->first();
                    ?>
                    <li class="list-group-item"><a href="{{ route('streams.user', ['user' => $user->name]) }}">{{ $user->display_name }}</a></li>
                @endforeach
            </ul>
        @else
            <p class="text text-warning">
                There are no stream profiles to be listed!
            </p>
        @endif
    </div>
@endsection
