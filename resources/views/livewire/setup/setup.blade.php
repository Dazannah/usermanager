<div class="max-w-7xl mx-auto sm:px-6 lg:px-8 mt-6">
    <header>
        <x-slot name="header">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Beállítások') }}
            </h2>
        </x-slot>
        <div>
            @if (session()->has('message'))
                <div class="alert alert-success">
                    {{ session('message') }}
                </div>
            @endif
        </div>
    </header>

    <livewire:setup.components.app-settings-component />
</div>
