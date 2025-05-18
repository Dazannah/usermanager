<div x-data="{
    show_add_column_field: false,
    show_add_authorization_field: false,
    show_add_sub_authorization_field: false
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
                                <th colspan="3" class="px-6 py-3">
                                    {{ $column->displayName }}
                                </th>
                                <th>
                                    <a href="#"
                                        class="font-medium text-orange-600 dark:text-orange-500 underline hover:no-underline">Oszlop
                                        szerkesztése</a>
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

    {{-- Create column modal --}}

    <div x-data="{ show: false }" x-init="$watch('show_add_column_field', value => show = value);
    $watch('show', value => show_add_column_field = value)">
        <x-modal :name="'Jogosultság hozzáadás'">
            <form wire:submit.prevent="save_column">
                <div class="sm:flex sm:items-start">
                    <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                        <h3 class="text-base font-semibold text-gray-500 dark:text-gray-400" id="modal-title">
                            Oszlop hozzáadás
                        </h3>
                        <div class="mt-2">
                            <div class="grid grid-cols-2 gap-6">
                                <div class="relative z-0 w-full mb-5 group">
                                    <input wire:model="column_display_name" type="text" name="column_display_name"
                                        id="column_display_name"
                                        class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer"
                                        placeholder=" " />
                                    <label for="column_display_name"
                                        class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">
                                        Elnevezés
                                    </label>
                                    @error('column_display_name')
                                        <x-input-error :messages="$message" class="mt-2" />
                                    @enderror
                                </div>
                                <div class="relative z-0 w-full mb-5 group">
                                    <select wire:model="column_status_id" type="select" name="column_status_id"
                                        id="column_status_id"
                                        class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer"
                                        placeholder=" ">
                                        @foreach ($this->statuses as $status)
                                            <x-option
                                                value="{{ $status->id }}">{{ $status->displayName }}</x-option>
                                        @endforeach
                                    </select>
                                    <label for="column_status_id"
                                        class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">
                                        Státusz
                                    </label>
                                    @error('column_status_id')
                                        <x-input-error :messages="$message" class="mt-2" />
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-100 dark:bg-gray-600 px-4 py-3 sm:flex sm:flex-row-reverse sm:px-6 items-center">
                    <x-danger-button
                        @click.prevent="show_add_column_field = !show_add_column_field">{{ __('Bezárás') }}
                    </x-danger-button>

                    <x-success-button class="me-3">
                        {{ __('Mentés') }}
                    </x-success-button>

                    <x-action-message wire:loading class="me-3" on="save_column">
                        {{ __('Betöltés') }}
                    </x-action-message>

                    <x-action-message-success class="me-3" on="columns_save_success">
                        {{ __('Sikeres mentés') }}
                    </x-action-message-success>

                    @error('save_column_error')
                        <div class="me-3">
                            <x-input-error :messages="$message" />
                        </div>
                    @enderror
                </div>
            </form>
        </x-modal>
    </div>

    {{-- Create authorization modal --}}
    <div x-data="{ show: false }" x-init="$watch('show_add_authorization_field', value => show = value);
    $watch('show', value => show_add_authorization_field = value)">
        <x-modal :name="'Jogosultság hozzáadás'">
            <form wire:submit.prevent="save_authorization">
                <div class="sm:flex sm:items-start">
                    <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                        <h3 class="text-base font-semibold text-gray-500 dark:text-gray-400" id="modal-title">
                            Jogosultság hozzáadás
                        </h3>
                        <div class="mt-2">
                            <div class="grid grid-cols-3 gap-6">
                                <div class="relative z-0 w-full mb-5 group">
                                    <input wire:model="authorization_display_name" type="text"
                                        name="authorization_display_name" id="authorization_display_name"
                                        class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer"
                                        placeholder=" " />
                                    <label for="authorization_display_name"
                                        class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">
                                        Elnevezés
                                    </label>
                                    @error('authorization_display_name')
                                        <x-input-error :messages="$message" class="mt-2" />
                                    @enderror
                                </div>
                                <div class="relative z-0 w-full mb-5 group">
                                    <select wire:model="authorization_column_id" type="select"
                                        name="authorization_column_id" id="authorization_column_id"
                                        class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer"
                                        placeholder=" ">
                                        <x-option>Válassz egy oszlopot</x-option>
                                        @foreach ($this->columns as $column)
                                            <x-option
                                                value="{{ $column->id }}">{{ $column->displayName }}</x-option>
                                        @endforeach
                                    </select>
                                    </select>
                                    <label for="authorization_column_id"
                                        class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">
                                        Oszlop
                                    </label>
                                    @error('authorization_column_id')
                                        <x-input-error :messages="$message" class="mt-2" />
                                    @enderror
                                </div>
                                <div class="relative z-0 w-full mb-5 group">
                                    <select wire:model="authorization_status_id" type="select"
                                        name="authorization_status_id" id="authorization_status_id"
                                        class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer"
                                        placeholder=" ">
                                        @foreach ($this->statuses as $status)
                                            <x-option
                                                value="{{ $status->id }}">{{ $status->displayName }}</x-option>
                                        @endforeach
                                    </select>
                                    <label for="authorization_status_id"
                                        class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">
                                        Státusz
                                    </label>
                                    @error('authorization_status_id')
                                        <x-input-error :messages="$message" class="mt-2" />
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-100 dark:bg-gray-600 px-4 py-3 sm:flex sm:flex-row-reverse sm:px-6 items-center">
                    <x-danger-button
                        @click.prevent="show_add_authorization_field = !show_add_authorization_field">{{ __('Bezárás') }}
                    </x-danger-button>

                    <x-success-button class="me-3">
                        {{ __('Mentés') }}
                    </x-success-button>

                    <x-action-message wire:loading class="me-3" on="save_authorization">
                        {{ __('Betöltés') }}
                    </x-action-message>

                    <x-action-message-success class="me-3" on="authorization_save_success">
                        {{ __('Sikeres mentés') }}
                    </x-action-message-success>

                    @error('save_authorization_error')
                        <div class="me-3">
                            <x-input-error :messages="$message" />
                        </div>
                    @enderror
                </div>
            </form>
        </x-modal>
    </div>

    {{-- Create sub authorization modal --}}
    <div x-data="{ show: false }" x-init="$watch('show_add_sub_authorization_field', value => show = value);
    $watch('show', value => show_add_sub_authorization_field = value)">
        <x-modal :name="'Jogosultság hozzáadás'">

            <form wire:submit.prevent="save_sub_authorization">
                <div class="sm:flex sm:items-start">
                    <div class="mt-3 py-2 text-center sm:mt-0 sm:ml-4 sm:text-left">
                        <h3 class="text-base font-semibold text-gray-500 dark:text-gray-400" id="modal-title">
                            Aljogosultság hozzáadás
                        </h3>
                        <div class="mt-2">
                            <div class="grid grid-cols-3 gap-6">
                                <div class="relative z-0 w-full mb-5 group">
                                    <input wire:model="sub_auth_item_display_name" type="text"
                                        name="sub_auth_item_display_name" id="sub_auth_item_display_name"
                                        class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer"
                                        placeholder=" " />
                                    <label for="sub_auth_item_display_name"
                                        class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">
                                        Elnevezés
                                    </label>
                                    @error('sub_auth_item_display_name')
                                        <x-input-error :messages="$message" class="mt-2" />
                                    @enderror
                                </div>
                                <div class="relative z-0 w-full mb-5 group">
                                    <select wire:model="sub_auth_item_authItem_Id" type="select"
                                        name="sub_auth_item_authItem_Id" id="sub_auth_item_authItem_Id"
                                        class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer"
                                        placeholder=" ">
                                        <x-option>Válassz egy jogosultságot</x-option>
                                        @foreach ($this->authorizations as $authorization)
                                            <x-option
                                                value="{{ $authorization->id }}">{{ $authorization->displayName }}</x-option>
                                        @endforeach
                                    </select>
                                    <label for="sub_auth_item_authItem_Id"
                                        class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">
                                        Jogosultság
                                    </label>
                                    @error('sub_auth_item_authItem_Id')
                                        <x-input-error :messages="$message" class="mt-2" />
                                    @enderror
                                </div>
                                <div class="relative z-0 w-full mb-5 group">
                                    <select wire:model="sub_auth_item_status_id" type="select"
                                        name="sub_auth_item_status_id" id="sub_auth_item_status_id"
                                        class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer"
                                        placeholder=" ">
                                        @foreach ($this->statuses as $status)
                                            <x-option
                                                value="{{ $status->id }}">{{ $status->displayName }}</x-option>
                                        @endforeach
                                    </select>
                                    <label for="sub_auth_item_status_id"
                                        class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">
                                        Státusz
                                    </label>
                                    @error('sub_auth_item_status_id')
                                        <x-input-error :messages="$message" class="mt-2" />
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-100 dark:bg-gray-600 px-4 py-3 sm:flex sm:flex-row-reverse sm:px-6 items-center">
                    <x-danger-button
                        @click.prevent="show_add_sub_authorization_field = !show_add_sub_authorization_field">{{ __('Bezárás') }}
                    </x-danger-button>

                    <x-success-button class="me-3">
                        {{ __('Mentés') }}
                    </x-success-button>

                    <x-action-message wire:loading class="me-3" on="save_sub_authorization">
                        {{ __('Betöltés') }}
                    </x-action-message>

                    <x-action-message-success class="me-3" on="sub_authitem_save_success">
                        {{ __('Sikeres mentés') }}
                    </x-action-message-success>

                    @error('save_sub_authorization_error')
                        <div class="me-3">
                            <x-input-error :messages="$message" />
                        </div>
                    @enderror
                </div>
            </form>
        </x-modal>
    </div>
</div>
