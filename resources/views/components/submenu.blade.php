@props(['title'])

<header class="bg-[#15808a] dark:bg-[#15808a] shadow py-6">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h2 class="font-semibold text-xl text-white dark:text-gray-200 leading-tight">
            {{ $title }}
        </h2>
        {{ $slot }}
    </div>
</header>
