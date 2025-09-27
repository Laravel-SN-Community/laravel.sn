<header class="bg-[#f8fafc]/70">
    <div class="flex h-16  items-center gap-8 px-4 sm:px-6 lg:px-8" x-data="{ open: false }"
        @keydown.window.escape="open = false">
        <a href="{{ route('welcome') }}" wire:navigate>
            <span class="sr-only">Home</span>
            <x-application-logo class="block h-8 w-auto sm:h-9" aria-hidden="true" />
        </a>

        <div class="flex flex-1 items-center justify-end md:justify-between">
            <nav aria-label="Global" class="hidden md:block">
                <div class="hidden ml-10 items-center gap-6 md:flex">
                    @include('partials._navigation')
                </div>
            </nav>

            <div class="flex items-center gap-4">
                <div class="hidden items-center gap-6 md:flex">
                    @guest
                        <x-nav-link :href="route('login')" title="Se connecter" />
                        <x-nav-link :href="route('register')" title="Créer un compte" />
                    @else
                        <livewire:components.user-dropdown />

                    @endguest

                </div>

                <button
                    class="block rounded-sm bg-gray-100 p-2.5 text-gray-600 transition hover:text-gray-600/75 md:hidden"
                    aria-controls="mobile-menu" @click="open = !open" aria-expanded="false"
                    x-bind:aria-expanded="open.toString()">
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
                        x-transition:leave-end="opacity-0" class="fixed inset-0 bg-black/40 backdrop-blur-sm"
                        @click="open = false" style="display: none"></div>

                    <!-- SLIDE PANEL -->
                    <div x-show="open" x-transition:enter="transform transition ease-in-out duration-300"
                        x-transition:enter-start="-translate-x-full" x-transition:enter-end="translate-x-0"
                        x-transition:leave="transform transition ease-in-out duration-300"
                        x-transition:leave-start="translate-x-0" x-transition:leave-end="-translate-x-full"
                        class="fixed top-0 left-0 h-full w-72 bg-[#f8fafc] shadow-xl" style="display: none">

                        <div class="flex items-center justify-between p-4 border-b">
                            <!-- App Logo -->
                            <x-brand />

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
                                @php
                                    $user = \Illuminate\Support\Facades\Auth::user();
                                @endphp
                                @auth
                                    <div class="flex items-center gap-2">
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
                                    <div class="mt-6 flex flex-col space-y-4">
                                        <x-link :href="route('profile.show')"
                                            class="group flex items-center gap-2 text-sm text-gray-400 dark:text-gray-500">
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"
                                                stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                                stroke-linejoin="round"
                                                class="lucide lucide-circle-user-icon lucide-circle-user size-5">
                                                <circle cx="12" cy="12" r="10" />
                                                <circle cx="12" cy="10" r="3" />
                                                <path d="M7 20.662V19a2 2 0 0 1 2-2h6a2 2 0 0 1 2 2v1.662" />
                                            </svg>
                                            {{ __('global.navigation.profile') }}
                                        </x-link>
                                        <livewire:components.logout />
                                    </div>
                                @else
                                    <div class="flex space-x-4">
                                        <x-nav-link :href="route('login')" title="Se connecter" />
                                        <x-nav-link :href="route('register')" title="Créer un compte" />
                                    </div>
                                @endauth
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>
