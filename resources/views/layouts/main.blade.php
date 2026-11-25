<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') | Tasks for Today</title>
    <link rel="stylesheet" href="{{ asset('css/tasks.css') }}">
</head>
<body>
    <header class="site-header">
        <div class="header-inner">
            <a class="brand" href="{{ route('welcome') }}">Tasks for Today<span>.</span></a>
            <nav aria-label="Main navigation">
                <a href="{{ route('welcome') }}" @if (request()->routeIs('welcome')) aria-current="page" @endif>Home</a>
                <a href="{{ route('tasks.index') }}" @if (request()->routeIs('tasks.index')) aria-current="page" @endif>Task List</a>
                @auth
                    <a href="{{ route('tasks.archived') }}" @if (request()->routeIs('tasks.archived*')) aria-current="page" @endif>Archived Tasks</a>
                @endauth
                <a href="{{ route('profile') }}" @if (request()->routeIs('profile')) aria-current="page" @endif>Profile</a>
                <a href="{{ route('about') }}" @if (request()->routeIs('about')) aria-current="page" @endif>About</a>
                @include('partials.auth-navigation')
            </nav>
        </div>
    </header>
    <main class="container">
        @yield('content')
    </main>
    <footer class="site-footer">&copy; {{ date('Y') }} Tasks for Today. One task at a time.</footer>
</body>
</html>
