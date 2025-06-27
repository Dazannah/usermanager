<div x-data="{
    show_edit_request_field: false,
}">
    <x-submenu :title="'Kérelmek'">
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
                                    <x-text-input :property_name="'name'" :type="'text'" />
                                    <x-label :for="'name'" :text="'Név'" />
                                    @error('name')
                                        <x-input-error :messages="$message" class="mt-2" />
                                    @enderror
                                </div>
                            </th>

                            <th scope="col" class="px-6 py-3 whitespace-nowrap">
                                <div class="relative z-0 w-full mb-5 group">
                                    <x-checkbox :property_name="'is_technical'" :text="'Technikai'" />
                                    @error('is_technical')
                                        <x-input-error :messages="$message" class="mt-2" />
                                    @enderror
                                </div>
                            </th>

                            <th scope="col" class="px-6 py-3">
                                <div class="relative z-0 w-full mb-5 group">
                                    <x-select :property_name="'department_id'" :select="true" :select_value="'Összes'"
                                        :data="$this->departments" />
                                    <x-label :for="'department_id'" :text="'Osztály'" />
                                    @error('department_id')
                                        <x-input-error :messages="$message" class="mt-2" />
                                    @enderror
                                </div>
                            </th>

                            <th scope="col" class="px-6 py-3">
                                <div class="relative z-0 w-full mb-5 group">
                                    <x-select :property_name="'worker_request_process_id'" :select="true" :select_value="'Összes'"
                                        :data="$this->process" />
                                    <x-label :for="'worker_request_process_id'" :text="'Művelet'" />
                                    @error('worker_request_process_id')
                                        <x-input-error :messages="$message" class="mt-2" />
                                    @enderror
                                </div>
                            </th>

                            <th scope="col" class="px-6 py-3">
                                <div class="relative z-0 w-full mb-5 group">
                                    <x-select :property_name="'worker_request_status_id'" :select="true" :select_value="'Összes'"
                                        :data="$this->statuses" />
                                    <x-label :for="'worker_request_status_id'" :text="'Státusz'" />
                                    @error('worker_request_status_id')
                                        <x-input-error :messages="$message" class="mt-2" />
                                    @enderror
                                </div>
                            </th>

                            <th scope="col" class="px-6 py-3">
                                <div class="relative z-0 w-full mb-5 group">
                                    <x-text-input :property_name="'requester'" :type="'text'" />
                                    <x-label :for="'requester'" :text="'Igénylő'" />
                                    @error('requester')
                                        <x-input-error :messages="$message" class="mt-2" />
                                    @enderror
                                </div>
                            </th>

                            <th scope="col" class="px-6 py-3 text-right">
                                <x-primary-button
                                    @click.prevent="$dispatch('requests_filter_reset')">{{ __('Visszaállítás') }}
                                </x-primary-button>
                            </th>
                        </tr>
                    </form>
                </thead>
                <tbody>
                    @foreach ($requests as $request)
                        <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 border-gray-200">
                            <th scope="row"
                                class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                {{ $request->name }}
                            </th>
                            <th scope="row"
                                class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                @if ($request->is_technical)
                                    &#10003
                                @endif
                            </th>
                            <th scope="row"
                                class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                @foreach ($request->departments as $department)
                                    {{ $department->displayName }} </br>
                                @endforeach
                            </th>
                            <th scope="row"
                                class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                {{ $request->process->displayName }}
                            </th>
                            <td class="px-6 py-4">
                                {{ $request->status->displayName }}
                            </td>
                            <td class="px-6 py-4">
                                {{ $request->requester->name }}
                            </td>
                            <td class="px-6 py-4 text-right">
                                <button
                                    @click="show_edit_request_field = !show_edit_request_field; update_request_id = {{ $request->id }}"
                                    class="font-medium text-orange-600 dark:text-orange-500 underline hover:no-underline">Szerkesztés</button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        {{ $requests->links() }}
    </div>

    {{-- location modal --}}
    <livewire:admin.components.worker-request-form-panel-modal :$departments :$columns />
</div>
