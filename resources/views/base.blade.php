<?php
    $nav = Menu::new()
        ->addClass('nav navbar-nav')
        ->setActive(Request::url())
        ->route('home', 'Home')
        ->route('streams', 'Streams');

    $navRight = Menu::new()
        ->addClass('nav navbar-nav navbar-right');

    if(Auth::check()) {
        // TODO: Add menu items for logged in users.
        if(Auth::user()->admin) {
            $nav->route('admin.home', 'Admin');
        }
    } else {
        $navRight->route('auth.twitch', '<i class="fa fa-twitch fa-1x"></i> Connect with Twitch');
    }
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>Twitch Active Streams - {{ $page or '[Unknown]' }}</title>
        <link rel="stylesheet" href="/css/bootstrap.min.css" media="screen" charset="utf-8">
        <link rel="stylesheet" href="/css/darkly.min.css" media="screen" charset="utf-8">
        <link rel="stylesheet" href="/css/font-awesome.min.css" media="screen" charset="utf-8">
        <link rel="stylesheet" href="/css/custom.css" media="screen" charset="utf-8">
        <script src="/js/jquery-1.12.2.min.js" charset="utf-8"></script>
        <script src="/js/bootstrap.min.js" charset="utf-8"></script>
    </head>
    <body>
        <nav class="navbar navbar-default" role="navigation">
            <div class="container-fluid">
                <div class="navbar-header">
                    <a href="{{ URL::route('home') }}" class="navbar-brand">Twitch Active Streams</a>
                </div>

                {!! $nav->render() !!}

                {!! $navRight->render() !!}
            </div>
        </nav>

        <div class="container-fluid">
            <div class="page-header">
                <h1>Twitch Active Streams &mdash; {{ $page or '[Unknown]' }}</h1>
            </div>

            @include('shared.errors')
            @yield('main')
        </div>
    </body>
</html>
