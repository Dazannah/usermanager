@props(['text', 'properti_to_change'])
<button @click="{{ $properti_to_change }} = !{{ $properti_to_change }}"
    class="inline-flex items-center px-1 pt-1 border-b-2 border-transparent text-sm font-medium leading-5 text-gray-200 dark:text-gray-200 hover:border-[#e3a420] dark:hover:border-[#e3a420] focus:outline-none focus:border-[#e3a420] focus:dark:text-gray-100 transition duration-150 ease-in-out">
    {{ $text }}
</button>
