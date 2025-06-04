<div x-data="{ show: false, method_name: '', modal_title: '' }"
    x-init= "$watch('show_edit_local_account_field', value => {
    show = value
    method_name = 'update_local_account'
    modal_title = 'Helyi fiók szerkesztése'

    if (value) $dispatch('edit_local_account_id', [edit_local_account_id])
});
$watch('show_add_local_account_field', value => {
    show = value
    method_name = 'create_local_account'
    modal_title = 'Helyi fiók hozzáadása'

    if (value) $dispatch('show_add_local_account')
});
$watch('show', value => {
    if(!value){
        show_edit_local_account_field = value
        show_add_local_account_field = value
    }
});
window.addEventListener('edit_local_account_delete_success', () => {
    show = false
});">
    <x-modal :name="'LocalAccountFormPanelModal'">
        <form wire:submit.prevent="save_local_account">
            <div class="sm:flex sm:items-start">
                <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                    <h3 class="text-base font-semibold text-gray-500 dark:text-gray-400" id="modal-title"
                        x-text="modal_title">
                    </h3>
                    <div class="mt-2">
                        <div class="grid grid-cols-3 gap-6">
                            <div class="relative z-0 w-full mb-5 group">
                                <x-text-input :property_name="'form.name'" :type="'text'" />
                                <x-label :for="'form.name'" :text="'Név'" />
                                @error('form.name')
                                    <x-input-error :messages="$message" class="mt-2" />
                                @enderror
                            </div>

                            <div class="relative z-0 w-full mb-5 group">
                                <x-text-input :property_name="'form.username'" :type="'text'" />
                                <x-label :for="'form.username'" :text="'Felhasználónév'" />
                                @error('form.username')
                                    <x-input-error :messages="$message" class="mt-2" />
                                @enderror
                            </div>

                            <div class="relative z-0 w-full mb-5 group">
                                <x-text-input :property_name="'form.email'" :type="'email'" />
                                <x-label :for="'form.email'" :text="'E-mail'" />
                                @error('form.email')
                                    <x-input-error :messages="$message" class="mt-2" />
                                @enderror
                            </div>

                            <div class="relative grid grid-cols-3 gap-x-6 col-span-3 z-0 w-full mb-5 group">
                                @foreach ($this->accountAuthorizationLevels as $accountAuthorizationLevel)
                                    <x-checkbox :property_name="'form.authorizations.' . $accountAuthorizationLevel->name" :text="$accountAuthorizationLevel->displayName" />
                                @endforeach

                                @error('form.authorizations')
                                    <x-input-error :messages="$message" class="mt-2" />
                                @enderror
                            </div>

                            <div class="relative z-0 w-full mb-5 group">
                                <x-text-input :property_name="'form.password'" :type="'password'" />
                                <x-label :for="'form.password'" :text="'Jelszó'" />
                                @error('form.password')
                                    <x-input-error :messages="$message" class="mt-2" />
                                @enderror
                            </div>

                            <div class="relative z-0 w-full mb-5 group">
                                <x-text-input :property_name="'form.password_confirmation'" :type="'password'" />
                                <x-label :for="'form.password_confirmation'" :text="'Jelszó megerősítése'" />
                                @error('form.password_confirmation')
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

                            {{-- if show_edit_local_account_field true --}}
                            <div x-show="show_edit_local_account_field" x-data="{ showConfirmDelete: false }"
                                class="relative z-0 w-full mb-5 group">
                                <x-danger-button @click.prevent="showConfirmDelete = true">
                                    {{ __('Törlés') }}
                                </x-danger-button>
                                <div x-show="showConfirmDelete">
                                    <x-modal :name="'Helyi fiók törlése'">
                                        <div class="m-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                                            <h3 class="text-base font-semibold text-gray-500 dark:text-gray-400"
                                                id="modal-title">
                                                Biztosan törlöd?
                                            </h3>
                                            <x-success-button
                                                @click.prevent="showConfirmDelete = false">Mégse</x-success-button>
                                            <x-danger-button
                                                @click.prevent="$wire.delete_edit_local_account(); showConfirmDelete = false">Igen,
                                                törlöm</x-danger-button>
                                        </div>
                                    </x-modal>
                                </div>
                                @error('delete_edit_local_account')
                                    <x-input-error :messages="$message" class="mt-2" />
                                @enderror
                            </div>

                        </div>
                    </div>
                </div>
            </div>
            <div class="bg-gray-100 dark:bg-gray-600 px-4 py-3 sm:flex sm:flex-row-reverse sm:px-6 items-center">
                <x-danger-button
                    @click.prevent="show_edit_local_account_field = false; show_add_local_account_field = false">{{ __('Bezárás') }}
                </x-danger-button>

                <x-success-button @click.prevent="$wire[method_name]()" class="me-3">
                    {{ __('Mentés') }}
                </x-success-button>

                <x-action-message wire:loading class="me-3" on="save_local_account">
                    {{ __('Mentés') }}
                </x-action-message>

                <x-action-message-success class="me-3" on="save_local_account_success">
                    {{ __('Sikeres mentés') }}
                </x-action-message-success>

                <x-action-message-success class="me-3" on="edit_local_account_delete_success">
                    {{ __('Sikeres törlés') }}
                </x-action-message-success>

                @error('save_edit_local_account_error')
                    <div class="me-3">
                        <x-input-error :messages="$message" />
                    </div>
                @enderror
            </div>
        </form>
    </x-modal>
</div>
