<div>

    <!-- Articles Section -->
    <section id="articles" class="py-12">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Header with Title and Create Button -->
            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-8">
                <div>
                    <h1 class="text-3xl md:text-4xl font-bold text-gray-900">{{ __('Mes Articles') }}</h1>
                    <p class="text-gray-600 mt-2">{{ __('Gérez et publiez vos articles') }}</p>
                </div>
                <div class="flex-shrink-0">
                    <x-filament::button color="danger" wire:navigate href="{{ route('articles.create') }}" tag="a">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                             stroke="currentColor" class="size-6">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                  d="M12 9v6m3-3H9m12 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
                        </svg>
                        {{ __('Nouvel Article') }}
                    </x-filament::button>
                </div>
            </div>

            <!-- Search Bar -->
            <div class="mb-8">
                <x-filament::input.wrapper class="relative">
                    <x-filament::input
                        type="text"
                        wire:model.live.debounce.200ms="search"
                        placeholder="Rechercher un article..."
                        class="w-full  pl-10 border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-transparent"
                    />
                    <svg class="absolute left-3 top-2 h-5 w-5 text-gray-400" fill="none" stroke="currentColor"
                         viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                </x-filament::input.wrapper>
            </div>

            <!-- Success Message -->
            @if (session()->has('message'))
                <div class="mb-6 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg">
                    {{ session('message') }}
                </div>
            @endif

            <!-- Articles Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @forelse($articles as $article)
                    <div
                        class="bg-white rounded-xl border border-gray-200 overflow-hidden hover:border-red-600 transition-colors">
                        <!-- Article Cover Image -->
                        <div class="relative h-48 overflow-hidden bg-gray-100">
                            <img src="{{ $article->getFirstMediaUrl('articles') ?: asset('/images/Laravelsn.jpg') }}"
                                 alt="{{ $article->title }}"
                                 class="w-full h-full object-cover">

                            <!-- Status Badge -->
                            <div class="absolute top-3 right-3">
                                @if($article->status === \App\Enums\ArticleStatus::Published)
                                    <span
                                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800 border border-green-300">
                                        Publié
                                    </span>
                                @elseif($article->status === \App\Enums\ArticleStatus::Draft)
                                    <span
                                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800 border border-gray-300">
                                        Brouillon
                                    </span>
                                @else
                                    <span
                                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800 border border-yellow-300">
                                        En attente
                                    </span>
                                @endif
                            </div>
                        </div>

                        <!-- Article Content -->
                        <div class="p-5">
                            <!-- Title -->
                            <h3 class="text-lg font-semibold text-gray-900 mb-2 line-clamp-2">
                                {{ $article->title }}
                            </h3>

                            <!-- Meta Information -->
                            <div class="flex items-center text-sm text-gray-500 mb-3">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                                {{ $article->created_at->format('d/m/Y') }}
                            </div>

                            <!-- Excerpt -->
                            <p class="text-sm text-gray-600 mb-4 line-clamp-3">
                                {{ $article->excerpt ?? Str::limit(strip_tags($article->content), 120) }}
                            </p>

                            <!-- Actions -->
                            <div class="flex items-center gap-2">
                                <a wire:navigate href="{{ route('articles.edit', $article->id) }}"
                                   class="flex-1 text-center px-3 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition-colors text-sm font-medium">
                                    Modifier
                                </a>

                                @if($article->status === \App\Enums\ArticleStatus::Published)
                                    <a wire:navigate href="{{ route('article.show', $article->slug) }}"
                                       target="_blank"
                                       class="flex-1 text-center px-3 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-colors text-sm font-medium">
                                        Voir
                                    </a>
                                @endif

                                <x-filament::button wire:click="deleteArticle({{ $article->id }})"
                                        wire:confirm="Êtes-vous sûr de vouloir supprimer cet article ?"
                                        class="px-3 py-2 bg-red-100 text-red-600 rounded-lg hover:bg-red-200 transition-colors">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                              d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                    </svg>
                                </x-filament::button>
                            </div>
                        </div>
                    </div>
                @empty
                    <!-- Empty State -->
                    <div class="text-center py-16 col-span-full">
                        <svg class="mx-auto h-24 w-24 text-gray-400 mb-6" fill="none" stroke="currentColor"
                             viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1"
                                  d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                        </svg>
                        <h3 class="text-2xl font-bold text-gray-900 mb-4">Aucun article</h3>
                        <p class="text-gray-600 mb-8">
                            @if($search)
                                Aucun article ne correspond à votre recherche "{{ $search }}".
                            @else
                                Commencez par créer votre premier article !
                            @endif
                        </p>
                        @if($search)
                            <button wire:click="$set('search', '')"
                                    class="bg-red-600 text-white px-6 py-3 rounded-lg font-semibold hover:bg-red-700 transition-colors">
                                Voir tous les articles
                            </button>
                        @else
                            <a wire:navigate href="{{ route('articles.create') }}"
                               class="inline-flex items-center bg-red-600 text-white px-6 py-3 rounded-lg font-semibold hover:bg-red-700 transition-colors">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M12 4v16m8-8H4"></path>
                                </svg>
                                Créer mon premier article
                            </a>
                        @endif
                    </div>
                @endforelse
            </div>

            <!-- Pagination -->
            @if($articles->hasPages())
                <div class="mt-12">
                    {{ $articles->links() }}
                </div>
            @endif
        </div>
    </section>

    <x-filament-actions::modals/>
</div>
