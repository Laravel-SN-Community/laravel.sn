<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;600;700&display=swap" rel="stylesheet">

    <!-- Heroicons CSS -->
    <link href="https://unpkg.com/heroicons@2.0.18/24/outline/style.css" rel="stylesheet">
    <link
    href="https://cdn.jsdelivr.net/npm/remixicon@4.7.0/fonts/remixicon.css"
    rel="stylesheet"
/>

    <!-- App CSS -->
    @vite(['resources/css/app.css'])

    <!-- Filament + Livewire styles -->
    @filamentStyles
    @livewireStyles
</head>
<body class="h-full bg-gray-50 antialiased">
    <div x-data="{ userDropdownOpen: false, mobileNavOpen: false }" class="h-full">
        <x-sidebar />

        <div class="lg:pl-72">
            <x-topbar />
            <main class="py-6">
                <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                    {{ $slot }}
                </div>
            </main>
        </div>
    </div>
 
    @livewireScripts
    @filamentScripts
    @vite(['resources/js/app.js'])
</body>
</html>
