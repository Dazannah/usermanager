<div x-data="{
    show_update_account_authorization_field: false,
}">
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
                    <form action="filter_locations">
                        <tr>
                            <th scope="col" class="px-6 py-3">
                                <div class="relative z-0 w-full mb-5 group">
                                    <x-text-input :property_name="'displayName'" :type="'text'" />
                                    <x-label :for="'displayName'" :text="'Megjelenítési név'" />
                                    @error('displayName')
                                        <x-input-error :messages="$message" class="mt-2" />
                                    @enderror
                                </div>
                            </th>

                            @if (config('ldap.active'))
                                <th scope="col" class="px-6 py-3">
                                    <div class="relative z-0 w-full mb-5 group">
                                        <x-text-input :property_name="'ldap_group_name'" :type="'text'" />
                                        <x-label :for="'ldap_group_name'" :text="'LDAP csoport név'" />
                                        @error('ldap_group_name')
                                            <x-input-error :messages="$message" class="mt-2" />
                                        @enderror
                                    </div>
                                </th>
                            @endif

                            <th scope="col" class="px-6 py-3">
                                <div class="relative z-0 w-full mb-5 group">
                                    <x-text-input :property_name="'name'" :type="'text'" />
                                    <x-label :for="'name'" :text="'Azonosító'" />
                                    @error('name')
                                        <x-input-error :messages="$message" class="mt-2" />
                                    @enderror
                                </div>
                            </th>

                            <th scope="col" class="px-6 py-3 text-right">
                                <x-primary-button
                                    @click.prevent="$dispatch('authorizations_levels_filter_reset')">{{ __('Visszaállítás') }}
                                </x-primary-button>
                            </th>
                        </tr>
                    </form>
                </thead>
                <tbody>

                    @foreach ($accountAuthorizationLevels as $accountAuthorizationLevel)
                        <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 border-gray-200">
                            <td class="px-6 py-4">
                                {{ $accountAuthorizationLevel->displayName }}
                            </td>

                            @if (config('ldap.active'))
                                <td class="px-6 py-4">
                                    {{ $accountAuthorizationLevel->ldap_group_name }}
                                </td>
                            @endif

                            <td class="px-6 py-4">
                                {{ $accountAuthorizationLevel->name }}
                            </td>
                            <td class="px-6 py-4 text-right">
                                <button
                                    @click="show_update_account_authorization_field = !show_update_account_authorization_field; update_account_authorization_id = {{ $accountAuthorizationLevel->id }}"
                                    class="font-medium text-orange-600 dark:text-orange-500 underline hover:no-underline">Szerkesztés</button>
                            </td>
                        </tr>
                    @endforeach

                </tbody>
            </table>
        </div>
        {{ $accountAuthorizationLevels->links() }}
    </div>

    {{-- location modal --}}
    <livewire:setup.components.account-authorization-levels-form-panel />
</div>
