@props(['for', 'text', 'disabled' => false])

<label for="{{ $for }}"
    {{ $attributes->merge(['class' => 'peer-focus:font-medium absolute text-sm text-primary_color dark:text-primary_color duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto peer-focus:text-secondary_color peer-focus:dark:text-[#e3a42] peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6']) }}>
    {{ $text }}
</label>
