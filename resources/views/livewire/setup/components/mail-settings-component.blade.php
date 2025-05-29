<div class="mb-6 p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
    <h2 class="mb-2 text-lg font-medium text-gray-900 dark:text-gray-100">
        {{ __('Technikai email fiók beállítása SMTP') }}
    </h2>
    <div class="max-w-xl">
        <div class="relative z-0 w-full mb-5 group">
            <x-text-input :property_name="'mail_host'" :type="'text'" />
            <x-label :for="'mail_host'" :text="'Email szerver címe'" />
            @error('mail_host')
                <x-input-error :messages="$message" class="mt-2" />
            @enderror
        </div>

        <div class="relative z-0 w-full mb-5 group">
            <x-text-input :property_name="'mail_port'" :type="'number'" />
            <x-label :for="'mail_port'" :text="'SMTP Port'" />
            @error('mail_port')
                <x-input-error :messages="$message" class="mt-2" />
            @enderror
        </div>

        <div class="relative z-0 w-full mb-5 group">
            <x-text-input :property_name="'mail_username'" :type="'email'" />
            <x-label :for="'mail_username'" :text="'Email cím'" />
            @error('mail_username')
                <x-input-error :messages="$message" class="mt-2" />
            @enderror
        </div>

        <div class="relative z-0 w-full mb-5 group">
            <x-text-input :property_name="'mail_password'" :type="'password'" />
            <x-label :for="'mail_password'" :text="'Jelszó'" />
            @error('mail_password')
                <x-input-error :messages="$message" class="mt-2" />
            @enderror
        </div>

        <div class="relative z-0 w-full mb-5 group">
            <x-text-input :property_name="'mail_test_address'" :type="'email'" />
            <x-label :for="'mail_test_address'" :text="'Teszt címzet'" />
            @error('mail_test_address')
                <x-input-error :messages="$message" class="mt-2" />
            @enderror
        </div>

        @error('mail_test_result_error')
            <x-input-error :messages="$message" class="mt-2" />
        @enderror

        <x-session-message :session_variable="'mail_test_result'" />

        @error('save_mail_error')
            <x-input-error :messages="$message" class="mt-2" />
        @enderror

        <div class="flex items-center gap-4">
            <x-primary-button
                wire:click.prevent="test_mail_connection_standalone">{{ __('Teszt email küldés') }}</x-primary-button>

            <x-action-message wire:loading class="me-3" on="save_mail">
                {{ __('Betöltés') }}
            </x-action-message>

        </div>
    </div>
    <div class="flex items-center gap-4">
        <x-primary-button wire:click.prevent="save_mail">{{ __('Mentés') }}</x-primary-button>
        <x-action-message-success class="me-3" on="save_mail_success">
            {{ __('Sikeres mentés') }}
        </x-action-message-success>
    </div>
</div>
