@php
    $classes =
        'text-white dark:text-white hover:text-white dark:hover:text-white hover:border-[#e3a420] hover:dark:border-[#e3a420]';
@endphp

<x-submenu :title="'Beállítások'">
    <x-nav-link :href="route('admin-app-configuration-general')" class="{{ $classes }}" :active="request()->routeIs('admin-app-configuration-general')" wire:navigate>
        {{ __('Általános') }}
    </x-nav-link>
    <x-nav-link :href="route('admin-app-configuration-texts')" class="{{ $classes }}" :active="request()->routeIs('admin-app-configuration-texts')" wire:navigate>
        {{ __('Feliratok') }}
    </x-nav-link>
    <x-nav-link :href="route('admin-app-configuration-local-accounts')" class="{{ $classes }}" :active="request()->routeIs('admin-app-configuration-local-accounts')" wire:navigate>
        {{ __('Helyi fiókok') }}
    </x-nav-link>

    @if (request()->routeIs('admin-app-configuration-local-accounts'))
        <br><x-submenu-button :text="'Helyi fiók hozzáadás'" :properti_to_change="'show_add_local_account_field'" />
    @endif


</x-submenu>
