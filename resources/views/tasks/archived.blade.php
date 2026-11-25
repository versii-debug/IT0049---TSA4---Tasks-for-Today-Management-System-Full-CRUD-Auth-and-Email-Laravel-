@extends('layouts.main')

@section('title', 'Archived Tasks')

@section('content')
<div class="page-heading">
    <div>
        <h1>Archived Tasks</h1>
        <p class="muted">Archived tasks remain saved and can be viewed here.</p>
    </div>
    <a class="button" href="{{ route('tasks.index') }}">Active Tasks</a>
</div>

<section class="card" aria-labelledby="archived-tasks-heading">
    <div class="card-heading">
        <h2 id="archived-tasks-heading">Archived Tasks <span class="count">{{ $tasks->count() }}</span></h2>
        <p class="muted">Ordered by task date. Select a title to view the task details.</p>
    </div>
    @if ($tasks->isEmpty())
        <div class="empty-state">
            <h3>No archived tasks</h3>
            <p class="muted">Tasks you archive will appear here.</p>
        </div>
    @else
        <div class="table-scroll" role="region" aria-label="Archived task list" tabindex="0">
            <table>
                <thead>
                    <tr>
                        <th scope="col">ID</th>
                        <th scope="col">Title</th>
                        <th scope="col">Status</th>
                        <th scope="col">Task Date</th>
                        <th scope="col">Created At</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($tasks as $task)
                        <tr>
                            <td class="muted">#{{ $task->id }}</td>
                            <td class="task-title"><a href="{{ route('tasks.archived.show', $task->id) }}">{{ $task->title }}</a></td>
                            <td><span class="badge {{ $task->status === 'done' ? 'badge-done' : 'badge-pending' }}">{{ ucfirst($task->status) }}</span></td>
                            <td class="date-cell">{{ $task->task_date }}</td>
                            <td class="date-cell muted">{{ $task->created_at?->format('Y-m-d H:i:s') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
</section>
@endsection
