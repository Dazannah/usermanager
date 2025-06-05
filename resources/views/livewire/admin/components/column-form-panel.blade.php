<div x-data="{ show: false, method_name: '', modal_title: '' }" x-init="$watch('show_update_column_field', value => {
    show = value
    method_name = 'update_column'
    modal_title = 'Oszlop szerkesztése'
    if (value) $dispatch('show_update_column', [update_column_id])
});
$watch('show_store_column_field', value => {
    show = value
    method_name = 'store_column'
    modal_title = 'Oszlop hozzáadás'
    if (value) $dispatch('show_store_column_field')
});
$watch('show', value => {
    if (!value) {
        show_update_column_field = value
        show_store_column_field = value
    }
});
window.addEventListener('delete_column_success', () => {
    show = false
});">
    <x-modal :name="'Jogosultság hozzáadás'">
        <form wire:submit.prevent="save_edit_column">
            <div class="sm:flex sm:items-start">
                <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                    <h3 class="text-base font-semibold text-gray-500 dark:text-gray-400" id="modal-title"
                        x-text="modal_title">
                    </h3>
                    <div class="mt-2">
                        <div class="grid grid-cols-4 gap-6">
                            <div class="relative z-0 w-full mb-5 group">
                                <x-text-input :property_name="'form.displayName'" :type="'text'" />
                                <x-label :for="'form.displayName'" :text="'Elnevezés'" />
                                @error('form.displayName')
                                    <x-input-error :messages="$message" class="mt-2" />
                                @enderror
                            </div>

                            <div class="relative z-0 w-full mb-5 group">
                                <x-select :property_name="'form.status_id'" :data="$this->statuses" />
                                <x-label :for="'form.status_id'" :text="'Státusz'" />
                                @error('form.status_id')
                                    <x-input-error :messages="$message" class="mt-2" />
                                @enderror
                            </div>

                            <div x-show="show_update_column_field" class="relative z-0 w-full mb-5 group">
                                <x-select :property_name="'form.position'" :counter="true" :counter_max="$columns_number" />
                                <x-label :for="'form.position'" :text="'Pozíció'" />
                                @error('form.position')
                                    <x-input-error :messages="$message" class="mt-2" />
                                @enderror
                            </div>
                            <div x-show="show_update_column_field" x-data="{ showConfirmDelete: false }"
                                class="relative z-0 w-full mb-5 group">
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
                                                @click.prevent="$wire.delete_column(); showConfirmDelete = false">Igen,
                                                törlöm</x-danger-button>
                                        </div>
                                    </x-modal>
                                </div>
                                @error('delete_column')
                                    <x-input-error :messages="$message" class="mt-2" />
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="bg-gray-100 dark:bg-gray-600 px-4 py-3 sm:flex sm:flex-row-reverse sm:px-6 items-center">
                <x-danger-button @click.prevent="show_update_column_field = false; show_store_column_field = false">
                    {{ __('Bezárás') }}
                </x-danger-button>

                <x-success-button @click.prevent="$wire[method_name]" class="me-3">
                    {{ __('Mentés') }}
                </x-success-button>

                <x-action-message wire:loading class="me-3" on="save_column">
                    {{ __('Betöltés') }}
                </x-action-message>

                <x-action-message-success class="me-3" on="save_column_success">
                    {{ __('Sikeres mentés') }}
                </x-action-message-success>

                <x-action-message-success class="me-3" on="delete_column_success">
                    {{ __('Sikeres törlés') }}
                </x-action-message-success>

                @error('save_column_error')
                    <div class="me-3">
                        <x-input-error :messages="$message" />
                    </div>
                @enderror
            </div>
        </form>
    </x-modal>
</div>
