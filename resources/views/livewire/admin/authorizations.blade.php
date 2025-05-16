<div x-data="{
    show_add_column_field: false,
    show_add_authorization_field: false,
    show_add_sub_authorization_field: false
}">

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
        <div class="flex flex-wrap gap-2">
            <div class="w-2/5 mx-auto break-words">
                <table class="text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                        <tr>
                            <th colspan="3" class="px-6 py-3">
                                Oszlop név
                            </th>
                            <th>
                                <a href="#"
                                    class="font-medium text-orange-600 dark:text-orange-500 hover:underline">Oszlop
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
                    <tbody>
                        <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 border-gray-200">
                            <th scope="row"
                                class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                1
                            </th>
                            <td class="px-6 py-4">
                                Pc hozzáférés asdasd aa asda asd asd lkdaskjadskljsad kjlasdkljasdklj kjklj
                            </td>
                            <td class="px-6 py-4 text-green-600 dark:text-green-500">
                                Aktív
                            </td>
                            <td class="px-6 py-4">
                                <a href="#"
                                    class="font-medium text-orange-600 dark:text-orange-500 hover:underline">Szerkesztés</a>
                                <a href="#"
                                    class="font-medium text-red-600 dark:text-red-500 hover:underline">Törlés</a>
                            </td>
                        </tr>
                        <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 border-gray-200">
                            <th rowspan="2" scope="row"
                                class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                2
                            </th>
                            <td class="px-6 py-4">
                                E-mail
                            </td>
                            <td class="px-6 py-4 text-green-600 dark:text-green-500">
                                Aktív
                            </td>
                            <td rowspan="2" class="px-6 py-4">
                                <a href="#"
                                    class="font-medium text-orange-600 dark:text-orange-500 hover:underline">Szerkesztés</a>
                                <a href="#"
                                    class="font-medium text-red-600 dark:text-red-500 hover:underline">Törlés</a>
                            </td>
                        </tr>
                        <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 border-gray-200">
                            <td colspan="2" class="px-6 py-4">
                                <div>

                                </div>
                                <div>
                                    <span
                                        class="font-medium text-green-600 dark:text-green-500 hover:underline hover:cursor-pointer">Normál</span>
                                    <span
                                        class="font-medium text-green-600 dark:text-green-500 hover:underline hover:cursor-pointer">Admin</span>
                                    <span
                                        class="font-medium text-red-600 dark:text-red-500 hover:underline hover:cursor-pointer">Dummy</span>
                                </div>

                            </td>
                        </tr>
                        <tr class="bg-white dark:bg-gray-800">
                            <th scope="row"
                                class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                3
                            </th>
                            <td class="px-6 py-4">
                                FTP
                            </td>
                            <td class="px-6 py-4 text-red-600 dark:text-red-500">
                                Inkatív
                            </td>
                            <td class="px-6 py-4">
                                <a href="#"
                                    class="font-medium text-orange-600 dark:text-orange-500 hover:underline">Szerkesztés</a>
                                <a href="#"
                                    class="font-medium text-red-600 dark:text-red-500 hover:underline">Törlés</a>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="w-2/5 mx-auto break-words rounded-lg">
                <table class="text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                        <tr>
                            <th colspan="3" class="px-6 py-3">
                                Oszlop név 2
                            </th>
                            <th>
                                <a href="#"
                                    class="font-medium text-orange-600 dark:text-orange-500 hover:underline">Oszlop
                                    szerkesztése</a>
                            </th>
                        </tr>
                        <tr>
                            <th scope="col" class="px-6 py-3">
                                Sorszám
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
                    <tbody>
                        <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 border-gray-200">
                            <th scope="row"
                                class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                1
                            </th>
                            <td class="px-6 py-4">
                                Pc hozzáférés
                            </td>
                            <td class="px-6 py-4 text-green-600 dark:text-green-500">
                                Aktív
                            </td>
                            <td class="px-6 py-4">
                                <a href="#"
                                    class="font-medium text-orange-600 dark:text-orange-500 hover:underline">Szerkesztés</a>
                                <a href="#"
                                    class="font-medium text-red-600 dark:text-red-500 hover:underline">Törlés</a>
                            </td>
                        </tr>
                        <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 border-gray-200">
                            <th scope="row"
                                class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                2
                            </th>
                            <td class="px-6 py-4">
                                E-mail
                            </td>
                            <td class="px-6 py-4 text-green-600 dark:text-green-500">
                                Aktív
                            </td>
                            <td class="px-6 py-4">
                                <a href="#"
                                    class="font-medium text-orange-600 dark:text-orange-500 hover:underline">Szerkesztés</a>
                                <a href="#"
                                    class="font-medium text-red-600 dark:text-red-500 hover:underline">Törlés</a>
                            </td>
                        </tr>
                        <tr class="bg-white dark:bg-gray-800">
                            <th scope="row"
                                class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                3
                            </th>
                            <td class="px-6 py-4">
                                FTP
                            </td>
                            <td class="px-6 py-4 text-red-600 dark:text-red-500">
                                Inkatív
                            </td>
                            <td class="px-6 py-4">
                                <a href="#"
                                    class="font-medium text-orange-600 dark:text-orange-500 hover:underline">Szerkesztés</a>
                                <a href="#"
                                    class="font-medium text-red-600 dark:text-red-500 hover:underline">Törlés</a>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="w-2/5 mt-1 mx-auto break-words rounded-lg">
                <table class="text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                        <tr>
                            <th colspan="3" class="px-6 py-3">
                                Oszlop név 3
                            </th>
                            <th>
                                <a href="#"
                                    class="font-medium text-orange-600 dark:text-orange-500 hover:underline">Oszlop
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
                    <tbody>
                        <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 border-gray-200">
                            <th scope="row"
                                class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                1
                            </th>
                            <td class="px-6 py-4">
                                Pc hozzáférés
                            </td>
                            <td class="px-6 py-4 text-green-600 dark:text-green-500">
                                Aktív
                            </td>
                            <td class="px-6 py-4">
                                <a href="#"
                                    class="font-medium text-orange-600 dark:text-orange-500 hover:underline">Szerkesztés</a>
                                <a href="#"
                                    class="font-medium text-red-600 dark:text-red-500 hover:underline">Törlés</a>
                            </td>
                        </tr>
                        <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 border-gray-200">
                            <th scope="row"
                                class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                2
                            </th>
                            <td class="px-6 py-4">
                                E-mail
                            </td>
                            <td class="px-6 py-4 text-green-600 dark:text-green-500">
                                Aktív
                            </td>
                            <td class="px-6 py-4">
                                <a href="#"
                                    class="font-medium text-orange-600 dark:text-orange-500 hover:underline">Szerkesztés</a>
                                <a href="#"
                                    class="font-medium text-red-600 dark:text-red-500 hover:underline">Törlés</a>
                            </td>
                        </tr>
                        <tr class="bg-white dark:bg-gray-800">
                            <th scope="row"
                                class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                3
                            </th>
                            <td class="px-6 py-4">
                                FTP
                            </td>
                            <td class="px-6 py-4 text-red-600 dark:text-red-500">
                                Inkatív
                            </td>
                            <td class="px-6 py-4">
                                <a href="#"
                                    class="font-medium text-orange-600 dark:text-orange-500 hover:underline">Szerkesztés</a>
                                <a href="#"
                                    class="font-medium text-red-600 dark:text-red-500 hover:underline">Törlés</a>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="w-2/5 mt-1 mx-auto break-words rounded-lg">
                <table class="text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                        <tr>
                            <th colspan="3" class="px-6 py-3">
                                Oszlop név 3
                            </th>
                            <th>
                                <a href="#"
                                    class="font-medium text-orange-600 dark:text-orange-500 hover:underline">Oszlop
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
                    <tbody>
                        <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 border-gray-200">
                            <th scope="row"
                                class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                1
                            </th>
                            <td class="px-6 py-4">
                                Pc hozzáférés
                            </td>
                            <td class="px-6 py-4 text-green-600 dark:text-green-500">
                                Aktív
                            </td>
                            <td class="px-6 py-4">
                                <a href="#"
                                    class="font-medium text-orange-600 dark:text-orange-500 hover:underline">Szerkesztés</a>
                                <a href="#"
                                    class="font-medium text-red-600 dark:text-red-500 hover:underline">Törlés</a>
                            </td>
                        </tr>
                        <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 border-gray-200">
                            <th scope="row"
                                class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                2
                            </th>
                            <td class="px-6 py-4">
                                E-mail
                            </td>
                            <td class="px-6 py-4 text-green-600 dark:text-green-500">
                                Aktív
                            </td>
                            <td class="px-6 py-4">
                                <a href="#"
                                    class="font-medium text-orange-600 dark:text-orange-500 hover:underline">Szerkesztés</a>
                                <a href="#"
                                    class="font-medium text-red-600 dark:text-red-500 hover:underline">Törlés</a>
                            </td>
                        </tr>
                        <tr class="bg-white dark:bg-gray-800">
                            <th scope="row"
                                class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                3
                            </th>
                            <td class="px-6 py-4">
                                FTP
                            </td>
                            <td class="px-6 py-4 text-red-600 dark:text-red-500">
                                Inkatív
                            </td>
                            <td class="px-6 py-4">
                                <a href="#"
                                    class="font-medium text-orange-600 dark:text-orange-500 hover:underline">Szerkesztés</a>
                                <a href="#"
                                    class="font-medium text-red-600 dark:text-red-500 hover:underline">Törlés</a>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
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
                                    <input type="text" name="display_name" id="display_name"
                                        class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer"
                                        placeholder=" " />
                                    <label for="display_name"
                                        class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">
                                        Elnevezés
                                    </label>
                                </div>
                                <div class="relative z-0 w-full mb-5 group">
                                    <select type="select" name="status" id="status"
                                        class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer"
                                        placeholder=" ">
                                        <option>Válassz egy státuszt</option>
                                    </select>
                                    <label for="status"
                                        class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">
                                        Státusz
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-100 dark:bg-gray-600 px-4 py-3 sm:flex sm:flex-row-reverse sm:px-6">
                    <x-danger-button
                        @click="show_add_column_field = !show_add_column_field">{{ __('Bezárás') }}</x-primary-button>
                        <x-success-button class="mx-2">{{ __('Mentés') }}</x-primary-button>
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
                                    <input type="text" name="display_name" id="display_name"
                                        class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer"
                                        placeholder=" " />
                                    <label for="display_name"
                                        class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">
                                        Elnevezés
                                    </label>
                                </div>
                                <div class="relative z-0 w-full mb-5 group">
                                    <select type="select" name="column" id="column"
                                        class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer"
                                        placeholder=" ">
                                        <option>Válassz egy oszlopot</option>
                                    </select>
                                    <label for="column"
                                        class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">
                                        Oszlop
                                    </label>
                                </div>
                                <div class="relative z-0 w-full mb-5 group">
                                    <select type="select" name="status" id="status"
                                        class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer"
                                        placeholder=" ">
                                        <option>Válassz egy státuszt</option>
                                    </select>
                                    <label for="status"
                                        class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">
                                        Státusz
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-100 dark:bg-gray-600 px-4 py-3 sm:flex sm:flex-row-reverse sm:px-6">
                    <x-danger-button
                        @click="show_add_authorization_field = !show_add_authorization_field">{{ __('Bezárás') }}</x-primary-button>
                        <x-success-button class="mx-2">{{ __('Mentés') }}</x-primary-button>
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
                                    <input type="text" name="display_name" id="display_name"
                                        class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer"
                                        placeholder=" " />
                                    <label for="display_name"
                                        class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">
                                        Elnevezés
                                    </label>
                                </div>
                                <div class="relative z-0 w-full mb-5 group">
                                    <select type="select" name="authorization" id="authorization"
                                        class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer"
                                        placeholder=" ">
                                        <option>Válassz egy oszlopot</option>
                                    </select>
                                    <label for="authorization"
                                        class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">
                                        Jogosultság
                                    </label>
                                </div>
                                <div class="relative z-0 w-full mb-5 group">
                                    <select type="select" name="status" id="status"
                                        class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer"
                                        placeholder=" ">
                                        <option>Válassz egy státuszt</option>
                                    </select>
                                    <label for="status"
                                        class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">
                                        Státusz
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-100 dark:bg-gray-600 px-4 py-3 sm:flex sm:flex-row-reverse sm:px-6">
                    <x-danger-button
                        @click="show_add_sub_authorization_field = !show_add_sub_authorization_field">{{ __('Bezárás') }}</x-primary-button>
                        <x-success-button class="mx-2">{{ __('Mentés') }}</x-primary-button>
                </div>
            </form>
        </x-modal>
    </div>
</div>
