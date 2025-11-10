<div class="sticky top-0 z-40 bg-white/80 backdrop-blur-md border-b border-gray-200 shadow-sm">
    
    {{-- Main topbar row --}}
    <div class="flex h-16 shrink-0 items-center gap-x-4 px-4 sm:gap-x-6 sm:px-6 lg:px-8">
        {{-- Main topbar content area --}}
        <div class="flex flex-1 justify-between items-center gap-x-4 lg:gap-x-6">
            
            {{-- Logo/Brand --}}
            <a 
                href="{{ route('welcome') }}" 
                wire:navigate
                class="flex items-center gap-3 transition-opacity duration-200 hover:opacity-80"
            >
                <img 
                    src="{{ asset('images/Laravelsn.jpg') }}" 
                    class="h-9 w-9 rounded-lg object-cover shadow-sm"
                    alt="{{ config('app.name') }}"
                />
                <span class="text-lg font-bold text-gray-900">
                    {{ config('app.name') }}
                </span>
            </a>
            
            {{-- Right side actions --}}
            <div class="flex items-center gap-x-4 lg:gap-x-6">
                
                {{-- Language selector dropdown --}}
                <livewire:pages.lang.change-locale />
                
                {{-- User profile dropdown --}}
                <x-user-profil-dropdown />
            </div>
        </div>
    </div>

    {{-- Navigation Tabs --}}
    <div>
        <nav class="flex gap-x-8 px-4 sm:px-6 lg:px-8" aria-label="Tabs">
            <a 
                href="{{ route('dashboard') }}" 
                wire:navigate
                class="{{ request()->routeIs('dashboard') ? 'border-red-600 text-red-600' : 'border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-700' }} whitespace-nowrap border-b-2 py-4 px-1 text-sm font-medium transition-all duration-200"
            >
                {{ __('Dashboard') }}
            </a>
            <a 
                href="{{ route('projects.index') }}" 
                wire:navigate
                class="{{ request()->routeIs('projects*') ? 'border-red-600 text-red-600' : 'border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-700' }} whitespace-nowrap border-b-2 py-4 px-1 text-sm font-medium transition-all duration-200"
            >
                {{ __('Projects') }}
            </a>
        </nav>
    </div>
</div>

