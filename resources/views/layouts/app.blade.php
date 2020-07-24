<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title') EventO</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>

<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">
                @guest
                @if (Route::has('register'))
                <a class="navbar-brand" href="{{ route('login') }}">
                    EventO
                </a>
                @endif
                @else
                <a class="navbar-brand" href="{{ url('/home') }}">
                    EventO
                </a>
                @endguest

                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse links" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mr-auto">

                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="nav nav-pills nav-stacked ml-auto">

                        <li class="nav-item">
                            <a class="nav-link {{ (Request::segment(1) == 'home') || (Request::segment(1) == '') ? 'active' : null }}" href="{{ url('home') }}">{{ __('Events') }}</a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link {{ Request::segment(1) === 'about' ? 'active' : null }}" href="{{ url('about') }}">{{ __('About') }}</a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link {{ Request::segment(1) === 'contact' ? 'active' : null }}" href="{{ url('contact') }}">{{ __('Contacts') }}</a>
                        </li>

                        <!-- Authentication Links -->
                        @guest

                        @if (Request::path() == 'login' || Route::has('register'))
                        <li class="nav-item">
                            <a class="nav-link {{ Request::segment(1) === 'login' ? 'active' : null }}" href="{{ route('login') }}">{{ __('Sign in') }}</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ Request::segment(1) === 'register' ? 'active' : null }}" href="{{ route('register') }}">{{ __('Sign up') }}</a>
                        </li>
                        @endif

                        @else
                        <li class="nav-item dropdown">
                            <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                <span class="caret">My account</span>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">

                                <a class="dropdown-item" href="{{ route('profile.show', auth()->user()->id)}}">{{ __('My profile') }}</a>


                                <a class="sub-menu dropdown-item collapsed " href="#submenu" data-toggle="collapse" data-target="#submenu">
                                    {{ __('My events ') }} &#x21B7;
                                </a>


                                <div class="sub-item collapse" id="submenu" aria-expanded="false">

                                    <a class="dropdown-item" href="{{ route('profile.approved') }}">&emsp;{{ __('Approved') }}</a>

                                    <a class="dropdown-item" href="{{ route('profile.waiting') }}">&emsp;{{ __('Waiting for approvals') }}</a>

                                    @if(auth()->user()->organizer == false)
                                    <a class="dropdown-item" href="{{ route('event.create') }}">&emsp;{{ __('My event requests') }}</a>
                                    @endif
                                </div>

                                <!-- <a class="dropdown-item" href="#">{{ __('My ratings') }}</a> -->

                                <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();
                                    document.getElementById('logout-form').submit();"> {{ __('Log out') }}
                                </a>

                                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                    @csrf
                                </form>
                            </div>
                        </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        <main class="py-4">

            <div class="container">
                @if(Session::has('success'))
                <div class="alert alert-success text-center" role="alert">
                    {{ Session::get('success') }}
                </div>
                @endif

                @if(Session::has('error'))
                <div class="alert alert-danger text-center" role="alert">
                    {{ Session::get('error') }}
                </div>
                @endif
            </div>

            @yield('content')
        </main>
    </div>
</body>

</html>