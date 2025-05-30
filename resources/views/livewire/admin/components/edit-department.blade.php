<div x-data="{ show: false }" x-init="$watch('show_edit_department_field', value => {
    show = value
    if (value) $dispatch('edit_department_id', [edit_department_id])
});
$watch('show', value => show_edit_department_field = value);
window.addEventListener('edit_department_delete_success', () => {
    show = false
});">
    <x-modal :name="'Osztály szerkesztése'">
        <form wire:submit.prevent="save_edit_department">
            <div class="sm:flex sm:items-start">
                <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                    <h3 class="text-base font-semibold text-gray-500 dark:text-gray-400" id="modal-title">
                        Osztály szerkesztése
                    </h3>
                    <div class="mt-2">
                        <div class="grid grid-cols-4 gap-6">
                            <div class="relative z-0 w-full mb-5 group">
                                <x-text-input :property_name="'edit_department_displayName'" :type="'text'" />
                                <x-label :for="'edit_department_displayName'" :text="'Elnevezés'" />
                                @error('edit_department_displayName')
                                    <x-input-error :messages="$message" class="mt-2" />
                                @enderror
                            </div>

                            <div class="relative z-0 w-full mb-5 group">
                                <x-text-input :property_name="'edit_department_departmentNumber'" :type="'text'" />
                                <x-label :for="'edit_department_departmentNumber'" :text="texts_settings()->departmentNumber" />
                                @error('edit_department_departmentNumber')
                                    <x-input-error :messages="$message" class="mt-2" />
                                @enderror
                            </div>

                            <div class="relative z-0 w-full mb-5 group">
                                <x-text-input :property_name="'edit_department_departmentNumber2'" :type="'text'" />
                                <x-label :for="'edit_department_departmentNumber2'" :text="texts_settings()->departmentNumber2" />
                                @error('edit_department_departmentNumber2')
                                    <x-input-error :messages="$message" class="mt-2" />
                                @enderror
                            </div>

                            <div class="relative z-0 w-full mb-5 group">
                                <x-select :property_name="'edit_department_status_id'" :data="$this->statuses" />
                                <x-label :for="'edit_department_status_id'" :text="'Státusz'" />
                                @error('edit_department_status_id')
                                    <x-input-error :messages="$message" class="mt-2" />
                                @enderror
                            </div>

                            <div class="relative z-0 w-full mb-5 group">
                                <x-select :property_name="'edit_department_location_id'" :data="$this->locations" />
                                <x-label :for="'edit_department_location_id'" :text="'Helyszín'" />
                                @error('edit_department_location_id')
                                    <x-input-error :messages="$message" class="mt-2" />
                                @enderror
                            </div>


                            <div x-data="{ showConfirmDelete: false }" class="relative z-0 w-full mb-5 group">
                                <x-danger-button @click.prevent="showConfirmDelete = true">
                                    {{ __('Törlés') }}
                                </x-danger-button>
                                <div x-show="showConfirmDelete">
                                    <x-modal :name="'Helyszín törlése'">
                                        <div class="m-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                                            <h3 class="text-base font-semibold text-gray-500 dark:text-gray-400"
                                                id="modal-title">
                                                Biztosan törlöd?
                                            </h3>
                                            <x-success-button
                                                @click.prevent="showConfirmDelete = false">Mégse</x-success-button>
                                            <x-danger-button
                                                @click.prevent="$wire.delete_edit_department(); showConfirmDelete = false">Igen,
                                                törlöm</x-danger-button>
                                        </div>
                                    </x-modal>
                                </div>
                                @error('delete_edit_department')
                                    <x-input-error :messages="$message" class="mt-2" />
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="bg-gray-100 dark:bg-gray-600 px-4 py-3 sm:flex sm:flex-row-reverse sm:px-6 items-center">
                <x-danger-button @click.prevent="show_edit_department_field = !show_edit_department_field">
                    {{ __('Bezárás') }}
                </x-danger-button>

                <x-success-button wire:click.prevent="save_edit_department" class="me-3">
                    {{ __('Mentés') }}
                </x-success-button>

                <x-action-message wire:loading class="me-3" on="save_edit_department">
                    {{ __('Betöltés') }}
                </x-action-message>

                <x-action-message-success class="me-3" on="save_edit_department_success">
                    {{ __('Sikeres mentés') }}
                </x-action-message-success>

                <x-action-message-success class="me-3" on="edit_department_delete_success">
                    {{ __('Sikeres törlés') }}
                </x-action-message-success>

                @error('save_edit_department_error')
                    <div class="me-3">
                        <x-input-error :messages="$message" />
                    </div>
                @enderror
            </div>
        </form>
    </x-modal>
</div>
