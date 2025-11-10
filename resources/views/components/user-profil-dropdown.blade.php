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
        
        {{-- User name and dropdown arrow --}}
        <span class="flex items-center gap-2">
            {{-- User name --}}
            <span class="text-sm font-semibold text-gray-900">
                {{ Auth::user()->name }}
            </span>
            <svg 
                class="h-6 w-6 text-gray-500 transition-transform duration-200" 
                :class="{ 'rotate-180': open }"
                viewBox="0 0 20 20" 
                fill="currentColor" 
                aria-hidden="true"
            >
                <path fill-rule="evenodd" d="M5.23 7.21a.75.75 0 011.06.02L10 11.168l3.71-3.938a.75.75 0 111.08 1.04l-4.25 4.5a.75.75 0 01-1.08 0l-4.25-4.5a.75.75 0 01.02-1.06z" clip-rule="evenodd"/>
            </svg>
        </span>
    </button>

    {{-- Dropdown menu --}}
    <div
        class="absolute left-0 right-0 lg:left-auto lg:right-0 z-10 mt-3 w-full lg:w-48 origin-top lg:origin-top-right rounded-lg bg-white shadow-lg focus:outline-none overflow-hidden"
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
        <div class="py-2">
            <a 
                href="{{ route('dashboard') }}" 
                class="block px-4 py-3 text-sm text-gray-700 hover:bg-gray-50 transition-colors duration-150"
            >
                {{ __('Dashboard') }}
            </a>

            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button 
                    type="submit"
                    class="block w-full text-left px-4 py-3 text-sm text-gray-700 hover:bg-gray-50 transition-colors duration-150"
                    role="menuitem" 
                    tabindex="-1"
                >
                    {{ __('Sign out') }}
                </button>
            </form>
        </div>
    </div>
</div>