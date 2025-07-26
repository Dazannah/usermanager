@props(['wire_key' => null, 'property_name', 'text', 'disabled' => false, 'on_click' => null])

<div>
    <input @disabled($disabled) @if ($on_click) @click="{{ $on_click }}" @endif
        wire:key="{{ $wire_key }}" wire:model.live="{{ $property_name }}" id="{{ $property_name }}" type="checkbox"
        wire:checked="{{ $property_name }}"
        class="w-4 h-4 border border-gray-300 rounded-sm bg-gray-50 focus:ring-3 focus:ring-primary_color dark:bg-gray-700 dark:border-gray-600 dark:focus:ring-primary_color dark:ring-offset-gray-800 dark:focus:ring-offset-gray-800" />

    <label for="{{ $property_name }}"
        class="ms-2 text-sm font-medium text-primary_color dark:text-primary_color">{{ $text }}</label>
</div>
