<div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
    <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
        <x-checkbox :property_name="'ispfonfig_active'" :text="'ISPConfig SOAP api'" />
    </h2>
    <p class="pb-4 mt-1 text-sm text-gray-600 dark:text-gray-400">
        {{ __('Az ISPConfig SOAP api, a terjesztési listák létrehozása, szerkesztéséhez kell, amennyiben használja a szervezet az ISPConfig-ot') }}
    </p>
    <div wire:show="ispfonfig_active" wire:key="ispconfig-fields">
        <div class="max-w-xl">
            <div class="relative z-0 w-full mb-5 group">
                <x-text-input :property_name="'uri'" :type="'text'" />
                <x-label :for="'uri'" :text="'ISPConfig szerver URI'" />
                @error('uri')
                    <x-input-error :messages="$message" class="mt-2" />
                @enderror
            </div>

            <div class="relative z-0 w-full mb-5 group">
                <x-text-input :property_name="'location'" :tooltip="'Példa: https://localhost:8080/remote'" :type="'text'" />
                <x-label :for="'location'" :text="'ISPConfig soap location'" />
                @error('location')
                    <x-input-error :messages="$message" class="mt-2" />
                @enderror
            </div>

            <div class="relative z-0 w-full mb-5 group">
                <x-text-input :property_name="'username'" :type="'text'" />
                <x-label :for="'username'" :text="'Felhasználónév'" />
                @error('username')
                    <x-input-error :messages="$message" class="mt-2" />
                @enderror
            </div>

            {{-- <x-input-label for="password" :value="__('Jelszó')" />
            <x-text-input placeholder="{{ $is_password_set ? 'Változatlan' : 'Jelszó' }}" wire:model.live="password"
                id="password" name="password" type="password" class="mt-1 block w-full" />
            @error('password')
                <x-input-error :messages="$message" class="mt-2" />
            @enderror --}}

            <div class="relative z-0 w-full mb-5 group">
                <x-text-input :property_name="'password'" :type="'password'" />
                <x-label :for="'password'" :text="'Jelszó'" />
                @error('password')
                    <x-input-error :messages="$message" class="mt-2" />
                @enderror
            </div>

            @error('ispconfig_test_result_error')
                <x-input-error :messages="$message" class="mt-2" />
            @enderror

            <x-session-message :session_variable="'ispconfig_test_result'" />
        </div>

        <div class="flex items-center gap-4">
            <x-primary-button
                wire:click.prevent="test_ispconfig_connection_standalone">{{ __('ISPConfig kapcsolat tesztelése') }}</x-primary-button>

            <x-action-message wire:loading class="me-3" on="test_ispconfig_connection_standalone">
                {{ __('Betöltés') }}
            </x-action-message>
        </div>
    </div>
    <div class="flex items-center gap-4">
        <x-primary-button wire:click.prevent="save_ispconfig">{{ __('Mentés') }}</x-primary-button>
        <x-action-message-success class="me-3" on="save_ispconfig_success">
            {{ __('Sikeres mentés') }}
        </x-action-message-success>
    </div>
</div>
