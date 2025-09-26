@props(['title' => null, 'canonical' => null])

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full scroll-smooth">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ isset($title) ? $title . ' | ' : '' }} {{ __('global.site_name') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    {{-- Favivons --}}
    @include('partials._favicons')

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Styles -->
    @livewireStyles
</head>

<body>
    <div class="min-h-screen w-full bg-[#f8fafc] relative">
        <div class="absolute inset-0 z-0 h-screen"
            style="
    background-image: linear-gradient(to right, #e2e8f0 1px, transparent 1px), linear-gradient(to bottom, #e2e8f0 1px, transparent 1px);
    background-size: 20px 30px;
    -webkit-mask-image: radial-gradient(ellipse 70% 60% at 50% 0%, #000 60%, transparent 100%);
    mask-image: radial-gradient(ellipse 70% 60% at 50% 0%, #000 60%, transparent 100%);
    " />
    </div>
    <div class="absolute inset-0 z-10">
        <x-layouts.header />

        {{ $slot }}

        {{-- <x-toaster-hub /> --}}
    </div>
    </div>
    @livewireScripts
</body>

</html>
