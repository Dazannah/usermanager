<div x-data="{
    show_add_local_account_field: false,
    show_edit_local_account_field: false,
}">

    <x-submenu :title="'Helyi fiókok'">
        <x-submenu-button :text="'Helyi fiók hozzáadás'" :properti_to_change="'show_add_local_account_field'" />
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
                    <form action="filter_departments">
                        <tr>
                            <th scope="col" class="px-6 py-3">
                                <div class="relative z-0 w-full mb-5 group">
                                    <x-text-input :property_name="'search_user_name'" :type="'text'" />
                                    <x-label :for="'search_user_name'" :text="'Név'" />
                                </div>
                            </th>

                            <th scope="col" class="px-6 py-3">
                                <div class="relative z-0 w-full mb-5 group">
                                    <x-text-input :property_name="'search_user_username'" :type="'text'" />
                                    <x-label :for="'search_user_username'" :text="'Felhasználó név'" />
                                </div>
                            </th>

                            <th scope="col" class="px-6 py-3">
                                <div class="relative z-0 w-full mb-5 group">
                                    <x-text-input :property_name="'search_user_email'" :type="'text'" />
                                    <x-label :for="'search_user_email'" :text="'E-mail'" />
                                </div>
                            </th>

                            <th scope="col" class="px-6 py-3">
                                <div class="relative z-0 w-full mb-5 group">
                                    <x-select :property_name="'search_user_authorization_level'" :select="true" :select_value="'Összes'"
                                        :value_setter="'name'" :data="$this->accountAuthorizationLevels" />
                                    <x-label :for="'search_user_authorization_level'" :text="'Jogosultság szint'" />
                                </div>
                            </th>

                            <th scope="col" class="px-6 py-3">
                                <div class="relative z-0 w-full mb-5 group">
                                    <x-select :property_name="'search_user_status_id'" :select="true" :select_value="'Összes'"
                                        :data="$this->statuses" />
                                    <x-label :for="'search_user_status_id'" :text="'Státusz'" />
                                </div>
                            </th>

                            <th scope="col" class="px-6 py-3 text-right">
                                <x-primary-button
                                    @click.prevent="$dispatch('local_accounts_filter_reset')">{{ __('Visszaállítás') }}
                                </x-primary-button>
                            </th>
                        </tr>
                    </form>
                </thead>
                <tbody>

                    @foreach ($local_accounts as $local_account)
                        <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 border-gray-200">
                            <th scope="row"
                                class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                {{ $local_account->name }}
                            </th>
                            <th scope="row"
                                class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                {{ $local_account->username }}
                            </th>
                            <th scope="row"
                                class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                {{ $local_account->email }}
                            </th>
                            <th scope="row"
                                class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                @php
                                    $account_level_names = $local_account->get_auth_level_displayNames();
                                @endphp
                                @foreach ($account_level_names as $idx => $auth_level_name)
                                    {{ $idx < count($account_level_names) - 1 ? $auth_level_name . ',' : $auth_level_name }}
                                @endforeach
                            </th>
                            <td
                                class="px-6 py-4 {{ $local_account->status->name == 'active' ? 'text-green-600 dark:text-green-500' : 'text-red-600 dark:text-red-500' }}">
                                {{ $local_account->status->displayName }}
                            </td>
                            <td class="px-6 py-4 text-right">
                                <button
                                    @click="show_edit_local_account_field = !show_edit_local_account_field; edit_local_account_id = {{ $local_account->id }}"
                                    class="font-medium text-orange-600 dark:text-orange-500 underline hover:no-underline">Szerkesztés</button>
                            </td>
                        </tr>
                    @endforeach

                </tbody>
            </table>
        </div>
        {{ $local_accounts->links(data: ['scrollTo' => false]) }}
    </div>

    <livewire:admin.components.local-account-form-panel :$accountAuthorizationLevels :$statuses />
</div>
