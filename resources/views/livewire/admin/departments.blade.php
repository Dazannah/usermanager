<div x-data="{
    show_add_department_field: false,
    show_edit_department_field: false,
}">

    <x-submenu :title="'Osztályok'">
        <x-submenu-button :text="'Osztály hozzáadás'" :properti_to_change="'show_add_department_field'" />
    </x-submenu>


    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 mt-6">
        @error('error')
            <div class="py-4">
                <x-input-error :messages="$message" class="mt" />
            </div>
        @enderror

        <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
            <table class="w-full table-auto text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-800 dark:text-gray-400">
                    <form action="filter_departments">
                        <tr>
                            <th scope="col" class="px-6 py-3">
                                <div class="flex items-center">
                                    <div class="relative z-0 w-full mb-5 group">
                                        <input wire:key="search_department_displayName"
                                            wire:model="search_department_displayName" type="text"
                                            name="search_department_displayName" id="search_department_displayName"
                                            class="block py-2.5 px-0 w-full text-sm text-[#15808a] focus:text-[#e3a420] bg-transparent border-0 border-b-2 border-[#15808a] appearance-none dark:text-[#15808a] focus:dark:text-[#e3a420] dark:border-[#15808a] dark:focus:border-[#e3a420] focus:outline-none focus:ring-0 focus:border-[#e3a420] peer"
                                            placeholder=" " />
                                        <label for="search_department_displayName"
                                            class="peer-focus:font-medium absolute text-sm text-[#15808a] dark:text-[#15808a] duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto peer-focus:text-[#e3a420] peer-focus:dark:text-[#e3a42] peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">
                                            Elnevezés
                                        </label>
                                        @error('search_department_displayName')
                                            <x-input-error :messages="$message" class="mt-2" />
                                        @enderror
                                    </div>
                                </div>
                            </th>

                            <th scope="col" class="px-6 py-3">
                                <div class="flex items-center">
                                    <div class="relative z-0 w-full mb-5 group">
                                        <input wire:key="search_department_departmentNumber"
                                            wire:model="search_department_departmentNumber" type="text"
                                            name="search_department_departmentNumber"
                                            id="search_department_departmentNumber"
                                            class="block py-2.5 px-0 w-full text-sm text-[#15808a] focus:text-[#e3a420] bg-transparent border-0 border-b-2 border-[#15808a] appearance-none dark:text-[#15808a] focus:dark:text-[#e3a420] dark:border-[#15808a] dark:focus:border-[#e3a420] focus:outline-none focus:ring-0 focus:border-[#e3a420] peer"
                                            placeholder=" " />
                                        <label for="search_department_departmentNumber"
                                            class="peer-focus:font-medium absolute text-sm text-[#15808a] dark:text-[#15808a] duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto peer-focus:text-[#e3a420] peer-focus:dark:text-[#e3a42] peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">
                                            departmentNumber
                                        </label>
                                        @error('search_department_departmentNumber')
                                            <x-input-error :messages="$message" class="mt-2" />
                                        @enderror
                                    </div>
                                </div>
                            </th>

                            <th scope="col" class="px-6 py-3">
                                <div class="flex items-center">
                                    <div class="relative z-0 w-full mb-5 group">
                                        <input wire:key="search_department_departmentNumber2"
                                            wire:model="search_department_departmentNumber2" type="text"
                                            name="search_department_departmentNumber2"
                                            id="search_department_departmentNumber2"
                                            class="block py-2.5 px-0 w-full text-sm text-[#15808a] focus:text-[#e3a420] bg-transparent border-0 border-b-2 border-[#15808a] appearance-none dark:text-[#15808a] focus:dark:text-[#e3a420] dark:border-[#15808a] dark:focus:border-[#e3a420] focus:outline-none focus:ring-0 focus:border-[#e3a420] peer"
                                            placeholder=" " />
                                        <label for="search_department_departmentNumber2"
                                            class="peer-focus:font-medium absolute text-sm text-[#15808a] dark:text-[#15808a] duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto peer-focus:text-[#e3a420] peer-focus:dark:text-[#e3a42] peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">
                                            departmentNumber2
                                        </label>
                                        @error('search_department_departmentNumber2')
                                            <x-input-error :messages="$message" class="mt-2" />
                                        @enderror
                                    </div>
                                </div>
                            </th>

                            <th scope="col" class="px-6 py-3">
                                <div class="flex items-center">
                                    <div class="relative z-0 w-full mb-5 group">
                                        <select wire:key="search_department_status_id"
                                            wire:model="search_department_status_id" type="select"
                                            name="search_department_status_id" id="authorization_status_id"
                                            class="block py-2.5 px-0 w-full text-sm text-[#15808a] focus:text-[#e3a420] bg-transparent border-0 border-b-2 border-[#15808a] appearance-none dark:text-[#15808a] focus:dark:text-[#e3a420] dark:border-[#15808a] dark:focus:border-[#e3a420] focus:outline-none focus:ring-0 focus:border-[#e3a420] peer"
                                            placeholder=" ">
                                            <x-option value="">Összes</x-option>
                                            @foreach ($this->statuses as $status)
                                                <x-option
                                                    value="{{ $status->id }}">{{ $status->displayName }}</x-option>
                                            @endforeach
                                        </select>
                                        <label for="search_department_status_id"
                                            class="peer-focus:font-medium absolute text-sm text-[#15808a] dark:text-[#15808a] duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto peer-focus:text-[#e3a420] peer-focus:dark:text-[#e3a42] peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">
                                            Státusz
                                        </label>
                                        @error('search_department_status_id')
                                            <x-input-error :messages="$message" class="mt-2" />
                                        @enderror
                                    </div>
                                </div>
                            </th>

                            <th scope="col" class="px-6 py-3">
                                <div class="flex items-center">
                                    <div class="relative z-0 w-full mb-5 group">
                                        <select wire:key="search_department_location_id"
                                            wire:model="search_department_location_id" type="select"
                                            name="search_department_location_id" id="authorization_status_id"
                                            class="block py-2.5 px-0 w-full text-sm text-[#15808a] focus:text-[#e3a420] bg-transparent border-0 border-b-2 border-[#15808a] appearance-none dark:text-[#15808a] focus:dark:text-[#e3a420] dark:border-[#15808a] dark:focus:border-[#e3a420] focus:outline-none focus:ring-0 focus:border-[#e3a420] peer"
                                            placeholder=" ">
                                            <x-option value="">Összes</x-option>
                                            @foreach ($this->locations as $location)
                                                <x-option
                                                    value="{{ $location->id }}">{{ $location->displayName }}</x-option>
                                            @endforeach
                                        </select>
                                        <label for="search_department_location_id"
                                            class="peer-focus:font-medium absolute text-sm text-[#15808a] dark:text-[#15808a] duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto peer-focus:text-[#e3a420] peer-focus:dark:text-[#e3a42] peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">
                                            Helyszín
                                        </label>
                                        @error('search_department_location_id')
                                            <x-input-error :messages="$message" class="mt-2" />
                                        @enderror
                                    </div>
                                </div>
                            </th>

                            <th scope="col" class="px-6 py-3 text-right">
                                <x-success-button wire:click.prevent="refresh_departments_mount" class="me-3">
                                    {{ __('Keresés') }}
                                </x-success-button>
                                <x-primary-button
                                    @click.prevent="$dispatch('department_filter_reset')">{{ __('Visszaállítás') }}
                                </x-primary-button>
                            </th>
                        </tr>
                    </form>
                </thead>
                <tbody>

                    @foreach ($departments as $department)
                        <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 border-gray-200">
                            <th scope="row"
                                class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                {{ $department->displayName }}
                            </th>
                            <th scope="row"
                                class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                {{ $department->departmentNumber }}
                            </th>
                            <th scope="row"
                                class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                {{ $department->departmentNumber2 }}
                            </th>
                            <td
                                class="px-6 py-4 {{ $department->status->name == 'active' ? 'text-green-600 dark:text-green-500' : 'text-red-600 dark:text-red-500' }}">
                                {{ $department->status->displayName }}
                            </td>
                            <td class="px-6 py-4">
                                {{ $department->location->displayName }}
                            </td>
                            <td class="px-6 py-4 text-right">
                                <button
                                    @click="show_edit_department_field = !show_edit_department_field; edit_department_id = {{ $department->id }}"
                                    class="font-medium text-orange-600 dark:text-orange-500 underline hover:no-underline">Szerkesztés</button>
                            </td>
                        </tr>
                    @endforeach

                </tbody>
            </table>
        </div>
        {{ $departments->links(data: ['scrollTo' => false]) }}
    </div>

    {{-- department modals --}}
    <livewire:admin.components.create-department :$statuses :$locations />
    <livewire:admin.components.edit-department :$statuses :$locations />
</div>
