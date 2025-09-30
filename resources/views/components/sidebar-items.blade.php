{{-- 
    Sidebar Navigation Items Component
    
    Features:
    - Organized navigation sections
    - Active state highlighting
    - Smooth hover animations
    - Icon-based navigation
    - Expandable sections (ready for future use)
--}}

<nav class="flex flex-1 flex-col">
    <ul role="list" class="flex flex-1 flex-col gap-y-7">
        
        {{-- Main Navigation Section --}}
        <li>
            <div class="text-xs font-semibold leading-6 text-gray-400 uppercase tracking-wide ">
                {{ __('Main') }}
            </div>
            <ul role="list" class="-mx-2 mt-2 space-y-1">
                {{-- Dashboard Link --}}
                <li>
                    <a 
                        href="{{ route('dashboard') }}" 
                        wire:navigate
                        class="{{ request()->route()->getName() == 'dashboard' 
                            ? 'bg-blue-50 border-r-2 border-blue-600 text-blue-700 ' 
                            : 'text-gray-700 hover:text-blue-600 hover:bg-gray-50 ' 
                        }} group flex gap-x-3 rounded-l-md p-3 text-sm leading-6 font-medium transition-all duration-200"
                        title="{{ __('Dashboard') }}"
                    >
                        <svg 
                            class="{{ request()->route()->getName() == 'dashboard' 
                                ? 'text-blue-600 ' 
                                : 'text-gray-400 group-hover:text-blue-500  ' 
                            }} h-6 w-6 shrink-0 transition-colors duration-200" 
                            fill="none" 
                            viewBox="0 0 24 24" 
                            stroke-width="1.5" 
                            stroke="currentColor"
                        >
                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12l8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25"/>
                        </svg>
                        {{ __('Dashboard') }}
                        
                        {{-- Active indicator --}}
                        @if(request()->route()->getName() == 'dashboard')
                            <div class="ml-auto">
                                <div class="flex h-2 w-2 rounded-full bg-blue-600 "></div>
                            </div>
                        @endif
                    </a>
                </li>
                
                {{-- Future: Analytics Link --}}
                {{-- <li>
                    <a 
                        href="#" 
                        class="text-gray-700 hover:text-blue-600 hover:bg-gray-50  group flex gap-x-3 rounded-l-md p-3 text-sm leading-6 font-medium transition-all duration-200"
                        title="{{ __('Analytics') }}"
                    >
                        <svg class="text-gray-400 group-hover:text-blue-500   h-6 w-6 shrink-0 transition-colors duration-200" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 13.125C3 12.504 3.504 12 4.125 12h2.25c.621 0 1.125.504 1.125 1.125v6.75C7.5 20.496 6.996 21 6.375 21h-2.25A1.125 1.125 0 013 19.875v-6.75zM9.75 8.625c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125v11.25c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V8.625zM16.5 4.125c0-.621.504-1.125 1.125-1.125h2.25C20.496 3 21 3.504 21 4.125v15.75c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V4.125z" />
                        </svg>
                        {{ __('Analytics') }}
                    </a>
                </li> --}}
            </ul>
        </li>

        {{-- Future: Content Management Section --}}
        {{-- <li>
            <div class="text-xs font-semibold leading-6 text-gray-400 uppercase tracking-wide ">
                {{ __('Content') }}
            </div>
            <ul role="list" class="-mx-2 mt-2 space-y-1">
                <li>
                    <a 
                        href="#" 
                        class="text-gray-700 hover:text-blue-600 hover:bg-gray-50  group flex gap-x-3 rounded-l-md p-3 text-sm leading-6 font-medium transition-all duration-200"
                        title="{{ __('Posts') }}"
                    >
                        <svg class="text-gray-400 group-hover:text-blue-500   h-6 w-6 shrink-0 transition-colors duration-200" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" />
                        </svg>
                        {{ __('Posts') }}
                    </a>
                </li>
                <li>
                    <a 
                        href="#" 
                        class="text-gray-700 hover:text-blue-600 hover:bg-gray-50  group flex gap-x-3 rounded-l-md p-3 text-sm leading-6 font-medium transition-all duration-200"
                        title="{{ __('Media') }}"
                    >
                        <svg class="text-gray-400 group-hover:text-blue-500   h-6 w-6 shrink-0 transition-colors duration-200" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="m2.25 15.75 5.159-5.159a2.25 2.25 0 0 1 3.182 0l5.159 5.159m-1.5-1.5 1.409-1.409a2.25 2.25 0 0 1 3.182 0l2.909 2.909m-18 3.75h16.5a1.5 1.5 0 0 0 1.5-1.5V6a1.5 1.5 0 0 0-1.5-1.5H3.75A1.5 1.5 0 0 0 2.25 6v12a1.5 1.5 0 0 0 1.5 1.5Zm10.5-11.25h.008v.008h-.008V8.25Zm.375 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Z" />
                        </svg>
                        {{ __('Media') }}
                    </a>
                </li>
            </ul>
        </li> --}}

        {{-- Future: Settings Section --}}
        {{-- <li>
            <div class="text-xs font-semibold leading-6 text-gray-400 uppercase tracking-wide ">
                {{ __('Settings') }}
            </div>
            <ul role="list" class="-mx-2 mt-2 space-y-1">
                <li>
                    <a 
                        href="#" 
                        class="text-gray-700 hover:text-blue-600 hover:bg-gray-50  group flex gap-x-3 rounded-l-md p-3 text-sm leading-6 font-medium transition-all duration-200"
                        title="{{ __('General') }}"
                    >
                        <svg class="text-gray-400 group-hover:text-blue-500   h-6 w-6 shrink-0 transition-colors duration-200" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9.594 3.94c.09-.542.56-.94 1.11-.94h2.593c.55 0 1.02.398 1.11.94l.213 1.281c.063.374.313.686.645.87.074.04.147.083.22.127.324.196.72.257 1.075.124l1.217-.456a1.125 1.125 0 011.37.49l1.296 2.247a1.125 1.125 0 01-.26 1.431l-1.003.827c-.293.24-.438.613-.431.992a6.759 6.759 0 010 .255c-.007.378.138.75.43.99l1.005.828c.424.35.534.954.26 1.43l-1.298 2.247a1.125 1.125 0 01-1.369.491l-1.217-.456c-.355-.133-.75-.072-1.076.124a6.57 6.57 0 01-.22.128c-.331.183-.581.495-.644.869l-.213 1.28c-.09.543-.56.941-1.11.941h-2.594c-.55 0-1.02-.398-1.11-.94l-.213-1.281c-.062-.374-.312-.686-.644-.87a6.52 6.52 0 01-.22-.127c-.325-.196-.72-.257-1.076-.124l-1.217.456a1.125 1.125 0 01-1.369-.49l-1.297-2.247a1.125 1.125 0 01.26-1.431l1.004-.827c.292-.24.437-.613.43-.992a6.932 6.932 0 010-.255c.007-.378-.138-.75-.43-.99l-1.004-.828a1.125 1.125 0 01-.26-1.43l1.297-2.247a1.125 1.125 0 011.37-.491l1.216.456c.356.133.751.072 1.076-.124.072-.044.146-.087.22-.128.332-.183.582-.495.644-.869l.214-1.281z" />
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                        {{ __('General') }}
                    </a>
                </li>
                <li>
                    <a 
                        href="#" 
                        class="text-gray-700 hover:text-blue-600 hover:bg-gray-50  group flex gap-x-3 rounded-l-md p-3 text-sm leading-6 font-medium transition-all duration-200"
                        title="{{ __('Users') }}"
                    >
                        <svg class="text-gray-400 group-hover:text-blue-500   h-6 w-6 shrink-0 transition-colors duration-200" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z" />
                        </svg>
                        {{ __('Users') }}
                    </a>
                </li>
            </ul>
        </li> --}}

        {{-- Spacer for bottom content --}}
        <li class="mt-auto">
            {{-- Future: Help & Support Section --}}
            {{-- <div class="text-xs font-semibold leading-6 text-gray-400 uppercase tracking-wide  mb-2">
                {{ __('Support') }}
            </div>
            <ul role="list" class="-mx-2 space-y-1">
                <li>
                    <a 
                        href="#" 
                        class="text-gray-700 hover:text-blue-600 hover:bg-gray-50  group flex gap-x-3 rounded-l-md p-3 text-sm leading-6 font-medium transition-all duration-200"
                        title="{{ __('Help Center') }}"
                    >
                        <svg class="text-gray-400 group-hover:text-blue-500   h-6 w-6 shrink-0 transition-colors duration-200" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9.879 7.519c1.171-1.025 3.071-1.025 4.242 0 1.172 1.025 1.172 2.687 0 3.712-.203.179-.43.326-.67.442-.745.361-1.45.999-1.45 1.827v.75M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9 5.25h.008v.008H12v-.008z" />
                        </svg>
                        {{ __('Help Center') }}
                    </a>
                </li>
            </ul> --}}
        </li>

    </ul>
</nav>

