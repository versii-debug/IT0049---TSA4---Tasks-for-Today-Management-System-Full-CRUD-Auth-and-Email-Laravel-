@extends('layouts.main')

@section('title', 'Archived Task Details')

@section('content')
<div class="page-heading">
    <div>
        <h1>Archived Task Details</h1>
        <p class="muted">This task is archived and is available to view only.</p>
    </div>
    <a class="button" href="{{ route('tasks.archived') }}">Archived Tasks</a>
</div>

<section class="card">
    <div class="card-heading">
        <h2>{{ $task->title }}</h2>
        <p>ID: {{ $task->id }}</p>
        <p>Status: <span class="badge {{ $task->status === 'done' ? 'badge-done' : 'badge-pending' }}">{{ ucfirst($task->status) }}</span></p>
        <p>Task Date: {{ $task->task_date }}</p>
        <p>Created At: {{ $task->created_at?->format('Y-m-d H:i:s') }}</p>
        <p>Last Updated: {{ $task->updated_at?->format('Y-m-d H:i:s') }}</p>
        <p>Archived: Yes</p>
    </div>
</section>
@endsection
