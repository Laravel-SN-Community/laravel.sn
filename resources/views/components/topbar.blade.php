{{-- 
    Topbar Component
    
    Features:
    - Responsive design with mobile hamburger menu
    - User profile dropdown with smooth animations
    - Support for notifications (commented out for future use)
    - Proper Alpine.js state management
--}}

<div class="sticky top-0 z-40 flex h-16 shrink-0 items-center gap-x-4 border-b border-gray-200 bg-white px-4 shadow-xs sm:gap-x-6 sm:px-6 lg:px-8">
    
    {{-- Mobile menu button - only visible on mobile devices --}}
    <button 
        type="button" 
        class="-m-2.5 p-2.5 text-gray-700 transition-colors duration-200 hover:text-gray-900 lg:hidden" 
        x-on:click="mobileNavOpen = true"
        aria-label="Open sidebar"
    >
        <span class="sr-only">Open sidebar</span>
        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
            <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5"/>
        </svg>
    </button>

    {{-- Separator between mobile menu button and content --}}
    <div class="h-6 w-px bg-gray-200 lg:hidden" aria-hidden="true"></div>

    {{-- Main topbar content area --}}
    <div class="flex flex-1 justify-end gap-x-4 self-stretch lg:gap-x-6">
        <div class="flex items-center gap-x-4 lg:gap-x-6">
            
            {{-- Future: Impersonation notice --}}
            {{-- @impersonating($guard = null)
            <div class="flex items-center gap-x-2 rounded-md bg-yellow-50 px-3 py-1 text-sm text-yellow-800 ">
                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z" />
                </svg>
                <span>Impersonating user</span>
                <a href="{{ route('impersonate.leave') }}" class="ml-2 font-medium underline hover:no-underline">
                    Leave
                </a>
            </div>
            @endImpersonating --}}

            {{-- Future: Notification bell --}}
            {{-- <button type="button" class="relative -m-2.5 p-2.5 text-gray-400 hover:text-gray-500 ">
                <span class="sr-only">View notifications</span>
                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M14.857 17.082a23.848 23.848 0 005.454-1.31A8.967 8.967 0 0118 9.75v-.7V9A6 6 0 006 9v.75a8.967 8.967 0 01-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 01-5.714 0m5.714 0a3 3 0 11-5.714 0" />
                </svg>
                <span class="absolute -top-0.5 -right-0.5 h-4 w-4 rounded-full bg-red-500 text-xs font-medium text-white flex items-center justify-center">3</span>
            </button> --}}

            {{-- Separator before profile dropdown --}}
            <div class="hidden lg:block lg:h-6 lg:w-px lg:bg-gray-200 " aria-hidden="true"></div>

            {{-- User profile dropdown --}}
            <div class="relative" x-data="{ open: false }" x-on:click.away="open = false">
                <button 
                    type="button" 
                    class="-m-1.5 flex items-center rounded-lg p-1.5 transition-colors duration-200 hover:bg-gray-50 " 
                    id="user-menu-button" 
                    aria-expanded="false"
                    aria-haspopup="true" 
                    x-on:click="open = !open"
                    :aria-expanded="open"
                >
                    <span class="sr-only">Open user menu</span>
                    
                    {{-- User avatar --}}
                    <div class="flex h-8 w-8 items-center justify-center rounded-full bg-gray-100 ">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="h-5 w-5 text-gray-600 ">
                            <path fill-rule="evenodd" d="M18.685 19.097A9.723 9.723 0 0021.75 12c0-5.385-4.365-9.75-9.75-9.75S2.25 6.615 2.25 12a9.723 9.723 0 003.065 7.097A9.716 9.716 0 0012 21.75a9.716 9.716 0 006.685-2.653zm-12.54-1.285A7.486 7.486 0 0112 15a7.486 7.486 0 015.855 2.812A8.224 8.224 0 0112 20.25a8.224 8.224 0 01-5.855-2.438zM15.75 9a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0z" clip-rule="evenodd"/>
                        </svg>
                    </div>
                    
                    {{-- User name and dropdown arrow (hidden on mobile) --}}
                    <span class="hidden lg:flex lg:items-center">
                        <span class="ml-3 text-sm font-semibold leading-6 text-gray-900 ">
                            {{ Auth::user()->name }}
                        </span>
                        <svg 
                            class="ml-2 h-5 w-5 text-gray-400 transition-transform duration-200 " 
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
                    class="absolute right-0 z-10 mt-2.5 w-48 origin-top-right rounded-lg bg-white py-2 shadow-lg ring-1 ring-gray-900/5   focus:outline-hidden"
                    role="menu" 
                    aria-orientation="vertical" 
                    aria-labelledby="user-menu-button" 
                    tabindex="-1"
                    x-cloak 
                    x-show="open"
                    x-transition:enter="transition ease-out duration-100"
                    x-transition:enter-start="transform opacity-0 scale-95"
                    x-transition:enter-end="transform opacity-100 scale-100"
                    x-transition:leave="transition ease-in duration-75"
                    x-transition:leave-start="transform opacity-100 scale-100"
                    x-transition:leave-end="transform opacity-0 scale-95"
                >
                    {{-- User info header --}}
                    <div class="px-4 py-2 border-b border-gray-100 ">
                        <p class="text-sm font-medium text-gray-900 ">{{ Auth::user()->name }}</p>
                        <p class="text-sm text-gray-500  truncate">{{ Auth::user()->email }}</p>
                    </div>

                    {{-- Menu items --}}
                    <div class="py-1">
                        <a 
                            href="{{ route('profile.show') }}" 
                            wire:navigate
                            class="group flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 hover:text-gray-900  transition-colors duration-200"
                            role="menuitem" 
                            tabindex="-1"
                        >
                            <svg class="mr-3 h-4 w-4 text-gray-400 group-hover:text-gray-500  " fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0014.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z" />
                            </svg>
                            {{ __('Profile') }}
                        </a>
                        
                        {{-- Future: Settings link --}}
                        {{-- <a href="#" class="group flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 hover:text-gray-900  transition-colors duration-200" role="menuitem">
                            <svg class="mr-3 h-4 w-4 text-gray-400 group-hover:text-gray-500  " fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9.594 3.94c.09-.542.56-.94 1.11-.94h2.593c.55 0 1.02.398 1.11.94l.213 1.281c.063.374.313.686.645.87.074.04.147.083.22.127.324.196.72.257 1.075.124l1.217-.456a1.125 1.125 0 011.37.49l1.296 2.247a1.125 1.125 0 01-.26 1.431l-1.003.827c-.293.24-.438.613-.431.992a6.759 6.759 0 010 .255c-.007.378.138.75.43.99l1.005.828c.424.35.534.954.26 1.43l-1.298 2.247a1.125 1.125 0 01-1.369.491l-1.217-.456c-.355-.133-.75-.072-1.076.124a6.57 6.57 0 01-.22.128c-.331.183-.581.495-.644.869l-.213 1.28c-.09.543-.56.941-1.11.941h-2.594c-.55 0-1.02-.398-1.11-.94l-.213-1.281c-.062-.374-.312-.686-.644-.87a6.52 6.52 0 01-.22-.127c-.325-.196-.72-.257-1.076-.124l-1.217.456a1.125 1.125 0 01-1.369-.49l-1.297-2.247a1.125 1.125 0 01.26-1.431l1.004-.827c.292-.24.437-.613.43-.992a6.932 6.932 0 010-.255c.007-.378-.138-.75-.43-.99l-1.004-.828a1.125 1.125 0 01-.26-1.43l1.297-2.247a1.125 1.125 0 011.37-.491l1.216.456c.356.133.751.072 1.076-.124.072-.044.146-.087.22-.128.332-.183.582-.495.644-.869l.214-1.281z" />
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                            {{ __('Settings') }}
                        </a> --}}
                    </div>

                    {{-- Logout section --}}
                    <div class="border-t border-gray-100  py-1">
                        <form method="POST" action="{{ route('logout') }}" x-data="{}">
                            @csrf
                            <button 
                                type="submit"
                                class="group flex w-full items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 hover:text-gray-900  transition-colors duration-200"
                                role="menuitem" 
                                tabindex="-1"
                            >
                                <svg class="mr-3 h-4 w-4 text-gray-400 group-hover:text-gray-500  " fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6a2.25 2.25 0 00-2.25 2.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15M12 9l-3 3m0 0l3 3m-3-3h12.75" />
                                </svg>
                                {{ __('Logout') }}
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

