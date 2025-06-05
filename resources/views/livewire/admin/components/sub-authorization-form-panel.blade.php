<div x-data="{ show: false, method_name: '', modal_title: '' }" x-init="$watch('show_update_sub_authorization_field', value => {
    show = value
    method_name = 'update_sub_authorization_item'
    modal_title = 'Aljogosultság szerkesztése'
    if (value) $dispatch('show_update_sub_authorization', [update_sub_authorization_id])
});
$watch('show_store_sub_authorization_field', value => {
    show = value
    method_name = 'store_sub_authorization_item'
    modal_title = 'Aljogosultság hozzáadás'
    if (value) $dispatch('show_create_sub_authorization')
});
$watch('show', value => {
    if (!value) {
        show_update_sub_authorization_field = value
        show_store_sub_authorization_field = value
    }
});
window.addEventListener('sub_authorization_delete_success', () => {
    show = false
});">
    <x-modal :name="'Jogosultság szerkesztése'">
        <form wire:submit.prevent="save_sub_authorization">
            <div class="sm:flex sm:items-start">
                <div class="mt-3 py-2 text-center sm:mt-0 sm:ml-4 sm:text-left">
                    <h3 class="text-base font-semibold text-gray-500 dark:text-gray-400" id="modal-title"
                        x-text="modal_title">
                    </h3>
                    <div class="mt-2">
                        <div class="grid grid-cols-3 gap-6">
                            <div class="relative z-0 w-full mb-5 group">
                                <x-text-input :property_name="'form.displayName'" :type="'text'" />
                                <x-label :for="'form.displayName'" :text="'Elnevezés'" />
                                @error('form.displayName')
                                    <x-input-error :messages="$message" class="mt-2" />
                                @enderror
                            </div>

                            <div class="relative z-0 w-full mb-5 group">
                                <x-select :property_name="'form.authItem_id'" :select="true" :select_value="'Válassz egy jogosultságot'" :data="$this->authorizations" />
                                <x-label :for="'form.authItem_id'" :text="'Jogosultság'" />
                                @error('form.authItem_id')
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
                            <div x-show="show_update_sub_authorization_field" class="relative z-0 w-full mb-5 group">
                                <x-select :wire_key="$form->id ?? 0" :property_name="'form.position'" :counter="true" :counter_max="$form->subAuthItems_number" />
                                <x-label :for="'form.position'" :text="'Pozíció'" />
                                @error('form.position')
                                    <x-input-error :messages="$message" class="mt-2" />
                                @enderror
                            </div>

                            <div x-show="show_update_sub_authorization_field" x-data="{ showConfirmDelete: false }"
                                class="relative z-0 w-full mb-5 group">
                                <x-danger-button @click.prevent="showConfirmDelete = true">
                                    {{ __('Törlés') }}
                                </x-danger-button>
                                <div x-show="showConfirmDelete">
                                    <x-modal :name="'Aljogosultság törlése'">
                                        <div class="m-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                                            <h3 class="text-base font-semibold text-gray-500 dark:text-gray-400"
                                                id="modal-title">
                                                Biztosan törlöd?
                                            </h3>
                                            <x-success-button
                                                @click.prevent="showConfirmDelete = false">Mégse</x-success-button>
                                            <x-danger-button
                                                @click.prevent="$wire.delete_sub_authorization(); showConfirmDelete = false">Igen,
                                                törlöm</x-danger-button>
                                        </div>
                                    </x-modal>
                                </div>
                                @error('delete_sub_authorization')
                                    <x-input-error :messages="$message" class="mt-2" />
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="bg-gray-100 dark:bg-gray-600 px-4 py-3 sm:flex sm:flex-row-reverse sm:px-6 items-center">
                <x-danger-button
                    @click.prevent="show_update_sub_authorization_field = false; show_store_sub_authorization_field = false">{{ __('Bezárás') }}
                </x-danger-button>

                <x-success-button @click.prevent="$wire[method_name]" class="me-3">
                    {{ __('Mentés') }}
                </x-success-button>

                <x-action-message wire:loading class="me-3" on="store_sub_authorization_item">
                    {{ __('Betöltés') }}
                </x-action-message>

                <x-action-message-success class="me-3" on="save_sub_authorization_success">
                    {{ __('Sikeres mentés') }}
                </x-action-message-success>

                <x-action-message-success class="me-3" on="sub_authorization_delete_success">
                    {{ __('Sikeres törlés') }}
                </x-action-message-success>

                @error('save_edit_sub_authorization_error')
                    <div class="me-3">
                        <x-input-error :messages="$message" />
                    </div>
                @enderror
            </div>
        </form>
    </x-modal>
</div>
