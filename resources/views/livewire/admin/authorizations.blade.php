<div x-data="{
    show_store_column_field: false,
    show_store_authorization_field: false,
    show_add_sub_authorization_field: false,
    show_update_column_field: false,
    show_update_authorization_field: false,
    show_edit_sub_authorization_field: false
}">
    <x-submenu :title="'Jogosultságok'">
        <x-submenu-button :text="'Oszlop hozzáadás'" :properti_to_change="'show_store_column_field'" />
        <x-submenu-button :text="'Jogosultság hozzáadás'" :properti_to_change="'show_store_authorization_field'" />
        <x-submenu-button :text="'Aljogosultság hozzáadás'" :properti_to_change="'show_add_sub_authorization_field'" />
    </x-submenu>

    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 mt-6">
        @error('error')
            <div class="py-4">
                <x-input-error :messages="$message" class="mt" />
            </div>
        @enderror
        <div class="flex flex-wrap gap-2">
            {{-- start of tables --}}
            @foreach ($columns as $column)
                <div class="relative overflow-x-auto break-words shadow-md rounded-lg">
                    <table
                        class="text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400 bg-white dark:bg-gray-800">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                            <tr>
                                <th colspan="2" class="px-6 py-3">
                                    {{ $column->displayName }}
                                </th>
                                <th
                                    class="px-6 py-3 {{ $column->status->name == 'active' ? 'text-green-600 dark:text-green-500' : 'text-red-600 dark:text-red-500' }}">
                                    {{ $column->status->displayName }}
                                </th>
                                <th>
                                    <button
                                        @click="show_update_column_field = !show_update_column_field; update_column_id = {{ $column->id }}"
                                        class="font-medium text-orange-600 dark:text-orange-500 underline hover:no-underline">Oszlop
                                        szerkesztése</button>
                                </th>
                            </tr>
                            <tr>
                                <th scope="col" class="px-6 py-3">

                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Elnevezés
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Státusz
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Műveletek
                                </th>
                            </tr>
                        </thead>
                        <tbody x-sort="handle" x-sort:group="column-{{ $column->id }}-authItems"
                            x-data="{ handle: (item, position) => { $wire.call('save_order', item, position) } }">
                            @foreach ($column->auth_items as $auth_item)
                                <tr x-sort:item="{{ $auth_item->id }}"
                                    class="border-b dark:border-gray-700 border-gray-200">
                                    <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                        {{ $auth_item->position }}
                                    </td>
                                    @if (count($auth_item?->sub_auth_items) > 0)
                                        <td colspan="2" class="w-full h-full">
                                            <div class="flex items-center justify-center w-full h-full">
                                                <div class="grid grid-cols-2 items-center text-center w-full h-full">
                                                    <div class="w-full text-left">
                                                        {{ $auth_item->displayName }}
                                                    </div>
                                                    <div
                                                        class="w-full px-6 py-4 text-green-600 dark:text-green-500 text-right">
                                                        {{ $auth_item->status->displayName }}
                                                    </div>
                                                    <div class="py-2 col-span-2 flex flex-wrap justify-center gap-2">
                                                        @foreach ($auth_item->sub_auth_items as $sub_auth_item)
                                                            <button
                                                                @click="show_edit_sub_authorization_field = !show_edit_sub_authorization_field; edit_sub_authorization_id = {{ $sub_auth_item->id }}"
                                                                class="font-medium {{ $sub_auth_item->status->name == 'active' ? 'text-green-600 dark:text-green-500' : 'text-red-600 dark:text-red-500' }}  underline hover:no-underline cursor-pointer">{{ $sub_auth_item->displayName }}</button>
                                                        @endforeach
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                    @else
                                        <td class="w-full text-left">
                                            {{ $auth_item->displayName }}
                                        </td>
                                        <td
                                            class="px-6 py-4 {{ $auth_item->status->name == 'active' ? 'text-green-600 dark:text-green-500' : 'text-red-600 dark:text-red-500' }} text-right">
                                            {{ $auth_item->status->displayName }}
                                        </td>
                                    @endif
                                    <td class="px-6 py-4">
                                        <button
                                            @click="show_update_authorization_field = !show_update_authorization_field; update_authorization_id = {{ $auth_item->id }}"
                                            class="font-medium text-orange-600 dark:text-orange-500 underline hover:no-underline">Szerkesztés</button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endforeach
        </div>
    </div>

    {{-- Column modal --}}
    <livewire:admin.components.column-form-panel :$statuses />

    {{-- Authorization modals --}}
    <livewire:admin.components.authorization-form-panel :$statuses :$columns />

    {{-- Sub authorization modals --}}
    <livewire:admin.components.create-sub-authorization :$statuses :$authorizations />
    <livewire:admin.components.edit-sub-authorization :$statuses :$authorizations />

</div>
