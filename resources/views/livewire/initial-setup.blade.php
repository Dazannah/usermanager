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
        </div>
      </div>
      <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
        {{ __('Adatbázis beállítások (mysql)') }}
    </h2>
    <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
      {{ __('Adatbázist elörre létre kell hozni.') }}
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
            <x-action-message wire:loading class="me-3" on="password-updated">
              {{ __('Loading') }}
            </x-action-message>
        </div>
      </div>
        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
          {{ __('Alapértelmezett rendszergazda fiók') }}
      </h2>
        <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
          <div class="max-w-xl">
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
           {{ __('LDAP autentikáció') }} <input type="checkbox" wire:click="toggle_ldap_active" class="form-checkbox" />
      </h2>
      @if ($ldap_active === true)
        <div wire:key="ldap-fields" class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
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
              <x-action-message wire:loading class="me-3" on="password-updated">
                {{ __('Loading') }}
              </x-action-message>
          </div>
        </div>
        @endif
        @error('save_error') <x-input-error :messages="$message" class="mt-2" /> @enderror
      <div class="flex items-center gap-4">
          <x-primary-button>{{ __('Mentés') }}</x-primary-button>

          <x-action-message wire:loading class="me-3" on="password-updated">
            {{ __('Loading') }}
          </x-action-message>
      </div>
  </form>
  </div>
  