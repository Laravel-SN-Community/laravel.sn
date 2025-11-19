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
    <link href="https://fonts.googleapis.com/css2?family=Work+Sans:ital,wght@0,100..900;1,100..900&display=swap"
        rel="stylesheet">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/css/filament.css', 'resources/js/app.js'])

    <!-- Styles -->
    @filamentStyles
    @livewireStyles

    <!-- Mixpanel -->
    @include('genealabs-laravel-mixpanel::partials.mixpanel')
</head>

<body class="h-full bg-gray-50">

    {{-- Top Navigation Bar --}}
    <x-topbar />
    <div x-data="{ userDropdownOpen: false }" class="">

        {{-- Page Content --}}
        <main class="py-6">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                {{ $slot }}
            </div>
        </main>

        {{-- Future: Notification Components --}}
        @livewire('notifications')
    </div>

    @stack('modals')

    @filamentScripts()
    @livewireScripts
    @vite(['resources/js/app.js'])
</body>

</html>
