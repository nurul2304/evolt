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
    /**
     * Tentukan apakah user diizinkan membuat request ini.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Dapatkan aturan validasi yang berlaku untuk request.
     */
    public function rules(): array
    {
        return [
            // 'email' adalah nama input v-model dari form Vue
            'email' => ['required', 'string'], 
            'password' => ['required', 'string'],
        ];
    }

    /**
     * Coba autentikasi kredensial request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function authenticate(): void
    {
        $this->ensureIsNotRateLimited();

        // GANTI: Auth::attempt($this->only('email', 'password')...
        // MENJADI: Auth::attempt($this->getCredentials()...
        if (! Auth::attempt($this->getCredentials(), $this->boolean('remember'))) {
            RateLimiter::hit($this->throttleKey());

            throw ValidationException::withMessages([
                // Error tetap dilempar ke field 'email'
                'email' => trans('auth.failed'),
            ]);
        }

        RateLimiter::clear($this->throttleKey());
    }

    /**
     * [METODE BARU]
     * Menyiapkan kredensial untuk login (bisa email atau username).
     */
    public function getCredentials(): array
    {
        // Ambil input dari form (v-model="form.email")
        $loginInput = $this->input('email');

        // Cek apakah inputan adalah email atau username
        $fieldType = filter_var($loginInput, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';

        // Kembalikan array yang benar untuk dicoba oleh Auth::attempt()
        return [
            $fieldType => $loginInput,
            'password' => $this->input('password'),
        ];
    }

    /**
     * Pastikan request login tidak di-rate limit.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function ensureIsNotRateLimited(): void
    {
        if (! RateLimiter::tooManyAttempts($this->throttleKey(), 5)) {
            return;
        }

        event(new Lockout($this));

        $seconds = RateLimiter::availableIn($this->throttleKey());

        throw ValidationException::withMessages([
            'email' => trans('auth.throttle', [
                'seconds' => $seconds,
                'minutes' => ceil($seconds / 60),
            ]),
        ]);
    }

    /**
     * Dapatkan throttle key untuk request.
     */
    public function throttleKey(): string
    {
        // Kunci throttle berdasarkan input 'email' (yang bisa jadi username) dan IP
        return Str::transliterate(Str::lower($this->input('email')).'|'.$this->ip());
    }
}