@extends('layouts.main')

@section('title', 'Log in')

@section('content')
<h1>Welcome back</h1>
<p class="muted">Log in to manage today's tasks.</p>

@if (session('status'))
    <p class="alert" role="status">{{ session('status') }}</p>
@endif

<form method="POST" action="{{ route('login.store') }}">
    @csrf
    <p>
        <label for="email">Email address</label>
        <input id="email" name="email" type="email" maxlength="255" value="{{ old('email') }}" autocomplete="username" required autofocus @error('email') aria-invalid="true" aria-describedby="email-error" @enderror>
        @error('email') <span id="email-error" role="alert">{{ $message }}</span> @enderror
    </p>
    <p>
        <label for="password">Password</label>
        <input id="password" name="password" type="password" maxlength="255" autocomplete="current-password" required @error('password') aria-invalid="true" aria-describedby="password-error" @enderror>
        @error('password') <span id="password-error" role="alert">{{ $message }}</span> @enderror
    </p>
    <button type="submit">Log in</button>
    <a href="{{ route('register') }}">Create an account</a>
</form>
@endsection
