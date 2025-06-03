<?php

use App\Livewire\Forms\LoginForm;
use Illuminate\Support\Facades\Session;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('layouts.guest')] class extends Component {
    public LoginForm $form;

    /**
     * Handle an incoming authentication request.
     */
    public function login(): void
    {
        $this->validate();

        $this->form->authenticate();

        Session::regenerate();

        $this->redirectIntended(default: route('dashboard', absolute: false), navigate: true);
    }
}; ?>

<div>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form wire:submit="login">
        <!-- Email Address -->
        <div class="relative z-0 w-full mb-5 group">
            <x-text-input :property_name="'form.email'" :type="'text'" required autofocus autocomplete="username" />
            <x-label :for="'form.email'" :text="'Felhasználónév'" />
            <x-input-error :messages="$errors->get('form.email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="relative z-0 w-full mb-5 group">
            <x-text-input :property_name="'form.password'" :type="'password'" autocomplete="current-password" />
            <x-label :for="'form.password'" :text="'Jelszó'" />

            <x-input-error :messages="$errors->get('form.password')" class="mt-2" />
        </div>

        <!-- Remember Me -->
        <div class="block mt-4">
            <x-checkbox :property_name="'form.remember'" :text="'Bejelentkezve maradok'" />
        </div>

        <div class="flex items-center justify-end mt-4">
            @if (Route::has('password.request'))
                <a class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800"
                    href="{{ route('password.request') }}" wire:navigate>
                    {{ __('Elfelejtett jelszó?') }}
                </a>
            @endif

            <x-primary-button class="ms-3">
                {{ __('Bejelentkezés') }}
            </x-primary-button>
        </div>
    </form>
</div>
