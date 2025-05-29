@props(['property_name', 'text', 'disabled' => false])

<div class="flex items-center h-5">
    <input @disabled($disabled) wire:key="{{ $property_name }}" wire:model="{{ $property_name }}"
        id="{{ $property_name }}" type="checkbox"
        class="w-4 h-4 border border-gray-300 rounded-sm bg-gray-50 focus:ring-3 focus:ring-[#15808a] dark:bg-gray-700 dark:border-gray-600 dark:focus:ring-[#15808a] dark:ring-offset-gray-800 dark:focus:ring-offset-gray-800" />
</div>
<label for="{{ $property_name }}"
    class="ms-2 text-sm font-medium text-[#15808a] dark:text-[#15808a]">{{ $text }}</label>
