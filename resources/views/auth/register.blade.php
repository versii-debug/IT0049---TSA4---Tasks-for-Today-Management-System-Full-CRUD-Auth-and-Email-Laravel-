@extends('layouts.main')

@section('title', 'Create account')

@section('content')
<h1>Create your account</h1>
<p class="muted">Join your team and start managing tasks.</p>

<form method="POST" action="{{ route('register.store') }}">
    @csrf
    <p>
        <label for="name">Name</label>
        <input id="name" name="name" type="text" maxlength="255" value="{{ old('name') }}" autocomplete="name" required autofocus @error('name') aria-invalid="true" aria-describedby="name-error" @enderror>
        @error('name') <span id="name-error" role="alert">{{ $message }}</span> @enderror
    </p>
    <p>
        <label for="email">Email address</label>
        <input id="email" name="email" type="email" maxlength="255" value="{{ old('email') }}" autocomplete="username" required @error('email') aria-invalid="true" aria-describedby="email-error" @enderror>
        @error('email') <span id="email-error" role="alert">{{ $message }}</span> @enderror
    </p>
    <p>
        <label for="password">Password (at least 8 characters)</label>
        <input id="password" name="password" type="password" minlength="8" maxlength="255" autocomplete="new-password" required @error('password') aria-invalid="true" aria-describedby="password-error" @enderror>
        @error('password') <span id="password-error" role="alert">{{ $message }}</span> @enderror
    </p>
    <p>
        <label for="password_confirmation">Confirm password</label>
        <input id="password_confirmation" name="password_confirmation" type="password" minlength="8" maxlength="255" autocomplete="new-password" required>
    </p>
    <button type="submit">Create account</button>
    <a href="{{ route('login') }}">Already have an account? Log in</a>
</form>
@endsection
