@props(['title'])

<header class="bg-primary_color dark:bg-primary_color shadow py-6">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h2 class="font-semibold text-xl text-white dark:text-gray-200 leading-tight">
            {{ $title }}
        </h2>
        {{ $slot }}
    </div>
</header>
