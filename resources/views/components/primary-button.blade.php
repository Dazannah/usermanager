<button
    {{ $attributes->merge(['type' => 'submit', 'class' => 'inline-flex items-center mt-2 px-4 py-2 bg-[#15808a] dark:bg-[#15808a] border border-transparent rounded-md font-semibold text-xs text-white dark:text-white uppercase tracking-widest hover:bg-[#e3a420] dark:hover:bg-[#e3a420] focus:bg-[#e3a420] dark:focus:bg-[#e3a420] active:bg-[#e3a420] dark:active:bg-[#e3a420] focus:outline-none focus:ring-2 focus:ring-[#15808a] focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150']) }}>
    {{ $slot }}
</button>
