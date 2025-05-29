<div class="max-w-7xl mx-auto sm:px-6 lg:px-8 mt-6">
    <header>
        <x-slot name="header">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Beállítások') }}
            </h2>
        </x-slot>
        <header>
            <x-session-message :session_variable="'message'" />
        </header>
        <form class="mt-6 space-y-6">
            <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                {{ __('Alapértelmezett rendszergazda fiók') }}
            </h2>
            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <div class="max-w-xl">
                    <x-input-label for="admin_name" :value="__('Név')" />
                    <x-text-input placeholder="Név" wire:model.live="admin_name" id="admin_name" name="admin_name"
                        type="text" class="mt-1 block w-full" />
                    @error('admin_name')
                        <x-input-error :messages="$message" class="mt-2" />
                    @enderror

                    <x-input-label for="admin_username" :value="__('Felhasználónév')" />
                    <x-text-input placeholder="Felhasználónév" wire:model.live="admin_username" id="admin_username"
                        name="admin_username" type="text" class="mt-1 block w-full" />
                    @error('admin_username')
                        <x-input-error :messages="$message" class="mt-2" />
                    @enderror

                    <x-input-label for="admin_email" :value="__('Email cím')" />
                    <x-text-input placeholder="Email cím" wire:model.live="admin_email" id="admin_email"
                        name="admin_email" type="email" class="mt-1 block w-full" />
                    @error('admin_email')
                        <x-input-error :messages="$message" class="mt-2" />
                    @enderror

                    <x-input-label for="password" :value="__('Jelszó')" />
                    <x-text-input placeholder="Jelszó" wire:model.live="password" id="password" name="password"
                        type="password" class="mt-1 block w-full" />
                    @error('password')
                        <x-input-error :messages="$message" class="mt-2" />
                    @enderror

                    <x-input-label for="password_confirmation" :value="__('Jelszó megerősítése')" />
                    <x-text-input placeholder="Jelszó megerősítése" wire:model.live="password_confirmation"
                        id="password_confirmation" name="password_confirmation" type="password"
                        class="mt-1 block w-full" />
                    @error('password_confirmation')
                        <x-input-error :messages="$message" class="mt-2" />
                    @enderror
                </div>
            </div>
            <div class="flex items-center gap-4">
                <x-primary-button wire:click.prevent="save_admin">{{ __('Mentés') }}</x-primary-button>
                <x-action-message-success class="me-3" on="save_admin_success">
                    {{ __('Sikeres mentés') }}
                </x-action-message-success>
            </div>
        </form>
</div>
