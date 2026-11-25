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
