@extends('layouts.main')

@section('title', 'Welcome')

@section('content')
<section class="welcome" aria-labelledby="welcome-heading">
    <p class="eyebrow">A little focus. A better day.</p>
    <h1 id="welcome-heading">Make room for what matters today.</h1>
    <p class="muted">Keep your plans in one place, take things one step at a time, and enjoy a little more clarity with Tasks for Today.</p>
    <div class="welcome-actions">
        <a class="button" href="{{ route('tasks.index') }}">View Task List</a>
        <a href="{{ route('tasks.create') }}">Create a task &rarr;</a>
    </div>
</section>

<section aria-labelledby="features-heading">
    <h2 id="features-heading">A simpler approach to your day</h2>
    <div class="features">
        <article class="card feature">
            <h3>Clear your mind</h3>
            <p class="muted">Start with a simple list of the things you want to get done.</p>
        </article>
        <article class="card feature">
            <h3>Find your focus</h3>
            <p class="muted">Set a date and take your day one task at a time.</p>
        </article>
        <article class="card feature">
            <h3>Celebrate progress</h3>
            <p class="muted">Mark tasks as done and archive them when you are ready.</p>
        </article>
    </div>
</section>
@endsection
