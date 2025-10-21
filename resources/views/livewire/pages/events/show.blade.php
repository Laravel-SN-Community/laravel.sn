<div class="min-h-screen bg-gradient-to-br from-red-50 via-white to-green-50">

    <!-- Back Button -->
    <section class="relative py-8 bg-white">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <a wire:navigate href="{{ route('events') }}" 
               class="inline-flex items-center text-red-600 hover:text-red-700 font-medium transition-colors">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                </svg>
                Retour aux événements
            </a>
        </div>
    </section>

    <!-- Event Content -->
    <section class="py-12 bg-white">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <!-- Event Header -->
            <header class="mb-8">
                <h1 class="text-4xl md:text-5xl font-bold text-gray-900 mb-4 leading-tight">
                    {{ $event->name }}
                </h1>
                
                <!-- Event Meta Information -->
                <div class="space-y-4 mb-6">
                    <!-- Date -->
                    <div class="flex items-center text-gray-600">
                        <svg class="w-5 h-5 mr-3 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                        <span class="text-lg">
                            {{ $event->date->format('l d F Y') }} à {{ $event->date->format('H:i') }}
                        </span>
                    </div>

                    <!-- Location -->
                    <div class="flex items-center text-gray-600">
                        <svg class="w-5 h-5 mr-3 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        </svg>
                        <span class="text-lg">
                            {{ $event->place }}
                        </span>
                    </div>
                </div>

                <!-- Divider -->
                <div class="w-24 h-1 bg-red-600 rounded-full"></div>
            </header>

            <!-- Event Description -->
            <article class="prose prose-lg max-w-none prose-headings:text-gray-900 prose-headings:font-bold prose-p:text-gray-800 prose-p:leading-relaxed prose-a:text-red-600 prose-a:no-underline hover:prose-a:underline prose-strong:text-gray-900 prose-ul:list-disc prose-ol:list-decimal prose-li:text-gray-800">
                <div class="text-gray-800 leading-relaxed whitespace-pre-wrap">
                    {{ $event->description }}
                </div>
            </article>

            <!-- Action Buttons -->
            @if($event->rsvp_link || $event->event_link)
                <div class="mt-8 flex flex-wrap gap-4">
                    @if($event->rsvp_link)
                        <a href="{{ $event->rsvp_link }}" 
                           target="_blank"
                           class="inline-flex items-center bg-red-600 text-white px-6 py-3 rounded-lg font-semibold hover:bg-red-700 transition-colors">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path>
                            </svg>
                            S'inscrire à l'événement
                        </a>
                    @endif

                    @if($event->event_link)
                        <a href="{{ $event->event_link }}" 
                           target="_blank"
                           class="inline-flex items-center bg-green-600 text-white px-6 py-3 rounded-lg font-semibold hover:bg-green-700 transition-colors">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path>
                            </svg>
                            Plus d'informations
                        </a>
                    @endif
                </div>
            @endif

            <!-- Event Footer -->
            <footer class="mt-12 pt-8 border-t border-gray-200">
                <div class="flex items-center justify-between">
                    <div class="flex items-center space-x-4">
                        <span class="text-gray-600">Partager cet événement :</span>
                        <div class="flex space-x-3">
                            <a href="https://twitter.com/intent/tweet?text={{ urlencode($event->name) }}&url={{ urlencode(request()->url()) }}" 
                               target="_blank"
                               class="text-gray-400 hover:text-red-600 transition-colors">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M18.9 1.98h3.28l-7.17 8.2 8.43 11.84h-6.6l-5.17-6.78-5.91 6.78H1.47l7.67-8.8L1 1.98h6.8l4.7 6.17 6.4-6.17Z"/>
                                </svg>
                            </a>
                            <a href="https://www.linkedin.com/sharing/share-offsite/?url={{ urlencode(request()->url()) }}" 
                               target="_blank"
                               class="text-gray-400 hover:text-red-600 transition-colors">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/>
                                </svg>
                            </a>
                        </div>
                    </div>

                </div>
            </footer>
        </div>
    </section>

    <!-- Other Events Section -->
    <section class="py-16 bg-gray-50">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            <h2 class="text-3xl font-bold text-gray-900 mb-8 text-center">
                Autres événements
            </h2>
            
            <div class="text-center">
                <a wire:navigate href="{{ route('events') }}" 
                   class="inline-flex items-center bg-red-600 text-white px-8 py-3 rounded-lg font-semibold hover:bg-red-700 transition-colors">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                    </svg>
                    Voir tous les événements
                </a>
            </div>
        </div>
    </section>
    
</div>

