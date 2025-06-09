<div>
    <livewire:admin.setup-sub-navigation />

    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 mt-6">
        @error('error')
            <div class="py-4">
                <x-input-error :messages="$message" class="mt" />
            </div>
        @enderror

        <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
            <table class="w-full table-auto text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                    <form action="filter_sessions">
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

                            <th scope="col" class="px-6 py-3">
                                <div class="relative z-0 w-full mb-5 group">
                                    <x-text-input :property_name="'username'" :type="'text'" />
                                    <x-label :for="'username'" :text="'Felhasználó név'" />
                                    @error('username')
                                        <x-input-error :messages="$message" class="mt-2" />
                                    @enderror
                                </div>
                            </th>

                            <th scope="col" class="px-6 py-3 text-right">
                                <x-primary-button
                                    @click.prevent="$dispatch('sessions_filter_reset')">{{ __('Visszaállítás') }}
                                </x-primary-button>
                            </th>
                        </tr>
                    </form>
                </thead>
                <tbody>

                    @foreach ($sessions as $session)
                        <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 border-gray-200">
                            <td class="px-6 py-4">
                                {{ $session->name }}
                            </td>

                            <td class="px-6 py-4">
                                {{ $session->username }}
                            </td>
                            <td class="px-6 py-4 text-right">

                                <button
                                    @click.prevent="$dispatch('delete_session', ['{{ $session->id }}', '{{ $session->username }}'])"
                                    class="font-medium text-orange-600 dark:text-orange-500 underline hover:no-underline">Kijelentkeztetés</button>
                            </td>
                        </tr>
                    @endforeach

                </tbody>
            </table>
        </div>
        {{ $sessions->links() }}
    </div>
</div>
