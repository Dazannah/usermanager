<div class="mb-6 p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
    <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
        {{ __('Technikai email fiók beállítása SMTP') }}
    </h2>
    <div class="max-w-xl">
        <x-input-label for="mail_host" :value="__('Email szerver címe')" />
        <x-text-input placeholder="Szerver címe" wire:model.live="mail_host" id="mail_host" name="mail_host" type="text"
            class="mt-1 block w-full" />
        @error('mail_host')
            <x-input-error :messages="$message" class="mt-2" />
        @enderror

        <x-input-label for="mail_port" :value="__('SMTP Port')" />
        <x-text-input placeholder="465" wire:model.live="mail_port" id="mail_port" name="mail_port" type="number"
            class="mt-1 block w-full" />
        @error('mail_port')
            <x-input-error :messages="$message" class="mt-2" />
        @enderror

        <x-input-label for="mail_username" :value="__('Email cím')" />
        <x-text-input placeholder="Email cím" wire:model.live="mail_username" id="mail_username" name="mail_username"
            type="email" class="mt-1 block w-full" />
        @error('mail_username')
            <x-input-error :messages="$message" class="mt-2" />
        @enderror

        <x-input-label for="mail_password" :value="__('Jelszó')" />
        <x-text-input placeholder="Jelszó" wire:model.live="mail_password" id="mail_password" name="mail_password"
            type="password" class="mt-1 block w-full" />
        @error('mail_password')
            <x-input-error :messages="$message" class="mt-2" />
        @enderror

        <x-input-label for="mail_test_address" :value="__('Teszt címzet')" />
        <x-text-input placeholder="Teszt címzet" wire:model.live="mail_test_address" id="mail_test_address"
            name="mail_test_address" type="email" class="mt-1 block w-full" />
        @error('mail_test_address')
            <x-input-error :messages="$message" class="mt-2" />
        @enderror
        @error('mail_test_result_error')
            <x-input-error :messages="$message" class="mt-2" />
        @enderror
        @if (session()->has('mail_test_result'))
            <div class="alert alert-success">
                {{ session('mail_test_result') }}
            </div>
        @endif

        @error('save_mail_error')
            <x-input-error :messages="$message" class="mt-2" />
        @enderror

        <div class="flex items-center gap-4">
            <x-primary-button
                wire:click.prevent="test_mail_connection_standalone">{{ __('Teszt email küldés') }}</x-primary-button>
            <x-primary-button wire:click.prevent="save_mail">{{ __('Mentés') }}</x-primary-button>
            <x-action-message wire:loading class="me-3" on="save_mail">
                {{ __('Betöltés') }}
            </x-action-message>
            <x-action-message-success class="me-3" on="save_mail_success">
                {{ __('Sikeres mentés') }}
            </x-action-message-success>
        </div>
    </div>
</div>
