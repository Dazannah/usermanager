<div x-data="{
    show_add_column_field: false,
    show_add_authorization_field: false,
    show_add_sub_authorization_field: false,
    show_edit_column_field: false,
    edit_column_id: 0
}">

    {{-- Sub menus for creating items --}}
    <header class="bg-white dark:bg-gray-800 shadow py-6">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Jogosultságok') }}
            </h2>
            <button @click="show_add_column_field = !show_add_column_field"
                class="inline-flex items-center px-1 pt-1 border-b-2 border-transparent text-sm font-medium leading-5 text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300 hover:border-indigo-700 dark:hover:border-indigo-700 focus:outline-none focus:border-indigo-700 focus:text-gray-900 focus:dark:text-gray-100 transition duration-150 ease-in-out">
                Oszlop hozzáadás
            </button>
            <button @click="show_add_authorization_field = !show_add_authorization_field"
                class="inline-flex items-center px-1 pt-1 border-b-2 border-transparent text-sm font-medium leading-5 text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300 hover:border-indigo-700 dark:hover:border-indigo-700 focus:outline-none focus:border-indigo-700 focus:text-gray-900 focus:dark:text-gray-100 transition duration-150 ease-in-out">
                Jogosultság hozzáadás
            </button>
            <button @click="show_add_sub_authorization_field = !show_add_sub_authorization_field"
                class="inline-flex items-center px-1 pt-1 border-b-2 border-transparent text-sm font-medium leading-5 text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300 hover:border-indigo-700 dark:hover:border-indigo-700 focus:outline-none focus:border-indigo-700 focus:text-gray-900 focus:dark:text-gray-100 transition duration-150 ease-in-out">
                Aljogosultság hozzáadás
            </button>
        </div>
    </header>

    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 mt-6">
        @error('error')
            <div class="py-4">
                <x-input-error :messages="$message" class="mt" />
            </div>
        @enderror
        <div class="flex flex-wrap gap-2">
            {{-- start of tables --}}
            @foreach ($columns as $column)
                <div class="w-2/5 mx-auto break-words">
                    <table
                        class="text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400 bg-white  dark:bg-gray-800 rounded-t-md">
                        <thead
                            class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400 rounded-t-md">
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
                                        @click="show_edit_column_field = !show_edit_column_field; edit_column_id = {{ $column->id }}"
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
                                                    <div class="py-2 col-span-2 flex flex-wrap justify-center gap-1">

                                                        @foreach ($auth_item->sub_auth_items as $sub_auth_item)
                                                            <span
                                                                class="font-medium {{ $sub_auth_item->status->name == 'active' ? 'text-green-600 dark:text-green-500' : 'text-red-600 dark:text-red-500' }}  underline hover:no-underline cursor-pointer">{{ $sub_auth_item->displayName }}</span>
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
                                        <a href="#"
                                            class="font-medium text-orange-600 dark:text-orange-500 underline hover:no-underline">Szerkesztés</a>
                                        <a href="#"
                                            class="font-medium text-red-600 dark:text-red-500 underline hover:no-underline">Törlés</a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endforeach
        </div>
    </div>

    {{-- Column modals --}}
    <livewire:admin.components.create-column :$statuses />
    <livewire:admin.components.edit-column :$statuses />

    {{-- Authorization modals --}}
    <livewire:admin.components.create-authorization :$statuses :$columns />

    {{-- Sub authorization modals --}}
    <livewire:admin.components.create-sub-authorization :$statuses :$authorizations />


</div>
