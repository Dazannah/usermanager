<div>
    <header>
      <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
          {{ __('Alap beállítások') }}
      </h2>
  
      <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
          {{ __('Ezek a beállítások később módosíthatóak az .env file-ban.') }}
      </p>
      <div>
        @if (session()->has('message'))
            <div class="alert alert-success">
                {{ session('message') }}
            </div>
        @endif
    </div>
  </header>
    <form wire:submit.prevent="save" class="mt-6 space-y-6">
      <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
        <div class="max-w-xl">
            <x-input-label for="app_name" :value="__('Alkalmazás neve')" />
            <x-text-input placeholder="Alkalmazás neve" wire:model.live="app_name" id="app_name" name="app_name" type="text" class="mt-1 block w-full" />
            @error('app_name') <x-input-error :messages="$message" class="mt-2" /> @enderror
{{-- 
            <x-input-label for="logo" :value="__('Logo')" />
            @if ($logo) 
              <img src="{{ $logo->temporaryUrl() }}">
            @endif
            <x-text-input wire:model="logo" id="logo" name="logo" type="file" class="mt-1 block w-full" />
            @error('logo') <x-input-error :messages="$message" class="mt-2" /> @enderror
            <x-action-message wire:loading class="me-3" on="password-updated">
              {{ __('Loading') }}
            </x-action-message> --}}
        </div>
      </div>

    <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
        {{ __('Technikai email fiók beállítása SMTP') }}
    </h2>
      <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
        <div class="max-w-xl">
            <x-input-label for="mail_host" :value="__('Email szerver címe')" />
            <x-text-input placeholder="Szerver címe" wire:model="mail_host" id="mail_host" name="mail_host" type="text" class="mt-1 block w-full" />
            @error('mail_host') <x-input-error :messages="$message" class="mt-2" /> @enderror
  
            <x-input-label for="mail_port" :value="__('SMTP Port')" />
            <x-text-input placeholder="465" wire:model="mail_port" id="mail_port" name="mail_port" type="number" class="mt-1 block w-full" />
            @error('mail_port') <x-input-error :messages="$message" class="mt-2" /> @enderror
  
            <x-input-label for="mail_username" :value="__('Email cím')" />
            <x-text-input placeholder="Email cím" wire:model="mail_username" id="mail_username" name="mail_username" type="email" class="mt-1 block w-full" />
            @error('mail_username') <x-input-error :messages="$message" class="mt-2" /> @enderror
  
            <x-input-label for="mail_password" :value="__('Jelszó')" />
            <x-text-input placeholder="Jelszó" wire:model="mail_password" id="mail_password" name="mail_password" type="password" class="mt-1 block w-full" />
            @error('mail_password') <x-input-error :messages="$message" class="mt-2" /> @enderror

            <x-input-label for="mail_test_address" :value="__('Teszt címzet')" />
            <x-text-input placeholder="Teszt címzet" wire:model="mail_test_address" id="mail_test_address" name="mail_test_address" type="text" class="mt-1 block w-full" />
            @error('mail_test_result_error') <x-input-error :messages="$message" class="mt-2" /> @enderror
            @if (session()->has('mail_test_result'))
                <div class="alert alert-success">
                    {{ session('mail_test_result') }}
                </div>
            @endif
            <x-primary-button wire:click.prevent="test_mail_connection_standalone">{{ __('Teszt email küldés') }}</x-primary-button>
            <x-action-message wire:loading class="me-3" on="test_mail_connection_standalone">
              {{ __('Loading') }}
            </x-action-message>
        </div>
      </div>

      <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
        {{ __('Adatbázis beállítások MYSQL') }}
    </h2>
    <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
      {{ __('Adatbázist előre létre kell hozni.') }}
  </p>
      <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
        <div class="max-w-xl">
            <x-input-label for="db_host" :value="__('Szerver címe')" />
            <x-text-input placeholder="Szerver címe" wire:model="db_host" id="db_host" name="db_host" type="text" class="mt-1 block w-full" />
            @error('db_host') <x-input-error :messages="$message" class="mt-2" /> @enderror
  
            <x-input-label for="db_port" :value="__('Port')" />
            <x-text-input placeholder="3306" wire:model="db_port" id="db_port" name="db_port" type="number" class="mt-1 block w-full" />
            @error('db_port') <x-input-error :messages="$message" class="mt-2" /> @enderror
  
            <x-input-label for="db_databasename" :value="__('Adatbázis név')" />
            <x-text-input placeholder="Adatbázis név" wire:model="db_databasename" id="db_databasename" name="db_databasename" type="text" class="mt-1 block w-full" />
            @error('db_databasename') <x-input-error :messages="$message" class="mt-2" /> @enderror
  
            <x-input-label for="db_username" :value="__('Felhasználó név')" />
            <x-text-input placeholder="Felhasználó név" wire:model="db_username" id="db_username" name="db_username" type="text" class="mt-1 block w-full" />
            @error('db_username') <x-input-error :messages="$message" class="mt-2" /> @enderror
  
            <x-input-label for="db_password" :value="__('Jelszó')" />
            <x-text-input placeholder="Jelszó" wire:model="db_password" id="db_password" name="db_password" type="password" class="mt-1 block w-full" />
            @error('db_password') <x-input-error :messages="$message" class="mt-2" /> @enderror
            @error('db_test_result_error') <x-input-error :messages="$message" class="mt-2" /> @enderror
            @if (session()->has('db_test_result'))
                <div class="alert alert-success">
                    {{ session('db_test_result') }}
                </div>
            @endif
            <x-primary-button wire:click.prevent="test_database_connection_standalone">{{ __('Kapcsolat tesztelése') }}</x-primary-button>
            <x-action-message wire:loading class="me-3" on="test_database_connection_standalone">
              {{ __('Loading') }}
            </x-action-message>
        </div>
      </div>
        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
          {{ __('Alapértelmezett rendszergazda fiók') }}
      </h2>
        <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
          <div class="max-w-xl">
            <x-input-label for="admin_name" :value="__('Név')" />
            <x-text-input placeholder="Név" wire:model="admin_name" id="admin_name" name="admin_name" type="text" class="mt-1 block w-full" />
            @error('admin_name') <x-input-error :messages="$message" class="mt-2" /> @enderror

              <x-input-label for="admin_username" :value="__('Felhasználónév')" />
              <x-text-input placeholder="Felhasználónév" wire:model="admin_username" id="admin_username" name="admin_username" type="text" class="mt-1 block w-full" />
              @error('admin_username') <x-input-error :messages="$message" class="mt-2" /> @enderror

              <x-input-label for="admin_email" :value="__('Email cím')" />
              <x-text-input placeholder="Email cím" wire:model="admin_email" id="admin_email" name="admin_email" type="text" class="mt-1 block w-full" />
              @error('admin_email') <x-input-error :messages="$message" class="mt-2" /> @enderror

              <x-input-label for="password" :value="__('Jelszó')" />
              <x-text-input placeholder="Jelszó" wire:model="password" id="password" name="password" type="password" class="mt-1 block w-full" />
              @error('password') <x-input-error :messages="$message" class="mt-2" /> @enderror

              <x-input-label for="password_confirmation" :value="__('Jelszó megerősítése')" />
              <x-text-input placeholder="Jelszó megerősítése" wire:model="password_confirmation" id="password_confirmation" name="password_confirmation" type="password" class="mt-1 block w-full" />
              @error('password_confirmation') <x-input-error :messages="$message" class="mt-2" /> @enderror
          </div>
        </div>

        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
            {{'LDAP autentikáció'}}
            <x-text-input wire:model="ldap_active" type="checkbox" class="m-1 p-1" :checked="$ldap_active"/>
        </h2>

        <div wire:show="ldap_active" wire:key="ldap-fields" class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
          <div class="max-w-xl">
            <x-input-label for="ldap_host" :value="__('Szerver címe')" />
            <x-text-input placeholder="Szerver címe" wire:model="ldap_host" id="ldap_host" name="ldap_host" type="text" class="mt-1 block w-full" />
            @error('ldap_host') <x-input-error :messages="$message" class="mt-2" /> @enderror

            <x-input-label for="ldap_port" :value="__('Port')" />
            <x-text-input placeholder="389" wire:model="ldap_port" id="ldap_port" name="ldap_port" type="text" class="mt-1 block w-full" />
            @error('ldap_port') <x-input-error :messages="$message" class="mt-2" /> @enderror
            
            <x-input-label for="ldap_base_dn" :value="__('Base DN')" />
            <x-text-input placeholder="dc=local,dc=com" wire:model="ldap_base_dn" id="ldap_base_dn" name="ldap_base_dn" type="text" class="mt-1 block w-full" />
            @error('ldap_base_dn') <x-input-error :messages="$message" class="mt-2" /> @enderror

            <x-input-label for="ldap_username" :value="__('Felhasználónév')" />
            <x-text-input placeholder="Felhasználónév" wire:model="ldap_username" id="ldap_username" name="ldap_username" type="text" class="mt-1 block w-full" />
            @error('ldap_username') <x-input-error :messages="$message" class="mt-2" /> @enderror

            <x-input-label for="ldap_password" :value="__('Jelszó')" />
            <x-text-input placeholder="Jelszó" wire:model="ldap_password" id="ldap_password" name="ldap_password" type="password" class="mt-1 block w-full" />
            @error('ldap_password') <x-input-error :messages="$message" class="mt-2" /> @enderror

              @error('ldap_test_result_error') <x-input-error :messages="$message" class="mt-2" /> @enderror
              @if (session()->has('ldap_test_result'))
                  <div class="alert alert-success">
                      {{ session('ldap_test_result') }}
                  </div>
              @endif
              <x-primary-button wire:click.prevent="test_ldap_connection_standalone">{{ __('LDAP tesztelése') }}</x-primary-button>
              <x-action-message wire:loading class="me-3" on="test_ldap_connection_standalone">
                {{ __('Loading') }}
              </x-action-message>
          </div>
        </div>

      <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
          {{ __('ISPConfig SOAP api') }}
          <x-text-input wire:model="ispfonfig_active" type="checkbox" class="m-1 p-1" :checked="$ispfonfig_active"/>
      </h2>
      <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
          {{ __('Az ISPConfig SOAP api, a terjesztési listák létrehozása, szerkesztéséhez kell, amennyiben használja a szervezet az ISPConfig-ot') }}
      </p>
        <div wire:show="ispfonfig_active" wire:key="ispconfig-fields" class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
          <div class="max-w-xl">
            <x-input-label for="ispconfig_soap_uri" :value="__('ISPConfig szerver címe')" />
            <x-text-input placeholder="localhost" wire:model="ispconfig_soap_uri" id="ispconfig_soap_uri" name="ispconfig_soap_uri" type="text" class="mt-1 block w-full" />
            @error('ispconfig_soap_uri') <x-input-error :messages="$message" class="mt-2" /> @enderror

            <x-input-label for="ispconfig_soap_location" :value="__('ISPConfig soap helye')" />
            <x-text-input placeholder="https://localhost:8080/remote/index.php" wire:model="ispconfig_soap_location" id="ispconfig_soap_location" name="ispconfig_soap_location" type="text" class="mt-1 block w-full" />
            @error('ispconfig_soap_location') <x-input-error :messages="$message" class="mt-2" /> @enderror

            <x-input-label for="ispconfig_soap_remote_username" :value="__('Felhasználónév')" />
            <x-text-input placeholder="Felhasználónév" wire:model="ispconfig_soap_remote_username" id="ispconfig_soap_remote_username" name="ispconfig_soap_remote_username" type="text" class="mt-1 block w-full" />
            @error('ispconfig_soap_remote_username') <x-input-error :messages="$message" class="mt-2" /> @enderror

            <x-input-label for="ispconfig_soap_remote_user_password" :value="__('Jelszó')" />
            <x-text-input placeholder="Jelszó" wire:model="ispconfig_soap_remote_user_password" id="ispconfig_soap_remote_user_password" name="ispconfig_soap_remote_user_password" type="password" class="mt-1 block w-full" />
            @error('ispconfig_soap_remote_user_password') <x-input-error :messages="$message" class="mt-2" /> @enderror

              @error('ispconfig_test_result_error') <x-input-error :messages="$message" class="mt-2" /> @enderror
              @if (session()->has('ispconfig_test_result'))
                  <div class="alert alert-success">
                      {{ session('ispconfig_test_result') }}
                  </div>
              @endif
              <x-primary-button wire:click.prevent="test_ispconfig_connection_standalone">{{ __('ISPConfig kapcsolat tesztelése') }}</x-primary-button>
              <x-action-message wire:loading class="me-3" on="test_ispconfig_connection_standalone">
                {{ __('Loading') }}
              </x-action-message>
          </div>
        </div>
        @error('save_error') <x-input-error :messages="$message" class="mt-2" /> @enderror
      <div class="flex items-center gap-4">
          <x-primary-button>{{ __('Mentés') }}</x-primary-button>

          <x-action-message wire:loading class="me-3" on="save">
            {{ __('Loading') }}
          </x-action-message>
      </div>
  </form>
  </div>
  