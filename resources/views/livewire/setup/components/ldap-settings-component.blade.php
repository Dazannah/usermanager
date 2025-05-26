<div class="mb-6 p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
    <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
        <label for="ldap_active">LDAP autentikáció</label>
        <x-text-input wire:model="ldap_active" id="ldap_active" name="ldap_active" type="checkbox" class="m-1 p-1"
            :checked="$ldap_active" />
    </h2>

    <div wire:show="ldap_active" wire:key="ldap-fields">
        <div class="max-w-xl">
            <x-input-label for="ldap_host" :value="__('Szerver címe')" />
            <x-text-input placeholder="Szerver címe" wire:model.live="ldap_host" id="ldap_host" name="ldap_host"
                type="text" class="mt-1 block w-full" />
            @error('ldap_host')
                <x-input-error :messages="$message" class="mt-2" />
            @enderror

            <x-input-label for="ldap_port" :value="__('Port')" />
            <x-text-input placeholder="389" wire:model.live="ldap_port" id="ldap_port" name="ldap_port" type="text"
                class="mt-1 block w-full" />
            @error('ldap_port')
                <x-input-error :messages="$message" class="mt-2" />
            @enderror

            <x-input-label for="ldap_base_dn" :value="__('Base DN')" />
            <x-text-input placeholder="dc=local,dc=com" wire:model.live="ldap_base_dn" id="ldap_base_dn"
                name="ldap_base_dn" type="text" class="mt-1 block w-full" />
            @error('ldap_base_dn')
                <x-input-error :messages="$message" class="mt-2" />
            @enderror

            <x-input-label for="ldap_username" :value="__('Felhasználónév')" />
            <x-text-input placeholder="Felhasználónév" wire:model.live="ldap_username" id="ldap_username"
                name="ldap_username" type="text" class="mt-1 block w-full" />
            @error('ldap_username')
                <x-input-error :messages="$message" class="mt-2" />
            @enderror

            <x-input-label for="ldap_password" :value="__('Jelszó')" />
            <x-text-input placeholder="{{ $is_password_set ? 'Változatlan' : 'Jelszó' }}"
                wire:model.live="ldap_password" id="ldap_password" name="ldap_password" type="password"
                class="mt-1 block w-full" />
            @error('ldap_password')
                <x-input-error :messages="$message" class="mt-2" />
            @enderror

            @error('ldap_test_result_error')
                <x-input-error :messages="$message" class="mt-2" />
            @enderror

            @if (session()->has('ldap_test_result'))
                <div class="alert alert-success">
                    {{ session('ldap_test_result') }}
                </div>
            @endif

            <div class="flex items-center gap-4">
                <x-primary-button
                    wire:click.prevent="test_ldap_connection_standalone">{{ __('LDAP tesztelése') }}</x-primary-button>


                <x-action-message wire:loading class="me-3" on="save_ldap">
                    {{ __('Betöltés') }}
                </x-action-message>
            </div>
        </div>
    </div>
    <div class="flex items-center gap-4">
        <x-primary-button wire:click.prevent="save_ldap">{{ __('Mentés') }}</x-primary-button>
        <x-action-message-success class="me-3" on="save_ldap_success">
            {{ __('Sikeres mentés') }}
        </x-action-message-success>
    </div>
</div>
