<div x-data="{ show: false }"
    x-init= "$watch('show_edit_local_account_field', value => {
    show = value
    if (value) $dispatch('edit_local_account_id', [edit_local_account_id])
});
$watch('show', value => show_edit_local_account_field = value);
window.addEventListener('edit_local_account_delete_success', () => {
    show = false
});">
    <x-modal :name="'Helyi fiók szerkesztése'">
        <form wire:submit.prevent="save_local_account">
            <div class="sm:flex sm:items-start">
                <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                    <h3 class="text-base font-semibold text-gray-500 dark:text-gray-400" id="modal-title">
                        Helyi fiók szerkesztése
                    </h3>
                    <div class="mt-2">
                        <div class="grid grid-cols-3 gap-6">
                            <div class="relative z-0 w-full mb-5 group">
                                <x-text-input :property_name="'edit_local_account_name'" :type="'text'" />
                                <x-label :for="'edit_local_account_name'" :text="'Név'" />
                                @error('edit_local_account_name')
                                    <x-input-error :messages="$message" class="mt-2" />
                                @enderror
                            </div>

                            <div class="relative z-0 w-full mb-5 group">
                                <x-text-input :property_name="'edit_local_account_username'" :type="'text'" />
                                <x-label :for="'edit_local_account_username'" :text="'Felhasználónév'" />
                                @error('edit_local_account_username')
                                    <x-input-error :messages="$message" class="mt-2" />
                                @enderror
                            </div>

                            <div class="relative z-0 w-full mb-5 group">
                                <x-text-input :property_name="'edit_local_account_email'" :type="'email'" />
                                <x-label :for="'edit_local_account_email'" :text="'E-mail'" />
                                @error('edit_local_account_email')
                                    <x-input-error :messages="$message" class="mt-2" />
                                @enderror
                            </div>

                            <div class="relative grid grid-cols-3 gap-x-6 col-span-3 z-0 w-full mb-5 group">
                                @foreach ($this->accountAuthorizationLevels as $accountAuthorizationLevel)
                                    <x-checkbox :wire_key="'edit_local_account_authorizations.' . $accountAuthorizationLevel->name" :property_name="'edit_local_account_authorizations.' . $accountAuthorizationLevel->name" :text="$accountAuthorizationLevel->displayName" />
                                @endforeach

                                @error('edit_local_account_authorizations')
                                    <x-input-error :messages="$message" class="mt-2" />
                                @enderror
                            </div>

                            <div class="relative z-0 w-full mb-5 group">
                                <x-text-input :property_name="'edit_local_account_password'" :type="'password'" />
                                <x-label :for="'edit_local_account_password'" :text="'Jelszó'" />
                                @error('edit_local_account_password')
                                    <x-input-error :messages="$message" class="mt-2" />
                                @enderror
                            </div>

                            <div class="relative z-0 w-full mb-5 group">
                                <x-text-input :property_name="'edit_local_account_password_confirmation'" :type="'password'" />
                                <x-label :for="'edit_local_account_password_confirmation'" :text="'Jelszó megerősítése'" />
                                @error('edit_local_account_password_confirmation')
                                    <x-input-error :messages="$message" class="mt-2" />
                                @enderror
                            </div>

                            <div x-data="{ showConfirmDelete: false }" class="relative z-0 w-full mb-5 group">
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
                    @click.prevent="show_edit_local_account_field = !show_edit_local_account_field">{{ __('Bezárás') }}
                </x-danger-button>

                <x-success-button wire:click.prevent="save_local_account" class="me-3">
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
