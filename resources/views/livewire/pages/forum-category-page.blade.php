<x-slot:title>{{ $category->name }} - Forum</x-slot:title>

<div class="min-h-screen bg-gradient-to-br from-red-50 via-white to-green-50">
    <!-- Header -->
    <div class="bg-white border-b border-gray-200">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <!-- Breadcrumb -->
            <nav class="flex mb-4" aria-label="Breadcrumb">
                <ol class="inline-flex items-center space-x-1 md:space-x-3">
                    <li class="inline-flex items-center">
                        <a href="{{ route('forum') }}" wire:navigate class="text-gray-700 hover:text-red-600 inline-flex items-center">
                            <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"></path>
                            </svg>
                            Forum
                        </a>
                    </li>
                    <li>
                        <div class="flex items-center">
                            <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                            </svg>
                            <span class="ml-1 text-gray-500 md:ml-2">{{ $category->name }}</span>
                        </div>
                    </li>
                </ol>
            </nav>

            <!-- Category Header -->
            <div class="flex items-start justify-between">
                <div class="flex-1">
                    <div class="flex items-center mb-3">
                        @if($category->icon)
                            <div class="w-16 h-16 rounded-xl flex items-center justify-center mr-4"
                                 style="background-color: {{ $category->color }}20;">
                                <svg class="w-8 h-8" style="color: {{ $category->color }}" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                                </svg>
                            </div>
                        @endif
                        <div>
                            <h1 class="text-3xl font-bold text-gray-900">{{ $category->name }}</h1>
                            @if($category->description)
                                <p class="text-gray-600 mt-1">{{ $category->description }}</p>
                            @endif
                        </div>
                    </div>
                </div>

                @auth
                    <a href="{{ route('forum.thread.create', $category->slug) }}" wire:navigate
                       class="inline-flex items-center px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-colors">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                        </svg>
                        Nouvelle discussion
                    </a>
                @endauth
            </div>
        </div>
    </div>

    <!-- Filters & Search -->
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
        <div class="flex flex-col sm:flex-row gap-4 mb-6">
            <!-- Search -->
            <div class="flex-1">
                <input type="text"
                       wire:model.live.debounce.300ms="search"
                       placeholder="Rechercher dans les discussions..."
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-transparent">
            </div>

            <!-- Sort -->
            <select wire:model.live="sortBy"
                    class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-transparent">
                <option value="latest">Plus récentes</option>
                <option value="popular">Plus populaires</option>
                <option value="oldest">Plus anciennes</option>
            </select>
        </div>

        <!-- Threads List -->
        @if($threads->count() > 0)
            <div class="space-y-4">
                @foreach($threads as $thread)
                    <article class="bg-white rounded-lg shadow hover:shadow-md transition-shadow border border-gray-200">
                        <div class="p-6">
                            <div class="flex items-start gap-4">
                                <!-- Author Avatar -->
                                <div class="flex-shrink-0">
                                    <div class="w-12 h-12 bg-gray-200 rounded-full flex items-center justify-center">
                                        <span class="text-lg font-semibold text-gray-600">
                                            {{ substr($thread->user->name, 0, 1) }}
                                        </span>
                                    </div>
                                </div>

                                <!-- Thread Content -->
                                <div class="flex-1 min-w-0">
                                    <div class="flex items-start justify-between">
                                        <div class="flex-1">
                                            <a href="{{ route('forum.thread.show', [$category->slug, $thread->slug]) }}"
                                               wire:navigate
                                               class="text-xl font-semibold text-gray-900 hover:text-red-600 transition-colors">
                                                @if($thread->is_pinned)
                                                    <span class="text-red-600">📌</span>
                                                @endif
                                                @if($thread->is_locked)
                                                    <span class="text-gray-400">🔒</span>
                                                @endif
                                                {{ $thread->title }}
                                            </a>
                                            <div class="flex items-center gap-3 mt-1 text-sm text-gray-600">
                                                <span>par <span class="font-medium">{{ $thread->user->name }}</span></span>
                                                <span>•</span>
                                                <span>{{ $thread->created_at->diffForHumans() }}</span>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Thread Stats -->
                                    <div class="flex items-center gap-6 mt-4 text-sm text-gray-500">
                                        <div class="flex items-center">
                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                                            </svg>
                                            {{ $thread->posts_count ?? 0 }} réponses
                                        </div>
                                        <div class="flex items-center">
                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                            </svg>
                                            {{ $thread->views_count ?? 0 }} vues
                                        </div>
                                        @if($thread->lastPostUser)
                                            <div class="flex items-center ml-auto">
                                                <span class="text-xs">Dernière réponse par <span class="font-medium">{{ $thread->lastPostUser->name }}</span></span>
                                                <span class="mx-1">•</span>
                                                <span class="text-xs">{{ $thread->last_post_at?->diffForHumans() }}</span>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </article>
                @endforeach
            </div>

            <!-- Pagination -->
            <div class="mt-6">
                {{ $threads->links() }}
            </div>
        @else
            <!-- Empty State -->
            <div class="bg-white rounded-lg shadow p-12 text-center">
                <svg class="mx-auto h-16 w-16 text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                </svg>
                <h3 class="text-xl font-semibold text-gray-900 mb-2">Aucune discussion</h3>
                <p class="text-gray-600 mb-6">
                    @if($search)
                        Aucune discussion trouvée pour votre recherche.
                    @else
                        Soyez le premier à créer une discussion dans cette catégorie !
                    @endif
                </p>
                @auth
                    <a href="{{ route('forum.thread.create', $category->slug) }}" wire:navigate
                       class="inline-flex items-center px-6 py-3 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-colors">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                        </svg>
                        Créer une discussion
                    </a>
                @endauth
            </div>
        @endif
    </div>
</div>
