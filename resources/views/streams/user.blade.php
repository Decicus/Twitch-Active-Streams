@extends('base')

@section('main')
    <div class="jumbotron">
        <h2 class="text-info"><strong>{{ $user->display_name }}</strong></h2>
        {{-- TODO: Fix bio parsing (Markdown/BBcode?) --}}
        <p>{{ $profile->bio }}</p>
    </div>
@endsection
