<div x-data="{
    show_store_department_field: false,
    show_update_department_field: false,
}">

    <x-submenu :title="'Osztályok'">
        <x-submenu-button :text="'Osztály hozzáadás'" :properti_to_change="'show_store_department_field'" />
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
                    <form action="filter_departments">
                        <tr>
                            <th scope="col" class="px-6 py-3">
                                <div class="relative z-0 w-full mb-5 group">
                                    <x-text-input :property_name="'search_department_displayName'" :type="'text'" />
                                    <x-label :for="'search_department_displayName'" :text="'Elnevezés'" />
                                    @error('search_department_displayName')
                                        <x-input-error :messages="$message" class="mt-2" />
                                    @enderror
                                </div>
                            </th>

                            <th scope="col" class="px-6 py-3">
                                <div class="relative z-0 w-full mb-5 group">
                                    <x-text-input :property_name="'search_department_departmentNumber'" :type="'text'" />
                                    <x-label :for="'search_department_departmentNumber'" :text="texts_settings()->departmentNumber" />
                                    @error('search_department_departmentNumber')
                                        <x-input-error :messages="$message" class="mt-2" />
                                    @enderror
                                </div>
                            </th>

                            <th scope="col" class="px-6 py-3">
                                <div class="relative z-0 w-full mb-5 group">
                                    <x-text-input :property_name="'search_department_departmentNumber2'" :type="'text'" />
                                    <x-label :for="'search_department_departmentNumber2'" :text="texts_settings()->departmentNumber2" />
                                    @error('search_department_departmentNumber2')
                                        <x-input-error :messages="$message" class="mt-2" />
                                    @enderror
                                </div>
                            </th>

                            <th scope="col" class="px-6 py-3">
                                <div class="relative z-0 w-full mb-5 group">
                                    <x-select :property_name="'search_department_status_id'" :select="true" :select_value="'Összes'"
                                        :data="$this->statuses" />
                                    <x-label :for="'search_department_status_id'" :text="'Státusz'" />
                                    @error('search_department_status_id')
                                        <x-input-error :messages="$message" class="mt-2" />
                                    @enderror
                                </div>
                            </th>

                            <th scope="col" class="px-6 py-3">
                                <div class="relative z-0 w-full mb-5 group">
                                    <x-select :property_name="'search_department_location_id'" :select="true" :select_value="'Összes'"
                                        :data="$this->locations" />
                                    <x-label :for="'search_department_location_id'" :text="'Helyszín'" />
                                    @error('search_department_location_id')
                                        <x-input-error :messages="$message" class="mt-2" />
                                    @enderror
                                </div>
                            </th>

                            <th scope="col" class="px-6 py-3 text-right">
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
                                    @click="show_update_department_field = !show_update_department_field; update_department_id = {{ $department->id }}"
                                    class="font-medium text-orange-600 dark:text-orange-500 underline hover:no-underline">Szerkesztés</button>
                            </td>
                        </tr>
                    @endforeach

                </tbody>
            </table>
        </div>
        {{ $departments->links(data: ['scrollTo' => false]) }}
    </div>

    {{-- department modal --}}
    <livewire:admin.components.department-form-panel :$statuses :$locations />
</div>
