@extends('layouts.main')

@section('title', 'Task List')

@section('content')
<div class="page-heading">
    <div>
        <h1>Task List</h1>
        <p class="muted">Keep your tasks organized, one day at a time.</p>
    </div>
    <a class="button" href="{{ route('tasks.create') }}"><span aria-hidden="true">+</span> Add Task</a>
</div>

@if (session('success'))
    <p class="alert" role="status">{{ session('success') }}</p>
@endif

<section class="card" aria-labelledby="all-tasks-heading">
    <div class="card-heading">
        <h2 id="all-tasks-heading">All Tasks <span class="count">{{ $tasks->count() }}</span></h2>
        <p class="muted">Your active tasks, ordered by date. Edit a task or archive it when you are ready.</p>
    </div>
@if ($tasks->isEmpty())
    <div class="empty-state">
        <h3>No tasks yet</h3>
        <p class="muted">Add your first task to get started.</p>
        <a href="{{ route('tasks.create') }}">Create a task &rarr;</a>
    </div>
@else
    <div class="table-scroll" role="region" aria-label="Task list" tabindex="0">
    <table>
        <thead>
        <tr>
            <th scope="col">ID</th>
            <th scope="col">Title</th>
            <th scope="col">Status</th>
            <th scope="col">Task Date</th>
            <th scope="col">Created At</th>
            <th scope="col">Actions</th>
        </tr>
        </thead>
        <tbody>
        @foreach ($tasks as $task)
            <tr>
                <td class="muted">#{{ $task->id }}</td>
                <td class="task-title">{{ $task->title }}</td>
                <td><span class="badge {{ $task->status === 'done' ? 'badge-done' : 'badge-pending' }}">{{ ucfirst($task->status) }}</span></td>
                <td class="date-cell">{{ $task->task_date }}</td>
                <td class="date-cell muted">{{ $task->created_at->format('Y-m-d H:i:s') }}</td>
                <td>
                    <div class="task-actions">
                    <a href="{{ route('tasks.edit', $task->id) }}">Edit</a>
                    <form method="POST" action="{{ route('tasks.archive', $task->id) }}">
                        @csrf
                        @method('PATCH')
                        <button class="archive-button" type="submit">Archive</button>
                    </form>
                    </div>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
    </div>
@endif
</section>
@endsection
