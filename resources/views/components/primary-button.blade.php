<button
    {{ $attributes->merge(['type' => 'submit', 'class' => 'inline-flex items-center mt-2 px-4 py-2 bg-primary_color dark:bg-primary_color border border-transparent rounded-md font-semibold text-xs text-white dark:text-white uppercase tracking-widest hover:bg-secondary_color dark:hover:bg-secondary_color focus:bg-secondary_color dark:focus:bg-secondary_color active:bg-secondary_color dark:active:bg-secondary_color focus:outline-none focus:ring-2 focus:ring-primary_color focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150']) }}>
    {{ $slot }}
</button>
