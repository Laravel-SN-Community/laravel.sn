<div class="min-h-screen">

    <!-- Back Button -->
    <section class="relative py-8">
        <div class="max-w-7xl mx-auto px-8 sm:px-12 lg:px-16">
            <a wire:navigate href="{{ route('events') }}" 
               class="inline-flex items-center text-gray-600 hover:text-red-600 font-medium transition-colors group">
                <svg class="w-5 h-5 mr-2 group-hover:-translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                </svg>
                Retour aux événements
            </a>
        </div>
    </section>

    <!-- Event Content -->
    <section class="py-12">
        <div class="max-w-7xl mx-auto px-8 sm:px-12 lg:px-16">
            <div class="max-w-4xl">
                <!-- Event Header -->
                <header class="mb-12">
                    <!-- Label -->
                    <div class="inline-flex items-center gap-2 mb-8">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-5 w-5 text-red-500">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M17.25 6.75 22.5 12l-5.25 5.25m-10.5 0L1.5 12l5.25-5.25m7.5-3-4.5 16.5" />
                        </svg>
                        <span class="text-sm font-medium text-red-600 uppercase tracking-wider">Événement</span>
                    </div>

                    <h1 class="text-5xl md:text-6xl lg:text-7xl font-bold text-gray-900 mb-10 leading-[1.1] tracking-tight">
                        {{ $event->name }}
                    </h1>
                    
                    <!-- Event Meta Information -->
                    <div class="space-y-4 mb-8">
                        <!-- Date -->
                        <div class="flex items-center text-gray-600">
                            <svg class="w-6 h-6 mr-3 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                            <span class="text-lg md:text-xl font-light">
                                {{ $event->date->format('l d F Y') }} à {{ $event->date->format('H:i') }}
                            </span>
                        </div>

                        <!-- Location -->
                        <div class="flex items-center text-gray-600">
                            <svg class="w-6 h-6 mr-3 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            </svg>
                            <span class="text-lg md:text-xl font-light">
                                {{ $event->place }}
                            </span>
                        </div>
                    </div>
                </header>

                <!-- Event Description -->
                <article class="mb-16">
                    <div class="text-lg md:text-xl text-gray-700 leading-relaxed font-light whitespace-pre-wrap">
                        {{ $event->description }}
                    </div>
                </article>

                @php($mediaItems = $event->getMedia('events'))
                @if($mediaItems->isNotEmpty())
                    <!-- Event Gallery -->
                    <div class="mb-16">
                        <div class="inline-flex items-center gap-2 mb-8">
                            <span class="h-px w-12 bg-red-500"></span>
                            <span class="text-sm font-medium text-red-600 uppercase tracking-wider">{{__('Guest (s)')}}</span>
                        </div>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            @foreach($mediaItems as $media)
                                <div class="group relative overflow-hidden rounded-xl bg-gray-100 aspect-[4/3] border border-gray-200 hover:border-red-300 transition-all duration-200">
                                    <a href="{{ $media->getUrl() }}" target="_blank" class="block w-full h-full">
                                        <img
                                            src="{{ $media->getUrl() }}"
                                            alt="{{ $event->name }} - Image {{ $loop->iteration }}"
                                            class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105"
                                            loading="lazy"
                                        />
                                        <div class="absolute inset-0 bg-black opacity-0 group-hover:opacity-5 transition-opacity duration-300"></div>
                                    </a>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif

                <!-- Action Buttons -->
                @if($event->rsvp_link || $event->event_link)
                    <div class="flex flex-wrap gap-6 mb-16">
                        @if($event->rsvp_link)
                            <a href="{{ $event->rsvp_link }}" 
                               target="_blank"
                               class="inline-flex items-center justify-center bg-red-600 text-white px-10 py-5 rounded-xl text-lg font-semibold hover:bg-red-700 transition-all duration-200 group">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path>
                                </svg>
                                S'inscrire à l'événement
                            </a>
                        @endif

                        @if($event->event_link)
                            <a href="{{ $event->event_link }}" 
                               target="_blank"
                               class="inline-flex items-center justify-center border-2 border-gray-300 text-gray-900 px-10 py-5 rounded-xl text-lg font-semibold hover:border-red-600 hover:text-red-600 transition-all duration-200 group">
                                <svg class="w-5 h-5 mr-2 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path>
                                </svg>
                                Plus d'informations
                            </a>
                        @endif
                    </div>
                @endif

                <!-- Event Footer -->
                <footer class="pt-12 border-t border-gray-200">
                    <div class="flex flex-col sm:flex-row items-start sm:items-center gap-4">
                        <span class="text-gray-600 font-light">Partager cet événement :</span>
                        <div class="flex gap-4">
                            <a href="https://twitter.com/intent/tweet?text={{ urlencode($event->name) }}&url={{ urlencode(request()->url()) }}" 
                               target="_blank"
                               class="flex items-center justify-center w-10 h-10 rounded-lg border border-gray-300 text-gray-600 hover:border-red-600 hover:text-red-600 transition-all duration-200">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M18.9 1.98h3.28l-7.17 8.2 8.43 11.84h-6.6l-5.17-6.78-5.91 6.78H1.47l7.67-8.8L1 1.98h6.8l4.7 6.17 6.4-6.17Z"/>
                                </svg>
                            </a>
                            <a href="https://www.linkedin.com/sharing/share-offsite/?url={{ urlencode(request()->url()) }}" 
                               target="_blank"
                               class="flex items-center justify-center w-10 h-10 rounded-lg border border-gray-300 text-gray-600 hover:border-red-600 hover:text-red-600 transition-all duration-200">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/>
                                </svg>
                            </a>
                        </div>
                    </div>
                </footer>
            </div>
        </div>
    </section>

    <!-- Other Events Section -->
    <section class="py-20 bg-gray-50/50">
        <div class="max-w-7xl mx-auto px-8 sm:px-12 lg:px-16">
            <div class="text-center max-w-2xl mx-auto">
                <h2 class="text-4xl md:text-5xl font-bold text-gray-900 mb-8 tracking-tight">
                    Autres événements
                </h2>
                
                <a wire:navigate href="{{ route('events') }}" 
                   class="inline-flex items-center justify-center bg-red-600 text-white px-10 py-5 rounded-xl text-lg font-semibold hover:bg-red-700 transition-all duration-200 group">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                    </svg>
                    Voir tous les événements
                    <svg class="w-5 h-5 ml-2 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                    </svg>
                </a>
            </div>
        </div>
    </section>
    
</div>

