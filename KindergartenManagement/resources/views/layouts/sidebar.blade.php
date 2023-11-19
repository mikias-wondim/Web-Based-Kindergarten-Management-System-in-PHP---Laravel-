<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Kinder Garten Management System</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">
    <link
        href="https://fonts.googleapis.com/css2?family=Shantell+Sans:ital,wght@0,400;1,300&display=swap"
        rel="stylesheet"
    />


    <!-- Box Icons -->
    <link
        href="https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css"
        rel="stylesheet"
    />

    <!-- Styles and Scripts -->
    @vite(['resources/css/app.css','resources/sass/app.scss', 'resources/js/app.js'])
</head>
<body>
<div id="app">
    <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm fixed-top">
        <div class="container">
            <a class="navbar-brand d-flex justify-center items-center" href="{{ url('/') }}">
                <div class="pe-2" >
                    <img src="{{ asset('image/logo-colorful.png') }}" alt="logo" style="max-height: 50px">
                </div>
                <div class="logo-center title-logo">
                    Kinder-Garten Management
                </div>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <!-- Left Side Of Navbar -->
                <ul class="navbar-nav me-auto">

                </ul>

                <!-- Right Side Of Navbar -->
                <ul class="navbar-nav ms-auto">
                    <!-- Authentication Links -->
                    @guest
                        @if (Route::has('login'))
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                            </li>
                        @endif

                        @if (Route::has('register'))
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                            </li>
                        @endif
                    @else
                        <li class="nav-item dropdown">
                            <a id="navbarDropdown" class="nav-link dropdown-toggle" href="/profile" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                <img src="{{ asset('storage/'.Auth::user()->profile->profile_pic) }}" style="max-height: 20px; padding-left: 5px;" alt="profile">
                                {{ Auth::user()->unique_name }}
                            </a>

                            <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item" href="{{ route('logout') }}"
                                   onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                    {{ __('Logout') }}
                                </a>

                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                    @csrf
                                </form>
                            </div>
                        </li>
                    @endguest
                </ul>
            </div>
        </div>
    </nav>

    <!-- SIDEBAR -->
    <section id="sidebar">
        <ul class="side-menu top">
            <li class="active">
                <a href="/dashboard">
                    <i class="bx bxs-dashboard"></i>
                    <span class="text">Dashboard</span>
                </a>
            </li>
            <li >
                <a href="/profile">
                    <i class="bx bx-notepad"></i>
                    <span class="text">Profile</span>
                </a>
            </li>
            <li>
                <a href="/noticeboard">
                    <i class="bx bxs-bell"></i>
                    <span class="text">Notice</span>
                </a>
            </li>
            <li>
                <a href="/progress-report">
                    <i class="bx bx-line-chart"></i>
                    <span class="text">Progress Report</span>
                </a>
            </li>
            <li>
                <a href="/class-schedule">
                    <i class="bx bx-calendar"></i>
                    <span class="text">Class Schedule</span>
                </a>
            </li>
            <li>
                <a href="/bill-record">
                    <i class="bx bx-dollar-circle"></i>
                    <span class="text">Billing</span>
                </a>
            </li>
            <li>
                <a href="/chat">
                    <i class="bx bxs-message-dots"></i>
                    <span class="text">Chat</span>
                </a>
            </li>
        </ul>
        <ul class="side-menu">
            <li>
                <a class="dropdown-item logout" href="{{ route('logout') }}"
                   onclick="event.preventDefault();
                                                 document.getElementById('logout-form').submit();">
                    <i class="bx bx-log-out"></i>
                    <span>Logout</span>
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                    @csrf
                </form>
            </li>
        </ul>
    </section>
    <!-- SIDEBAR -->

    <main class="py-4">
        @yield('content')
    </main>
</div>
</body>
</html>
