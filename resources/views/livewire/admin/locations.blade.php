<div x-data="{
    show_add_location_field: false,
    show_edit_location_field: false,
}">
    <x-submenu :title="'Helyszínek'">
        <x-submenu-button :text="'Helyszín hozzáadás'" :properti_to_change="'show_add_location_field'" />
    </x-submenu>

    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 mt-6">
        @error('error')
            <div class="py-4">
                <x-input-error :messages="$message" class="mt" />
            </div>
        @enderror

        <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
            <table class="w-full table-auto text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                    <form action="filter_locations">
                        <tr>
                            <th scope="col" class="px-6 py-3">
                                <div class="flex items-center">
                                    <div class="relative z-0 w-full mb-5 group">
                                        <input wire:key="search_location_displayName"
                                            wire:model="search_location_displayName" type="text"
                                            name="search_location_displayName" id="search_location_displayName"
                                            class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-indigo-400 focus:outline-none focus:ring-0 focus:border-indigo-400 peer"
                                            placeholder=" " />
                                        <label for="search_location_displayName"
                                            class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto peer-focus:text-indigo-600 peer-focus:dark:text-indigo-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">
                                            Elnevezés
                                        </label>
                                        @error('search_location_displayName')
                                            <x-input-error :messages="$message" class="mt-2" />
                                        @enderror
                                    </div>
                                </div>
                            </th>

                            <th scope="col" class="px-6 py-3">
                                <div class="flex items-center">
                                    <div class="relative z-0 w-full mb-5 group">
                                        <select wire:key="search_location_status_id"
                                            wire:model="search_location_status_id" type="select"
                                            name="search_location_status_id" id="authorization_status_id"
                                            class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-indigo-400 focus:outline-none focus:ring-0 focus:border-indigo-400 peer"
                                            placeholder=" ">
                                            <x-option value="">Összes</x-option>
                                            @foreach ($this->statuses as $status)
                                                <x-option
                                                    value="{{ $status->id }}">{{ $status->displayName }}</x-option>
                                            @endforeach
                                        </select>
                                        <label for="search_location_status_id"
                                            class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto peer-focus:text-indigo-600 peer-focus:dark:text-indigo-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">
                                            Státusz
                                        </label>
                                        @error('search_location_status_id')
                                            <x-input-error :messages="$message" class="mt-2" />
                                        @enderror
                                    </div>
                                </div>
                            </th>

                            <th scope="col" class="px-6 py-3">
                                <div class="flex items-center">
                                    <div class="relative z-0 w-full mb-5 group">
                                        <input wire:key="search_location_note" wire:model="search_location_note"
                                            type="text" name="search_location_note" id="search_location_note"
                                            class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-indigo-400 focus:outline-none focus:ring-0 focus:border-indigo-400 peer"
                                            placeholder=" " />
                                        <label for="search_location_note"
                                            class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto peer-focus:text-indigo-600 peer-focus:dark:text-indigo-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">
                                            Megjegyzés
                                        </label>
                                        @error('search_location_note')
                                            <x-input-error :messages="$message" class="mt-2" />
                                        @enderror
                                    </div>
                                </div>
                            </th>

                            <th scope="col" class="px-6 py-3 text-right">
                                <x-success-button wire:click.prevent="refresh_locations_mount" class="me-3">
                                    {{ __('Keresés') }}
                                </x-success-button>
                                <x-primary-button
                                    @click.prevent="$dispatch('location_filter_reset')">{{ __('Visszaállítás') }}
                                </x-primary-button>
                            </th>
                        </tr>
                    </form>
                </thead>
                <tbody>

                    @foreach ($locations as $location)
                        <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 border-gray-200">
                            <th scope="row"
                                class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                {{ $location->displayName }}
                            </th>
                            <td
                                class="px-6 py-4 {{ $location->status->name == 'active' ? 'text-green-600 dark:text-green-500' : 'text-red-600 dark:text-red-500' }}">
                                {{ $location->status->displayName }}
                            </td>
                            <td class="px-6 py-4">
                                {{ $location->note }}
                            </td>
                            <td class="px-6 py-4 text-right">
                                <button
                                    @click="show_edit_location_field = !show_edit_location_field; show_edit_location_id = {{ $location->id }}"
                                    class="font-medium text-orange-600 dark:text-orange-500 underline hover:no-underline">Szerkesztés</button>
                            </td>
                        </tr>
                    @endforeach

                </tbody>
            </table>
        </div>
        {{ $locations->links() }}
    </div>

    {{-- location modals --}}
    <livewire:admin.components.create-location :$statuses />
    <livewire:admin.components.edit-location :$statuses />
</div>
