<div x-data="{ show: false }" x-init="$watch('show_add_column_field', value => show = value);
$watch('show', value => show_add_column_field = value)">
    <x-modal :name="'Jogosultság hozzáadás'">
        <form wire:submit.prevent="save_column">
            <div class="sm:flex sm:items-start">
                <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                    <h3 class="text-base font-semibold text-gray-500 dark:text-gray-400" id="modal-title">
                        Oszlop hozzáadás
                    </h3>
                    <div class="mt-2">
                        <div class="grid grid-cols-2 gap-6">
                            <div class="relative z-0 w-full mb-5 group">
                                <input wire:model="column_display_name" type="text" name="column_display_name"
                                    id="column_display_name"
                                    class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-indigo-600 focus:outline-none focus:ring-0 focus:border-indigo-400 peer"
                                    placeholder=" " />
                                <label for="column_display_name"
                                    class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto peer-focus:text-indigo-600 peer-focus:dark:text-indigo-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">
                                    Elnevezés
                                </label>
                                @error('column_display_name')
                                    <x-input-error :messages="$message" class="mt-2" />
                                @enderror
                            </div>
                            <div class="relative z-0 w-full mb-5 group">
                                <select wire:model="column_status_id" type="select" name="column_status_id"
                                    id="column_status_id"
                                    class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-indigo-600 focus:outline-none focus:ring-0 focus:border-indigo-400 peer"
                                    placeholder=" ">
                                    @foreach ($this->statuses as $status)
                                        <x-option value="{{ $status->id }}">{{ $status->displayName }}</x-option>
                                    @endforeach
                                </select>
                                <label for="column_status_id"
                                    class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto peer-focus:text-indigo-600 peer-focus:dark:text-indigo-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">
                                    Státusz
                                </label>
                                @error('column_status_id')
                                    <x-input-error :messages="$message" class="mt-2" />
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="bg-gray-100 dark:bg-gray-600 px-4 py-3 sm:flex sm:flex-row-reverse sm:px-6 items-center">
                <x-danger-button @click.prevent="show_add_column_field = !show_add_column_field">{{ __('Bezárás') }}
                </x-danger-button>

                <x-success-button wire:click.prevent="save_column" class="me-3">
                    {{ __('Mentés') }}
                </x-success-button>

                <x-action-message wire:loading class="me-3" on="save_column">
                    {{ __('Betöltés') }}
                </x-action-message>

                <x-action-message-success class="me-3" on="columns_save_success">
                    {{ __('Sikeres mentés') }}
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
