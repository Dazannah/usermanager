<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ app_settings()->app_name ?? config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @livewireScriptConfig
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        :root {
            --primary_color: #{{ app_settings()->primary_color }};
            --secondary_color: #{{ app_settings()->secondary_color }};
        }
    </style>
</head>
