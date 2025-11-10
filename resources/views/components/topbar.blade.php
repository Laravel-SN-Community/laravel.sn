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
            <x-user-profil-dropdown />
        </div>
    </div>
</div>

