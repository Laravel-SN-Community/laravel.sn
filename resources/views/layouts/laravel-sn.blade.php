<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Styles -->
    @livewireStyles
</head>

<body class="h-full">

    <div x-data="{ userDropdownOpen: false, mobileNavOpen: false }">
        <x-sidebar />
        <div class="lg:pl-72">
            <x-topbar />

        </div>
        {{-- <livewire:notifications/> --}}
        {{-- <livewire:database-notifications/> --}}
    </div>

    @stack('modals')
    @filamentScripts()
    @vite(['resources/js/app.js'])
</body>

</html>
