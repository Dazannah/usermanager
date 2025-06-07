<div x-data="{ show: false, method_name: '', modal_title: '' }" x-init="$watch('show_update_account_authorization_field', value => {
    show = value
    method_name = 'update_account_authorization'
    modal_title = 'Jogosultsági szint szerkesztése'
    if (value) $dispatch('show_update_account_authorization', [update_account_authorization_id])
});
$watch('show', value => {
    if (!value) {
        show_update_account_authorization_field = value
    }
});">
    <x-modal :name="'Jogosultsági szint szerkesztése'">
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
                                <x-text-input :property_name="'form.ldap_group_name'" :type="'text'" />
                                <x-label :for="'form.ldap_group_name'" :text="'LDAP csoport név'" />
                                @error('form.ldap_group_name')
                                    <x-input-error :messages="$message" class="mt-2" />
                                @enderror
                            </div>

                            <div class="relative z-0 w-full mb-5 group">
                                <x-text-input :property_name="'form.name'" :type="'text'" disabled />
                                <x-label :for="'form.name'" :text="'Azonosító'" />
                                @error('form.name')
                                    <x-input-error :messages="$message" class="mt-2" />
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="bg-gray-100 dark:bg-gray-600 px-4 py-3 sm:flex sm:flex-row-reverse sm:px-6 items-center">
                <x-danger-button @click.prevent="show_update_account_authorization_field = false;">
                    {{ __('Bezárás') }}
                </x-danger-button>

                <x-success-button @click.prevent="$wire[method_name]" class="me-3">
                    {{ __('Mentés') }}
                </x-success-button>

                <x-action-message wire:loading class="me-3" on="update_account_authorization">
                    {{ __('Betöltés') }}
                </x-action-message>

                <x-action-message-success class="me-3" on="update_account_authorization_success">
                    {{ __('Sikeres mentés') }}
                </x-action-message-success>

                @error('account_authorization_error')
                    <div class="me-3">
                        <x-input-error :messages="$message" />
                    </div>
                @enderror
            </div>
        </form>
    </x-modal>
</div>
