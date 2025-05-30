<div>
    <livewire:admin.setup-sub-navigation />

    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 mt-6">

        @error('error')
            <div class="py-4">
                <x-input-error :messages="$message" class="mt" />
            </div>
        @enderror
        <div class="mb-6 p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
            <h2 class="mb-2 pb-4 text-lg font-medium text-gray-900 dark:text-gray-100">
                {{ __('Szövegmező elnevezések') }}
            </h2>

            <div class="max-w-xl">
                <div class="relative z-0 w-full mb-5 group">
                    <x-text-input :property_name="'departmentNumber'" :type="'text'" />
                    <x-label :for="'departmentNumber'" :text="'departmentNumber'" />
                    @error('departmentNumber')
                        <x-input-error :messages="$message" class="mt-2" />
                    @enderror
                </div>

                <div class="relative z-0 w-full mb-5 group">
                    <x-text-input :property_name="'departmentNumber2'" :type="'text'" />
                    <x-label :for="'departmentNumber2'" :text="'departmentNumber2'" />
                    @error('departmentNumber2')
                        <x-input-error :messages="$message" class="mt-2" />
                    @enderror
                </div>

                <div class="flex items-center gap-4">

                    <x-action-message wire:loading class="me-3" on="save_mail">
                        {{ __('Betöltés') }}
                    </x-action-message>

                </div>
            </div>
            <div class="flex items-center gap-4">
                <x-primary-button wire:click.prevent="save_texts">{{ __('Mentés') }}</x-primary-button>
                <x-action-message-success class="me-3" on="save_texts_success">
                    {{ __('Sikeres mentés') }}
                </x-action-message-success>
            </div>


        </div>
    </div>
</div>
