    <div class="mb-6 space-y-6 basis-1/2" x-init="window.addEventListener('app-updated', event => {
        location.reload()
    });">

        <div class="max-w-xl p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
            <h2 class="py-4 text-lg font-medium text-gray-900 dark:text-gray-100">
                {{ __('Általános beállítások') }}
            </h2>

            <div class="relative z-0 w-full mb-5 group">
                <x-text-input :property_name="'app_name'" :type="'text'" />
                <x-label :for="'app_name'" :text="'Alkalmazás neve'" />
                @error('app_name')
                    <x-input-error :messages="$message" class="mt-2" />
                @enderror
            </div>

            <div class="relative z-0 w-full mb-5 group">
                <x-input-label for="app_name" :value="__('Logó')" />
                @if ($logo?->isPreviewable())
                    <img src="{{ $logo->temporaryUrl() }}">
                @else
                    @if (app_settings()->logo_name != null)
                        <x-application-logo-lg class="block h-9 w-auto text-gray-800 dark:text-gray-200" />
                    @endif
                @endif
                <x-text-input class="mt-1 block w-full" :property_name="'logo'" :type="'file'" />
                <x-primary-button wire:click.prevent="delete_logo">{{ __('Logó törlése') }}</x-primary-button>
                @error('logo')
                    <x-input-error :messages="$message" class="mt-2" />
                @enderror
            </div>
            <h2 class="py-4 text-gray-900 dark:text-gray-100">
                {{ __('Színek megadása') }}
            </h2>

            <div class="relative z-0 w-full mb-5 group">
                <x-text-input :property_name="'primary_color'" :type="'text'" />
                <x-label :for="'primary_color'" :text="'Elsődleges szín'" />
                @error('primary_color')
                    <x-input-error :messages="$message" class="mt-2" />
                @enderror
            </div>

            <div class="relative z-0 w-full mb-5 group">
                <x-text-input :property_name="'secondary_color'" :type="'text'" />
                <x-label :for="'secondary_color'" :text="'Másodlagos szín'" />
                @error('secondary_color')
                    <x-input-error :messages="$message" class="mt-2" />
                @enderror
            </div>

            @error('save_general_error')
                <x-input-error :messages="$message" class="mt-2" />
            @enderror
            <div class="flex items-center gap-4">
                <x-primary-button wire:loading.remove
                    wire:click.prevent="save_general">{{ __('Mentés') }}</x-primary-button>

                <x-action-message wire:loading class="me-3" on="save_general">
                    <x-loading />
                </x-action-message>

                <x-action-message-success class="me-3" on="save_general_success">
                    {{ __('Sikeres mentés') }}
                </x-action-message-success>
            </div>
        </div>
    </div>
