{{-- 
    Modern Sidebar Navigation Items Component
    
    Features:
    - Organized navigation sections
    - Active state with gradient highlighting
    - Smooth hover animations with icon backgrounds
    - Icon-based navigation with modern badges
    - Expandable sections (ready for future use)
--}}

<ul role="list" class="space-y-6">
    
    {{-- Main Navigation Section --}}
    <li>
        <div class="mb-3 flex items-center gap-2">
            <div class="h-px flex-1 bg-gradient-to-r from-gray-200 to-transparent"></div>
            <span class="text-xs font-semibold text-gray-400 uppercase tracking-wider">
                {{ __('Main') }}
            </span>
            <div class="h-px flex-1 bg-gradient-to-l from-gray-200 to-transparent"></div>
        </div>
        
        <ul role="list" class="space-y-1">
            {{-- Dashboard Link --}}
            <li>
                <a 
                    href="{{ route('dashboard') }}" 
                    wire:navigate
                    class="{{ request()->route()->getName() == 'dashboard' 
                        ? 'bg-gradient-to-r from-red-50 to-red-50/50 text-red-700 shadow-sm' 
                        : 'text-gray-700 hover:bg-gray-50' 
                    }} group flex items-center gap-3 rounded-lg px-3 py-2.5 text-sm font-medium transition-all duration-200"
                    title="{{ __('Dashboard') }}"
                >
                    <div class="{{ request()->route()->getName() == 'dashboard' 
                        ? 'bg-red-600 shadow-md' 
                        : 'bg-gray-100 group-hover:bg-red-100' 
                    }} flex h-9 w-9 items-center justify-center rounded-lg transition-all duration-200">
                        <svg 
                            class="{{ request()->route()->getName() == 'dashboard' 
                                ? 'text-white' 
                                : 'text-gray-600 group-hover:text-red-600' 
                            }} h-5 w-5 shrink-0 transition-colors duration-200" 
                            fill="none" 
                            viewBox="0 0 24 24" 
                            stroke-width="2" 
                            stroke="currentColor"
                        >
                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12l8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25"/>
                        </svg>
                    </div>
                    <span class="flex-1">{{ __('Dashboard') }}</span>
                    
                    {{-- Active indicator --}}
                    @if(request()->route()->getName() == 'dashboard')
                        <div class="flex h-2 w-2 rounded-full bg-red-600 shadow-sm"></div>
                    @endif
                </a>
            </li>
        </ul>
    </li>

    {{-- Community Section --}}
    <li>
        <div class="mb-3 flex items-center gap-2">
            <div class="h-px flex-1 bg-gradient-to-r from-gray-200 to-transparent"></div>
            <span class="text-xs font-semibold text-gray-400 uppercase tracking-wider">
                {{ __('Community') }}
            </span>
            <div class="h-px flex-1 bg-gradient-to-l from-gray-200 to-transparent"></div>
        </div>

        <ul role="list" class="space-y-1">
            {{-- Forum Link --}}
            <li>
                <a
                    href="{{ route('forum') }}"
                    wire:navigate
                    class="{{ request()->route()->getName() == 'forum'
                        ? 'bg-gradient-to-r from-red-50 to-red-50/50 text-red-700 shadow-sm'
                        : 'text-gray-700 hover:bg-gray-50'
                    }} group flex items-center gap-3 rounded-lg px-3 py-2.5 text-sm font-medium transition-all duration-200"
                    title="{{ __('Forum') }}"
                >
                    <div class="{{ request()->route()->getName() == 'forum'
                        ? 'bg-red-600 shadow-md'
                        : 'bg-gray-100 group-hover:bg-red-100'
                    }} flex h-9 w-9 items-center justify-center rounded-lg transition-all duration-200">
                        <svg
                            class="{{ request()->route()->getName() == 'forum'
                                ? 'text-white'
                                : 'text-gray-600 group-hover:text-red-600'
                            }} h-5 w-5 shrink-0 transition-colors duration-200"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke-width="2"
                            stroke="currentColor"
                        >
                            <path stroke-linecap="round" stroke-linejoin="round" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                        </svg>
                    </div>
                    <span class="flex-1">{{ __('Forum') }}</span>

                    {{-- Active indicator --}}
                    @if(request()->route()->getName() == 'forum')
                        <div class="flex h-2 w-2 rounded-full bg-red-600 shadow-sm"></div>
                    @endif
                </a>
            </li>
        </ul>
    </li>

    {{-- Projects Section --}}
    <li>
        <div class="mb-3 flex items-center gap-2">
            <div class="h-px flex-1 bg-gradient-to-r from-gray-200 to-transparent"></div>
            <span class="text-xs font-semibold text-gray-400 uppercase tracking-wider">
                {{ __('Projects') }}
            </span>
            <div class="h-px flex-1 bg-gradient-to-l from-gray-200 to-transparent"></div>
        </div>

        <ul role="list" class="space-y-1">
            <li>
                <a
                    href="{{ route('projects.index') }}"
                    wire:navigate
                    class="{{ request()->route()->getName() == 'projects.index'
                        ? 'bg-gradient-to-r from-red-50 to-red-50/50 text-red-700 shadow-sm'
                        : 'text-gray-700 hover:bg-gray-50'
                    }} group flex items-center gap-3 rounded-lg px-3 py-2.5 text-sm font-medium transition-all duration-200"
                    title="{{ __('Projects') }}"
                >
                    <div class="{{ request()->route()->getName() == 'projects.index'
                        ? 'bg-red-600 shadow-md'
                        : 'bg-gray-100 group-hover:bg-red-100'
                    }} flex h-9 w-9 items-center justify-center rounded-lg transition-all duration-200">
                        <svg
                            class="{{ request()->route()->getName() == 'projects.index'
                                ? 'text-white'
                                : 'text-gray-600 group-hover:text-red-600'
                            }} h-5 w-5 shrink-0 transition-colors duration-200"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke-width="2"
                            stroke="currentColor"
                        >
                            <path stroke-linecap="round" stroke-linejoin="round" d="M20.25 14.15v4.25c0 1.094-.787 2.036-1.872 2.18-2.087.277-4.216.42-6.378.42s-4.291-.143-6.378-.42c-1.085-.144-1.872-1.086-1.872-2.18v-4.25m16.5 0a2.18 2.18 0 00.75-1.661V8.706c0-1.081-.768-2.015-1.837-2.175a48.114 48.114 0 00-3.413-.387m4.5 8.006c-.194.165-.42.295-.673.38A23.978 23.978 0 0112 15.75c-2.648 0-5.195-.429-7.577-1.22a2.016 2.016 0 01-.673-.38m0 0A2.18 2.18 0 013 12.489V8.706c0-1.081.768-2.015 1.837-2.175a48.111 48.111 0 013.413-.387m7.5 0V5.25A2.25 2.25 0 0013.5 3h-3a2.25 2.25 0 00-2.25 2.25v.894m7.5 0a48.667 48.667 0 00-7.5 0M12 12.75h.008v.008H12v-.008z"/>
                        </svg>
                    </div>
                        <span class="flex-1">{{ __('Projects') }}</span>

                    {{-- Active indicator --}}
                    @if(request()->route()->getName() == 'projects.index')
                        <div class="flex h-2 w-2 rounded-full bg-red-600 shadow-sm"></div>
                    @endif
                </a>
            </li>
        </ul>
    </li>

    {{-- Future: Settings Section --}}
    {{-- <li>
        <div class="mb-3 flex items-center gap-2">
            <div class="h-px flex-1 bg-gradient-to-r from-gray-200 to-transparent"></div>
            <span class="text-xs font-semibold text-gray-400 uppercase tracking-wider">
                {{ __('Settings') }}
            </span>
            <div class="h-px flex-1 bg-gradient-to-l from-gray-200 to-transparent"></div>
        </div>
        
        <ul role="list" class="space-y-1">
            <li>
                <a 
                    href="#" 
                    wire:navigate
                    class="group flex items-center gap-3 rounded-lg px-3 py-2.5 text-sm font-medium text-gray-700 hover:bg-gray-50 transition-all duration-200"
                    title="{{ __('General') }}"
                >
                    <div class="flex h-9 w-9 items-center justify-center rounded-lg bg-gray-100 group-hover:bg-red-100 transition-all duration-200">
                        <svg class="h-5 w-5 shrink-0 text-gray-600 group-hover:text-red-600 transition-colors duration-200" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9.594 3.94c.09-.542.56-.94 1.11-.94h2.593c.55 0 1.02.398 1.11.94l.213 1.281c.063.374.313.686.645.87.074.04.147.083.22.127.324.196.72.257 1.075.124l1.217-.456a1.125 1.125 0 011.37.49l1.296 2.247a1.125 1.125 0 01-.26 1.431l-1.003.827c-.293.24-.438.613-.431.992a6.759 6.759 0 010 .255c-.007.378.138.75.43.99l1.005.828c.424.35.534.954.26 1.43l-1.298 2.247a1.125 1.125 0 01-1.369.491l-1.217-.456c-.355-.133-.75-.072-1.076.124a6.57 6.57 0 01-.22.128c-.331.183-.581.495-.644.869l-.213 1.28c-.09.543-.56.941-1.11.941h-2.594c-.55 0-1.02-.398-1.11-.94l-.213-1.281c-.062-.374-.312-.686-.644-.87a6.52 6.52 0 01-.22-.127c-.325-.196-.72-.257-1.076-.124l-1.217.456a1.125 1.125 0 01-1.369-.49l-1.297-2.247a1.125 1.125 0 01.26-1.431l1.004-.827c.292-.24.437-.613.43-.992a6.932 6.932 0 010-.255c.007-.378-.138-.75-.43-.99l-1.004-.828a1.125 1.125 0 01-.26-1.43l1.297-2.247a1.125 1.125 0 011.37-.491l1.216.456c.356.133.751.072 1.076-.124.072-.044.146-.087.22-.128.332-.183.582-.495.644-.869l.214-1.281z" />
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                    </div>
                    <span class="flex-1">{{ __('General') }}</span>
                </a>
            </li>
            <li>
                <a 
                    href="#" 
                    wire:navigate
                    class="group flex items-center gap-3 rounded-lg px-3 py-2.5 text-sm font-medium text-gray-700 hover:bg-gray-50 transition-all duration-200"
                    title="{{ __('Users') }}"
                >
                    <div class="flex h-9 w-9 items-center justify-center rounded-lg bg-gray-100 group-hover:bg-red-100 transition-all duration-200">
                        <svg class="h-5 w-5 shrink-0 text-gray-600 group-hover:text-red-600 transition-colors duration-200" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z" />
                        </svg>
                    </div>
                    <span class="flex-1">{{ __('Users') }}</span>
                </a>
            </li>
        </ul>
    </li> --}}

    {{-- Future: Help & Support Section --}}
    {{-- <li>
        <div class="mb-3 flex items-center gap-2">
            <div class="h-px flex-1 bg-gradient-to-r from-gray-200 to-transparent"></div>
            <span class="text-xs font-semibold text-gray-400 uppercase tracking-wider">
                {{ __('Support') }}
            </span>
            <div class="h-px flex-1 bg-gradient-to-l from-gray-200 to-transparent"></div>
        </div>
        
        <ul role="list" class="space-y-1">
            <li>
                <a 
                    href="#" 
                    wire:navigate
                    class="group flex items-center gap-3 rounded-lg px-3 py-2.5 text-sm font-medium text-gray-700 hover:bg-gray-50 transition-all duration-200"
                    title="{{ __('Help Center') }}"
                >
                    <div class="flex h-9 w-9 items-center justify-center rounded-lg bg-gray-100 group-hover:bg-red-100 transition-all duration-200">
                        <svg class="h-5 w-5 shrink-0 text-gray-600 group-hover:text-red-600 transition-colors duration-200" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9.879 7.519c1.171-1.025 3.071-1.025 4.242 0 1.172 1.025 1.172 2.687 0 3.712-.203.179-.43.326-.67.442-.745.361-1.45.999-1.45 1.827v.75M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9 5.25h.008v.008H12v-.008z" />
                        </svg>
                    </div>
                    <span class="flex-1">{{ __('Help Center') }}</span>
                </a>
            </li>
        </ul>
    </li> --}}

</ul>

