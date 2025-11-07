<div class="sticky top-0 z-40 flex h-16 shrink-0 items-center gap-x-4 border-b border-gray-200 bg-white/80 backdrop-blur-md px-4 shadow-sm sm:gap-x-6 sm:px-6 lg:px-8">
    
    {{-- Mobile menu button - only visible on mobile devices --}}
    <button 
        type="button" 
        class="flex h-10 w-10 items-center justify-center rounded-lg text-gray-700 hover:bg-gray-100 transition-all duration-200 lg:hidden" 
        x-on:click="mobileNavOpen = true"
        aria-label="Open sidebar"
    >
        <span class="sr-only">Open sidebar</span>
        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" aria-hidden="true">
            <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5"/>
        </svg>
    </button>

    {{-- Separator between mobile menu button and content --}}
    <div class="h-6 w-px bg-gray-200 lg:hidden" aria-hidden="true"></div>

    {{-- Main topbar content area --}}
    <div class="flex flex-1 justify-end gap-x-4 self-stretch lg:gap-x-6">
        <div class="flex items-center gap-x-4 lg:gap-x-6">
            
            {{-- Language selector dropdown --}}
            <livewire:pages.lang.change-locale />
            
            {{-- User profile dropdown --}}
            <div class="relative" x-data="{ open: false }" x-on:click.away="open = false">
                <button 
                    type="button" 
                    class="flex items-center gap-2 rounded-lg px-3 py-2 transition-all duration-200 hover:bg-gray-100" 
                    id="user-menu-button" 
                    aria-expanded="false"
                    aria-haspopup="true" 
                    x-on:click="open = !open"
                    :aria-expanded="open"
                >
                    <span class="sr-only">Open user menu</span>
                    
                    {{-- User avatar with gradient --}}
                    <div class="flex h-9 w-9 items-center justify-center rounded-full bg-red-600 shadow-sm ring-2 ring-white">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="h-5 w-5 text-white">
                            <path fill-rule="evenodd" d="M18.685 19.097A9.723 9.723 0 0021.75 12c0-5.385-4.365-9.75-9.75-9.75S2.25 6.615 2.25 12a9.723 9.723 0 003.065 7.097A9.716 9.716 0 0012 21.75a9.716 9.716 0 006.685-2.653zm-12.54-1.285A7.486 7.486 0 0112 15a7.486 7.486 0 015.855 2.812A8.224 8.224 0 0112 20.25a8.224 8.224 0 01-5.855-2.438zM15.75 9a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0z" clip-rule="evenodd"/>
                        </svg>
                    </div>
                    
                    {{-- User name and dropdown arrow (hidden on mobile) --}}
                    <span class="hidden lg:flex lg:items-center lg:gap-2">
                        <span class="text-sm font-semibold text-gray-900">
                            {{ Auth::user()->name }}
                        </span>
                        <svg 
                            class="h-4 w-4 text-gray-500 transition-transform duration-200" 
                            :class="{ 'rotate-180': open }"
                            viewBox="0 0 20 20" 
                            fill="currentColor" 
                            aria-hidden="true"
                        >
                            <path fill-rule="evenodd" d="M5.23 7.21a.75.75 0 011.06.02L10 11.168l3.71-3.938a.75.75 0 111.08 1.04l-4.25 4.5a.75.75 0 01-1.08 0l-4.25-4.5a.75.75 0 01.02-1.06z" clip-rule="evenodd"/>
                        </svg>
                    </span>
                </button>

                {{-- Dropdown menu with smooth animations --}}
                <div
                    class="absolute right-0 z-10 mt-3 w-56 origin-top-right rounded-xl bg-white shadow-xl ring-1 ring-gray-900/5 focus:outline-none overflow-hidden"
                    role="menu" 
                    aria-orientation="vertical" 
                    aria-labelledby="user-menu-button" 
                    tabindex="-1"
                    x-cloak 
                    x-show="open"
                    x-transition:enter="transition ease-out duration-150"
                    x-transition:enter-start="transform opacity-0 scale-95"
                    x-transition:enter-end="transform opacity-100 scale-100"
                    x-transition:leave="transition ease-in duration-100"
                    x-transition:leave-start="transform opacity-100 scale-100"
                    x-transition:leave-end="transform opacity-0 scale-95"
                >
                    {{-- User info header with gradient --}}
                    <div class="bg-gradient-to-r from-blue-600 to-indigo-600 px-4 py-3">
                        <div class="flex items-center gap-3">
                            <div class="flex h-10 w-10 items-center justify-center rounded-full bg-white/20 backdrop-blur-sm ring-2 ring-white/30">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="h-5 w-5 text-white">
                                    <path fill-rule="evenodd" d="M18.685 19.097A9.723 9.723 0 0021.75 12c0-5.385-4.365-9.75-9.75-9.75S2.25 6.615 2.25 12a9.723 9.723 0 003.065 7.097A9.716 9.716 0 0012 21.75a9.716 9.716 0 006.685-2.653zm-12.54-1.285A7.486 7.486 0 0112 15a7.486 7.486 0 015.855 2.812A8.224 8.224 0 0112 20.25a8.224 8.224 0 01-5.855-2.438zM15.75 9a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0z" clip-rule="evenodd"/>
                                </svg>
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="text-sm font-semibold text-white">{{ Auth::user()->name }}</p>
                                <p class="text-xs text-blue-100 truncate">{{ Auth::user()->email }}</p>
                            </div>
                        </div>
                    </div>

                    {{-- Menu items --}}
                    <div class="py-2">
                        <a 
                            href="{{ route('profile.show') }}" 
                            wire:navigate
                            class="group flex items-center gap-3 px-4 py-2.5 text-sm font-medium text-gray-700 hover:bg-gray-50 transition-colors duration-150"
                            role="menuitem" 
                            tabindex="-1"
                        >
                            <div class="flex h-8 w-8 items-center justify-center rounded-lg bg-gray-100 group-hover:bg-blue-100 transition-colors duration-150">
                                <svg class="h-4 w-4 text-gray-600 group-hover:text-blue-600" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0014.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z" />
                                </svg>
                            </div>
                            <span>{{ __('Profile') }}</span>
                        </a>
                    </div>

                    <div class="border-t border-gray-100 py-2">
                        <form method="POST" action="{{ route('logout') }}" x-data="{}">
                            @csrf
                            <button 
                                type="submit"
                                class="group flex w-full items-center gap-3 px-4 py-2.5 text-sm font-medium text-gray-700 hover:bg-red-50 transition-colors duration-150"
                                role="menuitem" 
                                tabindex="-1"
                            >
                                <div class="flex h-8 w-8 items-center justify-center rounded-lg bg-gray-100 group-hover:bg-red-100 transition-colors duration-150">
                                    <svg class="h-4 w-4 text-gray-600 group-hover:text-red-600" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6a2.25 2.25 0 00-2.25 2.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15M12 9l-3 3m0 0l3 3m-3-3h12.75" />
                                    </svg>
                                </div>
                                <span>{{ __('Logout') }}</span>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

