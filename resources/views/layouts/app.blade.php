<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <title> @yield('title') </title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <meta content="{{ csrf_token() }}" name="csrf-token">

        <title>Laravel</title>

        {{-- Styles --}}
        <link rel="stylesheet" type="text/css" href="{{ asset('css\app.css') }}">

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">

    </head>
    <body>
        <div class="container d-flex justify-content-center">
            <nav class="navbar navbar-expand-lg navbar-light bg-light">
                <a class="navbar-brand" href="{{ route('home') }}">Livechat prototype</a>

                {{-- Button for expanding navbar when collapsed --}}
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="navbar-collapse collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav mr-auto">
                        <li class="nav-item">
                            <a href="{{ route('home') }}" class="nav-link">Home</a>
                        </li>

                        <li class="nav-item">
                            <a href="{{ route('register') }}" class="nav-link">Register</a>
                        </li>

                        <li class="nav-item">
                            <a href="{{ route('public-channel') }}" class="nav-link">Public channel</a>
                        </li>

                        <li class="nav-item">
                            <a href="{{ route('presence-channel') }}" class="nav-link">Presence channel</a>
                        </li>

                        <li class="nav-item">
                            <a href="{{ route('private-channel') }}" class="nav-link">Private channel</a>
                        </li>
                    </ul>
                </div>

            </nav>
        </div>
        <div id="app" class="container">
            @yield('content')
        </div>
        {{-- Scripts --}}
        <script type="text/javascript" src="{{ asset('js\app.js') }}"></script>
    </body>
</html>
