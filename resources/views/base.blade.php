<?php
    $nav = Menu::new()
        ->addClass('nav navbar-nav')
        ->setActive(Request::url())
        ->route('home', 'Home')
        ->route('streams.main', 'Streams');

    if(Auth::check()) {
        if(Auth::user()->admin) {
            $nav->route('admin.home', 'Admin');
        }
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

                <ul class="nav navbar-nav navbar-right">
                    @if(Auth::check())
                        <div class="dropdown">
                            <a href="#" type="button" class="btn btn-default navbar-btn dropdown" data-toggle="dropdown">
                                <i class="fa fa-user fa-1x"></i> {{ Auth::user()->display_name }} <span class="caret"></span>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-right" role="menu">
                                <li role="presentation"><a href="{{ URL::route('auth.logout') }}"><i class="fa fa-sign-out fa-1x"></i> Logout</a></li>
                            </ul>
                        </div>
                    @else
                        <li><a href="{{ URL::route('auth.twitch') }}"><i class="fa fa-twitch fa-1x"></i> Connect with Twitch</a></li>
                    @endif
                </ul>
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
