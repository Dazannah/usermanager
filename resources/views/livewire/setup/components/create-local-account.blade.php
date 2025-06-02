<div x-data="{ show: false }" x-init="$watch('show_add_local_account_field', value => show = value);
$watch('show', value => show_add_local_account_field = value)">
    <x-modal :name="'Helyi fiók hozzáadás'">
        <form wire:submit.prevent="save_local_account">
            <div class="sm:flex sm:items-start">
                <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                    <h3 class="text-base font-semibold text-gray-500 dark:text-gray-400" id="modal-title">
                        Helyi fiók hozzáadás
                    </h3>
                    <div class="mt-2">
                        <div class="grid grid-cols-3 gap-6">
                            <div class="relative z-0 w-full mb-5 group">
                                <x-text-input :property_name="'create_local_account_name'" :type="'text'" />
                                <x-label :for="'create_local_account_name'" :text="'Név'" />
                                @error('create_local_account_name')
                                    <x-input-error :messages="$message" class="mt-2" />
                                @enderror
                            </div>

                            <div class="relative z-0 w-full mb-5 group">
                                <x-text-input :property_name="'create_local_account_username'" :type="'text'" />
                                <x-label :for="'create_local_account_username'" :text="'Felhasználónév'" />
                                @error('create_local_account_username')
                                    <x-input-error :messages="$message" class="mt-2" />
                                @enderror
                            </div>

                            <div class="relative z-0 w-full mb-5 group">
                                <x-text-input :property_name="'create_local_account_email'" :type="'email'" />
                                <x-label :for="'create_local_account_email'" :text="'E-mail'" />
                                @error('create_local_account_email')
                                    <x-input-error :messages="$message" class="mt-2" />
                                @enderror
                            </div>

                            <div class="relative grid grid-cols-3 gap-x-6 col-span-3 z-0 w-full mb-5 group">
                                @foreach ($this->accountAuthorizationLevels as $accountAuthorizationLevel)
                                    <x-checkbox :property_name="'create_local_account_authorizations.' .
                                        $accountAuthorizationLevel->name" :text="$accountAuthorizationLevel->displayName" />
                                @endforeach

                                @error('create_local_account_authorization_level')
                                    <x-input-error :messages="$message" class="mt-2" />
                                @enderror
                            </div>

                            <div class="relative z-0 w-full mb-5 group">
                                <x-text-input :property_name="'create_local_account_password'" :type="'password'" />
                                <x-label :for="'create_local_account_password'" :text="'Jelszó'" />
                                @error('create_local_account_password')
                                    <x-input-error :messages="$message" class="mt-2" />
                                @enderror
                            </div>

                            <div class="relative z-0 w-full mb-5 group">
                                <x-text-input :property_name="'create_local_account_password_confirmation'" :type="'password'" />
                                <x-label :for="'create_local_account_password_confirmation'" :text="'Jelszó megerősítése'" />
                                @error('create_local_account_password_confirmation')
                                    <x-input-error :messages="$message" class="mt-2" />
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="bg-gray-100 dark:bg-gray-600 px-4 py-3 sm:flex sm:flex-row-reverse sm:px-6 items-center">
                <x-danger-button
                    @click.prevent="show_add_local_account_field = !show_add_local_account_field">{{ __('Bezárás') }}
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

                @error('save_local_account_error')
                    <div class="me-3">
                        <x-input-error :messages="$message" />
                    </div>
                @enderror
            </div>
        </form>
    </x-modal>
</div>
