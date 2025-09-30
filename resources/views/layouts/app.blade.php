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
    <body class="h-full bg-gray-50">
        {{-- 
            Main Application Layout
            
            Features:
            - Alpine.js state management for mobile navigation and dropdowns
            - Responsive sidebar layout
            - Proper content area with padding
        --}}
        <div x-data="{ userDropdownOpen: false, mobileNavOpen: false }" class="h-full">
            {{-- Sidebar Component --}}
            <x-sidebar/>
            
            {{-- Main Content Area --}}
            <div class="lg:pl-72">
                {{-- Top Navigation Bar --}}
                <x-topbar/>
                
                {{-- Page Content --}}
                <main class="py-6">
                    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                        {{ $slot }}
                    </div>
                </main>
            </div>
            
            {{-- Future: Notification Components --}}
            {{-- <livewire:notifications/> --}}
            {{-- <livewire:database-notifications/> --}}
        </div>
        
        {{-- Modal Stack --}}
        @stack('modals')
        
        {{-- Scripts --}}
        @filamentScripts()
        @livewireScripts
        @vite(['resources/js/app.js'])
    </body>
</html>
