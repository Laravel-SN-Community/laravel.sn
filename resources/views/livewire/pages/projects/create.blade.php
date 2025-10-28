<div>
    <!-- Header -->
    <div class="mb-8 flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-bold">Mes Projets</h1>
            <p class="mt-2 text-gray-600">Gérez vos projets</p>
        </div>
        <button wire:click="openModal" type="button"
            class="inline-flex items-center gap-2 px-4 py-2 bg-red-600 text-white font-semibold rounded-md hover:bg-red-700 transition-colors">
            <i class="ri-add-line w-5 h-5"></i>
            Soumettre un projet
        </button>
    </div>

    <!-- Liste des projets -->
    @if($projects->count())
        <div class="space-y-4">
            @foreach($projects as $project)
                <div class="card">
                    <div class="flex items-center justify-between">
                        <div>
                            <h3 class="text-lg font-semibold">{{ $project->title }}</h3>
                            <p class="text-sm text-gray-600">{{ Str::limit($project->description, 150) }}</p>
                            <div class="flex items-center gap-4 text-sm text-gray-500 mt-2">
                                <span class="flex items-center gap-1">
                                    <i class="ri-heart-line w-4 h-4 text-red-500"></i>
                                    {{ $project->votes_count }}
                                </span>
                                <span class="flex items-center gap-1">
                                    <i class="ri-chat-1-line w-4 h-4 text-blue-500"></i>
                                    {{ $project->comments_count }}
                                </span>
                                <span>{{ $project->created_at->diffForHumans() }}</span>
                            </div>
                        </div>
                        <div class="flex gap-2">
                            @if($project->status->value === 'approved')
                            <a href="{{ route('projects.show', $project->slug) }}" target="_blank" class="btn btn-ghost">
                                <i class="ri-eye-line w-5 h-5"></i>
                            </a>
                            @endif
                            <button wire:click="deleteProject({{ $project->id }})" class="btn btn-ghost text-red-600">
                                <i class="ri-delete-bin-line w-5 h-5"></i>
                            </button>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        <div class="mt-6">{{ $projects->links() }}</div>
    @else
        <div class="card text-center py-12">
            <i class="ri-folder-open-line w-36 h-36 text-gray-400 mx-auto"></i>
            <h3 class="mt-2 text-lg font-medium">Aucun projet</h3>
            <button wire:click="openModal" type="button"
                class="inline-flex items-center gap-2 px-4 py-2 bg-red-600 text-white font-semibold rounded-md hover:bg-red-700 transition-colors mt-4">
                Premier projet
            </button>
        </div>
    @endif

    <!-- Modal -->
    <div x-data="{ show: @entangle('showModal') }" x-show="show" class="fixed inset-0 z-50 flex items-center justify-center overflow-y-auto" 
         x-transition style="display: none;" @keydown.escape="show = false">
        <!-- Overlay -->
        <div class="fixed inset-0 bg-black/50 z-40" @click="show = false"></div>
        
        <!-- Modal Content -->
        <div class="relative z-50 w-full max-w-4xl mx-auto px-4 py-8">
            <div class="bg-white rounded-lg shadow-2xl overflow-hidden">
                <!-- Header -->
                <div class="px-6 py-4 border-b border-gray-200 flex items-center justify-between">
                    <h3 class="text-xl font-bold text-gray-900">Soumettre un projet</h3>
                    <button @click="show = false" type="button" class="text-gray-400 hover:text-gray-600 transition">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>

                <!-- Form Content -->
                <div class="px-6 py-6 overflow-y-auto" style="max-height: calc(100vh - 200px);">
                    <form wire:submit="submit" class="space-y-6">
                        <!-- Render Filament form -->
                        <div class="filament-form">
                            {{ $this->form }}
                        </div>

                        <!-- Action Buttons -->
                        <div class="flex justify-end gap-3 pt-6 border-t border-gray-200">
                            <button type="button" @click="show = false" 
                                class="px-6 py-2.5 bg-gray-100 text-gray-700 font-medium rounded-md hover:bg-gray-200 transition-colors duration-200">
                                Annuler
                            </button>
                            <button type="submit" 
                                class="px-6 py-2.5 bg-red-600 text-white font-medium rounded-md hover:bg-red-700 transition-colors duration-200 inline-flex items-center gap-2">
                                <i class="ri-check-line w-5 h-5"></i>
                                Soumettre
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        document.addEventListener('alpine:initializing', () => {
            // Forcer le rechargement des styles Filament dans le modal
            if (window.Livewire) {
                Livewire.hook('morph.updated', () => {
                    // Réappliquer les styles Filament
                    if (window.filament) {
                        window.filament.reinitialize?.();
                    }
                });
            }
        });
    </script>
    @endpush
</div>