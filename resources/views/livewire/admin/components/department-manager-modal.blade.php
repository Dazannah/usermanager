<div x-data="{ show: false, show_create_department_manager: false }" x-init="$watch('show_manage_department_manager', value => {
    show = value
});

$watch('show', value => {
    if (!value) {
        show_manage_department_manager = value
    }
});">
    <x-modal :name="'DepartmentManagerModal'">
        <x-submenu :title="'Osztályvezetők'">
            <x-submenu-button :text="'Osztályvezető hozzáadás'" :properti_to_change="'show_create_department_manager'" />
        </x-submenu>

        @error('error')
            <div class="py-4">
                <x-input-error :messages="$message" class="mt" />
            </div>
        @enderror

        <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
            <table class="w-full table-auto text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                    <form action="filter_department_manager">
                        <tr>
                            <th scope="col" class="px-6 py-3">
                                <div class="relative z-0 w-full mb-5 group">
                                    <x-text-input :property_name="'search_department_manager_displayName'" :type="'text'" />
                                    <x-label :for="'search_department_manager_displayName'" :text="'Név'" />
                                    @error('search_department_manager_displayName')
                                        <x-input-error :messages="$message" class="mt-2" />
                                    @enderror
                                </div>
                            </th>

                            <th scope="col" class="px-6 py-3">
                                <div class="relative z-0 w-full mb-5 group">
                                    <x-text-input :property_name="'search_department_manager_registration_number'" :type="'text'" />
                                    <x-label :for="'search_department_manager_registration_number'" :text="'Nyilvátartási szám'" />
                                    @error('search_department_manager_registration_number')
                                        <x-input-error :messages="$message" class="mt-2" />
                                    @enderror
                                </div>
                            </th>

                            <th scope="col" class="px-6 py-3">
                                <div class="relative z-0 w-full mb-5 group">
                                    <x-text-input :property_name="'search_department_manager_note'" :type="'text'" />
                                    <x-label :for="'search_department_manager_note'" :text="'Megjegyzés'" />
                                    @error('search_department_manager_note')
                                        <x-input-error :messages="$message" class="mt-2" />
                                    @enderror
                                </div>
                            </th>

                            <th scope="col" class="px-6 py-3 text-right">
                                <x-primary-button
                                    @click.prevent="$dispatch('department_manager_filter_reset')">{{ __('Visszaállítás') }}
                                </x-primary-button>
                            </th>
                        </tr>
                    </form>
                </thead>
                <tbody>
                    <tr>
                        <th colspan="4">
                            <div class="grid place-items-center">
                                <x-action-message wire:loading class="m-3" on="filter_department_managers">
                                    <x-loading />
                                </x-action-message>
                            </div>
                        </th>
                    </tr>
                </tbody>
                <tbody wire:loading.class="hidden">
                    @foreach ($department_managers as $department_manager)
                        <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 border-gray-200">
                            <th scope="row"
                                class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                {{ $department_manager->worker->name }}
                            </th>
                            <th scope="row"
                                class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                {{ $department_manager->worker->registration_number }}
                            </th>
                            <th scope="row"
                                class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                {{ $department_manager->note }}
                            </th>
                            <td class="px-6 py-4 text-right">
                                <button
                                    @click="show_update_department_manager = !show_update_department_manager; update_department_manager_id = {{ $department_manager->id }}"
                                    class="font-medium text-orange-600 dark:text-orange-500 underline hover:no-underline">Szerkesztés</button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="p-2">
                {{ $department_managers->withQueryString()->links() }}
            </div>
        </div>
    </x-modal>
</div>
