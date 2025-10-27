<div class="max-w-7xl mx-auto px-4 py-12">
    {{-- En-tête --}}
    <div class="mb-12">
        <h1 class="text-5xl font-bold text-gray-900 mb-4">Projets Communautaires</h1>
        <p class="text-xl text-gray-600 mb-6">Découvrez d'incroyables projets Laravel créés par notre communauté</p>

        @auth
            <a href="{{ route('my-projects') }}"
                class="inline-block px-6 py-3 bg-red-600 text-white font-semibold rounded-md hover:bg-red-700 transition-colors">
                Soumettre Votre Projet
            </a>
        @else
            <a href="{{ route('login') }}"
                class="inline-block px-6 py-3 bg-red-600 text-white font-semibold rounded-md hover:bg-red-700 transition-colors">
                Connectez-vous pour Soumettre un Projet
            </a>
        @endauth
    </div>

    {{-- Recherche et Filtres --}}
    <div class="mb-8 flex flex-col md:flex-row gap-4">
        {{-- Recherche --}}
        <div class="flex-1">
            <input type="text" wire:model.live.debounce.300ms="search"
                placeholder="Rechercher des projets..."
                class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-red-500 focus:border-transparent">
        </div>

        {{-- Tri --}}
        <div class="w-full md:w-48">
            <select wire:model.live="sortBy"
                class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-red-500 focus:border-transparent">
                <option value="latest">Les Plus Récents</option>
                <option value="popular">Les Plus Populaires</option>
                <option value="top_rated">Les Mieux Notés</option>
            </select>
        </div>
    </div>

    {{-- Grille de Projets --}}
    @if($projects->count() > 0)
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-12">
            @foreach($projects as $project)
                <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition-shadow">
                    {{-- Image du Projet --}}
                    @if($project->getFirstMediaUrl('projects'))
                        <img src="{{ $project->getFirstMediaUrl('projects') }}"
                            alt="{{ $project->title }}"
                            class="w-full h-48 object-cover">
                    @else
                        <div class="w-full h-48 bg-gradient-to-br from-red-400 to-purple-500 flex items-center justify-center">
                            <span class="text-white text-6xl">📦</span>
                        </div>
                    @endif

                    {{-- Informations du Projet --}}
                    <div class="p-6">
                        <h3 class="text-xl font-bold text-gray-900 mb-2">
                            <a href="{{ route('projects.show', $project->slug) }}"
                                class="hover:text-red-600 transition-colors">
                                {{ $project->title }}
                            </a>
                        </h3>

                        <p class="text-gray-600 mb-4 line-clamp-3">
                            {{ $project->excerpt }}
                        </p>

                        {{-- Statistiques --}}
                        <div class="flex items-center justify-between text-sm text-gray-500 mb-4">
                            <div class="flex items-center gap-4">
                                <span title="Votes">❤️ {{ $project->votes_count }}</span>
                                <span title="Note">⭐ {{ number_format($project->average_rating, 1) }}</span>
                                <span title="Avis">💬 {{ $project->reviews_count }}</span>
                            </div>
                        </div>

                        {{-- Auteur --}}
                        <div class="flex items-center justify-between border-t pt-4">
                            <div class="flex items-center gap-2">
                                <div class="w-8 h-8 bg-gray-300 rounded-full"></div>
                                <span class="text-sm text-gray-700">{{ $project->user->name }}</span>
                            </div>
                            <a href="{{ $project->github_url }}" target="_blank"
                                class="text-gray-600 hover:text-gray-900" title="Voir sur GitHub">
                                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M12 0c-6.626 0-12 5.373-12 12 0 5.302 3.438 9.8 8.207 11.387.599.111.793-.261.793-.577v-2.234c-3.338.726-4.033-1.416-4.033-1.416-.546-1.387-1.333-1.756-1.333-1.756-1.089-.745.083-.729.083-.729 1.205.084 1.839 1.237 1.839 1.237 1.07 1.834 2.807 1.304 3.492.997.107-.775.418-1.305.762-1.604-2.665-.305-5.467-1.334-5.467-5.931 0-1.311.469-2.381 1.236-3.221-.124-.303-.535-1.524.117-3.176 0 0 1.008-.322 3.301 1.23.957-.266 1.983-.399 3.003-.404 1.02.005 2.047.138 3.006.404 2.291-1.552 3.297-1.23 3.297-1.23.653 1.653.242 2.874.118 3.176.77.84 1.235 1.911 1.235 3.221 0 4.609-2.807 5.624-5.479 5.921.43.372.823 1.102.823 2.222v3.293c0 .319.192.694.801.576 4.765-1.589 8.199-6.086 8.199-11.386 0-6.627-5.373-12-12-12z"/>
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        {{-- Pagination --}}
        <div class="mt-8">
            {{ $projects->links() }}
        </div>
    @else
        <div class="text-center py-12">
            <p class="text-xl text-gray-600">Aucun projet trouvé.</p>
            @auth
                <a href="{{ route('my-projects') }}"
                    class="inline-block mt-4 px-6 py-3 bg-red-600 text-white font-semibold rounded-md hover:bg-red-700 transition-colors">
                    Soyez le premier à soumettre !
                </a>
            @endauth
        </div>
    @endif
</div>