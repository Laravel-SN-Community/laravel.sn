<div class="py-6">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        {{-- Header --}}
        <div class="mb-8 flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold text-gray-900">Mes Projets</h1>
                <p class="mt-2 text-gray-600">Gérez vos projets soumis à la communauté</p>
            </div>

            {{-- Button to open modal --}}
            <button wire:click="openModal" type="button"
                class="inline-flex items-center gap-2 px-4 py-2 bg-red-600 text-white font-semibold rounded-md hover:bg-red-700 transition-colors">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                Soumettre un projet
            </button>
        </div>

        {{-- Projects List --}}
        @if($projects->count() > 0)
            <div class="bg-white rounded-lg shadow overflow-hidden">
                <ul role="list" class="divide-y divide-gray-200">
                    @foreach($projects as $project)
                        <li class="p-6 hover:bg-gray-50 transition-colors">
                            <div class="flex items-center justify-between">
                                <div class="flex-1 min-w-0">
                                    <div class="flex items-center gap-3 mb-2">
                                        <h3 class="text-lg font-semibold text-gray-900">
                                            {{ $project->title }}
                                        </h3>

                                        {{-- Status badge --}}
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                            {{ $project->status->value === 'pending' ? 'bg-yellow-100 text-yellow-800' : '' }}
                                            {{ $project->status->value === 'approved' ? 'bg-green-100 text-green-800' : '' }}
                                            {{ $project->status->value === 'rejected' ? 'bg-red-100 text-red-800' : '' }}">
                                            {{ ucfirst($project->status->value) }}
                                        </span>
                                    </div>

                                    <p class="text-sm text-gray-600 mb-3 line-clamp-2">
                                        {{ Str::limit($project->description, 150) }}
                                    </p>

                                    <div class="flex items-center gap-4 text-sm text-gray-500">
                                        <span>❤️ {{ $project->votes_count }} votes</span>
                                        <span>⭐ {{ number_format($project->average_rating, 1) }}/5</span>
                                        <span>💬 {{ $project->reviews_count }} avis</span>
                                        <span>📅 {{ $project->created_at->diffForHumans() }}</span>
                                    </div>

                                    {{-- Rejection reason if rejected --}}
                                    @if($project->status->value === 'rejected' && $project->rejection_reason)
                                        <div class="mt-3 p-3 bg-red-50 border border-red-200 rounded-md">
                                            <p class="text-sm text-red-800">
                                                <strong>Raison du rejet :</strong> {{ $project->rejection_reason }}
                                            </p>
                                        </div>
                                    @endif
                                </div>

                                <div class="ml-4 flex items-center gap-2">
                                    {{-- View project --}}
                                    @if($project->status->value === 'approved')
                                        <a href="{{ route('projects.show', $project->slug) }}" target="_blank"
                                            class="p-2 text-gray-600 hover:text-red-600 transition-colors"
                                            title="Voir le projet">
                                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                            </svg>
                                        </a>
                                    @endif

                                    {{-- Delete project --}}
                                    <button wire:click="deleteProject({{ $project->id }})"
                                        wire:confirm="Êtes-vous sûr de vouloir supprimer ce projet ?"
                                        class="p-2 text-gray-600 hover:text-red-600 transition-colors"
                                        title="Supprimer">
                                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                        </svg>
                                    </button>
                                </div>
                            </div>
                        </li>
                    @endforeach
                </ul>
            </div>

            {{-- Pagination --}}
            <div class="mt-6">
                {{ $projects->links() }}
            </div>
        @else
            {{-- Empty state --}}
            <div class="bg-white rounded-lg shadow p-12 text-center">
                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                </svg>
                <h3 class="mt-2 text-lg font-medium text-gray-900">Aucun projet</h3>
                <p class="mt-1 text-gray-500">Commencez par soumettre votre premier projet à la communauté.</p>
                <div class="mt-6">
                    <button wire:click="openModal" type="button"
                        class="inline-flex items-center gap-2 px-4 py-2 bg-red-600 text-white font-semibold rounded-md hover:bg-red-700 transition-colors">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                        </svg>
                        Soumettre mon premier projet
                    </button>
                </div>
            </div>
        @endif
    </div>

    {{-- Modal --}}
    @if($showModal)
        <div class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
            {{-- Backdrop --}}
            <div class="flex min-h-screen items-center justify-center p-4 text-center sm:p-0">
                <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" wire:click="closeModal"></div>

                {{-- Modal content --}}
                <div class="relative transform overflow-hidden rounded-lg bg-white text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-3xl">
                    <form wire:submit="submit">
                        {{-- Header --}}
                        <div class="bg-white px-6 py-4 border-b border-gray-200">
                            <div class="flex items-center justify-between">
                                <h3 class="text-lg font-semibold text-gray-900">Soumettre un nouveau projet</h3>
                                <button type="button" wire:click="closeModal" class="text-gray-400 hover:text-gray-600">
                                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                    </svg>
                                </button>
                            </div>
                        </div>

                        {{-- Body --}}
                        <div class="bg-white px-6 py-6 space-y-6 max-h-[70vh] overflow-y-auto">
                            {{-- Title --}}
                            <div>
                                <label for="title" class="block text-sm font-medium text-gray-700 mb-2">
                                    Titre du projet <span class="text-red-500">*</span>
                                </label>
                                <input type="text" id="title" wire:model="title"
                                    class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-red-500 focus:border-transparent"
                                    placeholder="Mon Awesome Projet Laravel">
                                @error('title') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                            </div>

                            {{-- Category --}}
                            <div>
                                <label for="category_id" class="block text-sm font-medium text-gray-700 mb-2">
                                    Catégorie
                                </label>
                                <select id="category_id" wire:model.live="category_id"
                                    class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-red-500 focus:border-transparent">
                                    <option value="">Sélectionner une catégorie (optionnel)</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                                    @endforeach
                                    <option value="0">Autre (spécifier ci-dessous)</option>
                                </select>
                                @error('category_id') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                            </div>

                            {{-- New Category --}}
                            @if($category_id === 0)
                            <div>
                                <label for="new_category_name" class="block text-sm font-medium text-gray-700 mb-2">
                                    Nouveau nom de catégorie <span class="text-red-500">*</span>
                                </label>
                                <input type="text" id="new_category_name" wire:model="new_category_name"
                                    class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-red-500 focus:border-transparent"
                                    placeholder="Entrez le nouveau nom de catégorie">
                                @error('new_category_name') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                            </div>
                            @endif

                            {{-- GitHub URL --}}
                            <div>
                                <label for="github_url" class="block text-sm font-medium text-gray-700 mb-2">
                                    URL GitHub <span class="text-red-500">*</span>
                                </label>
                                <input type="url" id="github_url" wire:model="github_url"
                                    class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-red-500 focus:border-transparent"
                                    placeholder="https://github.com/username/repository">
                                @error('github_url') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                            </div>

                            {{-- Demo URL --}}
                            <div>
                                <label for="demo_url" class="block text-sm font-medium text-gray-700 mb-2">
                                    URL de démo (Optionnel)
                                </label>
                                <input type="url" id="demo_url" wire:model="demo_url"
                                    class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-red-500 focus:border-transparent"
                                    placeholder="https://demo.example.com">
                                @error('demo_url') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                            </div>

                            {{-- Description --}}
                            <div>
                                <label for="description" class="block text-sm font-medium text-gray-700 mb-2">
                                    Description <span class="text-red-500">*</span>
                                </label>
                                <textarea id="description" wire:model="description" rows="8"
                                    class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-red-500 focus:border-transparent"
                                    placeholder="Décrivez votre projet en détail. Markdown supporté. Minimum 100 caractères."></textarea>
                                <p class="mt-1 text-sm text-gray-500">Minimum 100 caractères. Markdown supporté.</p>
                                @error('description') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                            </div>

                            {{-- Screenshots --}}
                            <div>
                                <label for="screenshots" class="block text-sm font-medium text-gray-700 mb-2">
                                    Captures d'écran (Optionnel)
                                </label>
                                <input type="file" id="screenshots" wire:model="screenshots" multiple accept="image/*"
                                    class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-red-500 focus:border-transparent">
                                <p class="mt-1 text-sm text-gray-500">Jusqu'à 5 images. Max 5MB par image.</p>
                                @error('screenshots.*') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                            </div>

                            {{-- Loading indicator --}}
                            <div wire:loading wire:target="screenshots" class="text-sm text-gray-600">
                                Téléchargement des images...
                            </div>
                        </div>

                        {{-- Footer --}}
                        <div class="bg-gray-50 px-6 py-4 flex items-center justify-end gap-3">
                            <button type="button" wire:click="closeModal"
                                class="px-4 py-2 bg-white border border-gray-300 text-gray-700 rounded-md hover:bg-gray-50 transition-colors">
                                Annuler
                            </button>
                            <button type="submit"
                                class="px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700 transition-colors disabled:opacity-50"
                                wire:loading.attr="disabled">
                                <span wire:loading.remove wire:target="submit">Soumettre</span>
                                <span wire:loading wire:target="submit">Envoi en cours...</span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endif
</div>
