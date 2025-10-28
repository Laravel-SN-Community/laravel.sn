<div class="max-w-6xl mx-auto px-4 py-12">
    {{-- Back Button --}}
    <div class="mb-8">
        <a href="{{ route('projects.index') }}" class="inline-flex items-center gap-2 text-red-600 hover:text-red-700 font-medium transition">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
            </svg>
            Retour aux projets
        </a>
    </div>

    {{-- Project Header --}}
    <div class="bg-gradient-to-r from-gray-50 to-white border border-gray-200 rounded-2xl p-8 md:p-10 mb-8">
        <div class="grid md:grid-cols-3 gap-8 mb-8">
            <div class="md:col-span-2">
                <h1 class="text-4xl md:text-5xl font-bold text-gray-900 mb-3">{{ $project->title }}</h1>
                <div class="flex flex-wrap items-center gap-4 text-gray-600">
                    <div class="flex items-center gap-2">
                        <div class="w-8 h-8 bg-gray-300 rounded-full"></div>
                        <span class="font-medium">{{ $project->user->name }}</span>
                    </div>
                    <span class="text-gray-400">•</span>
                    <span>{{ $project->approved_at->diffForHumans() }}</span>
                </div>
            </div>

            {{-- Vote Button --}}
            <div class="flex items-start justify-end">
                <button wire:click="toggleVote"
                    class="px-6 py-3 rounded-xl font-semibold transition-all duration-300 flex items-center gap-2 {{ $hasVoted ? 'bg-red-600 text-white shadow-lg hover:shadow-xl hover:bg-red-700' : 'bg-white text-red-600 border-2 border-red-200 hover:border-red-600 hover:bg-red-50' }}">
                    <span class="text-xl">{{ $hasVoted ? '❤️' : '🤍' }}</span>
                    <div class="text-left">
                        <div class="text-xs font-semibold text-gray-400 dark:text-gray-600">Votes</div>
                        <div class="text-lg font-bold">{{ $project->votes_count }}</div>
                    </div>
                </button>
            </div>
        </div>

        {{-- Stats --}}
        <div class="grid grid-cols-3 gap-4">
            <div class="bg-white border border-gray-200 rounded-xl p-4 text-center">
                <div class="flex items-center justify-center gap-2 mb-2">
                    <span class="text-2xl">⭐</span>
                    <div class="font-bold text-2xl text-gray-900">{{ number_format($project->average_rating, 1) }}</div>
                    <span class="text-gray-500">/5</span>
                </div>
                <p class="text-sm text-gray-600">Évaluation</p>
            </div>
            <div class="bg-white border border-gray-200 rounded-xl p-4 text-center">
                <div class="text-2xl font-bold text-gray-900 mb-2">{{ $reviews->count() }}</div>
                <p class="text-sm text-gray-600">Avis</p>
            </div>
            <div class="bg-white border border-gray-200 rounded-xl p-4 text-center">
                <div class="text-2xl font-bold text-gray-900 mb-2">{{ views($project)->unique()->count() }}</div>
                <p class="text-sm text-gray-600">Vues</p>
            </div>
        </div>

        {{-- Links --}}
        <div class="flex flex-wrap gap-3 mt-8">
            <a href="{{ $project->github_url }}" target="_blank"
                class="inline-flex items-center gap-2 px-6 py-3 bg-gray-900 text-white rounded-xl hover:bg-gray-800 font-semibold transition">
                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M12 0c-6.626 0-12 5.373-12 12 0 5.302 3.438 9.8 8.207 11.387.599.111.793-.261.793-.577v-2.234c-3.338.726-4.033-1.416-4.033-1.416-.546-1.387-1.333-1.756-1.333-1.756-1.089-.745.083-.729.083-.729 1.205.084 1.839 1.237 1.839 1.237 1.07 1.834 2.807 1.304 3.492.997.107-.775.418-1.305.762-1.604-2.665-.305-5.467-1.334-5.467-5.931 0-1.311.469-2.381 1.236-3.221-.124-.303-.535-1.524.117-3.176 0 0 1.008-.322 3.301 1.23.957-.266 1.983-.399 3.003-.404 1.02.005 2.047.138 3.006.404 2.291-1.552 3.297-1.23 3.297-1.23.653 1.653.242 2.874.118 3.176.77.84 1.235 1.911 1.235 3.221 0 4.609-2.807 5.624-5.479 5.921.43.372.823 1.102.823 2.222v3.293c0 .319.192.694.801.576 4.765-1.589 8.199-6.086 8.199-11.386 0-6.627-5.373-12-12-12z"/>
                </svg>
                Voir sur GitHub
            </a>

            @if($project->demo_url)
                <a href="{{ $project->demo_url }}" target="_blank"
                    class="inline-flex items-center gap-2 px-6 py-3 bg-red-600 text-white rounded-xl hover:bg-red-700 font-semibold transition">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                    </svg>
                    Démo en direct
                </a>
            @endif
        </div>
    </div>

    {{-- Screenshots --}}
    @if($project->getMedia('projects')->count() > 0)
        <div class="bg-white border border-gray-200 rounded-2xl p-8 md:p-10 mb-8">
            <h2 class="text-3xl font-bold text-gray-900 mb-6">Captures d'écran</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                @foreach($project->getMedia('projects') as $media)
                    <img src="{{ $media->getUrl() }}" alt="Capture d'écran"
                        class="w-full rounded-xl shadow-md hover:shadow-lg transition-shadow">
                @endforeach
            </div>
        </div>
    @endif

    {{-- Description --}}
    <div class="bg-white border border-gray-200 rounded-2xl p-8 md:p-10 mb-8">
        <h2 class="text-3xl font-bold text-gray-900 mb-6">À propos de ce projet</h2>
        <div class="prose prose-gray max-w-none text-gray-700 leading-relaxed">
            {!! $project->description_html !!}
        </div>
    </div>

    {{-- Reviews Section --}}
    <div class="bg-white border border-gray-200 rounded-2xl p-8 md:p-10">
        <div class="flex items-center justify-between mb-8">
            <h2 class="text-3xl font-bold text-gray-900">Avis ({{ $reviews->count() }})</h2>
        </div>

        {{-- Add Review Button --}}
        @auth
            @if(!$hasReviewed)
                @if(!$showReviewForm)
                    <button wire:click="$set('showReviewForm', true)"
                        class="mb-8 px-6 py-3 bg-red-600 text-white rounded-xl hover:bg-red-700 font-semibold transition">
                        Écrire un avis
                    </button>
                @else
                    {{-- Review Form --}}
                    <form wire:submit="submitReview" class="mb-8 p-6 bg-gray-50 rounded-xl border border-gray-200">
                        <h3 class="text-xl font-bold text-gray-900 mb-6">Votre avis</h3>

                        {{-- Title --}}
                        <div class="mb-6">
                            <label for="title" class="block text-sm font-semibold text-gray-700 mb-2">
                                Titre de votre avis
                            </label>
                            <input id="title" wire:model="title" type="text"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-transparent"
                                placeholder="Donnez un titre à votre avis...">
                            @error('title') <p class="mt-2 text-sm text-red-600">{{ $message }}</p> @enderror
                        </div>

                        {{-- Rating Stars --}}
                        <div class="mb-6">
                            <label class="block text-sm font-semibold text-gray-700 mb-3">Évaluation</label>
                            <div class="flex gap-3">
                                @for($i = 1; $i <= 5; $i++)
                                    <button type="button" wire:click="$set('rating', {{ $i }})"
                                        class="text-4xl transition-transform hover:scale-110 {{ $rating >= $i ? 'text-yellow-400' : 'text-gray-300' }}">
                                        ⭐
                                    </button>
                                @endfor
                            </div>
                            @error('rating') <p class="mt-2 text-sm text-red-600">{{ $message }}</p> @enderror
                        </div>

                        {{-- Comment --}}
                        <div class="mb-6">
                            <label for="comment" class="block text-sm font-semibold text-gray-700 mb-2">
                                Votre commentaire (Optionnel)
                            </label>
                            <textarea id="comment" wire:model="comment" rows="5"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-transparent resize-none"
                                placeholder="Partagez vos pensées sur ce projet..."></textarea>
                            @error('comment') <p class="mt-2 text-sm text-red-600">{{ $message }}</p> @enderror
                        </div>

                        <div class="flex gap-3">
                            <button type="submit"
                                class="px-6 py-3 bg-red-600 text-white rounded-lg hover:bg-red-700 font-semibold transition">
                                Soumettre
                            </button>
                            <button type="button" wire:click="$set('showReviewForm', false)"
                                class="px-6 py-3 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 font-semibold transition">
                                Annuler
                            </button>
                        </div>
                    </form>
                @endif
            @endif
        @else
            <p class="mb-8 text-gray-600 bg-blue-50 border border-blue-200 p-4 rounded-lg">
                <a href="{{ route('login') }}" class="text-red-600 hover:text-red-700 font-semibold">Connectez-vous</a> pour laisser un avis.
            </p>
        @endauth

        {{-- Reviews List --}}
        @if($reviews->count() > 0)
            <div class="space-y-6">
                @foreach($reviews as $review)
                    <div class="border-t border-gray-200 pt-6 first:border-t-0 first:pt-0">
                        <div class="flex items-start justify-between mb-3">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 bg-gradient-to-br from-red-400 to-red-600 rounded-full flex items-center justify-center text-white font-bold">
                                    {{ strtoupper(substr($review->user->name, 0, 1)) }}
                                </div>
                                <div>
                                    <div class="font-semibold text-gray-900">{{ $review->user->name }}</div>
                                    <div class="text-sm text-gray-500">{{ $review->created_at->diffForHumans() }}</div>
                                </div>
                            </div>

                            {{-- Delete button for own reviews --}}
                            @auth
                                @if($review->user_id === auth()->id())
                                    <button wire:click="deleteReview({{ $review->id }})"
                                        wire:confirm="Êtes-vous sûr de vouloir supprimer votre avis ?"
                                        class="text-red-600 hover:text-red-800 text-sm font-medium transition">
                                        Supprimer
                                    </button>
                                @endif
                            @endauth
                        </div>

                        {{-- Rating --}}
                        <div class="flex gap-1 mb-3">
                            @for($i = 1; $i <= 5; $i++)
                                <span class="{{ $i <= $review->rating ? 'text-yellow-400' : 'text-gray-300' }}">⭐</span>
                            @endfor
                        </div>

                        {{-- Title --}}
                        @if($review->title)
                            <h4 class="text-lg font-semibold text-gray-900 mb-2">{{ $review->title }}</h4>
                        @endif

                        {{-- Comment --}}
                        @if($review->comment)
                            <p class="text-gray-700 leading-relaxed">{{ $review->comment }}</p>
                        @endif
                    </div>
                @endforeach
            </div>
        @else
            <div class="text-center py-12">
                <svg class="w-12 h-12 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h12a2 2 0 012 2v8a2 2 0 01-2 2h-3.586l-4 4z"></path>
                </svg>
                <p class="text-gray-600 font-medium">Aucun avis pour le moment. Soyez le premier à commenter !</p>
            </div>
        @endif
    </div>
</div>