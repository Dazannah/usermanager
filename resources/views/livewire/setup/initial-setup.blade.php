<div class="max-w-7xl mx-auto sm:px-6 lg:px-8 mt-6">
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
        <div class="max-w-xl">

            <div class="relative z-0 w-full mb-5 group">
                <x-text-input :property_name="'admin_name'" :type="'text'" />
                <x-label :for="'admin_name'" :text="'Név'" />
                @error('admin_name')
                    <x-input-error :messages="$message" class="mt-2" />
                @enderror
            </div>

            <div class="relative z-0 w-full mb-5 group">
                <x-text-input :property_name="'admin_username'" :type="'text'" />
                <x-label :for="'admin_username'" :text="'Felhasználónév'" />
                @error('admin_username')
                    <x-input-error :messages="$message" class="mt-2" />
                @enderror
            </div>

            <div class="relative z-0 w-full mb-5 group">
                <x-text-input :property_name="'admin_email'" :type="'email'" />
                <x-label :for="'admin_email'" :text="'Email cím'" />
                @error('admin_email')
                    <x-input-error :messages="$message" class="mt-2" />
                @enderror
            </div>

            <div class="relative z-0 w-full mb-5 group">
                <x-text-input :property_name="'password'" :type="'password'" />
                <x-label :for="'password'" :text="'Jelszó'" />
                @error('password')
                    <x-input-error :messages="$message" class="mt-2" />
                @enderror
            </div>

            <div class="relative z-0 w-full mb-5 group">
                <x-text-input :property_name="'password_confirmation'" :type="'password'" />
                <x-label :for="'password_confirmation'" :text="'Jelszó megerősítése'" />
                @error('password_confirmation')
                    <x-input-error :messages="$message" class="mt-2" />
                @enderror
            </div>
        </div>

        <div class="flex items-center gap-4">
            <x-primary-button wire:click.prevent="save_admin">{{ __('Mentés') }}</x-primary-button>
            @error('save_error')
                <x-input-error :messages="$message" class="mt-2" />
            @enderror
            <x-action-message-success class="me-3" on="save_admin_success">
                {{ __('Sikeres mentés') }}
            </x-action-message-success>
        </div>
    </form>
</div>
