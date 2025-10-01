{{-- 
    Sidebar Component
    
    Features:
    - Responsive mobile off-canvas sidebar with backdrop
    - Smooth slide-in/out animations
    - Fixed desktop sidebar
    - Proper focus management and accessibility
    - Click outside to close functionality
--}}

{{-- Mobile off-canvas sidebar overlay --}}
<div 
    class="relative z-50 lg:hidden" 
    role="dialog" 
    aria-modal="true" 
    x-cloak 
    x-show="mobileNavOpen"
    x-transition:enter="transition-opacity ease-linear duration-300"
    x-transition:enter-start="opacity-0"
    x-transition:enter-end="opacity-100"
    x-transition:leave="transition-opacity ease-linear duration-300"
    x-transition:leave-start="opacity-100"
    x-transition:leave-end="opacity-0"
>
    {{-- Backdrop - click to close sidebar --}}
    <div 
        class="fixed inset-0 bg-gray-900/80 backdrop-blur-xs"
        x-on:click="mobileNavOpen = false"
        aria-hidden="true"
    ></div>

    {{-- Sidebar container --}}
    <div class="fixed inset-0 flex">
        {{-- Mobile sidebar panel --}}
        <div 
            class="relative mr-16 flex w-full max-w-xs flex-1"
            x-transition:enter="transition ease-in-out duration-300 transform"
            x-transition:enter-start="-translate-x-full"
            x-transition:enter-end="translate-x-0"
            x-transition:leave="transition ease-in-out duration-300 transform"
            x-transition:leave-start="translate-x-0"
            x-transition:leave-end="-translate-x-full"
        >
            {{-- Close button --}}
            <div class="absolute left-full top-0 flex w-16 justify-center pt-5">
                <button 
                    type="button" 
                    class="-m-2.5 rounded-md p-2.5 text-white hover:text-gray-300 focus:outline-hidden focus:ring-2 focus:ring-white focus:ring-offset-2 focus:ring-offset-gray-900 transition-colors duration-200" 
                    x-on:click="mobileNavOpen = false"
                    aria-label="Close sidebar"
                >
                    <span class="sr-only">Close sidebar</span>
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>

            {{-- Mobile sidebar content --}}
            <div class="flex grow flex-col gap-y-5 overflow-y-auto bg-white px-6 pb-4 shadow-xl ">
                {{-- Logo section --}}
                <div class="flex h-16 shrink-0 items-center">
                    <img 
                        src="{{ asset('images/Laravelsn.jpg') }}" 
                        class="block h-10 w-auto"
                    />
                    <span class="ml-3 text-xl font-semibold text-gray-900 ">
                        {{ config('app.name') }}
                    </span>
                </div>
                
                {{-- Navigation items --}}
                <x-sidebar-items/>
                
                {{-- Mobile sidebar footer --}}
                <div class="mt-auto">
                    <div class="border-t border-gray-200 pt-4 ">
                        <div class="flex items-center px-2">
                            <div class="flex h-8 w-8 items-center justify-center rounded-full bg-gray-100 ">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="h-4 w-4 text-gray-600 ">
                                    <path fill-rule="evenodd" d="M18.685 19.097A9.723 9.723 0 0021.75 12c0-5.385-4.365-9.75-9.75-9.75S2.25 6.615 2.25 12a9.723 9.723 0 003.065 7.097A9.716 9.716 0 0012 21.75a9.716 9.716 0 006.685-2.653zm-12.54-1.285A7.486 7.486 0 0112 15a7.486 7.486 0 015.855 2.812A8.224 8.224 0 0112 20.25a8.224 8.224 0 01-5.855-2.438zM15.75 9a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0z" clip-rule="evenodd"/>
                                </svg>
                            </div>
                            <div class="ml-3">
                                <p class="text-sm font-medium text-gray-900 ">{{ Auth::user()->name }}</p>
                                <p class="text-xs text-gray-500  truncate">{{ Auth::user()->email }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Desktop static sidebar --}}
<div class="hidden lg:fixed lg:inset-y-0 lg:z-50 lg:flex lg:w-72 lg:flex-col">
    {{-- Desktop sidebar content --}}
    <div class="flex grow flex-col gap-y-5 overflow-y-auto border-r border-gray-200 bg-white px-6 pb-4  ">
        {{-- Logo section --}}
        <div class="flex h-16 shrink-0 items-center">
            <img 
                src="{{ asset(config('app.logo')) }}" 
                alt="{{ config('app.name') }}"
                class="block h-10 w-auto"
            />
            <span class="ml-3 text-xl font-semibold text-gray-900 ">
                {{ config('app.name') }}
            </span>
        </div>
        
        {{-- Navigation items --}}
        <x-sidebar-items/>
        
        {{-- Desktop sidebar footer --}}
        <div class="mt-auto">
            <div class="border-t border-gray-200 pt-4 ">
                {{-- User info in desktop sidebar --}}
                <div class="flex items-center px-2 py-2 rounded-lg hover:bg-gray-50  transition-colors duration-200">
                    <div class="flex h-8 w-8 items-center justify-center rounded-full bg-gray-100 ">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="h-4 w-4 text-gray-600 ">
                            <path fill-rule="evenodd" d="M18.685 19.097A9.723 9.723 0 0021.75 12c0-5.385-4.365-9.75-9.75-9.75S2.25 6.615 2.25 12a9.723 9.723 0 003.065 7.097A9.716 9.716 0 0012 21.75a9.716 9.716 0 006.685-2.653zm-12.54-1.285A7.486 7.486 0 0112 15a7.486 7.486 0 015.855 2.812A8.224 8.224 0 0112 20.25a8.224 8.224 0 01-5.855-2.438zM15.75 9a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0z" clip-rule="evenodd"/>
                        </svg>
                    </div>
                    <div class="ml-3 flex-1">
                        <p class="text-sm font-medium text-gray-900 ">{{ Auth::user()->name }}</p>
                        <p class="text-xs text-gray-500  truncate">{{ Auth::user()->email }}</p>
                    </div>
                    {{-- Status indicator --}}
                    <div class="flex h-2 w-2 rounded-full bg-green-400"></div>
                </div>
                
                {{-- Quick actions in desktop sidebar --}}
                <div class="mt-3 flex gap-2">
                    <a 
                        href="{{ route('profile.show') }}" 
                        wire:navigate
                        class="flex-1 rounded-md bg-gray-50 px-3 py-2 text-xs font-medium text-gray-700 hover:bg-gray-100   transition-colors duration-200 text-center"
                        title="View Profile"
                    >
                        Profile
                    </a>
                    <form method="POST" action="{{ route('logout') }}" class="flex-1">
                        @csrf
                        <button 
                            type="submit"
                            class="w-full rounded-md bg-gray-50 px-3 py-2 text-xs font-medium text-gray-700 hover:bg-gray-100   transition-colors duration-200"
                            title="Logout"
                        >
                            Logout
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
