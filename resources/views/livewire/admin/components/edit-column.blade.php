<div x-data="{ show: false }" x-init="$watch('show_edit_column_field', value => {
    show = value
    if (value) $dispatch('edit_column_id', [edit_column_id])
});
$watch('show', value => show_edit_column_field = value);
window.addEventListener('edit_columns_delete_success', () => {
    show = false
});">
    <x-modal :name="'Jogosultság hozzáadás'">
        <form wire:submit.prevent="save_edit_column">
            <div class="sm:flex sm:items-start">
                <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                    <h3 class="text-base font-semibold text-gray-500 dark:text-gray-400" id="modal-title">
                        Oszlop hozzáadás
                    </h3>
                    <div class="mt-2">
                        <div class="grid grid-cols-4 gap-6">
                            <div class="relative z-0 w-full mb-5 group">
                                <x-text-input :property_name="'edit_column_display_name'" :type="'text'" />
                                <x-label :for="'edit_column_display_name'" :text="'Elnevezés'" />
                                @error('edit_column_display_name')
                                    <x-input-error :messages="$message" class="mt-2" />
                                @enderror
                            </div>

                            <div class="relative z-0 w-full mb-5 group">
                                <x-select :property_name="'edit_column_status_id'" :data="$this->statuses" />
                                <x-label :for="'edit_column_status_id'" :text="'Státusz'" />
                                @error('edit_column_status_id')
                                    <x-input-error :messages="$message" class="mt-2" />
                                @enderror
                            </div>

                            <div class="relative z-0 w-full mb-5 group">
                                <x-select :wire_key="'edit_column_position' . $edit_column_position" :property_name="'edit_column_position'" :counter="true" :counter_max="$columns_number" />
                                <x-label :for="'edit_column_position'" :text="'Pozíció'" />
                                @error('edit_column_position')
                                    <x-input-error :messages="$message" class="mt-2" />
                                @enderror
                            </div>
                            <div x-data="{ showConfirmDelete: false }" class="relative z-0 w-full mb-5 group">
                                <x-danger-button @click.prevent="showConfirmDelete = true">
                                    {{ __('Törlés') }}
                                </x-danger-button>
                                <div x-show="showConfirmDelete">
                                    <x-modal :name="'Jogosultság hozzáadás'">
                                        <div class="m-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                                            <h3 class="text-base font-semibold text-gray-500 dark:text-gray-400"
                                                id="modal-title">
                                                Biztosan törlöd?
                                            </h3>
                                            <x-success-button
                                                @click.prevent="showConfirmDelete = false">Mégse</x-success-button>
                                            <x-danger-button
                                                @click.prevent="$wire.delete_edit_column(); showConfirmDelete = false">Igen,
                                                törlöm</x-danger-button>
                                        </div>
                                    </x-modal>
                                </div>
                                @error('delete_edit_column')
                                    <x-input-error :messages="$message" class="mt-2" />
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="bg-gray-100 dark:bg-gray-600 px-4 py-3 sm:flex sm:flex-row-reverse sm:px-6 items-center">
                <x-danger-button @click.prevent="show_edit_column_field = !show_edit_column_field">
                    {{ __('Bezárás') }}
                </x-danger-button>

                <x-success-button wire:click.prevent="save_edit_column" class="me-3">
                    {{ __('Mentés') }}
                </x-success-button>

                <x-action-message wire:loading class="me-3" on="save_edit_column">
                    {{ __('Betöltés') }}
                </x-action-message>

                <x-action-message-success class="me-3" on="edit_columns_save_success">
                    {{ __('Sikeres mentés') }}
                </x-action-message-success>

                <x-action-message-success class="me-3" on="edit_columns_delete_success">
                    {{ __('Sikeres törlés') }}
                </x-action-message-success>

                @error('save_edit_column_error')
                    <div class="me-3">
                        <x-input-error :messages="$message" />
                    </div>
                @enderror
            </div>
        </form>
    </x-modal>
</div>
