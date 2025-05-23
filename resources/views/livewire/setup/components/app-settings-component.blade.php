    <form wire:submit.prevent="save_general" class="mb-6 space-y-6" x-init="window.addEventListener('app-name-updated', event => {
        if (event.detail[0])
            document.title = event.detail[0];
    });">

        <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
            <h2 class="py-4 text-lg font-medium text-gray-900 dark:text-gray-100">
                {{ __('Általános beállítások') }}
            </h2>

            <div class="max-w-xl">
                <x-input-label for="app_name" :value="__('Alkalmazás neve')" />
                <x-text-input placeholder="Alkalmazás neve" wire:model.live="app_name" id="app_name" name="app_name"
                    type="text" class="mt-1 block w-full" />
                @error('app_name')
                    <x-input-error :messages="$message" class="mt-2" />
                @enderror
            </div>

            <div class="max-w-xl py-2">
                <x-input-label for="app_name" :value="__('Logó')" />
                @if ($logo?->isPreviewable())
                    <img src="{{ $logo->temporaryUrl() }}">
                @else
                    @if (config('app.logo_name') != null)
                        <x-application-logo-lg class="block h-9 w-auto text-gray-800 dark:text-gray-200" />
                    @endif
                @endif
                <x-text-input wire:model="logo" id="logo" name="logo" type="file"
                    class="mt-1 block w-full" />
                @error('logo')
                    <x-input-error :messages="$message" class="mt-2" />
                @enderror
            </div>
            @error('save_general_error')
                <x-input-error :messages="$message" class="mt-2" />
            @enderror
            <div class="flex items-center gap-4">
                <x-primary-button>{{ __('Mentés') }}</x-primary-button>

                <x-action-message-success class="me-3" on="save_general_success">
                    {{ __('Sikeres mentés') }}
                </x-action-message-success>

                <x-action-message wire:loading class="me-3" on="save_general">
                    {{ __('Betöltés') }}
                </x-action-message>
            </div>
        </div>
    </form>
