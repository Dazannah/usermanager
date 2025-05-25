@if (app_settings()->logo_name)
    <img class="block h-9 w-auto text-gray-800 dark:text-gray-200" src="/storage/{{ app_settings()->logo_name }}"
        alt="application logo">
@endif
