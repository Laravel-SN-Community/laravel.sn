{{-- 
    Modern Sidebar Component
    
    Features:
    - Responsive mobile off-canvas sidebar with backdrop
    - Smooth slide-in/out animations
    - Fixed desktop sidebar with modern gradient
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
        class="fixed inset-0 bg-gray-900/60 backdrop-blur-sm"
        x-on:click="mobileNavOpen = false"
        aria-hidden="true"
    ></div>

    {{-- Sidebar container --}}
    <div class="fixed inset-0 flex">
        {{-- Mobile sidebar panel --}}
        <div 
            class="relative mr-16 flex w-full max-w-xs flex-1"
            x-transition:enter="transition ease-out duration-300 transform"
            x-transition:enter-start="-translate-x-full"
            x-transition:enter-end="translate-x-0"
            x-transition:leave="transition ease-in duration-200 transform"
            x-transition:leave-start="translate-x-0"
            x-transition:leave-end="-translate-x-full"
        >
            {{-- Close button --}}
            <div class="absolute left-full top-0 flex w-16 justify-center pt-5">
                <button 
                    type="button" 
                    class="flex h-10 w-10 items-center justify-center rounded-full bg-white/10 backdrop-blur-sm text-white hover:bg-white/20 focus:outline-none focus:ring-2 focus:ring-white transition-all duration-200" 
                    x-on:click="mobileNavOpen = false"
                    aria-label="Close sidebar"
                >
                    <span class="sr-only">Close sidebar</span>
                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>

            {{-- Mobile sidebar content --}}
            <div class="flex grow flex-col overflow-y-auto bg-white shadow-2xl">
                {{-- Logo section with gradient --}}
                <div class="flex h-16 shrink-0 items-center gap-3 border-b border-gray-100 bg-gradient-to-r from-blue-600 to-indigo-600 px-6">
                    <img 
                        src="{{ asset('images/Laravelsn.jpg') }}" 
                        class="h-9 w-9 rounded-lg object-cover shadow-md ring-2 ring-white/30"
                        alt="{{ config('app.name') }}"
                    />
                    <span class="text-lg font-bold text-white">
                        {{ config('app.name') }}
                    </span>
                </div>
                
                {{-- Navigation items --}}
                <nav class="flex-1 px-4 py-6">
                    <x-sidebar-items/>
                </nav>
                
                {{-- Mobile sidebar footer --}}
                <div class="border-t border-gray-100 bg-gray-50 p-4">
                    <div class="flex items-center gap-3 rounded-lg bg-white p-3 shadow-sm">
                        <div class="flex h-10 w-10 items-center justify-center rounded-full bg-gradient-to-br from-blue-500 to-indigo-600">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="h-5 w-5 text-white">
                                <path fill-rule="evenodd" d="M18.685 19.097A9.723 9.723 0 0021.75 12c0-5.385-4.365-9.75-9.75-9.75S2.25 6.615 2.25 12a9.723 9.723 0 003.065 7.097A9.716 9.716 0 0012 21.75a9.716 9.716 0 006.685-2.653zm-12.54-1.285A7.486 7.486 0 0112 15a7.486 7.486 0 015.855 2.812A8.224 8.224 0 0112 20.25a8.224 8.224 0 01-5.855-2.438zM15.75 9a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0z" clip-rule="evenodd"/>
                            </svg>
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-semibold text-gray-900 truncate">{{ Auth::user()->name }}</p>
                            <p class="text-xs text-gray-500 truncate">{{ Auth::user()->email }}</p>
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
    <div class="flex grow flex-col overflow-y-auto border-r border-gray-200 bg-white">
        {{-- Logo section with modern gradient --}}
        <div class="flex h-16 shrink-0 items-center gap-3 border-b border-gray-100 bg-red-600 px-6">
            <img 
                src="{{ asset('images/Laravelsn.jpg') }}"
                alt="{{ config('app.name') }}"
                class="h-9 w-9 rounded-lg object-cover shadow-md ring-2 ring-white/30"
            />
            <span class="text-lg font-bold text-white">
                {{ config('app.name') }}
            </span>
        </div>
        
        {{-- Navigation items --}}
        <nav class="flex-1 px-4 py-6">
            <x-sidebar-items/>
        </nav>
        
        {{-- Desktop sidebar footer --}}
        <div class="border-t border-gray-100 bg-gray-50 p-4">
            {{-- User info card --}}
            <div class="mb-3 flex items-center gap-3 rounded-lg bg-white p-3 shadow-sm ring-1 ring-gray-900/5">
                <div class="flex h-10 w-10 items-center justify-center rounded-full bg-red-600 shadow-sm">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="h-5 w-5 text-white">
                        <path fill-rule="evenodd" d="M18.685 19.097A9.723 9.723 0 0021.75 12c0-5.385-4.365-9.75-9.75-9.75S2.25 6.615 2.25 12a9.723 9.723 0 003.065 7.097A9.716 9.716 0 0012 21.75a9.716 9.716 0 006.685-2.653zm-12.54-1.285A7.486 7.486 0 0112 15a7.486 7.486 0 015.855 2.812A8.224 8.224 0 0112 20.25a8.224 8.224 0 01-5.855-2.438zM15.75 9a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0z" clip-rule="evenodd"/>
                    </svg>
                </div>
                <div class="flex-1 min-w-0">
                    <p class="text-sm font-semibold text-gray-900 truncate">{{ Auth::user()->name }}</p>
                    <p class="text-xs text-gray-500 truncate">{{ Auth::user()->email }}</p>
                </div>
                <div class="h-2 w-2 rounded-full bg-green-500 shadow-sm"></div>
            </div>
            
            {{-- Quick actions --}}
            <div class="flex gap-2">
                <a 
                    href="{{ route('profile.show') }}" 
                    wire:navigate
                    class="flex-1 rounded-lg bg-white px-3 py-2 text-xs font-semibold text-gray-700 shadow-sm ring-1 ring-gray-900/5 hover:bg-gray-50 transition-all duration-200 text-center"
                    title="View Profile"
                >
                    Profile
                </a>
                <form method="POST" action="{{ route('logout') }}" class="flex-1">
                    @csrf
                    <button 
                        type="submit"
                        class="w-full rounded-lg bg-white px-3 py-2 text-xs font-semibold text-gray-700 shadow-sm ring-1 ring-gray-900/5 hover:bg-gray-50 transition-all duration-200"
                        title="Logout"
                    >
                        Logout
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
