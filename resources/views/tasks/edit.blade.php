@extends('layouts.main')

@section('title', 'Edit Task')

@section('content')
<h2>Edit Task</h2>

<form method="POST" action="{{ route('tasks.update', $task->id) }}">
    @csrf
    @method('PUT')
    <p>
        <label for="title">Title</label><br>
        <input id="title" name="title" type="text" maxlength="150" value="{{ old('title', $task->title) }}" required>
        @error('title') <span>{{ $message }}</span> @enderror
    </p>
    <p>
        <label for="task_date">Date</label><br>
        <input id="task_date" name="task_date" type="date" value="{{ old('task_date', $task->task_date) }}" required>
        @error('task_date') <span>{{ $message }}</span> @enderror
    </p>
    <p>
        <label for="status">Status</label><br>
        <select id="status" name="status" required>
            <option value="pending" {{ old('status', $task->status) === 'pending' ? 'selected' : '' }}>pending</option>
            <option value="done" {{ old('status', $task->status) === 'done' ? 'selected' : '' }}>done</option>
        </select>
        @error('status') <span>{{ $message }}</span> @enderror
    </p>
    <button type="submit">Update Task</button>
    <a href="{{ route('tasks.index') }}">Cancel</a>
</form>
@endsection
