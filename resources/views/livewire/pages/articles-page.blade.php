<x-slot:title>Articles</x-slot:title>
<div class="min-h-screen bg-gradient-to-br from-red-50 via-white to-green-50">

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
                Blog Laravel Sénégal
            </h1>

            <!-- Subtitle -->
            <p class="text-xl md:text-2xl text-gray-700 mb-8 text-center max-w-4xl mx-auto">
                Découvrez nos articles, tutoriels et actualités de la communauté
                <span class="text-red-600 font-semibold">Laravel</span> au Sénégal
            </p>

            <!-- Search -->
            <div class="max-w-2xl mx-auto mb-12">
                <div class="relative">
                    <input type="text"
                           wire:model.live.debounce.300ms="search"
                           placeholder="Rechercher un article..."
                           class="w-full px-4 py-3 pl-10 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-transparent">
                    <svg class="absolute left-3 top-3.5 h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                </div>
            </div>
        </div>

        <!-- Fade Effect Bottom -->
        <div class="absolute bottom-0 left-0 w-full h-24 bg-gradient-to-b from-transparent to-white pointer-events-none z-20"></div>
    </section>

    <!-- Articles Section -->
    <section id="articles" class="py-20 bg-white">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            @if($articles->count() > 0)
                <!-- Articles Grid -->
                <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
                    @foreach($articles as $article)
                        <article class="bg-white rounded-xl shadow-lg border border-gray-200 overflow-hidden hover:shadow-xl transition-all duration-300 hover:-translate-y-1">
                            <!-- Article Cover Image -->
                            <a wire:navigate href="{{ route('article.show', $article->slug) }}">
                                <div class="relative h-48 overflow-hidden bg-gray-100">
                                    <img src="{{ $article->getFirstMediaUrl('articles') ?: asset('/images/Laravelsn.jpg') }}"
                                        alt="{{ $article->title }}"
                                        class="w-full h-full object-cover">
                                    <div class="absolute inset-0 bg-gradient-to-t from-black/20 to-transparent"></div>
                                </div>
                            </a>
                            <!-- Article Header -->
                            <div class="p-6 pb-4">
                                <div class="flex items-start justify-between mb-4">
                                    <div class="flex-1">
                                        <a wire:navigate href="{{ route('article.show', $article->slug) }}">
                                            <h3 class="text-xl font-bold text-gray-900 mb-2 line-clamp-2 hover:text-red-500 hover:underline">
                                                {{ $article->title }}
                                            </h3>
                                        </a>
                                        <div class="flex items-center text-gray-600 mb-2">
                                            <svg class="w-5 h-5 mr-2 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                            </svg>
                                            <span class="text-sm font-medium">
                                                {{ $article->published_at->format('d/m/Y') }}
                                            </span>
                                        </div>
                                    </div>
                                </div>

                                <!-- Article Excerpt -->
                                <p class="text-gray-600 text-sm line-clamp-3 mb-4">
                                    {{ $article->excerpt }}
                                </p>
                            </div>

                            <!-- Article Actions -->
                            <div class="px-6 pb-6">
                                <a wire:navigate href="{{ route('article.show', $article->slug) }}"
                                   class="w-full bg-red-600 text-white px-4 py-2 rounded-lg text-sm font-semibold hover:bg-red-700 transition-colors text-center block">
                                    Lire l'article
                                </a>
                            </div>
                        </article>
                    @endforeach
                </div>

                <!-- Pagination -->
                @if($articles->hasPages())
                    <div class="mt-12">
                        {{ $articles->links() }}
                    </div>
                @endif
            @else
                <!-- Empty State -->
                <div class="text-center py-16">
                    <svg class="mx-auto h-24 w-24 text-gray-400 mb-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                    </svg>
                    <h3 class="text-2xl font-bold text-gray-900 mb-4">Aucun article trouvé</h3>
                    <p class="text-gray-600 mb-8">
                        @if($search)
                            Aucun article ne correspond à votre recherche "{{ $search }}".
                        @else
                            Aucun article n'est actuellement disponible.
                        @endif
                    </p>
                    @if($search)
                        <button wire:click="$set('search', '')"
                                class="bg-red-600 text-white px-6 py-3 rounded-lg font-semibold hover:bg-red-700 transition-colors">
                            Voir tous les articles
                        </button>
                    @endif
                </div>
            @endif
        </div>
    </section>

</div>
