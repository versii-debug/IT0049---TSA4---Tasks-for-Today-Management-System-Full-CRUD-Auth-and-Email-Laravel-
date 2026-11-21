<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') | Tasks for Today</title>
</head>
<body>
    <h1>Tasks for Today</h1>
    <a href="{{ route('welcome') }}">Welcome</a> |
    <a href="{{ route('tasks.index') }}">Task List</a>
    <hr>

    @yield('content')
</body>
</html>
