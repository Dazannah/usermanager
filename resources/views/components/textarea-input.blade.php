@props(['property_name', 'rows' => 5, 'disabled' => false])

<textarea @disabled($disabled) wire:key="{{ $property_name }}" wire:model.live="{{ $property_name }}"
    name="{{ $property_name }}" id="{{ $property_name }}" rows="{{ $rows }}"
    {{ $attributes->merge(['class' => 'block py-2.5 px-0 w-full text-sm text-primary_color focus:text-secondary_color bg-transparent border-0 border-b-2 border-primary_color appearance-none dark:text-primary_color focus:dark:text-secondary_color dark:border-primary_color dark:focus:border-secondary_color focus:outline-none focus:ring-0 focus:border-secondary_color peer']) }}>
</textarea>
