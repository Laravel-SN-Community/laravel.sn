<div class="min-h-screen bg-gradient-to-br from-red-50 via-white to-green-50">
    <!-- Navigation Header -->
    <nav class="bg-white shadow-xs">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <div class="flex items-center space-x-3">
                    <img src="{{ asset('images/Laravelsn.jpg') }}" alt="Laravel Senegal"
                        class="h-10 w-10 rounded-full object-cover">
                    <h1 class="text-xl font-bold text-gray-900">Laravel Senegal</h1>
                </div>
                <div class="flex items-center space-x-8">
                    <!-- Navigation links -->
                    <div class="hidden md:flex items-center space-x-8">
                        <a href="{{ route('welcome') }}"
                            wire:navigate
                            class="{{ request()->routeIs('welcome') ? 'text-red-600 font-bold' : 'text-gray-900 font-bold hover:text-red-600 transition-colors' }}">{{ __('Accueil') }}</a>
                        <a href="{{ route('events') }}"
                            wire:navigate
                            class="{{ request()->routeIs('events') ? 'text-red-600 font-bold' : 'text-gray-900 font-bold hover:text-red-600 transition-colors' }}">{{ __('Événements') }}</a>
                        <!-- Vertical divider -->
                        <div class="h-6 w-px bg-gray-300"></div>
                    </div>
                    <!-- GitHub icon -->
                    <a href="https://github.com/Laravel-SN-Community/laravel.sn" target="_blank"
                        class="text-gray-900 hover:text-red-600 transition-colors" title="GitHub">
                        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                            <path
                                d="M12 0c-6.626 0-12 5.373-12 12 0 5.302 3.438 9.8 8.207 11.387.599.111.793-.261.793-.577v-2.234c-3.338.726-4.033-1.416-4.033-1.416-.546-1.387-1.333-1.756-1.333-1.756-1.089-.745.083-.729.083-.729 1.205.084 1.839 1.237 1.839 1.237 1.07 1.834 2.807 1.304 3.492.997.107-.775.418-1.305.762-1.604-2.665-.305-5.467-1.334-5.467-5.931 0-1.311.469-2.381 1.236-3.221-.124-.303-.535-1.524.117-3.176 0 0 1.008-.322 3.301 1.23.957-.266 1.983-.399 3.003-.404 1.02.005 2.047.138 3.006.404 2.291-1.552 3.297-1.23 3.297-1.23.653 1.653.242 2.874.118 3.176.77.84 1.235 1.911 1.235 3.221 0 4.609-2.807 5.624-5.479 5.921.43.372.823 1.102.823 2.222v3.293c0 .319.192.694.801.576 4.765-1.589 8.199-6.086 8.199-11.386 0-6.627-5.373-12-12-12z" />
                        </svg>
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="relative py-20 bg-white overflow-hidden">
        <!-- Gradient Overlay from Top to White -->
        <div class="absolute inset-0 z-0 pointer-events-none">
            <div class="absolute inset-0"
                style="background: linear-gradient(to bottom, #f3f4f6 0%, #ffffff 100%);">
            </div>
            <!-- Grid Background -->
            <div class="absolute inset-0 opacity-20">
                <div class="absolute inset-0"
                    style="background-image:
                    linear-gradient(to right, #9ca3af 1px, transparent 1px),
                    linear-gradient(to bottom, #9ca3af 1px, transparent 1px);
                    background-size: 20px 20px;">
                </div>
            </div>
        </div>

        <div class="relative z-10 max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Main Title -->
            <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold text-gray-900 mb-6 text-center">
                Événements Laravel Sénégal
            </h1>

            <!-- Subtitle -->
            <p class="text-xl md:text-2xl text-gray-700 mb-8 text-center max-w-4xl mx-auto">
                Découvrez nos prochains meetups, ateliers et événements de la communauté
                <span class="text-red-600 font-semibold">Laravel</span> au Sénégal
            </p>

            <!-- Search and Filter -->
            <div class="max-w-2xl mx-auto mb-12">
                <div class="flex flex-col sm:flex-row gap-4">
                    <!-- Search -->
                    <div class="flex-1">
                        <div class="relative">
                            <input type="text" 
                                   wire:model.live.debounce.300ms="search"
                                   placeholder="Rechercher un événement..."
                                   class="w-full px-4 py-3 pl-10 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-transparent">
                            <svg class="absolute left-3 top-3.5 h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                        </div>
                    </div>

                    <!-- Filter -->
                    <div class="sm:w-48">
                        <select wire:model.live="filter" 
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-transparent">
                            <option value="all">Tous les événements</option>
                            <option value="upcoming">À venir</option>
                            <option value="past">Passés</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>

        <!-- Fade Effect Bottom -->
        <div class="absolute bottom-0 left-0 w-full h-24 bg-gradient-to-b from-transparent to-white pointer-events-none z-20"></div>
    </section>

    <!-- Events Section -->
    <section id="events" class="py-20 bg-white">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            @if($events->count() > 0)
                <!-- Events Grid -->
                <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
                    @foreach($events as $event)
                        <div class="bg-white rounded-xl shadow-lg border border-gray-200 overflow-hidden hover:shadow-xl transition-all duration-300 hover:-translate-y-1">
                            <!-- Event Header -->
                            <div class="p-6 pb-4">
                                <div class="flex items-start justify-between mb-4">
                                    <div class="flex-1">
                                        <h3 class="text-xl font-bold text-gray-900 mb-2 line-clamp-2">
                                            {{ $event->name }}
                                        </h3>
                                        <div class="flex items-center text-gray-600 mb-2">
                                            <svg class="w-5 h-5 mr-2 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                            </svg>
                                            <span class="text-sm font-medium">
                                                {{ $event->date->format('d/m/Y à H:i') }}
                                            </span>
                                        </div>
                                        <div class="flex items-center text-gray-600 mb-3">
                                            <svg class="w-5 h-5 mr-2 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                            </svg>
                                            <span class="text-sm">{{ $event->place }}</span>
                                        </div>
                                    </div>
                                </div>

                                <!-- Event Description -->
                                <p class="text-gray-600 text-sm line-clamp-3 mb-4">
                                    {{ $event->description }}
                                </p>
                            </div>

                            <!-- Event Actions -->
                            <div class="px-6 pb-6">
                                <div class="flex gap-3">
                                    @if($event->rsvp_link)
                                        <a href="{{ $event->rsvp_link }}" target="_blank"
                                           class="flex-1 bg-red-600 text-white px-4 py-2 rounded-lg text-sm font-semibold hover:bg-red-700 transition-colors text-center">
                                            S'inscrire
                                        </a>
                                    @endif
                                    @if($event->event_link)
                                        <a href="{{ $event->event_link }}" target="_blank"
                                           class="flex-1 border-2 border-red-600 text-red-600 px-4 py-2 rounded-lg text-sm font-semibold hover:bg-red-600 hover:text-white transition-colors text-center">
                                            En savoir plus
                                        </a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Pagination -->
                @if($events->hasPages())
                    <div class="mt-12">
                        {{ $events->links() }}
                    </div>
                @endif
            @else
                <!-- Empty State -->
                <div class="text-center py-16">
                    <svg class="mx-auto h-24 w-24 text-gray-400 mb-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                    </svg>
                    <h3 class="text-2xl font-bold text-gray-900 mb-4">Aucun événement trouvé</h3>
                    <p class="text-gray-600 mb-8">
                        @if($search)
                            Aucun événement ne correspond à votre recherche "{{ $search }}".
                        @else
                            Aucun événement n'est actuellement programmé.
                        @endif
                    </p>
                    @if($search)
                        <button wire:click="$set('search', '')" 
                                class="bg-red-600 text-white px-6 py-3 rounded-lg font-semibold hover:bg-red-700 transition-colors">
                            Voir tous les événements
                        </button>
                    @endif
                </div>
            @endif
        </div>
    </section>

    <!-- Footer -->
    <footer class="relative bg-gray-900 text-white overflow-hidden">
        <!-- Background Pattern -->
        <div class="absolute inset-0 bg-gradient-to-br from-gray-800 to-gray-900"></div>
        <div class="absolute inset-0 bg-[url('data:image/svg+xml,%3Csvg width="60" height="60" viewBox="0 0 60 60" xmlns="http://www.w3.org/2000/svg"%3E%3Cg fill="none" fill-rule="evenodd"%3E%3Cg fill="%23ffffff" fill-opacity="0.03"%3E%3Ccircle cx="30" cy="30" r="1"/%3E%3C/g%3E%3C/g%3E%3C/svg%3E')] opacity-40"></div>
        
        <!-- Watermark LaravelSn -->
        <div class="absolute inset-0 flex items-center justify-center pointer-events-none">
            <h1 class="font-black leading-none tracking-tight text-transparent bg-clip-text bg-gradient-to-r from-gray-600/20 to-gray-400/20 select-none
                       text-[clamp(4rem,20vw,16rem)] whitespace-nowrap opacity-30">
                LaravelSn
            </h1>
        </div>
        
        <!-- Main Footer Content -->
        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8 lg:gap-12">
                
                <!-- Brand Section -->
                <div class="lg:col-span-2">
                    <div class="flex items-center gap-3 mb-6">
                        <img src="{{ asset('images/Laravelsn.jpg') }}" alt="Laravel Sénégal"
                             class="h-10 w-10 rounded-full object-cover ring-2">
                        <h3 class="text-2xl font-bold bg-gradient-to-r from-white to-gray-300 bg-clip-text text-transparent">
                            Laravel Sénégal
                        </h3>
                    </div>
                    <p class="text-gray-300 text-lg mb-6 max-w-md">
                        La communauté Laravel du Sénégal. Ensemble, construisons l'avenir du développement web au Sénégal.
                    </p>
                    
                    <!-- Social Links -->
                    <div class="flex gap-4">
                        <a href="https://x.com/laravel_sn" target="_blank" 
                           class="group flex items-center justify-center w-10 h-10 bg-gray-800 rounded-lg hover:bg-rose-600 transition-all duration-300 hover:scale-110">
                            <svg class="w-5 h-5 group-hover:text-white" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M18.9 1.98h3.28l-7.17 8.2 8.43 11.84h-6.6l-5.17-6.78-5.91 6.78H1.47l7.67-8.8L1 1.98h6.8l4.7 6.17 6.4-6.17Z"/>
                            </svg>
                        </a>
                        <a href="https://chat.whatsapp.com/JwITxALLv0uJIGNu7AsVnx" target="_blank"
                           class="group flex items-center justify-center w-10 h-10 bg-gray-800 rounded-lg hover:bg-emerald-600 transition-all duration-300 hover:scale-110">
                            <svg class="w-5 h-5 group-hover:text-white" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893A11.821 11.821 0 0020.885 3.488"/>
                            </svg>
                        </a>
                        <a href="https://github.com/Laravel-SN-Community/laravel.sn" target="_blank"
                           class="group flex items-center justify-center w-10 h-10 bg-gray-800 rounded-lg hover:bg-gray-700 transition-all duration-300 hover:scale-110">
                            <svg class="w-5 h-5 group-hover:text-white" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12 0C5.37 0 0 5.37 0 12c0 5.3 3.44 9.8 8.2 11.39.6.11.79-.26.79-.58v-2.23c-3.34.72-4.03-1.42-4.03-1.42-.55-1.39-1.34-1.76-1.34-1.76-1.09-.75.08-.73.08-.73 1.2.08 1.84 1.24 1.84 1.24 1.07 1.83 2.81 1.3 3.49.99.11-.78.42-1.3.76-1.6-2.67-.31-5.47-1.34-5.47-5.93 0-1.31.47-2.38 1.24-3.22-.12-.3-.53-1.52.12-3.18 0 0 1.01-.32 3.3 1.23.96-.27 1.98-.4 3-.4s2.04.13 3 .4c2.29-1.55 3.3-1.23 3.3-1.23.65 1.66.24 2.88.12 3.18.77.84 1.24 1.91 1.24 3.22 0 4.61-2.81 5.62-5.48 5.92.43.37.82 1.1.82 2.22v3.29c0 .32.19.69.8.58C20.56 21.8 24 17.3 24 12 24 5.37 18.63 0 12 0Z"/>
                            </svg>
                        </a>
                        <a href="https://www.linkedin.com/company/laravel-senegal" target="_blank"
                           class="group flex items-center justify-center w-10 h-10 bg-gray-800 rounded-lg hover:bg-blue-600 transition-all duration-300 hover:scale-110">
                            <svg class="w-5 h-5 group-hover:text-white" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/>
                            </svg>
                        </a>
                    </div>
                </div>

                <!-- Quick Links -->
                <div>
                    <h4 class="text-lg font-semibold mb-6 text-white">Liens Rapides</h4>
                    <ul class="space-y-3">
                        <li><a wire:navigate href="{{ route('welcome') }}" class="text-gray-300 hover:text-rose-400 transition-colors duration-300">Accueil</a></li>
                        <li><a wire:navigate href="{{ route('events') }}" class="text-gray-300 hover:text-rose-400 transition-colors duration-300">Événements</a></li>
                        <li><a wire:navigate href="{{ route('welcome') }}#contact" class="text-gray-300 hover:text-rose-400 transition-colors duration-300">Contact</a></li>
                    </ul>
                </div>

                <!-- Contact Info -->
                <div>
                    <h4 class="text-lg font-semibold mb-6 text-white">Contact</h4>
                    <div class="space-y-3">
                        <div class="flex items-start gap-3">
                            <svg class="w-5 h-5 text-rose-400 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8m-16 11h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                            </svg>
                            <a href="mailto:laravelsenegal@gmail.com" class="text-gray-300 hover:text-rose-400 transition-colors duration-300">
                                laravelsenegal@gmail.com
                            </a>
                        </div>
                        <div class="flex items-start gap-3">
                            <svg class="w-5 h-5 text-rose-400 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                            </svg>
                            <span class="text-gray-300">Dakar, Sénégal</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Bottom Bar -->
        <div class="relative border-t border-gray-800">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
                <div class="flex flex-col md:flex-row justify-between items-center gap-4">
                    <p class="text-gray-400 text-sm">
                        © {{ date('Y') }} Laravel Sénégal. Tous droits réservés.
                    </p>
                    <div class="flex gap-6 text-sm">
                        <a href="#" class="text-gray-400 hover:text-rose-400 transition-colors duration-300">Mentions légales</a>
                        <a href="#" class="text-gray-400 hover:text-rose-400 transition-colors duration-300">Politique de confidentialité</a>
                        <a href="#" class="text-gray-400 hover:text-rose-400 transition-colors duration-300">CGU</a>
                    </div>
                </div>
            </div>
        </div>
    </footer>
</div>
