<header class="bg-white shadow-xs sticky top-0 z-40">
    <div class="flex h-16 items-center justify-between max-w-7xl mx-auto px-4 sm:px-6 lg:px-8" x-data="{ open: false }"
        @keydown.window.escape="open = false; document.body.style.overflow = 'auto';">
        <a href="{{ route('welcome') }}" wire:navigate>
            <div class="flex items-center space-x-3">
                <img src="{{ asset('images/Laravelsn.jpg') }}" alt="Laravel Senegal"
                    class="h-10 w-10 rounded-full object-cover">
                <h1 class="text-xl font-bold text-gray-900">{{ __('Laravel Senegal') }}</h1>
            </div>
        </a>

        <div class="flex justify-end">
            <nav aria-label="Global" class="hidden md:flex space-x-8 md:items-center">
                <div class="hidden ml-10 items-center gap-6 md:flex">
                    @include('partials._navigation')
                </div>

                {{-- Spacer --}}
                <div class="h-6 w-px bg-gray-300"></div>

                <!-- GitHub icon -->
                <a href="https://github.com/Laravel-SN-Community/laravel.sn" target="_blank"
                    class="text-gray-900 hover:text-red-600 transition-colors" title="GitHub">
                    <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                        <path
                            d="M12 0c-6.626 0-12 5.373-12 12 0 5.302 3.438 9.8 8.207 11.387.599.111.793-.261.793-.577v-2.234c-3.338.726-4.033-1.416-4.033-1.416-.546-1.387-1.333-1.756-1.333-1.756-1.089-.745.083-.729.083-.729 1.205.084 1.839 1.237 1.839 1.237 1.07 1.834 2.807 1.304 3.492.997.107-.775.418-1.305.762-1.604-2.665-.305-5.467-1.334-5.467-5.931 0-1.311.469-2.381 1.236-3.221-.124-.303-.535-1.524.117-3.176 0 0 1.008-.322 3.301 1.23.957-.266 1.983-.399 3.003-.404 1.02.005 2.047.138 3.006.404 2.291-1.552 3.297-1.23 3.297-1.23.653 1.653.242 2.874.118 3.176.77.84 1.235 1.911 1.235 3.221 0 4.609-2.807 5.624-5.479 5.921.43.372.823 1.102.823 2.222v3.293c0 .319.192.694.801.576 4.765-1.589 8.199-6.086 8.199-11.386 0-6.627-5.373-12-12-12z" />
                    </svg>
                </a>

                {{-- Language selector dropdown --}}
                <livewire:pages.lang.change-locale />

                @auth
                    <livewire:components.user-dropdown />
                @else
                    <!-- Login icon -->
                    <a href="{{ route('login') }}" class="text-gray-900 hover:text-red-600 transition-colors"
                        title="{{ __('Login') }}">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="w-6 h-6 text-red-600">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M15.75 9V5.25A2.25 2.25 0 0 0 13.5 3h-6a2.25 2.25 0 0 0-2.25 2.25v13.5A2.25 2.25 0 0 0 7.5 21h6a2.25 2.25 0 0 0 2.25-2.25V15M12 9l-3 3m0 0 3 3m-3-3h12.75" />
                        </svg>
                    </a>
                @endauth
            </nav>

            <div class="flex items-center gap-4">
                <button
                    class="block rounded-sm bg-gray-100 p-2.5 text-gray-600 transition hover:text-gray-600/75 md:hidden"
                    aria-controls="mobile-menu" @click="open = !open; document.body.style.overflow = 'hidden'"
                    aria-expanded="false" x-bind:aria-expanded="open.toString()">
                    <span class="sr-only">Toggle menu</span>
                    <svg xmlns="http://www.w3.org/2000/svg" class="size-5" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </button>

                <!-- Mobile menu button -->
                <div class="lg:hidden">
                    <!-- BACKDROP -->
                    <div x-show="open" x-transition:enter="transition ease-out duration-300"
                        x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
                        x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100"
                        x-transition:leave-end="opacity-0" class="fixed inset-0 z-50 bg-black/40 backdrop-blur-sm"
                        @click="open = false; document.body.style.overflow = 'auto';" style="display: none"></div>

                    <!-- SLIDE PANEL -->
                    <div x-show="open" x-transition:enter="transform transition ease-in-out duration-300"
                        x-transition:enter-start="-translate-x-full" x-transition:enter-end="translate-x-0"
                        x-transition:leave="transform transition ease-in-out duration-300"
                        x-transition:leave-start="translate-x-0" x-transition:leave-end="-translate-x-full"
                        class="fixed top-0 left-0 h-full w-72 bg-[#f8fafc] shadow-xl z-50" style="display: none">

                        <div class="flex items-center justify-between p-4 border-b">
                            <!-- App Logo -->
                            <div class="flex items-center space-x-3">
                                <img src="{{ asset('images/Laravelsn.jpg') }}" alt="Laravel Senegal"
                                    class="h-10 w-10 rounded-full object-cover">
                                <h1 class="text-xl font-bold text-gray-900">{{ __('Laravel Senegal') }}</h1>
                            </div>

                            <!-- Close Button -->
                            <button @click="open = false" class="text-gray-500 hover:text-gray-800">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round"
                                    class="lucide lucide-x-icon lucide-x">
                                    <path d="M18 6 6 18" />
                                    <path d="m6 6 12 12" />
                                </svg>
                            </button>
                        </div>
                        <div class="divide-y-2 divide-gray-50 p-4 relative h-full">
                            <div class="mt-5 flex flex-col space-y-4">
                                @include('partials._navigation')
                            </div>

                            <div class="fixed bottom-4">
                                <div class="flex items-center space-x-4">
                                    @php
                                        $user = \Illuminate\Support\Facades\Auth::user();
                                    @endphp
                                    @auth
                                        <div>

                                            <div class="flex item-center mb-3 justify-between">
                                                <a href="https://github.com/Laravel-SN-Community/laravel.sn" target="_blank"
                                                    rel="noopener noreferrer"
                                                    class="group flex items-center gap-2 text-sm text-gray-900 pr-3 pl-2"
                                                    title="View on GitHub">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                        viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                        class="lucide lucide-github-icon lucide-github">
                                                        <path
                                                            d="M15 22v-4a4.8 4.8 0 0 0-1-3.5c3 0 6-2 6-5.5.08-1.25-.27-2.48-1-3.5.28-1.15.28-2.35 0-3.5 0 0-1 0-3 1.5-2.64-.5-5.36-.5-8 0C6 2 5 2 5 2c-.3 1.15-.3 2.35 0 3.5A5.403 5.403 0 0 0 4 9c0 3.5 3 5.5 6 5.5-.39.49-.68 1.05-.85 1.65-.17.6-.22 1.23-.15 1.85v4" />
                                                        <path d="M9 18c-4.51 2-5-2-7-2" />
                                                    </svg>
                                                    <span class="inline">GitHub</span>
                                                </a>
                                                {{-- Spacer --}}
                                                <div class=" w-px bg-gray-300"></div>

                                                <livewire:pages.lang.change-locale />
                                            </div>

                                            <x-dropdown align="top-left" width="60">
                                                <x-slot name="trigger">
                                                    <div class="flex items-center gap-2 cursor-pointer">
                                                        <div class="shrink-0">
                                                            <x-user.avatar :user="$user" class="size-8" />
                                                        </div>
                                                        <div class="leading-4">
                                                            <div class="text-sm font-medium text-gray-90">
                                                                {{ $user->name }}
                                                            </div>
                                                            <div class="text-sm text-gray-400 dark:text-gray-500">
                                                                {{ $user->email }}
                                                            </div>
                                                        </div>
                                                    </div>
                                                </x-slot>
                                                <x-slot name="content">
                                                    <div class="flex flex-col p-4 space-y-4">
                                                        <a href="{{ route('dashboard') }}"
                                                            class="group flex items-center gap-2 text-sm text-gray-400 dark:text-gray-500">
                                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                                                                fill="none" stroke="currentColor" stroke-width="2"
                                                                stroke-linecap="round" stroke-linejoin="round"
                                                                class="lucide lucide-circle-user-icon lucide-circle-user size-5">
                                                                <circle cx="12" cy="12" r="10" />
                                                                <circle cx="12" cy="10" r="3" />
                                                                <path
                                                                    d="M7 20.662V19a2 2 0 0 1 2-2h6a2 2 0 0 1 2 2v1.662" />
                                                            </svg>
                                                            {{ __('Dashboard') }}
                                                        </a>
                                                        <livewire:components.logout />
                                                    </div>
                                                </x-slot>
                                            </x-dropdown>
                                        </div>
                                    @else
                                        <div class="flex flex-col gap-4">
                                            <a href="{{ route('login') }}"
                                                class="flex items-center gap-2 px-3 py-2 rounded-lg border border-gray-300 hover:border-gray-400 bg-white hover:bg-gray-50 text-gray-800 hover:text-gray-900 transition-all duration-200 hover:scale-105 hover:shadow-lg whitespace-nowrap font-medium"
                                                title="{{ __('Login') }}">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                                </svg>
                                                <span>{{ __('Login') }}</span>
                                            </a>

                                           <div class="flex item-center mb-3 justify-between">
                                                <a href="https://github.com/Laravel-SN-Community/laravel.sn" target="_blank"
                                                    rel="noopener noreferrer"
                                                    class="group flex items-center gap-2 text-sm text-gray-900 pr-3 pl-2"
                                                    title="View on GitHub">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                        viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                        class="lucide lucide-github-icon lucide-github">
                                                        <path
                                                            d="M15 22v-4a4.8 4.8 0 0 0-1-3.5c3 0 6-2 6-5.5.08-1.25-.27-2.48-1-3.5.28-1.15.28-2.35 0-3.5 0 0-1 0-3 1.5-2.64-.5-5.36-.5-8 0C6 2 5 2 5 2c-.3 1.15-.3 2.35 0 3.5A5.403 5.403 0 0 0 4 9c0 3.5 3 5.5 6 5.5-.39.49-.68 1.05-.85 1.65-.17.6-.22 1.23-.15 1.85v4" />
                                                        <path d="M9 18c-4.51 2-5-2-7-2" />
                                                    </svg>
                                                    <span class="inline">GitHub</span>
                                                </a>
                                                {{-- Spacer --}}
                                                <div class="mx-1 w-px bg-gray-300"></div>

                                                <livewire:pages.lang.change-locale />
                                            </div>
                                        </div>
                                    @endauth
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>
