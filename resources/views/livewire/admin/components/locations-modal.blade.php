<div x-data="{
    show: false,
    show_add_location_field: false,
    show_edit_location_field: false,
}" x-init="$watch('show_manage_locations', value => {
    show = value
});

$watch('show', value => {
    if (!value) {
        show_manage_locations = value
    }
});">
    <x-modal :name="'LocationsModal'">
        <x-submenu :title="'Helyszínek'">
            <x-submenu-button :text="'Helyszín hozzáadás'" :properti_to_change="'show_add_location_field'" />
        </x-submenu>


        @error('error')
            <div class="py-4">
                <x-input-error :messages="$message" class="mt" />
            </div>
        @enderror

        <div class="w-full relative overflow-x-auto sm:rounded-lg">
            <table class="w-full table-auto text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                <form action="filter_locations">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
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
                                <x-primary-button
                                    @click.prevent="$dispatch('location_filter_reset')">{{ __('Visszaállítás') }}
                                </x-primary-button>
                            </th>
                        </tr>
                    </thead>
                </form>
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
                                    @click="show_edit_location_field = !show_edit_location_field; update_location_id = {{ $location->id }}"
                                    class="font-medium text-orange-600 dark:text-orange-500 underline hover:no-underline">Szerkesztés</button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        {{ $locations->links() }}


        <div class="bg-gray-100 dark:bg-gray-600 px-4 py-3 sm:flex sm:flex-row-reverse sm:px-6 items-center">
            <x-danger-button @click.prevent="show = false">
                {{ __('Bezárás') }}
            </x-danger-button>
        </div>
    </x-modal>

    {{-- location modal --}}
    <livewire:admin.components.location-form-panel :$statuses />
</div>
