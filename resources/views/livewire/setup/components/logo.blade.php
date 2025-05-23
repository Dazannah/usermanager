    <form wire:submit.prevent="save_logo" class="mb-6 space-y-6">
        <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
            <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                {{ __('Logó') }}
            </h2>
            <div class="max-w-xl">
                @if ($logo?->isPreviewable())
                    <img src="{{ $logo->temporaryUrl() }}">
                @else
                    @if (config('app.logo_name') != null)
                        <x-application-logo-lg class="block h-9 w-auto text-gray-800 dark:text-gray-200" />
                    @endif
                @endif
                <x-text-input wire:model="logo" id="logo" name="logo" type="file" class="mt-1 block w-full" />
                @error('logo')
                    <x-input-error :messages="$message" class="mt-2" />
                @enderror
            </div>
            @error('save_logo_error')
                <x-input-error :messages="$message" class="mt-2" />
            @enderror
            <div class="flex items-center gap-4">
                <x-primary-button>{{ __('Logo Mentése') }}</x-primary-button>

                <x-action-message-success class="me-3" on="logo_save_success">
                    {{ __('Sikeres mentés') }}
                </x-action-message-success>

                <x-action-message wire:loading class="me-3" on="save">
                    {{ __('Betöltés') }}
                </x-action-message>
            </div>
        </div>
    </form>
