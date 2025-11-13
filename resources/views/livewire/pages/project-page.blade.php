<x-slot:title>{{ __('Projects') }}</x-slot:title>
<div class="min-h-screen bg-gradient-to-br from-red-50 via-white to-green-50">

    <!-- Hero Section -->
    <section class="relative py-20 bg-white overflow-hidden">
        <!-- Gradient Overlay from Top to White -->
        <div class="absolute inset-0 z-0 pointer-events-none">
            <div class="absolute inset-0"
                style="background: linear-gradient(to bottom, #f3f4f6 0%, #ffffff 100%);">
            </div>
            <!-- Grid Background -->
            <div class="absolute inset-0 opacity-20">
                <div class="absolute inset-0"
                    style="background-image:
                    linear-gradient(to right, #9ca3af 1px, transparent 1px),
                    linear-gradient(to bottom, #9ca3af 1px, transparent 1px);
                    background-size: 20px 20px;">
                </div>
            </div>
        </div>

        <div class="relative z-10 max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Main Title -->
            <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold text-gray-900 mb-6 text-center">
                {{ __('Laravel Senegal Projects') }}
            </h1>

            <!-- Subtitle -->
            <p class="text-xl md:text-2xl text-gray-700 mb-8 text-center max-w-4xl mx-auto">
                {{ __('Discover the projects from the Laravel community in Senegal') }}
                <span class="text-red-600 font-semibold">Laravel</span> au Sénégal
            </p>

            <!-- Search -->
            <div class="max-w-2xl mx-auto mb-12">
                <div class="relative">
                    <input type="text"
                           wire:model.live.debounce.300ms="search"
                           placeholder="{{ __('Search for a project...') }}"
                           class="w-full px-4 py-3 pl-10 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-transparent">
                    <svg class="absolute left-3 top-3.5 h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                </div>
            </div>
        </div>

        <!-- Fade Effect Bottom -->
        <div class="absolute bottom-0 left-0 w-full h-24 bg-gradient-to-b from-transparent to-white pointer-events-none z-20"></div>
    </section>

    <!-- Projects Section -->
    <section id="projects" class="py-10 bg-white">
        <!-- Button to share your project -->
        <div class="flex justify-end max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 mb-6">
            <a wire:navigate href="{{ route('projects.index') }}" class="bg-red-600 text-white px-6 py-3 rounded-lg font-semibold hover:bg-red-700 transition-colors">
                {{__('Share your project')}}
            </a>
        </div>
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            @if($projects->count() > 0)
                <!-- Projects List -->
                <div class="flex flex-col gap-4">
                    @foreach($projects as $project)
                        <div class="bg-white rounded-xl border py-2 px-4 hover:border-red-600 transition-colors">
                            <div class="flex gap-6">
                                <!-- Left Side: Project Info -->
                                <div class="flex-1 min-w-0">
                                    <!-- 1. Project Name -->
                                    <h3 class="text-lg font-semibold text-red-600 mb-3">
                                        {{ $project->name }}
                                    </h3>

                                    <!-- 2. Project Description -->
                                    <p class="text-sm mb-4">
                                        {{ $project->description }}
                                    </p>

                                    <!-- 4. Project Technologies -->
                                    @if($project->tags->isNotEmpty())
                                        <div class="flex flex-wrap items-center gap-2 mb-4">
                                            @foreach($project->tags as $tag)
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-red-600">
                                                    {{ $tag->name }}
                                                </span>
                                            @endforeach
                                        </div>
                                    @endif

                                    <!-- 5. GitHub and Project Links (as icons) -->
                                    <div class="flex items-center gap-4 mb-4">
                                        @if($project->github_link)
                                            <a href="{{ $project->github_link }}" target="_blank" rel="noopener noreferrer"
                                               class="text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-200 transition-colors">
                                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                                    <path d="M12 0C5.37 0 0 5.37 0 12c0 5.3 3.44 9.8 8.2 11.39.6.11.79-.26.79-.58v-2.23c-3.34.72-4.03-1.42-4.03-1.42-.55-1.39-1.34-1.76-1.34-1.76-1.09-.75.08-.73.08-.73 1.2.08 1.84 1.24 1.84 1.24 1.07 1.83 2.81 1.3 3.49.99.11-.78.42-1.3.76-1.6-2.67-.31-5.47-1.34-5.47-5.93 0-1.31.47-2.38 1.24-3.22-.12-.3-.53-1.52.12-3.18 0 0 1.01-.32 3.3 1.23.96-.27 1.98-.4 3-.4s2.04.13 3 .4c2.29-1.55 3.3-1.23 3.3-1.23.65 1.66.24 2.88.12 3.18.77.84 1.24 1.91 1.24 3.22 0 4.61-2.81 5.62-5.48 5.92.43.37.82 1.1.82 2.22v3.29c0 .32.19.69.8.58C20.56 21.8 24 17.3 24 12 24 5.37 18.63 0 12 0Z"/>
                                                </svg>
                                            </a>
                                        @endif
                                        
                                        @if($project->project_link)
                                            <a href="{{ $project->project_link }}" target="_blank" rel="noopener noreferrer"
                                               class="text-gray-500 hover:text-red-600 transition-colors">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M13.19 8.688a4.5 4.5 0 0 1 1.242 7.244l-4.5 4.5a4.5 4.5 0 0 1-6.364-6.364l1.757-1.757m13.35-.622 1.757-1.757a4.5 4.5 0 0 0-6.364-6.364l-4.5 4.5a4.5 4.5 0 0 0 1.242 7.244" />
                                                </svg>
                                            </a>
                                        @endif
                                    </div>

                                    <!-- 6. Project User Name -->
                                    <div class="flex items-center text-sm">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 mr-1">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M17.982 18.725A7.488 7.488 0 0 0 12 15.75a7.488 7.488 0 0 0-5.982 2.975m11.963 0a9 9 0 1 0-11.963 0m11.963 0A8.966 8.966 0 0 1 12 21a8.966 8.966 0 0 1-5.982-2.275M15 9.75a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                                        </svg>
                                        <span>{{ $project->user->name }}</span>
                                    </div>
                                </div>

                                <!-- Right Side: Fire Button with Vote Count -->
                                <div class="flex items-center gap-2 md:flex-shrink-0">
                                    <button wire:click="toggleVote({{ $project->id }})" 
                                            type="button"
                                            class="flex items-center gap-2 border px-4 py-2 rounded-lg font-semibold transition-colors {{ auth()->user()?->hasVotedFor($project) ? 'border-red-600 text-red-600' : 'border-gray-300 hover:border-red-600 hover:text-red-600' }}">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.362 5.214A8.252 8.252 0 0 1 12 21 8.25 8.25 0 0 1 6.038 7.047 8.287 8.287 0 0 0 9 9.601a8.983 8.983 0 0 1 3.361-6.867 8.21 8.21 0 0 0 3 2.48Z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 18a3.75 3.75 0 0 0 .495-7.468 5.99 5.99 0 0 0-1.925 3.547 5.975 5.975 0 0 1-2.133-1.001A3.75 3.75 0 0 0 12 18Z" />
                                        </svg>                                          
                                        <span class="text-sm font-semibold">{{ $project->votes_count }}</span>
                                    </button>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Pagination -->
                @if($projects->hasPages())
                    <div class="mt-12">
                        {{ $projects->links() }}
                    </div>
                @endif
            @else
                <!-- Empty State -->
                <div class="text-center py-16">
                    <svg class="mx-auto h-24 w-24 text-gray-400 mb-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    <h3 class="text-2xl font-bold text-gray-900 mb-4">{{ __('No project found') }}</h3>
                    <p class="mb-6">
                        @if($search)
                            {{ __('No project found for your search') }} "{{ $search }}".
                        @else
                            {{ __('No project is currently available') }}.
                        @endif
                    </p>
                    @if($search)
                        <button wire:click="$set('search', '')"
                                class="bg-red-600 text-white px-6 py-3 rounded-lg font-semibold hover:bg-red-700 transition-colors">
                            {{ __('View all projects') }}
                        </button>
                    @endif
                </div>
            @endif
        </div>
    </section>

</div>

