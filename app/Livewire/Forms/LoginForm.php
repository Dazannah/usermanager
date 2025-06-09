<?php

namespace App\Livewire\Forms;

use Livewire\Form;
use App\Models\User;
use Illuminate\Support\Str;
use Livewire\Attributes\Validate;
use Illuminate\Auth\Events\Lockout;
use Illuminate\Support\Facades\Auth;
use App\Services\AuthorizationLevelService;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Validation\ValidationException;

class LoginForm extends Form {
    #[Validate('required|string')]
    public string $email = '';

    #[Validate('required|string')]
    public string $password = '';

    #[Validate('boolean')]
    public bool $remember = false;

    /**
     * Attempt to authenticate the request's credentials.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function authenticate(): void {
        $this->ensureIsNotRateLimited();

        $credentials = [
            'samaccountname' => $this->email,
            'password' => $this->password,
            'fallback' => [
                'username' => $this->email,
                'password' => $this->password,
            ]
        ];

        $user = User::where('username', '=', $this->email)->first();

        if (isset($user)) {
            if ($user->status->name == 'inactive')
                throw ValidationException::withMessages([
                    'form.email' => "Felhasználó inaktiválva.",
                ]);

            $user_auth_level = AuthorizationLevelService::get_user_auth_level($user);

            if ($user_auth_level  <= 0)
                throw ValidationException::withMessages([
                    'form.email' => "Nem rendelkezik megfelelő jogosultsággal.",
                ]);
        }

        if (! Auth::attempt($credentials, $this->remember)) {
            RateLimiter::hit($this->throttleKey());

            throw ValidationException::withMessages([
                'form.email' => trans('auth.failed'),
            ]);
        }

        RateLimiter::clear($this->throttleKey());
    }

    /**
     * Ensure the authentication request is not rate limited.
     */
    protected function ensureIsNotRateLimited(): void {
        if (! RateLimiter::tooManyAttempts($this->throttleKey(), 5)) {
            return;
        }

        event(new Lockout(request()));

        $seconds = RateLimiter::availableIn($this->throttleKey());

        throw ValidationException::withMessages([
            'form.email' => trans('auth.throttle', [
                'seconds' => $seconds,
                'minutes' => ceil($seconds / 60),
            ]),
        ]);
    }

    /**
     * Get the authentication rate limiting throttle key.
     */
    protected function throttleKey(): string {
        return Str::transliterate(Str::lower($this->email) . '|' . request()->ip());
    }
}
