<div>
    <x-submenu :title="'Beállítások'">

    </x-submenu>
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 mt-6">

        @error('error')
            <div class="py-4">
                <x-input-error :messages="$message" class="mt" />
            </div>
        @enderror

        <livewire:setup.components.app-settings-component />
        <livewire:setup.components.mail-settings-component />
        <livewire:setup.components.ispconfig-soap-settings-component />
    </div>
</div>
