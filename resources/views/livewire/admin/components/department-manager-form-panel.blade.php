<div x-data="{ show: false, method_name: '', modal_title: '' }" x-init="$watch('show_update_department_manager_field', value => {
    show = value
    method_name = 'update_department_manager'
    modal_title = 'Osztályvezető szerkesztése'

    if (value) $dispatch('update_department_manager_id', [update_department_manager_id])
});
$watch('show_create_department_manager_field', value => {
    show = value
    method_name = 'create_department_manager'
    modal_title = 'Osztályvezető hozzáadása'

    if (value) $dispatch('show_store_department_manager')
});
$watch('show', value => {
    if (!value) {
        show_update_department_manager_field = value
        show_create_department_manager_field = value
    }
});
window.addEventListener('department_manager_delete_success', () => {
    show = false
});">
    <x-modal :name="'DepartmentManagerFormPanelModal'">
        <form wire:submit.prevent="method_name">
            <div class="sm:flex sm:items-start">
                <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                    <h3 class="text-base font-semibold text-gray-500 dark:text-gray-400" id="modal-title"
                        x-text="modal_title">
                    </h3>
                    <div class="mt-2">
                        <div class="grid grid-cols-4 gap-6">
                            <div class="relative z-0 w-full mb-5 group">
                                <x-text-input :property_name="'form.worker_name'" :type="'text'" disabled />
                                <x-label :for="'form.worker_name'" :text="'Dolgozó neve'" />
                                @error('form.worker_name')
                                    <x-input-error :messages="$message" class="mt-2" />
                                @enderror
                                @error('form.worker_id')
                                    <x-input-error :messages="$message" class="mt-2" />
                                @enderror
                            </div>

                            <div class="relative z-0 w-full mb-5 group">
                                <x-text-input :property_name="'form.registration_number'" :type="'text'" disabled />
                                <x-label :for="'form.registration_number'" :text="'Nyilv. szám'" />
                                @error('form.registration_number')
                                    <x-input-error :messages="$message" class="mt-2" />
                                @enderror
                            </div>

                            <div x-show="false" class="relative z-0 w-full mb-5 group">
                                <x-text-input :property_name="'form.worker_id'" :type="'number'" />
                            </div>

                            <div class="relative z-0 w-full mb-5 group">
                                <x-select :property_name="'form.status_id'" :data="$this->statuses" />
                                <x-label :for="'form.status_id'" :text="'Státusz'" />
                                @error('form.status_id')
                                    <x-input-error :messages="$message" class="mt-2" />
                                @enderror
                            </div>

                            <div x-show="show_update_department_manager_field" x-data="{ showConfirmDelete: false }"
                                class="relative z-0 w-full mb-5 group">
                                <x-danger-button @click.prevent="showConfirmDelete = true">
                                    {{ __('Törlés') }}
                                </x-danger-button>
                                <div x-show="showConfirmDelete">
                                    <x-modal :name="'Osztályvezető törlése'">
                                        <div class="m-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                                            <h3 class="text-base font-semibold text-gray-500 dark:text-gray-400"
                                                id="modal-title">
                                                Biztosan törlöd?
                                            </h3>
                                            <x-success-button
                                                @click.prevent="showConfirmDelete = false">Mégse</x-success-button>
                                            <x-danger-button
                                                @click.prevent="$wire.delete_department_manager(); showConfirmDelete = false">Igen,
                                                törlöm</x-danger-button>
                                        </div>
                                    </x-modal>
                                </div>
                                @error('delete_department_manager')
                                    <x-input-error :messages="$message" class="mt-2" />
                                @enderror
                            </div>

                            <div x-data="{ worker_search: false }" class="col-span-4 relative z-0 w-full mb-5 group">
                                <div x-show="show_create_department_manager_field" class="col-span-4 pt-2">
                                    <div class="col-span-4 overflow-x-auto sm:rounded-lg">
                                        <h3 class="text-base font-semibold text-gray-500 dark:text-gray-400"
                                            id="modal-title" x-text="'Dolgozó keresés'">
                                        </h3>
                                        <table
                                            class="w-full table-auto text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                                            <thead
                                                class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                                <form>
                                                    <tr>
                                                        <th scope="col" class="px-6 py-3">
                                                            <div class="relative z-0 w-full mb-5 group">
                                                                <x-text-input id="input-group-search" :property_name="'worker_name_search'"
                                                                    :type="'text'" />
                                                                <x-label :for="'worker_name_search'" :text="'Dolgozó neve'" />
                                                                @error('worker_name_search')
                                                                    <x-input-error :messages="$message" class="mt-2" />
                                                                @enderror
                                                            </div>
                                                        </th>

                                                        <th scope="col" class="px-6 py-3">
                                                            <div class="relative z-0 w-full mb-5 group">
                                                                <x-text-input id="input-group-search" :property_name="'registration_number_search'"
                                                                    :type="'text'" />
                                                                <x-label :for="'registration_number_search'" :text="'Nyilv. szám'" />
                                                                @error('registration_number_search')
                                                                    <x-input-error :messages="$message" class="mt-2" />
                                                                @enderror
                                                            </div>
                                                        </th>

                                                        <th scope="col" class="px-6 py-3 text-right">
                                                            <x-primary-button
                                                                @click.prevent="$dispatch('worker_filter_reset')">{{ __('Visszaállítás') }}
                                                            </x-primary-button>
                                                        </th>
                                                    </tr>
                                                </form>
                                            </thead>
                                            <tbody>
                                                @foreach ($workers as $worker)
                                                    <tr class="hover:bg-gray-100 hover:cursor-pointer"
                                                        wire:click.prevent="set_worker({{ $worker->id }})"
                                                        class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 border-gray-200">
                                                        <th scope="row"
                                                            class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                                            {{ $worker->name }}
                                                        </th>
                                                        <th scope="row" colspan="2"
                                                            class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                                            {{ $worker->registration_number }}
                                                        </th>

                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                    {{ $workers->links(data: ['scrollTo' => false]) }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="bg-gray-100 dark:bg-gray-600 px-4 py-3 sm:flex sm:flex-row-reverse sm:px-6 items-center">
                <x-danger-button
                    @click.prevent="show_update_department_manager_field = false; show_create_department_manager_field = false">
                    {{ __('Bezárás') }}
                </x-danger-button>

                <x-success-button wire:loading.remove @click.prevent="$wire[method_name]()" class="me-3">
                    {{ __('Mentés') }}
                </x-success-button>

                <x-action-message wire:loading class="me-3" on="update_department_manager">
                    <x-loading />
                </x-action-message>

                <x-action-message-success class="me-3" on="department_manager_save_success">
                    {{ __('Sikeres mentés') }}
                </x-action-message-success>

                <x-action-message-success class="me-3" on="department_manager_delete_success">
                    {{ __('Sikeres törlés') }}
                </x-action-message-success>

                @error('department_manager_delete_error')
                    <div class="me-3">
                        <x-input-error :messages="$message" />
                    </div>
                @enderror
            </div>
        </form>
    </x-modal>
</div>
