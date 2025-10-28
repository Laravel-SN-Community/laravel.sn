<div>
    
    <!-- Projects Section -->
    <section id="projects" class="py-12">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Header with Title and Create Button -->
            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-8">
                <div>
                    <h1 class="text-3xl md:text-4xl font-bold text-gray-900">{{ __('My Projects') }}</h1>
                    <p class="text-gray-600 mt-2">{{ __('Manage and showcase your projects') }}</p>
                </div>
                <div class="flex-shrink-0">
                    <livewire:pages.projects.create />
                </div>
            </div>

            <!-- Projects Masonry Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @forelse($projects as $project)
                    <div class="bg-white rounded-xl shadow-lg border border-gray-200 overflow-hidden hover:shadow-xl transition-all duration-300 hover:-translate-y-1">
                        <!-- Project Cover Image -->
                        <div class="relative h-48 overflow-hidden bg-gray-100">
                            @if($project->getFirstMediaUrl('covers'))
                                <img src="{{ $project->getFirstMediaUrl('covers') }}" 
                                     alt="{{ $project->name }}"
                                     class="w-full h-full object-cover">
                            @else
                                <div class="w-full h-full flex items-center justify-center bg-gradient-to-br from-red-50 to-green-50">
                                    <svg class="w-16 h-16 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                    </svg>
                                </div>
                            @endif
                            <div class="absolute inset-0 bg-gradient-to-t from-black/10 to-transparent"></div>
                        </div>
                        
                        <!-- Project Content -->
                        <div class="p-6">
                            <!-- Status Badge -->
                            <div class="flex items-center justify-between mb-4">
                                @if($project->status->value === 'approved')
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                        <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                        </svg>
                                        Approved
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                        <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"></path>
                                        </svg>
                                        Pending
                                    </span>
                                @endif
                            </div>

                            <!-- Project Name -->
                            <h3 class="text-2xl font-bold text-gray-900 mb-3 line-clamp-2">
                                {{ $project->name }}
                            </h3>

                            <!-- Project Description -->
                            <p class="text-gray-600 text-sm line-clamp-4 mb-4">
                                {{ $project->description }}
                            </p>

                            <!-- Links -->
                            <div class="flex gap-3 pt-4 border-t border-gray-200">
                                @if($project->github_link)
                                    <a href="{{ $project->github_link }}" target="_blank" rel="noopener noreferrer"
                                       class="flex-1 flex items-center justify-center px-4 py-2 bg-gray-900 text-white rounded-lg text-sm font-semibold hover:bg-gray-800 transition-colors">
                                        <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 24 24">
                                            <path d="M12 2C6.477 2 2 6.477 2 12c0 4.42 2.865 8.17 6.839 9.49.5.092.682-.217.682-.482 0-.237-.008-.866-.013-1.7-2.782.603-3.369-1.34-3.369-1.34-.454-1.156-1.11-1.463-1.11-1.463-.908-.62.069-.608.069-.608 1.003.07 1.531 1.03 1.531 1.03.892 1.529 2.341 1.088 2.91.832.092-.647.35-1.088.636-1.338-2.22-.253-4.555-1.11-4.555-4.943 0-1.091.39-1.984 1.029-2.683-.103-.253-.446-1.27.098-2.647 0 0 .84-.269 2.75 1.025A9.578 9.578 0 0112 6.836c.85.004 1.705.114 2.504.336 1.909-1.294 2.747-1.025 2.747-1.025.546 1.377.203 2.394.1 2.647.64.699 1.028 1.592 1.028 2.683 0 3.842-2.339 4.687-4.566 4.935.359.309.678.919.678 1.852 0 1.336-.012 2.415-.012 2.743 0 .267.18.578.688.48C19.138 20.167 22 16.418 22 12c0-5.523-4.477-10-10-10z"></path>
                                        </svg>
                                        GitHub
                                    </a>
                                @endif
                                @if($project->project_link)
                                    <a href="{{ $project->project_link }}" target="_blank" rel="noopener noreferrer"
                                       class="flex-1 flex items-center justify-center px-4 py-2 bg-red-600 text-white rounded-lg text-sm font-semibold hover:bg-red-700 transition-colors">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path>
                                        </svg>
                                        View
                                    </a>
                                @endif
                            </div>
                        </div>
                    </div>
                @empty
                    <!-- Empty State -->
                    <div class="text-center py-16 col-span-full">
                        <svg class="mx-auto h-24 w-24 text-gray-400 mb-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                        <h3 class="text-2xl font-bold text-gray-900 mb-4">No projects yet</h3>
                        <p class="text-gray-600 mb-8">
                            Start by creating your first project!
                        </p>
                    </div>
                @endforelse
            </div>

            <!-- Pagination -->
            @if($projects->hasPages())
                <div class="mt-12">
                    {{ $projects->links() }}
                </div>
            @endif
        </div>
    </section>

    <x-filament-actions::modals />
</div>
