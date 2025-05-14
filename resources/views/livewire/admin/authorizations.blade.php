<div class="flex flex-wrap gap-2">
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Jogosultságok') }}
        </h2>
    </x-slot>

    <div class="w-2/5 mx-auto break-words rounded-lg">
        <table class="text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                <tr>
                    <th colspan="3" class="px-6 py-3">
                        Oszlop név
                    </th>
                    <th>
                        <a href="#" class="font-medium text-orange-600 dark:text-orange-500 hover:underline">Oszlop szerkesztése</a>
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
                    <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                        1
                    </th>
                    <td class="px-6 py-4">
                        Pc hozzáférés asdasd aa asda asd asd lkdaskjadskljsad kjlasdkljasdklj kjklj
                    </td>
                    <td class="px-6 py-4 text-green-600 dark:text-green-500">
                        Aktív
                    </td>
                    <td class="px-6 py-4">
                        <a href="#" class="font-medium text-orange-600 dark:text-orange-500 hover:underline">Szerkesztés</a>
                        <a href="#" class="font-medium text-red-600 dark:text-red-500 hover:underline">Törlés</a>
                    </td>
                </tr>
                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 border-gray-200">
                    <th rowspan="2" scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                        2
                    </th>
                    <td class="px-6 py-4">
                        E-mail
                    </td>
                    <td class="px-6 py-4 text-green-600 dark:text-green-500">
                        Aktív
                    </td>
                    <td rowspan="2" class="px-6 py-4">
                        <a href="#" class="font-medium text-orange-600 dark:text-orange-500 hover:underline">Szerkesztés</a>
                        <a href="#" class="font-medium text-red-600 dark:text-red-500 hover:underline">Törlés</a>
                    </td>
                </tr>
                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 border-gray-200">
                    <td colspan="2" class="px-6 py-4">
                        <div >

                        </div>
                        <div>
                            <span class="font-medium text-green-600 dark:text-green-500 hover:underline hover:cursor-pointer">Normál</span>
                            <span class="font-medium text-green-600 dark:text-green-500 hover:underline hover:cursor-pointer">Admin</span>
                            <span class="font-medium text-red-600 dark:text-red-500 hover:underline hover:cursor-pointer">Dummy</span>
                        </div>

                    </td>
                </tr>
                <tr class="bg-white dark:bg-gray-800">
                    <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                        3
                    </th>
                    <td class="px-6 py-4">
                        FTP
                    </td>
                    <td class="px-6 py-4 text-red-600 dark:text-red-500">
                        Inkatív
                    </td>
                    <td class="px-6 py-4">
                        <a href="#" class="font-medium text-orange-600 dark:text-orange-500 hover:underline">Szerkesztés</a>
                        <a href="#" class="font-medium text-red-600 dark:text-red-500 hover:underline">Törlés</a>
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
                        <a href="#" class="font-medium text-orange-600 dark:text-orange-500 hover:underline">Oszlop szerkesztése</a>
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
                    <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                        1
                    </th>
                    <td class="px-6 py-4">
                        Pc hozzáférés
                    </td>
                    <td class="px-6 py-4 text-green-600 dark:text-green-500">
                        Aktív
                    </td>
                    <td class="px-6 py-4">
                        <a href="#" class="font-medium text-orange-600 dark:text-orange-500 hover:underline">Szerkesztés</a>
                        <a href="#" class="font-medium text-red-600 dark:text-red-500 hover:underline">Törlés</a>
                    </td>
                </tr>
                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 border-gray-200">
                    <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                        2
                    </th>
                    <td class="px-6 py-4">
                        E-mail
                    </td>
                    <td class="px-6 py-4 text-green-600 dark:text-green-500">
                        Aktív
                    </td>
                    <td class="px-6 py-4">
                        <a href="#" class="font-medium text-orange-600 dark:text-orange-500 hover:underline">Szerkesztés</a>
                        <a href="#" class="font-medium text-red-600 dark:text-red-500 hover:underline">Törlés</a>
                    </td>
                </tr>
                <tr class="bg-white dark:bg-gray-800">
                    <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                        3
                    </th>
                    <td class="px-6 py-4">
                        FTP
                    </td>
                    <td class="px-6 py-4 text-red-600 dark:text-red-500">
                        Inkatív
                    </td>
                    <td class="px-6 py-4">
                        <a href="#" class="font-medium text-orange-600 dark:text-orange-500 hover:underline">Szerkesztés</a>
                        <a href="#" class="font-medium text-red-600 dark:text-red-500 hover:underline">Törlés</a>
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
                        <a href="#" class="font-medium text-orange-600 dark:text-orange-500 hover:underline">Oszlop szerkesztése</a>
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
                    <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                        1
                    </th>
                    <td class="px-6 py-4">
                        Pc hozzáférés
                    </td>
                    <td class="px-6 py-4 text-green-600 dark:text-green-500">
                        Aktív
                    </td>
                    <td class="px-6 py-4">
                        <a href="#" class="font-medium text-orange-600 dark:text-orange-500 hover:underline">Szerkesztés</a>
                        <a href="#" class="font-medium text-red-600 dark:text-red-500 hover:underline">Törlés</a>
                    </td>
                </tr>
                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 border-gray-200">
                    <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                        2
                    </th>
                    <td class="px-6 py-4">
                        E-mail
                    </td>
                    <td class="px-6 py-4 text-green-600 dark:text-green-500">
                        Aktív
                    </td>
                    <td class="px-6 py-4">
                        <a href="#" class="font-medium text-orange-600 dark:text-orange-500 hover:underline">Szerkesztés</a>
                        <a href="#" class="font-medium text-red-600 dark:text-red-500 hover:underline">Törlés</a>
                    </td>
                </tr>
                <tr class="bg-white dark:bg-gray-800">
                    <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                        3
                    </th>
                    <td class="px-6 py-4">
                        FTP
                    </td>
                    <td class="px-6 py-4 text-red-600 dark:text-red-500">
                        Inkatív
                    </td>
                    <td class="px-6 py-4">
                        <a href="#" class="font-medium text-orange-600 dark:text-orange-500 hover:underline">Szerkesztés</a>
                        <a href="#" class="font-medium text-red-600 dark:text-red-500 hover:underline">Törlés</a>
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
                        <a href="#" class="font-medium text-orange-600 dark:text-orange-500 hover:underline">Oszlop szerkesztése</a>
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
                    <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                        1
                    </th>
                    <td class="px-6 py-4">
                        Pc hozzáférés
                    </td>
                    <td class="px-6 py-4 text-green-600 dark:text-green-500">
                        Aktív
                    </td>
                    <td class="px-6 py-4">
                        <a href="#" class="font-medium text-orange-600 dark:text-orange-500 hover:underline">Szerkesztés</a>
                        <a href="#" class="font-medium text-red-600 dark:text-red-500 hover:underline">Törlés</a>
                    </td>
                </tr>
                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 border-gray-200">
                    <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                        2
                    </th>
                    <td class="px-6 py-4">
                        E-mail
                    </td>
                    <td class="px-6 py-4 text-green-600 dark:text-green-500">
                        Aktív
                    </td>
                    <td class="px-6 py-4">
                        <a href="#" class="font-medium text-orange-600 dark:text-orange-500 hover:underline">Szerkesztés</a>
                        <a href="#" class="font-medium text-red-600 dark:text-red-500 hover:underline">Törlés</a>
                    </td>
                </tr>
                <tr class="bg-white dark:bg-gray-800">
                    <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                        3
                    </th>
                    <td class="px-6 py-4">
                        FTP
                    </td>
                    <td class="px-6 py-4 text-red-600 dark:text-red-500">
                        Inkatív
                    </td>
                    <td class="px-6 py-4">
                        <a href="#" class="font-medium text-orange-600 dark:text-orange-500 hover:underline">Szerkesztés</a>
                        <a href="#" class="font-medium text-red-600 dark:text-red-500 hover:underline">Törlés</a>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>