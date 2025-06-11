<div>
    <x-submenu :title="'Új felhasználó'">
    </x-submenu>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <livewire:user.components.user-request-form-panel :$departments :$columns />
            </div>
        </div>
    </div>
</div>
