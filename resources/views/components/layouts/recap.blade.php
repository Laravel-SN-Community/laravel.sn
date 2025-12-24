<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Recap 2025 - {{ config('app.name') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
    <style>
        @keyframes progress {
            from {
                width: 0%;
            }
            to {
                width: 100%;
            }
        }
        .animate-progress {
            animation: progress linear forwards;
        }
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        @keyframes fadeInDown {
            from {
                opacity: 0;
                transform: translateY(-30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        @keyframes zoomIn {
            from {
                opacity: 0;
                transform: scale(0.5);
            }
            to {
                opacity: 1;
                transform: scale(1);
            }
        }
        @keyframes rotateIn {
            from {
                opacity: 0;
                transform: rotate(-180deg) scale(0.5);
            }
            to {
                opacity: 1;
                transform: rotate(0deg) scale(1);
            }
        }
        @keyframes bounce {
            0%, 20%, 50%, 80%, 100% {
                transform: translateY(0);
            }
            40% {
                transform: translateY(-20px);
            }
            60% {
                transform: translateY(-10px);
            }
        }
        @keyframes pulse {
            0%, 100% {
                opacity: 1;
                transform: scale(1);
            }
            50% {
                opacity: 0.8;
                transform: scale(1.2);
            }
        }
        @keyframes float {
            0%, 100% {
                transform: translateY(0px) translateX(0px);
            }
            33% {
                transform: translateY(-20px) translateX(10px);
            }
            66% {
                transform: translateY(-10px) translateX(-10px);
            }
        }
        @keyframes slideInFromRight {
            from {
                opacity: 0;
                transform: translateX(100px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }
        @keyframes slideInFromLeft {
            from {
                opacity: 0;
                transform: translateX(-100px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }
        @keyframes shimmer {
            0% {
                opacity: 0.5;
            }
            50% {
                opacity: 1;
            }
            100% {
                opacity: 0.5;
            }
        }
        @keyframes spin {
            from {
                transform: rotate(0deg);
            }
            to {
                transform: rotate(360deg);
            }
        }
        @keyframes gridFadeIn {
            from {
                opacity: 0;
                transform: scale(0.8);
            }
            to {
                opacity: 1;
                transform: scale(1);
            }
        }
        @keyframes gridSlideIn {
            from {
                opacity: 0;
                transform: translateY(50px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        @keyframes gridZoomOut {
            from {
                opacity: 1;
                transform: scale(1);
            }
            to {
                opacity: 0;
                transform: scale(1.1);
            }
        }
        .animate-grid-fade-in {
            animation: gridFadeIn 0.6s ease-out forwards;
        }
        .animate-grid-slide-in {
            animation: gridSlideIn 0.6s ease-out forwards;
        }
        .animate-grid-zoom-out {
            animation: gridZoomOut 0.8s ease-out forwards;
        }
        .animate-fade-in-up {
            animation: fadeInUp 1.2s ease-out;
        }
        .animate-fade-in-down {
            animation: fadeInDown 1.2s ease-out;
        }
        .animate-zoom-in {
            animation: zoomIn 1s ease-out;
        }
        .animate-rotate-in {
            animation: rotateIn 1.5s ease-out;
        }
        .animate-bounce {
            animation: bounce 2s ease-in-out infinite;
        }
        .animate-pulse-slow {
            animation: pulse 2s ease-in-out infinite;
        }
        .animate-float {
            animation: float 8s ease-in-out infinite;
        }
        .animate-slide-in-right {
            animation: slideInFromRight 1s ease-out;
        }
        .animate-slide-in-left {
            animation: slideInFromLeft 1s ease-out;
        }
        .animate-shimmer {
            animation: shimmer 2s ease-in-out infinite;
        }
        .animate-spin-slow {
            animation: spin 20s linear infinite;
        }
        body {
            overflow: hidden;
        }
    </style>
</head>
<body class="bg-black">
    {{ $slot }}
    @livewireScripts
</body>
</html>

