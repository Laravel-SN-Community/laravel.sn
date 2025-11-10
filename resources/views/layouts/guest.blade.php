@php
    use App\Models\Event;
    $ongoingEvent = Event::query()->upcoming()->published()->first();
@endphp

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>
        {{ isset($title) && $title ? "$title | " : '' }}{{ config('app.name') }}
        {{ request()->routeIs('welcome') ? ' - ' . 'La plus grande communauté de développeurs Laravel au Sénégal' : '' }}
    </title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400..900;1,400..900&display=swap"
        rel="stylesheet">

    <!-- Icons -->
    @include('partials._favicons')

    <!-- Prism.js for syntax highlighting -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/prism/1.29.0/themes/prism-tomorrow.min.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/prism/1.29.0/components/prism-core.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/prism/1.29.0/plugins/autoloader/prism-autoloader.min.js"></script>

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Styles -->
    @livewireStyles

    <!-- Mixpanel -->
    @include('genealabs-laravel-mixpanel::partials.mixpanel')

    <!-- Additional scripts -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.13.0/all.min.js"
        integrity="sha512-fxASHhXi6WjjUR9Hr8qt2IxNW2AzyZOpoPi4+UgVU0lTFNKMQ8INkZaQ5ZED2aAldHuHNaLlaHuwQ1oGT+LHhw=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"
        integrity="sha256-4+XzXVhsDmqanXGHaHvgh1gMQKX40OUvDEBTu8JcmNs=" crossorigin="anonymous"></script>
</head>

<body>
    <div class="min-h-screen w-full bg-[#f8fafc]">
        
        <div class="font-sans text-gray-900 antialiased">
            <x-topbar-guest />
            {{ $slot }}
            <x-footer />
        </div>
        <x-toaster-hub />
    </div>

    @livewireScripts
</body>

</html>
