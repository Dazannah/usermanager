@props(['property_name', 'type', 'disabled' => false])

<input @disabled($disabled) wire:key="{{ $property_name }}" wire:model="{{ $property_name }}"
    name="{{ $property_name }}" id="{{ $property_name }}" type="{{ $type }}" placeholder=" "
    {{ $attributes->merge(['class' => 'block py-2.5 px-0 w-full text-sm text-[#15808a] focus:text-[#e3a420] bg-transparent border-0 border-b-2 border-[#15808a] appearance-none dark:text-[#15808a] focus:dark:text-[#e3a420] dark:border-[#15808a] dark:focus:border-[#e3a420] focus:outline-none focus:ring-0 focus:border-[#e3a420] peer']) }}>
