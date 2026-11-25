@extends('layouts.main')

@section('title', 'Welcome')

@section('content')
<section class="welcome" aria-labelledby="welcome-heading">
    <p class="eyebrow">A little focus. A better day.</p>
    <h1 id="welcome-heading">Make room for what matters today.</h1>
    <p class="muted">Welcome to Tasks for Today. Keep your plans in one place, take things one step at a time, and enjoy a little more clarity.</p>
    <div class="welcome-actions">
        <a class="button" href="#features">Explore the idea <span aria-hidden="true">&darr;</span></a>
    </div>
</section>

<section id="features" aria-labelledby="features-heading">
    <h2 id="features-heading">A simpler approach to your day</h2>
    <div class="features">
        <article class="card feature">
            <h3>Clear your mind</h3>
            <p class="muted">Start with a simple list of the things you want to get done.</p>
        </article>
        <article class="card feature">
            <h3>Find your focus</h3>
            <p class="muted">Decide what matters most and take your day one task at a time.</p>
        </article>
        <article class="card feature">
            <h3>Celebrate progress</h3>
            <p class="muted">Every small step counts. Give yourself credit as you move forward.</p>
        </article>
    </div>
</section>

<section class="card" aria-labelledby="today-heading">
    <div class="card-heading">
        <h2 id="today-heading">Today's Tasks <span class="count">{{ $tasks->count() }}</span></h2>
        <p class="muted">{{ today()->format('Y-m-d') }} &middot; <a href="{{ route('tasks.index') }}">View all active tasks</a></p>
    </div>
    @if ($tasks->isEmpty())
        <div class="empty-state">
            <h3>No tasks for today</h3>
            <p class="muted">Check the Task List for your other plans.</p>
        </div>
    @else
        <div class="table-scroll" role="region" aria-label="Today's tasks" tabindex="0">
            <table>
                <thead>
                    <tr><th scope="col">ID</th><th scope="col">Title</th><th scope="col">Status</th><th scope="col">Task Date</th></tr>
                </thead>
                <tbody>
                    @foreach ($tasks as $task)
                        <tr>
                            <td class="muted">#{{ $task->id }}</td>
                            <td class="task-title">{{ $task->title }}</td>
                            <td><span class="badge {{ $task->status === 'done' ? 'badge-done' : 'badge-pending' }}">{{ ucfirst($task->status) }}</span></td>
                            <td class="date-cell">{{ $task->task_date }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
</section>
@endsection
