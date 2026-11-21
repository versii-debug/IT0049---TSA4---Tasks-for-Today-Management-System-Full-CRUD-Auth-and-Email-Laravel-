@extends('layouts.main')

@section('title', 'Task List')

@section('content')
<h2>All Tasks</h2>

@if (session('success'))
    <p>{{ session('success') }}</p>
@endif

<p><a href="{{ route('tasks.create') }}">Add Task</a></p>

@if ($tasks->isEmpty())
    <p>No tasks found.</p>
@else
    <table border="1" cellpadding="5">
        <tr>
            <th>ID</th>
            <th>Title</th>
            <th>Status</th>
            <th>Date</th>
            <th>Created At</th>
            <th>Actions</th>
        </tr>
        @foreach ($tasks as $task)
            <tr>
                <td>{{ $task->id }}</td>
                <td>{{ $task->title }}</td>
                <td>{{ $task->status }}</td>
                <td>{{ $task->task_date }}</td>
                <td>{{ $task->created_at->format('Y-m-d H:i:s') }}</td>
                <td>
                    <a href="{{ route('tasks.edit', $task->id) }}">Edit</a>
                    <form method="POST" action="{{ route('tasks.archive', $task->id) }}">
                        @csrf
                        @method('PATCH')
                        <button type="submit">Archive</button>
                    </form>
                </td>
            </tr>
        @endforeach
    </table>
@endif
@endsection
