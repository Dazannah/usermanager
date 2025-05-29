<div x-data="{ show: false }" x-init="$watch('show_edit_authorization_field', value => {
    show = value
    if (value) $dispatch('edit_authorization_id', [edit_authorization_id])
});
$watch('show', value => show_edit_authorization_field = value);
window.addEventListener('edit_authorization_delete_success', () => {
    show = false
});">
    <x-modal :name="'Jogosultság szerkesztése'">
        <form wire:submit.prevent="save_authorization">
            <div class="sm:flex sm:items-start">
                <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                    <h3 class="text-base font-semibold text-gray-500 dark:text-gray-400" id="modal-title">
                        Jogosultság szerkesztése
                    </h3>
                    <div class="mt-2">
                        <div class="grid grid-cols-5 gap-6">
                            <div class="relative z-0 w-full mb-5 group">
                                <x-text-input :property_name="'edit_authorization_display_name'" :type="'text'" />
                                <x-label :for="'edit_authorization_display_name'" :text="'Elnevezés'" />
                                @error('edit_authorization_display_name')
                                    <x-input-error :messages="$message" class="mt-2" />
                                @enderror
                            </div>
                            <div class="relative z-0 w-full mb-5 group">
                                <x-select :property_name="'edit_authorization_column_id'" :select="true" :select_value="'Válassz egy oszlopot'" :data="$this->columns" />
                                <x-label :for="'edit_authorization_column_id'" :text="'Státusz'" />
                                @error('edit_authorization_column_id')
                                    <x-input-error :messages="$message" class="mt-2" />
                                @enderror
                            </div>
                            <div class="relative z-0 w-full mb-5 group">
                                <x-select :property_name="'edit_authorization_status_id'" :data="$this->statuses" />
                                <x-label :for="'edit_authorization_status_id'" :text="'Státusz'" />
                                @error('edit_authorization_status_id')
                                    <x-input-error :messages="$message" class="mt-2" />
                                @enderror
                            </div>
                            <div class="flex items-start mb-5">
                                <x-checkbox :property_name="'edit_authorization_is_ldap'" :text="'LDAP/AD integráció'" />
                                @error('edit_authorization_is_ldap')
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
                                                @click.prevent="$wire.delete_edit_authorization(); showConfirmDelete = false">Igen,
                                                törlöm</x-danger-button>
                                        </div>
                                    </x-modal>
                                </div>
                                @error('delete_edit_authorization')
                                    <x-input-error :messages="$message" class="mt-2" />
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="bg-gray-100 dark:bg-gray-600 px-4 py-3 sm:flex sm:flex-row-reverse sm:px-6 items-center">
                <x-danger-button
                    @click.prevent="show_edit_authorization_field = !show_edit_authorization_field">{{ __('Bezárás') }}
                </x-danger-button>

                <x-success-button wire:click.prevent="save_edit_authorization" class="me-3">
                    {{ __('Mentés') }}
                </x-success-button>

                <x-action-message wire:loading class="me-3" on="save_edit_authorization">
                    {{ __('Betöltés') }}
                </x-action-message>

                <x-action-message-success class="me-3" on="edit_authorization_save_success">
                    {{ __('Sikeres mentés') }}
                </x-action-message-success>

                <x-action-message-success class="me-3" on="edit_authorization_delete_success">
                    {{ __('Sikeres törlés') }}
                </x-action-message-success>

                @error('save_edit_authorization_error')
                    <div class="me-3">
                        <x-input-error :messages="$message" />
                    </div>
                @enderror
            </div>
        </form>
    </x-modal>
</div>
