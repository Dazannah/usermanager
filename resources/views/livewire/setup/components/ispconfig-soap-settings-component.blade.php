<div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
    <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
        <label for="ispfonfig_active">ISPConfig SOAP api</label>
        <x-text-input id="ispfonfig_active" wire:model="ispfonfig_active" type="checkbox" class="m-1 p-1"
            :checked="$ispfonfig_active" />
    </h2>
    <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
        {{ __('Az ISPConfig SOAP api, a terjesztési listák létrehozása, szerkesztéséhez kell, amennyiben használja a szervezet az ISPConfig-ot') }}
    </p>
    <div wire:show="ispfonfig_active" wire:key="ispconfig-fields">
        <div class="max-w-xl">
            <x-input-label for="uri" :value="__('ISPConfig szerver URI')" />
            <x-text-input placeholder="localhost" wire:model.live="uri" id="uri" name="uri" type="text"
                class="mt-1 block w-full" />
            @error('uri')
                <x-input-error :messages="$message" class="mt-2" />
            @enderror

            <x-input-label for="location" :value="__('ISPConfig soap location')" />
            <x-text-input placeholder="https://localhost:8080/remote" wire:model.live="location" id="location"
                name="location" type="text" class="mt-1 block w-full" />
            @error('location')
                <x-input-error :messages="$message" class="mt-2" />
            @enderror

            <x-input-label for="username" :value="__('Felhasználónév')" />
            <x-text-input placeholder="Felhasználónév" wire:model.live="username" id="username" name="username"
                type="text" class="mt-1 block w-full" />
            @error('username')
                <x-input-error :messages="$message" class="mt-2" />
            @enderror

            <x-input-label for="password" :value="__('Jelszó')" />
            <x-text-input placeholder="Jelszó" wire:model.live="password" id="password" name="password" type="password"
                class="mt-1 block w-full" />
            @error('password')
                <x-input-error :messages="$message" class="mt-2" />
            @enderror

            @error('ispconfig_test_result_error')
                <x-input-error :messages="$message" class="mt-2" />
            @enderror

            @if (session()->has('ispconfig_test_result'))
                <div class="alert alert-success">
                    {{ session('ispconfig_test_result') }}
                </div>
            @endif
        </div>

        <div class="flex items-center gap-4">
            <x-primary-button
                wire:click.prevent="test_ispconfig_connection">{{ __('ISPConfig kapcsolat tesztelése') }}</x-primary-button>
            <x-primary-button wire:click.prevent="save_ispconfig">{{ __('Mentés') }}</x-primary-button>

            <x-action-message wire:loading class="me-3" on="test_ispconfig_connection">
                {{ __('Betöltés') }}
            </x-action-message>

            <x-action-message-success class="me-3" on="save_ispconfig_success">
                {{ __('Sikeres mentés') }}
            </x-action-message-success>
        </div>

    </div>
</div>
