<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Jogosultságok') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="flex flex-wrap sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg mx-auto break-words">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <table className="w-full text-sm text-left rtl:text-right">
                        <thead className="text-xs text-gray-700 uppercase bg-gray-100 dark:bg-gray-700 dark:text-gray-400">
                            <tr>
                                <th colspan="4" class="w-max left-0 px-6 py-3">
                                    Column Name
                                </th>
                            </tr>
                            <tr>
                                <th scope="col" class="px-6 py-3"></th>
                                <th scope="col" class="px-6 py-3">
                                    Elnevezés
                                </th>
                                <th scope="col" class="px-6 py-3">
                                   Státusz
                                </th>
                                <th scope="col" class="flex px-6 py-3">
                                    <div class="">
                                        <x-primary-button class="flex place-content-end" wire:click.prevent="show('this menu')">{{ __('Oszlop szerkesztése') }}</x-primary-button>
                                    </div>
                                </th>
                            </tr>
                        </thead>
                    <tbody>
                        <tr>
                            <td className="px-6 py-4">
                                1
                            </td>
                            <td className="px-6 py-4">
                                <span>Számítógép bejelentkezés</span>
                            </td>

                            <td className="px-6 py-4">Aktív</td>
                            <td className="px-1 py-4">
                                <div className="flex place-content-end">
                                    <button className="bg-transparent py-1 px-1 text-orange-500 text-sm transition-all hover:cursor-pointer hover:underline">
                                        Szerkesztés
                                    </button>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </div>
            </div>
        </div>
    </div>
</div>