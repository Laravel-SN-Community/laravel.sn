<div class="relative" x-data="{ open: false }" x-on:click.away="open = false">
    <button type="button"
        class="flex items-center gap-2 rounded-lg px-3 py-2 text-sm font-medium text-gray-700 hover:bg-gray-100 transition-all duration-200"
        id="language-menu-button" aria-expanded="false" aria-haspopup="true" x-on:click="open = !open"
        :aria-expanded="open">
        <span class="sr-only">Change language</span>

        {{-- Current language flag --}}
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
            stroke="currentColor" class="h-5 w-5 text-red-600">
            <path stroke-linecap="round" stroke-linejoin="round"
                d="m10.5 21 5.25-11.25L21 21m-9-3h7.5M3 5.621a48.474 48.474 0 0 1 6-.371m0 0c1.12 0 2.233.038 3.334.114M9 5.25V3m3.334 2.364C11.176 10.658 7.69 15.08 3 17.502m9.334-12.138c.896.061 1.785.147 2.666.257m-4.589 8.495a18.023 18.023 0 0 1-3.827-5.802" />
        </svg>
        <span>{{ $this->currentLocaleName }}</span>
    </button>

    {{-- Dropdown menu --}}
    <div class="absolute right-0 bottom-full mb-2 z-[60] w-24 origin-bottom-right rounded-xl bg-white shadow-xl ring-1 ring-gray-900/5 focus:outline-none overflow-hidden md:bottom-auto md:top-full md:mt-2 md:mb-0"
        role="menu" aria-orientation="vertical" aria-labelledby="language-menu-button" tabindex="-1" x-cloak
        x-show="open" x-transition:enter="transition ease-out duration-150"
        x-transition:enter-start="transform opacity-0 scale-95" x-transition:enter-end="transform opacity-100 scale-100"
        x-transition:leave="transition ease-in duration-100" x-transition:leave-start="transform opacity-100 scale-100"
        x-transition:leave-end="transform opacity-0 scale-95">
        <div class="py-1">
            @foreach ($this->availableLocales as $locale)
                <button type="button" wire:click="setLocale('{{ $locale['code'] }}')"
                    class="group flex w-full items-center gap-2 px-4 py-2.5 text-sm font-medium transition-colors duration-150 {{ $locale['code'] === $this->currentLocale ? 'bg-gray-50 text-gray-900' : 'text-gray-700 hover:bg-gray-50' }}"
                    role="menuitem" tabindex="-1">
                    <span>{{ $locale['code'] }}</span>
                    @if ($locale['code'] === $this->currentLocale)
                        <svg class="ml-auto h-4 w-4 text-red-600" fill="none" viewBox="0 0 24 24" stroke-width="2"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" />
                        </svg>
                    @endif
                </button>
            @endforeach
        </div>
    </div>
</div>
