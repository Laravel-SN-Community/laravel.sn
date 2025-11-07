<x-slot:title>{{ __('Forum') }}</x-slot:title>
<div class="min-h-screen bg-gradient-to-br from-red-50 via-white to-green-50">

    <!-- Hero Section -->
    <section class="relative py-20 bg-white overflow-hidden">
        <!-- Gradient Overlay -->
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
                {{ __('Forum Laravel Sénégal') }}
            </h1>

            <!-- Subtitle -->
            <p class="text-xl md:text-2xl text-gray-700 mb-8 text-center max-w-4xl mx-auto">
                {{ __('Échangez, posez vos questions et partagez vos connaissances avec la communauté') }}
                <span class="text-red-600 font-semibold">Laravel</span> du Sénégal
            </p>

            <!-- Search -->
            <div class="max-w-2xl mx-auto mb-12">
                <div class="relative">
                    <input type="text"
                           wire:model.live.debounce.300ms="search"
                           placeholder="{{ __('Rechercher dans les catégories...') }}"
                           class="w-full px-4 py-3 pl-10 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-transparent">
                    <svg class="absolute left-3 top-3.5 h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                </div>
            </div>

            <!-- Stats -->
            <div class="grid md:grid-cols-3 gap-6 max-w-3xl mx-auto">
                <div class="bg-white/80 backdrop-blur-sm rounded-lg p-6 text-center border border-gray-200">
                    <div class="text-3xl font-bold text-red-600 mb-2">{{ $categories->sum('threads_count') }}</div>
                    <div class="text-gray-600">{{ __('Discussions') }}</div>
                </div>
                <div class="bg-white/80 backdrop-blur-sm rounded-lg p-6 text-center border border-gray-200">
                    <div class="text-3xl font-bold text-green-600 mb-2">{{ $categories->count() }}</div>
                    <div class="text-gray-600">{{ __('Catégories') }}</div>
                </div>
                <div class="bg-white/80 backdrop-blur-sm rounded-lg p-6 text-center border border-gray-200">
                    <div class="text-3xl font-bold text-gray-800 mb-2">500+</div>
                    <div class="text-gray-600">{{ __('Membres actifs') }}</div>
                </div>
            </div>
        </div>

        <!-- Fade Effect Bottom -->
        <div class="absolute bottom-0 left-0 w-full h-24 bg-gradient-to-b from-transparent to-white pointer-events-none z-20"></div>
    </section>

    <!-- Categories Section -->
    <section id="categories" class="py-20 bg-white">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">

            @if($categories->count() > 0)
                <!-- Categories Grid -->
                <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
                    @foreach($categories as $category)
                        <article class="bg-white rounded-xl shadow-lg border border-gray-200 overflow-hidden hover:shadow-xl transition-all duration-300 hover:-translate-y-1">
                            <!-- Category Header -->
                            <div class="p-6">
                                <div class="flex items-center mb-4">
                                    @if($category->icon)
                                        <div class="w-12 h-12 rounded-lg flex items-center justify-center mr-4" style="background-color: {{ $category->color }}20;">
                                            <svg class="w-6 h-6" style="color: {{ $category->color }}" fill="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                                            </svg>
                                        </div>
                                    @endif
                                    <div class="flex-1">
                                        <h3 class="text-xl font-bold text-gray-900 mb-1">
                                            {{ $category->name }}
                                        </h3>
                                        <div class="flex items-center text-sm text-gray-500">
                                            <span class="mr-4">{{ $category->threads_count }} {{ __('discussions') }}</span>
                                            <span>{{ $category->posts_count }} {{ __('messages') }}</span>
                                        </div>
                                    </div>
                                </div>

                                @if($category->description)
                                    <p class="text-gray-600 text-sm mb-4">
                                        {{ $category->description }}
                                    </p>
                                @endif

                                <!-- Latest Thread -->
                                @if($category->latest_thread)
                                    <div class="border-t border-gray-100 pt-4">
                                        <div class="text-xs text-gray-500 mb-1">{{ __('Dernière discussion') }}</div>
                                        <div class="text-sm">
                                            <div class="text-gray-900 font-medium line-clamp-1">
                                                {{ $category->latest_thread->title }}
                                            </div>
                                            <div class="text-xs text-gray-500 mt-1">
                                                par {{ $category->latest_thread->lastPostUser->name ?? $category->latest_thread->user->name }}
                                                • {{ $category->latest_thread->last_post_at?->diffForHumans() }}
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            </div>

                            <!-- Category Footer -->
                            <div class="px-6 pb-6">
                                <button class="w-full bg-red-600 text-white px-4 py-2 rounded-lg text-sm font-semibold hover:bg-red-700 transition-colors text-center block cursor-not-allowed opacity-75">
                                    {{ __('Voir les discussions') }} ({{ __('Bientôt') }})
                                </button>
                            </div>
                        </article>
                    @endforeach
                </div>

                <!-- Call to Action -->
                @auth
                    <div class="mt-16 text-center">
                        <button class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-lg text-white bg-red-600 hover:bg-red-700 transition-colors cursor-not-allowed opacity-75">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                            </svg>
                            {{ __('Créer une nouvelle discussion') }} ({{ __('Bientôt') }})
                        </button>
                    </div>
                @endauth
            @else
                <!-- Empty State -->
                <div class="text-center py-16">
                    <svg class="mx-auto h-24 w-24 text-gray-400 mb-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                    </svg>
                    <h3 class="text-2xl font-bold text-gray-900 mb-4">{{ __('Aucune catégorie trouvée') }}</h3>
                    <p class="text-gray-600 mb-8">
                        @if($search)
                            {{ __('Aucune catégorie trouvée pour votre recherche') }} "{{ $search }}".
                        @else
                            {{ __('Le forum n\'a pas encore de catégories') }}.
                        @endif
                    </p>
                    @if($search)
                        <button wire:click="$set('search', '')"
                                class="bg-red-600 text-white px-6 py-3 rounded-lg font-semibold hover:bg-red-700 transition-colors">
                            {{ __('Voir toutes les catégories') }}
                        </button>
                    @endif
                </div>
            @endif
        </div>
    </section>

</div>
