<x-slot:title>{{ $thread->title }} - Forum</x-slot:title>

<div class="min-h-screen bg-gradient-to-br from-red-50 via-white to-green-50 py-8">
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Breadcrumb -->
        <nav class="flex mb-6" aria-label="Breadcrumb">
            <ol class="inline-flex items-center space-x-1 md:space-x-3">
                <li class="inline-flex items-center">
                    <a href="{{ route('forum') }}" wire:navigate class="text-gray-700 hover:text-red-600">Forum</a>
                </li>
                <li>
                    <div class="flex items-center">
                        <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                        </svg>
                        <a href="{{ route('forum.category.show', $category->slug) }}" wire:navigate class="ml-1 text-gray-700 hover:text-red-600">{{ $category->name }}</a>
                    </div>
                </li>
            </ol>
        </nav>

        <!-- Thread Header -->
        <div class="bg-white rounded-lg shadow-lg p-6 mb-6">
            <div class="flex items-start justify-between mb-4">
                <div class="flex-1">
                    <h1 class="text-3xl font-bold text-gray-900 mb-2">
                        @if($thread->is_pinned) <span class="text-red-600">📌</span> @endif
                        @if($thread->is_locked) <span class="text-gray-400">🔒</span> @endif
                        {{ $thread->title }}
                    </h1>
                    <div class="flex items-center gap-4 text-sm text-gray-600">
                        <span>par <span class="font-medium">{{ $thread->user->name }}</span></span>
                        <span>•</span>
                        <span>{{ $thread->created_at->diffForHumans() }}</span>
                        <span>•</span>
                        <span>{{ $thread->views_count }} vues</span>
                        <span>•</span>
                        <span>{{ $thread->posts_count }} réponses</span>
                    </div>
                </div>
            </div>

            <div class="prose max-w-none">
                {!! nl2br(e($thread->content)) !!}
            </div>
        </div>

        <!-- Messages -->
        @if($posts->count() > 0)
            <div class="space-y-4 mb-8">
                @foreach($posts as $post)
                    <div class="bg-white rounded-lg shadow p-6">
                        <div class="flex items-start gap-4">
                            <div class="flex-shrink-0">
                                <div class="w-12 h-12 bg-gray-200 rounded-full flex items-center justify-center">
                                    <span class="text-lg font-semibold text-gray-600">{{ substr($post->user->name, 0, 1) }}</span>
                                </div>
                            </div>
                            <div class="flex-1">
                                <div class="flex items-center justify-between mb-2">
                                    <div>
                                        <span class="font-semibold text-gray-900">{{ $post->user->name }}</span>
                                        <span class="text-sm text-gray-500 ml-2">{{ $post->created_at->diffForHumans() }}</span>
                                    </div>
                                    @if($post->is_solution)
                                        <span class="bg-green-100 text-green-800 text-xs font-medium px-2.5 py-0.5 rounded">✓ Solution</span>
                                    @endif
                                </div>
                                <div class="prose max-w-none text-gray-700">
                                    {!! nl2br(e($post->content)) !!}
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif

        <!-- Reply Form -->
        @auth
            @if(!$thread->is_locked)
                <div class="bg-white rounded-lg shadow-lg p-6">
                    <h3 class="text-xl font-bold text-gray-900 mb-4">Répondre</h3>

                    @if (session()->has('success'))
                        <div class="mb-4 p-4 bg-green-50 border border-green-200 rounded-lg text-green-700">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if (session()->has('error'))
                        <div class="mb-4 p-4 bg-red-50 border border-red-200 rounded-lg text-red-700">
                            {{ session('error') }}
                        </div>
                    @endif

                    <form wire:submit="postReply">
                        <textarea wire:model="reply"
                                  rows="6"
                                  class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-transparent"
                                  placeholder="Votre réponse (minimum 10 caractères)"></textarea>
                        @error('reply') <span class="text-red-600 text-sm mt-1">{{ $message }}</span> @enderror

                        <div class="mt-4 flex justify-end">
                            <button type="submit"
                                    class="px-6 py-3 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-colors font-semibold">
                                Publier la réponse
                            </button>
                        </div>
                    </form>
                </div>
            @else
                <div class="bg-gray-50 rounded-lg p-6 text-center text-gray-600">
                    🔒 Cette discussion est verrouillée. Vous ne pouvez plus y répondre.
                </div>
            @endif
        @else
            <div class="bg-white rounded-lg shadow-lg p-6 text-center">
                <p class="text-gray-600 mb-4">Vous devez être connecté pour répondre à cette discussion.</p>
                <a href="{{ route('login') }}" class="inline-block px-6 py-3 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-colors font-semibold">
                    Se connecter
                </a>
            </div>
        @endauth
    </div>
</div>
