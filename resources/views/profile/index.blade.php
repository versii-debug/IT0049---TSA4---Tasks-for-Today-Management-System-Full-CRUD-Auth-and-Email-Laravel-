@extends('layouts.main')

@section('title', 'Profile')

@section('content')
<h1>Profile</h1>

@if ($user === null)
    <p class="muted">No user found.</p>
@else
    <section class="card">
        <div class="card-heading">
            <h2>{{ $user->name }}</h2>
            <p>ID: {{ $user->id }}</p>
            <p>Email: {{ $user->email }}</p>
            <p>Created At: {{ $user->created_at?->format('Y-m-d H:i:s') }}</p>
        </div>
    </section>
@endif
@endsection
