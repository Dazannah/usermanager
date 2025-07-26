<form wire:submit.prevent="save_authorization">
    <div class="p-4 sm:flex sm:items-start">
        <div x-data="{ show_technical_note: false }" class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
            <h3 class="text-base font-semibold text-gray-500 dark:text-gray-400" id="modal-title">
            </h3>
            <div class="mt-2">
                <div class="grid grid-cols-3 gap-6">
                    <div class="relative z-0 w-full mb-5 group">
                        <x-text-input :property_name="'form.name'" :type="'text'" />
                        <x-label :for="'form.name'" :text="'Név'" />
                        @error('form.name')
                            <x-input-error :messages="$message" class="mt-2" />
                        @enderror
                    </div>

                    <div class="relative z-0 w-full mb-5 group">
                        <x-checkbox :on_click="'show_technical_note = !show_technical_note'" :property_name="'form.is_technical'" :text="'Technikai fiók'" />
                        @error('form.is_technical')
                            <x-input-error :messages="$message" class="mt-2" />
                        @enderror
                    </div>

                    <div class="relative z-0 w-full mb-5 group">
                        <x-text-input :property_name="'form.registration_number'" :type="'text'" />
                        <x-label :for="'form.registration_number'" :text="'Nyilv. szám'" />
                        @error('form.registration_number')
                            <x-input-error :messages="$message" class="mt-2" />
                        @enderror
                    </div>

                    <div class="relative z-0 w-full mb-5 group">
                        <x-text-input :property_name="'form.post'" :type="'text'" />
                        <x-label :for="'form.post'" :text="'Beosztás'" />
                        @error('form.post')
                            <x-input-error :messages="$message" class="mt-2" />
                        @enderror
                    </div>

                    <div class="relative z-0 w-full mb-5 group">
                        <x-text-input :property_name="'form.department_leader'" :type="'text'" />
                        <x-label :for="'form.department_leader'" :text="'Osztály vezető'" />
                        @error('form.department_leader')
                            <x-input-error :messages="$message" class="mt-2" />
                        @enderror
                    </div>

                    <div class="relative z-0 w-full mb-5 group">
                        <x-select :property_name="'form.department_id'" :select="true" :data="$this->departments" />
                        <x-label :for="'form.department_id'" :text="'Osztály'" />
                        @error('form.department_id')
                            <x-input-error :messages="$message" class="mt-2" />
                        @enderror
                    </div>
                </div>
                <div class="grid gap-2">
                    @foreach ($this->columns as $column)
                        @if ($column?->status?->name == 'active')
                            <div key="column-key-{{ $column->id }}" class="grid gap-2">
                                <h1 class="ms-2 font-medium text-[#15808a] dark:text-[#15808a]">
                                    {{ $column->displayName }}</h1>
                                <div id="column_{{ $column->id }}">
                                    @foreach ($column->auth_items as $auth_item)
                                        @if ($auth_item?->status?->name == 'active')
                                            <div key="auth_item-key-{{ $auth_item->id }}" x-data="{ show: false }">
                                                <div class="relative z-0 w-full mb-5 group">
                                                    <x-checkbox :on_click="'show = !show'" :property_name="'form.authorizations.' . $auth_item->id"
                                                        :text="$auth_item->displayName" />
                                                    @error('form.authorizations.' . $auth_item->id)
                                                        <x-input-error :messages="$message" class="mt-2" />
                                                    @enderror
                                                </div>

                                                @if (count($auth_item?->sub_auth_items) > 0)
                                                    {{-- megnézni, a sub auth itemeket, valamelyik helyet cserél közvetlen renderelés után vélhetően a pozíció körül van valami baj, és a pozíció cserével is van valami baj --}}
                                                    <div x-show="show" x-cloak
                                                        class="grid grid-cols-2 gap-1 p-2 dark:bg-gray-900 sm:rounded-lg">
                                                        @foreach ($auth_item->sub_auth_items as $sub_auth_item)
                                                            @if ($sub_auth_item?->status?->name == 'active')
                                                                <div key="sub_auth_item-key-{{ $sub_auth_item->id }}"
                                                                    class="relative z-0 w-full mb-5 group">
                                                                    <x-checkbox :property_name="'form.sub_authorizations.' .
                                                                        $sub_auth_item->id" :text="$sub_auth_item->displayName" />
                                                                    @error('form.sub_authorizations.' .
                                                                        $sub_auth_item->id)
                                                                        <x-input-error :messages="$message" class="mt-2" />
                                                                    @enderror
                                                                </div>
                                                            @endif
                                                        @endforeach
                                                    </div>
                                                @endif
                                            </div>
                                        @endif
                                    @endforeach
                                </div>
                            </div>
                        @endif
                    @endforeach
                </div>
                <div class="grid grid-cols-1 gap-6">
                    <div class="relative z-0 w-full mb-5 group">
                        <x-textarea-input :property_name="'form.note'" />
                        <x-label :for="'form.note'" :text="'Megjegyzés'" />
                        @error('form.note')
                            <x-input-error :messages="$message" class="mt-2" />
                        @enderror
                    </div>


                    <div x-show="show_technical_note" class="relative z-0 w-full mb-5 group">
                        <x-textarea-input :property_name="'form.technical_note'" />
                        <x-label :for="'form.technical_note'" :text="'Technikai fiók megjegyzés'" />
                        @error('form.technical_note')
                            <x-input-error :messages="$message" class="mt-2" />
                        @enderror
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="bg-gray-100 dark:bg-gray-600 px-4 py-3 sm:flex sm:flex-row-reverse sm:px-6 items-center">
        <x-success-button wire:loading.remove @click.prevent="$wire[method_name]" class="me-3">
            {{ __('Mentés') }}
        </x-success-button>

        <x-action-message wire:loading class="me-3" on="save_authorization">
            <x-loading />
        </x-action-message>

        <x-action-message-success class="me-3" on="authorization_save_success">
            {{ __('Sikeres mentés') }}
        </x-action-message-success>

        @error('authorization_error')
            <div class="me-3">
                <x-input-error :messages="$message" />
            </div>
        @enderror
    </div>
</form>
