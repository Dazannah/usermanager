@props([
    'wire_key' => null,
    'property_name',
    'select' => false,
    'select_value' => 'Válassz',
    'value_setter' => null,
    'data',
    'counter' => false,
    'counter_max' => null,
    'disabled' => false,
])

@php
    $key = $wire_key ?? $property_name;
    $counter_max = is_numeric($counter_max) ? (int) $counter_max : 0;
@endphp

<select @disabled($disabled) wire:key="{{ $key }}" wire:model="{{ $property_name }}" type="select"
    name="{{ $property_name }}" id="{{ $property_name }}"
    {{ $attributes->merge(['class' => 'block p-2.5 w-full text-sm text-[#15808a] focus:text-[#e3a420] bg-transparent border-0 border-b-2 border-[#15808a] appearance-none dark:text-[#15808a] focus:dark:text-[#e3a420] dark:border-[#15808a] dark:focus:border-[#e3a420] focus:outline-none focus:ring-0 focus:border-[#e3a420] peer']) }}placeholder=" ">

    @if ($select)
        <x-option value="">{{ $select_value }}</x-option>
    @endif

    @if ($counter)
        @for ($i = 1; $i <= $counter_max; $i++)
            <x-option :value="$i">{{ $i }}</x-option>
        @endfor
    @else
        @foreach ($data as $element)
            @if (isset($value_setter))
                <x-option value="{{ $element->{$value_setter} }}">{{ $element->displayName }}</x-option>
            @else
                <x-option value="{{ $element->id }}">{{ $element->displayName }}</x-option>
            @endif
        @endforeach
    @endif

</select>
