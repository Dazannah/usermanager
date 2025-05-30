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
                                <div class="relative z-0 w-full mb-5 group">
                                    <x-text-input :property_name="'search_location_displayName'" :type="'text'" />
                                    <x-label :for="'search_location_displayName'" :text="'Elnevezés'" />
                                    @error('search_location_displayName')
                                        <x-input-error :messages="$message" class="mt-2" />
                                    @enderror
                                </div>
                            </th>

                            <th scope="col" class="px-6 py-3">
                                <div class="relative z-0 w-full mb-5 group">
                                    <x-select :property_name="'search_location_status_id'" :select="true" :select_value="'Összes'"
                                        :data="$this->statuses" />
                                    <x-label :for="'search_location_status_id'" :text="'Státusz'" />
                                    @error('search_location_status_id')
                                        <x-input-error :messages="$message" class="mt-2" />
                                    @enderror
                                </div>
                            </th>

                            <th scope="col" class="px-6 py-3">
                                <div class="relative z-0 w-full mb-5 group">
                                    <x-text-input :property_name="'search_location_note'" :type="'text'" />
                                    <x-label :for="'search_location_note'" :text="'Megjegyzés'" />
                                    @error('search_location_note')
                                        <x-input-error :messages="$message" class="mt-2" />
                                    @enderror
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
