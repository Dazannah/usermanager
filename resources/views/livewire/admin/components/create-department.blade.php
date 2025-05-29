<div x-data="{ show: false }" x-init="$watch('show_add_department_field', value => show = value);
$watch('show', value => show_add_department_field = value)">
    <x-modal :name="'Osztály hozzáadás'">
        <form wire:submit.prevent="save_new_department">
            <div class="sm:flex sm:items-start">
                <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                    <h3 class="text-base font-semibold text-gray-500 dark:text-gray-400" id="modal-title">
                        Osztály hozzáadás
                    </h3>
                    <div class="mt-2">
                        <div class="grid grid-cols-3 gap-6">
                            <div class="relative z-0 w-full mb-5 group">
                                <input wire:key="create_department_displayName"
                                    wire:model="create_department_displayName" type="text"
                                    name="create_department_displayName" id="create_department_displayName"
                                    class="block py-2.5 px-0 w-full text-sm text-[#15808a] focus:text-[#e3a420] bg-transparent border-0 border-b-2 border-[#15808a] appearance-none dark:text-[#15808a] focus:dark:text-[#e3a420] dark:border-[#15808a] dark:focus:border-[#e3a420] focus:outline-none focus:ring-0 focus:border-[#e3a420] peer"
                                    placeholder=" " />
                                <label for="create_department_displayName"
                                    class="peer-focus:font-medium absolute text-sm text-[#15808a] dark:text-[#15808a] duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto peer-focus:text-[#e3a420] peer-focus:dark:text-[#e3a42] peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">
                                    Elnevezés
                                </label>
                                @error('create_department_displayName')
                                    <x-input-error :messages="$message" class="mt-2" />
                                @enderror
                            </div>
                            <div class="relative z-0 w-full mb-5 group">
                                <input wire:key="create_department_departmentNumber"
                                    wire:model="create_department_departmentNumber" type="text"
                                    name="create_department_departmentNumber" id="create_department_departmentNumber"
                                    class="block py-2.5 px-0 w-full text-sm text-[#15808a] focus:text-[#e3a420] bg-transparent border-0 border-b-2 border-[#15808a] appearance-none dark:text-[#15808a] focus:dark:text-[#e3a420] dark:border-[#15808a] dark:focus:border-[#e3a420] focus:outline-none focus:ring-0 focus:border-[#e3a420] peer"
                                    placeholder=" " />
                                <label for="create_department_departmentNumber"
                                    class="peer-focus:font-medium absolute text-sm text-[#15808a] dark:text-[#15808a] duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto peer-focus:text-[#e3a420] peer-focus:dark:text-[#e3a42] peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">
                                    departmentNumber
                                </label>
                                @error('create_department_departmentNumber')
                                    <x-input-error :messages="$message" class="mt-2" />
                                @enderror
                            </div>
                            <div class="relative z-0 w-full mb-5 group">
                                <input wire:key="create_department_departmentNumber2"
                                    wire:model="create_department_departmentNumber2" type="text"
                                    name="create_department_departmentNumber2" id="create_department_departmentNumber2"
                                    class="block py-2.5 px-0 w-full text-sm text-[#15808a] focus:text-[#e3a420] bg-transparent border-0 border-b-2 border-[#15808a] appearance-none dark:text-[#15808a] focus:dark:text-[#e3a420] dark:border-[#15808a] dark:focus:border-[#e3a420] focus:outline-none focus:ring-0 focus:border-[#e3a420] peer"
                                    placeholder=" " />
                                <label for="create_department_departmentNumber2"
                                    class="peer-focus:font-medium absolute text-sm text-[#15808a] dark:text-[#15808a] duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto peer-focus:text-[#e3a420] peer-focus:dark:text-[#e3a42] peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">
                                    departmentNumber2
                                </label>
                                @error('create_department_departmentNumber2')
                                    <x-input-error :messages="$message" class="mt-2" />
                                @enderror
                            </div>
                            <div class="relative z-0 w-full mb-5 group">
                                <select key:wire="create_department_status_id" wire:model="create_department_status_id"
                                    type="select" name="create_department_status_id" id="create_department_status_id"
                                    class="block py-2.5 px-0 w-full text-sm text-[#15808a] focus:text-[#e3a420] bg-transparent border-0 border-b-2 border-[#15808a] appearance-none dark:text-[#15808a] focus:dark:text-[#e3a420] dark:border-[#15808a] dark:focus:border-[#e3a420] focus:outline-none focus:ring-0 focus:border-[#e3a420] peer"
                                    placeholder=" ">
                                    @foreach ($this->statuses as $status)
                                        <x-option value="{{ $status->id }}">{{ $status->displayName }}</x-option>
                                    @endforeach
                                </select>
                                <label for="create_department_status_id"
                                    class="peer-focus:font-medium absolute text-sm text-[#15808a] dark:text-[#15808a] duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto peer-focus:text-[#e3a420] peer-focus:dark:text-[#e3a42] peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">
                                    Státusz
                                </label>
                                @error('create_department_status_id')
                                    <x-input-error :messages="$message" class="mt-2" />
                                @enderror
                            </div>

                            <div class="relative z-0 w-full mb-5 group">
                                <select key:wire="create_department_location_id"
                                    wire:model="create_department_location_id" type="select"
                                    name="create_department_location_id" id="create_department_location_id"
                                    class="block py-2.5 px-0 w-full text-sm text-[#15808a] focus:text-[#e3a420] bg-transparent border-0 border-b-2 border-[#15808a] appearance-none dark:text-[#15808a] focus:dark:text-[#e3a420] dark:border-[#15808a] dark:focus:border-[#e3a420] focus:outline-none focus:ring-0 focus:border-[#e3a420] peer"
                                    placeholder=" ">
                                    <x-option>Válassz</x-option>
                                    @foreach ($this->locations as $location)
                                        <x-option value="{{ $location->id }}">{{ $location->displayName }}</x-option>
                                    @endforeach
                                </select>
                                <label for="create_department_location_id"
                                    class="peer-focus:font-medium absolute text-sm text-[#15808a] dark:text-[#15808a] duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto peer-focus:text-[#e3a420] peer-focus:dark:text-[#e3a42] peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">
                                    Helyszín
                                </label>
                                @error('create_department_location_id')
                                    <x-input-error :messages="$message" class="mt-2" />
                                @enderror
                            </div>

                        </div>
                    </div>
                </div>
            </div>
            <div class="bg-gray-100 dark:bg-gray-600 px-4 py-3 sm:flex sm:flex-row-reverse sm:px-6 items-center">
                <x-danger-button
                    @click.prevent="show_add_department_field = !show_add_department_field">{{ __('Bezárás') }}
                </x-danger-button>

                <x-success-button wire:click.prevent="save_new_department" class="me-3">
                    {{ __('Mentés') }}
                </x-success-button>

                <x-action-message wire:loading class="me-3" on="save_new_department">
                    {{ __('Betöltés') }}
                </x-action-message>

                <x-action-message-success class="me-3" on="save_new_department_success">
                    {{ __('Sikeres mentés') }}
                </x-action-message-success>

                @error('save_new_department_error')
                    <div class="me-3">
                        <x-input-error :messages="$message" />
                    </div>
                @enderror
            </div>
        </form>
    </x-modal>
</div>
