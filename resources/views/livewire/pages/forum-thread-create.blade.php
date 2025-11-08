<x-slot:title>Créer une discussion - {{ $category->name }}</x-slot:title>

<div class="min-h-screen bg-gradient-to-br from-red-50 via-white to-green-50 py-12">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Breadcrumb -->
        <nav class="flex mb-8" aria-label="Breadcrumb">
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
                <li>
                    <div class="flex items-center">
                        <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                        </svg>
                        <span class="ml-1 text-gray-500">Nouvelle discussion</span>
                    </div>
                </li>
            </ol>
        </nav>

        <!-- Form -->
        <div class="bg-white rounded-lg shadow-lg p-8">
            <h1 class="text-3xl font-bold text-gray-900 mb-6">Créer une discussion</h1>
            <p class="text-gray-600 mb-8">dans <span class="font-semibold text-red-600">{{ $category->name }}</span></p>

            @if (session()->has('success'))
                <div class="mb-6 p-4 bg-green-50 border border-green-200 rounded-lg text-green-700">
                    {{ session('success') }}
                </div>
            @endif

            <form wire:submit="createThread">
                <!-- Title -->
                <div class="mb-6">
                    <label for="title" class="block text-sm font-medium text-gray-700 mb-2">Titre de la discussion *</label>
                    <input type="text"
                           id="title"
                           wire:model="title"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-transparent"
                           placeholder="Entrez un titre descriptif (minimum 10 caractères)">
                    @error('title') <span class="text-red-600 text-sm mt-1">{{ $message }}</span> @enderror
                </div>

                <!-- Content -->
                <div class="mb-6">
                    <label for="content" class="block text-sm font-medium text-gray-700 mb-2">Contenu *</label>
                    <textarea id="content"
                              wire:model="content"
                              rows="10"
                              class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-transparent"
                              placeholder="Décrivez votre question ou sujet en détail (minimum 20 caractères)"></textarea>
                    @error('content') <span class="text-red-600 text-sm mt-1">{{ $message }}</span> @enderror
                </div>

                <!-- Actions -->
                <div class="flex items-center justify-between">
                    <a href="{{ route('forum.category.show', $category->slug) }}"
                       wire:navigate
                       class="text-gray-600 hover:text-gray-800">
                        ← Retour
                    </a>
                    <button type="submit"
                            class="px-6 py-3 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-colors font-semibold">
                        Publier la discussion
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
