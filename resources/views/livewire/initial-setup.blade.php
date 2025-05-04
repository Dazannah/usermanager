<div>
    <header>
      <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
          {{ __('Alap beállítások') }}
      </h2>
  
      <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
          {{ __('Ezek a beállítások később módosíthatóak az .env file-ban.') }}
      </p>
  </header>
    <form wire:submit.prevent="save" class="mt-6 space-y-6">
      <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
        <div class="max-w-xl">
            <x-input-label for="app_name" :value="__('Alkalmazás neve')" />
            <x-text-input wire:model.live="app_name" id="app_name" name="app_name" type="text" class="mt-1 block w-full" />
            <x-input-error :messages="$errors->get('app_name')" class="mt-2" />
        </div>
      </div>
      <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
        {{ __('Adatbázis beállítások (mysql)') }}
    </h2>
    <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
      {{ __('Ezek a beállítások később módosíthatóak az .env file-ban.') }}
  </p>
      <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
        <div class="max-w-xl">
            <x-input-label for="db_host" :value="__('Szerver címe')" />
            <x-text-input wire:model="db_host" id="db_host" name="db_host" type="text" class="mt-1 block w-full" />
            <x-input-error :messages="$errors->get('db_host')" class="mt-2" />
  
            <x-input-label for="db_port" :value="__('Port')" />
            <x-text-input wire:model="db_port" id="db_port" name="db_port" type="number" class="mt-1 block w-full" />
            <x-input-error :messages="$errors->get('db_port')" class="mt-2" />
  
            <x-input-label for="db_databasename" :value="__('Adatbázis név')" />
            <x-text-input wire:model="db_databasename" id="db_databasename" name="db_databasename" type="text" class="mt-1 block w-full" />
            <x-input-error :messages="$errors->get('db_databasename')" class="mt-2" />
  
            <x-input-label for="db_username" :value="__('Felhasználó név')" />
            <x-text-input wire:model="db_username" id="db_username" name="db_username" type="text" class="mt-1 block w-full" />
            <x-input-error :messages="$errors->get('db_username')" class="mt-2" />
  
            <x-input-label for="db_password" :value="__('Jelszó')" />
            <x-text-input wire:model="db_password" id="db_password" name="db_password" type="password" class="mt-1 block w-full" />
            <x-input-error :messages="$errors->get('db_password')" class="mt-2" />
        </div>
      </div>
      <div class="flex items-center gap-4">
          <x-primary-button>{{ __('Mentés') }}</x-primary-button>
  
  
          <x-action-message class="me-3" on="saved">
              {{ __('Mentés sikeres.') }}
          </x-action-message>
      </div>
  </form>
  </div>
  