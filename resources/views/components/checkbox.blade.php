@props(['wire_key' => null, 'property_name', 'text', 'disabled' => false])

<div>
    <input @disabled($disabled) wire:key="{{ $wire_key }}" wire:model="{{ $property_name }}"
        id="{{ $property_name }}" type="checkbox" wire:checked="{{ $property_name }}"
        class="w-4 h-4 border border-gray-300 rounded-sm bg-gray-50 focus:ring-3 focus:ring-[#15808a] dark:bg-gray-700 dark:border-gray-600 dark:focus:ring-[#15808a] dark:ring-offset-gray-800 dark:focus:ring-offset-gray-800" />

    <label for="{{ $property_name }}"
        class="ms-2 text-sm font-medium text-[#15808a] dark:text-[#15808a]">{{ $text }}</label>
</div>
