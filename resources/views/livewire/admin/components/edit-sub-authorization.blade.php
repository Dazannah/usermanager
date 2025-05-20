<div x-data="{ show: false }" x-init="$watch('show_edit_sub_authorization_field', value => {
    show = value
    if (value) $dispatch('edit_sub_authorization_id', [edit_sub_authorization_id])
});
$watch('show', value => show_edit_sub_authorization_field = value);
window.addEventListener('edit_sub_authorization_delete_success', () => {
    show = false
});">
    <x-modal :name="'Jogosultság szerkesztése'">
        <form wire:submit.prevent="save_sub_authorization">
            <div class="sm:flex sm:items-start">
                <div class="mt-3 py-2 text-center sm:mt-0 sm:ml-4 sm:text-left">
                    <h3 class="text-base font-semibold text-gray-500 dark:text-gray-400" id="modal-title">
                        Aljogosultság szerkesztése
                    </h3>
                    <div class="mt-2">
                        <div class="grid grid-cols-3 gap-6">
                            <div class="relative z-0 w-full mb-5 group">
                                <input wire:key="edit_sub_auth_item_display_name"
                                    wire:model="edit_sub_auth_item_display_name" type="text"
                                    name="edit_sub_auth_item_display_name" id="edit_sub_auth_item_display_name"
                                    class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-indigo-600 focus:outline-none focus:ring-0 focus:border-indigo-400 peer"
                                    placeholder=" " />
                                <label for="edit_sub_auth_item_display_name"
                                    class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto peer-focus:text-indigo-600 peer-focus:dark:text-indigo-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">
                                    Elnevezés
                                </label>
                                @error('edit_sub_auth_item_display_name')
                                    <x-input-error :messages="$message" class="mt-2" />
                                @enderror
                            </div>

                            <div class="relative z-0 w-full mb-5 group">
                                <select wire:key="edit_sub_auth_item_authItem_Id"
                                    wire:model="edit_sub_auth_item_authItem_Id" type="select"
                                    name="edit_sub_auth_item_authItem_Id" id="edit_sub_auth_item_authItem_Id"
                                    class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-indigo-600 focus:outline-none focus:ring-0 focus:border-indigo-400 peer"
                                    placeholder=" ">
                                    <x-option>Válassz egy jogosultságot</x-option>
                                    @foreach ($this->authorizations as $authorization)
                                        <x-option
                                            value="{{ $authorization->id }}">{{ $authorization->displayName }}</x-option>
                                    @endforeach
                                </select>
                                <label for="edit_sub_auth_item_authItem_Id"
                                    class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto peer-focus:text-indigo-600 peer-focus:dark:text-indigo-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">
                                    Jogosultság
                                </label>
                                @error('edit_sub_auth_item_authItem_Id')
                                    <x-input-error :messages="$message" class="mt-2" />
                                @enderror
                            </div>

                            <div class="relative z-0 w-full mb-5 group">
                                <select wire:key="edit_sub_auth_item_status_id"
                                    wire:model="edit_sub_auth_item_status_id" type="select"
                                    name="edit_sub_auth_item_status_id" id="edit_sub_auth_item_status_id"
                                    class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-indigo-600 focus:outline-none focus:ring-0 focus:border-indigo-400 peer"
                                    placeholder=" ">
                                    @foreach ($this->statuses as $status)
                                        <x-option value="{{ $status->id }}">{{ $status->displayName }}</x-option>
                                    @endforeach
                                </select>
                                <label for="edit_sub_auth_item_status_id"
                                    class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto peer-focus:text-indigo-600 peer-focus:dark:text-indigo-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">
                                    Státusz
                                </label>
                                @error('edit_sub_auth_item_status_id')
                                    <x-input-error :messages="$message" class="mt-2" />
                                @enderror
                            </div>

                            <div class="relative z-0 w-full mb-5 group">
                                <select wire:key="edit_sub_auth_item_position{{ $edit_sub_auth_item_position }}"
                                    wire:model="edit_sub_auth_item_position" type="select"
                                    name="edit_sub_auth_item_position" id="edit_sub_auth_item_position"
                                    class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-indigo-600 focus:outline-none focus:ring-0 focus:border-indigo-400 peer"
                                    placeholder=" ">
                                    @for ($i = 1; $i <= $edit_subAuthItem_number; $i++)
                                        <x-option :value="$i">{{ $i }}</x-option>
                                    @endfor
                                </select>
                                <label for="edit_sub_auth_item_position"
                                    class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto peer-focus:text-indigo-600 peer-focus:dark:text-indigo-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">
                                    Pozíció
                                </label>
                                @error('edit_sub_auth_item_position')
                                    <x-input-error :messages="$message" class="mt-2" />
                                @enderror
                            </div>

                            <div x-data="{ showConfirmDelete: false }" class="relative z-0 w-full mb-5 group">
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
                                                @click.prevent="$wire.delete_edit_sub_authorization(); showConfirmDelete = false">Igen,
                                                törlöm</x-danger-button>
                                        </div>
                                    </x-modal>
                                </div>
                                @error('delete_edit_sub_authorization')
                                    <x-input-error :messages="$message" class="mt-2" />
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="bg-gray-100 dark:bg-gray-600 px-4 py-3 sm:flex sm:flex-row-reverse sm:px-6 items-center">
                <x-danger-button
                    @click.prevent="show_edit_sub_authorization_field = !show_edit_sub_authorization_field">{{ __('Bezárás') }}
                </x-danger-button>

                <x-success-button wire:click.prevent="save_edit_sub_authorization" class="me-3">
                    {{ __('Mentés') }}
                </x-success-button>

                <x-action-message wire:loading class="me-3" on="save_edit_sub_authorization">
                    {{ __('Betöltés') }}
                </x-action-message>

                <x-action-message-success class="me-3" on="save_edit_sub_authorization_success">
                    {{ __('Sikeres mentés') }}
                </x-action-message-success>

                <x-action-message-success class="me-3" on="edit_sub_authorization_delete_success">
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
