<div class="max-w-7xl mx-auto sm:px-6 lg:px-8 mt-6">
    <header>
        <x-slot name="header">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Beállítások') }}
            </h2>
        </x-slot>
        <header>
            <div>
                @if (session()->has('message'))
                    <div class="alert alert-success">
                        {{ session('message') }}
                    </div>
                @endif
            </div>
        </header>
        <form wire:submit.prevent="save" class="mt-6 space-y-6">



            <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                {{ __('Adatbázis beállítások MYSQL') }}
            </h2>
            <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                {{ __('Adatbázist előre létre kell hozni.') }}
            </p>
            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <div class="max-w-xl">
                    <x-input-label for="db_host" :value="__('Szerver címe')" />
                    <x-text-input placeholder="Szerver címe" wire:model.live="db_host" id="db_host" name="db_host"
                        type="text" class="mt-1 block w-full" />
                    @error('db_host')
                        <x-input-error :messages="$message" class="mt-2" />
                    @enderror

                    <x-input-label for="db_port" :value="__('Port')" />
                    <x-text-input placeholder="3306" wire:model.live="db_port" id="db_port" name="db_port"
                        type="number" class="mt-1 block w-full" />
                    @error('db_port')
                        <x-input-error :messages="$message" class="mt-2" />
                    @enderror

                    <x-input-label for="db_databasename" :value="__('Adatbázis név')" />
                    <x-text-input placeholder="Adatbázis név" wire:model.live="db_databasename" id="db_databasename"
                        name="db_databasename" type="text" class="mt-1 block w-full" />
                    @error('db_databasename')
                        <x-input-error :messages="$message" class="mt-2" />
                    @enderror

                    <x-input-label for="db_username" :value="__('Felhasználó név')" />
                    <x-text-input placeholder="Felhasználó név" wire:model.live="db_username" id="db_username"
                        name="db_username" type="text" class="mt-1 block w-full" />
                    @error('db_username')
                        <x-input-error :messages="$message" class="mt-2" />
                    @enderror

                    <x-input-label for="db_password" :value="__('Jelszó')" />
                    <x-text-input placeholder="Jelszó" wire:model.live="db_password" id="db_password" name="db_password"
                        type="password" class="mt-1 block w-full" />
                    @error('db_password')
                        <x-input-error :messages="$message" class="mt-2" />
                    @enderror
                    @error('db_test_result_error')
                        <x-input-error :messages="$message" class="mt-2" />
                    @enderror
                    @if (session()->has('db_test_result'))
                        <div class="alert alert-success">
                            {{ session('db_test_result') }}
                        </div>
                    @endif
                    <x-primary-button
                        wire:click.prevent="test_database_connection_standalone">{{ __('Kapcsolat tesztelése') }}</x-primary-button>
                    <x-action-message wire:loading class="me-3" on="test_database_connection_standalone">
                        {{ __('Betöltés') }}
                    </x-action-message>
                </div>
            </div>
            @if (!config('app.installed'))
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
            @endif

            <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                {{ __('ISPConfig SOAP api') }}
                <x-text-input wire:model="ispfonfig_active" type="checkbox" class="m-1 p-1" :checked="$ispfonfig_active" />
            </h2>
            <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                {{ __('Az ISPConfig SOAP api, a terjesztési listák létrehozása, szerkesztéséhez kell, amennyiben használja a szervezet az ISPConfig-ot') }}
            </p>
            <div wire:show="ispfonfig_active" wire:key="ispconfig-fields"
                class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <div class="max-w-xl">
                    <x-input-label for="ispconfig_soap_uri" :value="__('ISPConfig szerver címe')" />
                    <x-text-input placeholder="localhost" wire:model.live="ispconfig_soap_uri"
                        id="ispconfig_soap_uri" name="ispconfig_soap_uri" type="text"
                        class="mt-1 block w-full" />
                    @error('ispconfig_soap_uri')
                        <x-input-error :messages="$message" class="mt-2" />
                    @enderror

                    <x-input-label for="ispconfig_soap_location" :value="__('ISPConfig soap helye')" />
                    <x-text-input placeholder="https://localhost:8080/remote/index.php"
                        wire:model.live="ispconfig_soap_location" id="ispconfig_soap_location"
                        name="ispconfig_soap_location" type="text" class="mt-1 block w-full" />
                    @error('ispconfig_soap_location')
                        <x-input-error :messages="$message" class="mt-2" />
                    @enderror

                    <x-input-label for="ispconfig_soap_remote_username" :value="__('Felhasználónév')" />
                    <x-text-input placeholder="Felhasználónév" wire:model.live="ispconfig_soap_remote_username"
                        id="ispconfig_soap_remote_username" name="ispconfig_soap_remote_username" type="text"
                        class="mt-1 block w-full" />
                    @error('ispconfig_soap_remote_username')
                        <x-input-error :messages="$message" class="mt-2" />
                    @enderror

                    <x-input-label for="ispconfig_soap_remote_user_password" :value="__('Jelszó')" />
                    <x-text-input placeholder="Jelszó" wire:model.live="ispconfig_soap_remote_user_password"
                        id="ispconfig_soap_remote_user_password" name="ispconfig_soap_remote_user_password"
                        type="password" class="mt-1 block w-full" />
                    @error('ispconfig_soap_remote_user_password')
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
                    <x-primary-button
                        wire:click.prevent="test_ispconfig_connection_standalone">{{ __('ISPConfig kapcsolat tesztelése') }}</x-primary-button>
                    <x-action-message wire:loading class="me-3" on="test_ispconfig_connection_standalone">
                        {{ __('Betöltés') }}
                    </x-action-message>
                </div>
            </div>
            @error('save_error')
                <x-input-error :messages="$message" class="mt-2" />
            @enderror
            <div class="flex items-center gap-4">
                <x-primary-button>{{ __('Mentés') }}</x-primary-button>

                <x-action-message wire:loading class="me-3" on="save">
                    {{ __('Betöltés') }}
                </x-action-message>
            </div>
        </form>
</div>
