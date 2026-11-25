<?php

namespace App\Http\Requests\Auth;

use Illuminate\Auth\Events\Lockout;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class LoginRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'email' => ['required', 'string', 'email', 'max:255'],
            'password' => ['required', 'string', 'max:255'],
        ];
    }

    public function authenticate(): void
    {
        $key = 'login:'.hash('sha256', Str::lower($this->string('email')->toString()).'|'.$this->ip());

        if (RateLimiter::tooManyAttempts($key, 5)) {
            event(new Lockout($this));

            throw ValidationException::withMessages([
                'email' => 'Too many login attempts. Please try again in '.RateLimiter::availableIn($key).' seconds.',
            ]);
        }

        if (! Auth::attempt([
            'email' => Str::lower($this->string('email')->toString()),
            'password' => $this->input('password'),
        ])) {
            RateLimiter::hit($key, 60);

            throw ValidationException::withMessages([
                'email' => 'Invalid email or password.',
            ]);
        }

        RateLimiter::clear($key);
    }
}
