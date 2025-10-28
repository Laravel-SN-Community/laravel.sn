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
                    <form wire:submit="submit" class="space-y-8">
                        <!-- Project Title -->
                        <div class="space-y-2">
                            <label class="block text-sm font-medium text-gray-700">
                                Project Title <span class="text-red-500">*</span>
                            </label>
                            <input type="text" wire:model="data.title" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500 transition-colors" placeholder="Enter your project title">
                            @error('data.title') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
                        </div>

                        <!-- URL Slug -->
                        <div class="space-y-2">
                            <label class="block text-sm font-medium text-gray-700">
                                URL Slug <span class="text-red-500">*</span>
                            </label>
                            <input type="text" wire:model="data.slug" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500 transition-colors" placeholder="auto-generated-from-title">
                            <p class="text-sm text-gray-500">This will be used in the project URL</p>
                            @error('data.slug') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
                        </div>

                        <!-- Project Category -->
                        <div class="space-y-2">
                            <label class="block text-sm font-medium text-gray-700">
                                Project Category <span class="text-red-500">*</span>
                            </label>
                            <select wire:model="data.category_id" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500 transition-colors">
                                <option value="">Choose a category</option>
                                @foreach(\App\Models\Category::all() as $category)
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            </select>
                            <p class="text-sm text-gray-500">Select the most appropriate category for your project</p>
                            @error('data.category_id') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
                        </div>

                        <!-- GitHub Repository -->
                        <div class="space-y-2">
                            <label class="block text-sm font-medium text-gray-700">
                                GitHub Repository <span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                    <span class="text-gray-500 text-sm">https://</span>
                                </div>
                                <input type="url" wire:model="data.github_url" class="w-full pl-20 pr-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500 transition-colors" placeholder="github.com/username/repository">
                            </div>
                            <p class="text-sm text-gray-500">Link to your project's GitHub repository</p>
                            @error('data.github_url') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
                        </div>

                        <!-- Live Demo -->
                        <div class="space-y-2">
                            <label class="block text-sm font-medium text-gray-700">
                                Live Demo
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                    <span class="text-gray-500 text-sm">https://</span>
                                </div>
                                <input type="url" wire:model="data.demo_url" class="w-full pl-20 pr-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500 transition-colors" placeholder="demo.example.com">
                            </div>
                            <p class="text-sm text-gray-500">Optional: Link to a live demo or project website</p>
                            @error('data.demo_url') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
                        </div>

                        <!-- Project Screenshots -->
                        <div class="space-y-2">
                            <label class="block text-sm font-medium text-gray-700">
                                Project Screenshots
                            </label>
                            <div class="border-2 border-dashed border-gray-300 rounded-lg p-8 text-center hover:border-red-400 transition-colors">
                                <div class="space-y-4">
                                    <div class="mx-auto w-12 h-12 bg-gray-100 rounded-full flex items-center justify-center">
                                        <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path>
                                        </svg>
                                    </div>
                                    <div>
                                        <p class="text-lg font-medium text-gray-900">Drag & Drop your files or Browse</p>
                                        <p class="text-sm text-gray-500">Files</p>
                                    </div>
                                    <button type="button" class="px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700 transition-colors">
                                        Browse
                                    </button>
                                </div>
                            </div>
                            <p class="text-sm text-gray-500">Upload up to 5 screenshots showcasing your project (max 5MB each)</p>
                            @error('data.screenshots') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
                        </div>

                        <!-- Project Description -->
                        <div class="space-y-2">
                            <label class="block text-sm font-medium text-gray-700">
                                Project Description <span class="text-red-500">*</span>
                            </label>
                            <textarea wire:model="data.description" rows="6" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500 transition-colors resize-vertical" placeholder="Describe your project in detail..."></textarea>
                            @error('data.description') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
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