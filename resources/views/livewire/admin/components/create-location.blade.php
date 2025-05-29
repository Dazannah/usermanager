<div x-data="{ show: false }" x-init="$watch('show_add_location_field', value => show = value);
$watch('show', value => show_add_location_field = value)">
    <x-modal :name="'Helyszín hozzáadás'">
        <form wire:submit.prevent="save_new_location">
            <div class="sm:flex sm:items-start">
                <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                    <h3 class="text-base font-semibold text-gray-500 dark:text-gray-400" id="modal-title">
                        Helyszín hozzáadás
                    </h3>
                    <div class="mt-2">
                        <div class="grid grid-cols-3 gap-6">
                            <div class="relative z-0 w-full mb-5 group">
                                <x-text-input :property_name="'create_location_displayName'" :type="'text'" />
                                <x-label :for="'create_location_displayName'" :text="'Elnevezés'" />
                                @error('create_location_displayName')
                                    <x-input-error :messages="$message" class="mt-2" />
                                @enderror
                            </div>
                            <div class="relative z-0 w-full mb-5 group">
                                <x-select :property_name="'create_location_status_id'" :data="$this->statuses" />
                                <x-label :for="'create_location_status_id'" :text="'Státusz'" />
                                @error('create_location_status_id')
                                    <x-input-error :messages="$message" class="mt-2" />
                                @enderror
                            </div>
                            <div class="relative z-0 w-full mb-5 group">
                                <x-text-input :property_name="'create_location_note'" :type="'text'" />
                                <x-label :for="'create_location_note'" :text="'Megjegyzés'" />
                                @error('create_location_note')
                                    <x-input-error :messages="$message" class="mt-2" />
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="bg-gray-100 dark:bg-gray-600 px-4 py-3 sm:flex sm:flex-row-reverse sm:px-6 items-center">
                <x-danger-button @click.prevent="show_add_location_field = !show_add_location_field">{{ __('Bezárás') }}
                </x-danger-button>

                <x-success-button wire:click.prevent="save_new_location" class="me-3">
                    {{ __('Mentés') }}
                </x-success-button>

                <x-action-message wire:loading class="me-3" on="save_new_location">
                    {{ __('Betöltés') }}
                </x-action-message>

                <x-action-message-success class="me-3" on="save_new_location_success">
                    {{ __('Sikeres mentés') }}
                </x-action-message-success>

                @error('save_new_location_error')
                    <div class="me-3">
                        <x-input-error :messages="$message" />
                    </div>
                @enderror
            </div>
        </form>
    </x-modal>
</div>
