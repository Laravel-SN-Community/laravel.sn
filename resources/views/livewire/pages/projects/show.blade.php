<x-slot:title>{{ $project->name }} - {{ __('Projects') }}</x-slot:title>

<div class="bg-gradient-to-br from-red-50 via-white to-green-50 min-h-screen py-8 ">
    <!-- Back Navigation -->
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 mb-8">
            <a wire:navigate href="{{ route('projects') }}"
               class="inline-flex items-center text-red-600 hover:text-red-700 font-medium transition-colors">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                </svg>
                Retour au Projets
            </a>
        </div>

    <!-- Project Detail Section -->
    <section class="">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white rounded-2xl shadow-lg overflow-hidden">
                <!-- Project Header -->
                <div class="relative">
                    <!-- Project Image -->
                    <div class="h-96 w-full overflow-hidden bg-gray-100">
                        <img src="{{ $project->getFirstMediaUrl('projects') ?: asset('/images/Laravelsn.jpg') }}"
                             alt="{{ $project->name }}"
                             class="w-full h-full object-cover">
                    </div>

                    <!-- Status Badge -->
{{--                    <div class="absolute top-4 right-4">--}}
{{--                        @if($project->status === \App\Enums\ProjectStatus::Approved)--}}
{{--                            <span class="bg-green-100 text-green-500 font-semibold px-4 py-2 rounded-full text-sm shadow-lg">--}}
{{--                                {{ __('Approved') }}--}}
{{--                            </span>--}}
{{--                        @else--}}
{{--                            <span class="bg-yellow-100 text-yellow-500 font-semibold px-4 py-2 rounded-full text-sm shadow-lg">--}}
{{--                                {{ __('Pending') }}--}}
{{--                            </span>--}}
{{--                        @endif--}}
{{--                    </div>--}}
                </div>

                <!-- Project Content -->
                <div class="p-8">
                    <!-- Project Title and Vote -->
                    <div class="flex flex-col md:flex-row md:items-start md:justify-between gap-6 mb-6">
                        <div class="flex-1">
                            <h1 class="text-3xl md:text-4xl font-bold text-gray-900 mb-2">
                                {{ $project->name }}
                            </h1>

                            <!-- Author Info -->
                            <div class="flex items-center gap-4 text-gray-600 mb-4">
                                <div class="flex items-center gap-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M17.982 18.725A7.488 7.488 0 0 0 12 15.75a7.488 7.488 0 0 0-5.982 2.975m11.963 0a9 9 0 1 0-11.963 0m11.963 0A8.966 8.966 0 0 1 12 21a8.966 8.966 0 0 1-5.982-2.275M15 9.75a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                                    </svg>
                                    <span class="font-medium">{{ $project->user->name }}</span>
                                </div>
                                <span class="text-gray-400">•</span>
                                <span>{{ $project->created_at->diffForHumans() }}</span>
                            </div>
                        </div>

                        <!-- Vote Button -->
                        <div class="flex-shrink-0">
                            <div class="flex items-center gap-2 md:flex-shrink-0">
                                <button wire:click="toggleVote({{ $project->id }})"
                                        type="button"
                                        class="flex items-center gap-2 border px-4 py-2 rounded-lg font-semibold transition-colors {{ auth()->user()?->hasVotedFor($project) ? 'border-red-600 text-red-600' : 'border-gray-300 hover:border-red-600 hover:text-red-600' }}">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.362 5.214A8.252 8.252 0 0 1 12 21 8.25 8.25 0 0 1 6.038 7.047 8.287 8.287 0 0 0 9 9.601a8.983 8.983 0 0 1 3.361-6.867 8.21 8.21 0 0 0 3 2.48Z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 18a3.75 3.75 0 0 0 .495-7.468 5.99 5.99 0 0 0-1.925 3.547 5.975 5.975 0 0 1-2.133-1.001A3.75 3.75 0 0 0 12 18Z" />
                                    </svg>
                                    <span class="text-sm font-semibold">{{ $project->votesCount() }}</span>
                                    <span>{{ auth()->user()?->hasVotedFor($project) ? __('Voted') : __('Vote') }}</span>
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Tags -->
                    @if($project->tags->isNotEmpty())
                        <div class="flex flex-wrap gap-2 mb-6">
                            @foreach($project->tags as $tag)
                                <span class="inline-flex items-center px-3 py-1.5 rounded-full text-sm font-medium bg-gray-100 text-red-600">
                                    {{ $tag->name }}
                                </span>
                            @endforeach
                        </div>
                    @endif

                    <!-- Description -->
                    <div class="prose prose-lg max-w-none mb-8">
                        <h2 class="text-2xl font-bold text-gray-900">{{ __('Description') }}</h2>
                        <div class="text-gray-700">
                            {!! str($project->description)->markdown() !!}
                        </div>
                    </div>

                    <!-- Links Section -->
                    <div class="border-t pt-6">
                        <h2 class="text-2xl font-bold text-gray-900 mb-4">{{ __('Links') }}</h2>
                        <div class="flex flex-col sm:flex-row gap-4">
                            @if($project->github_link)
                                <a href="{{ $project->github_link }}"
                                   target="_blank"
                                   rel="noopener noreferrer"
                                   class="flex items-center gap-2 p-2 bg-gray-900 text-white rounded-lg hover:bg-gray-800 transition-colors font-medium">
                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M12 0C5.37 0 0 5.37 0 12c0 5.3 3.44 9.8 8.2 11.39.6.11.79-.26.79-.58v-2.23c-3.34.72-4.03-1.42-4.03-1.42-.55-1.39-1.34-1.76-1.34-1.76-1.09-.75.08-.73.08-.73 1.2.08 1.84 1.24 1.84 1.24 1.07 1.83 2.81 1.3 3.49.99.11-.78.42-1.3.76-1.6-2.67-.31-5.47-1.34-5.47-5.93 0-1.31.47-2.38 1.24-3.22-.12-.3-.53-1.52.12-3.18 0 0 1.01-.32 3.3 1.23.96-.27 1.98-.4 3-.4s2.04.13 3 .4c2.29-1.55 3.3-1.23 3.3-1.23.65 1.66.24 2.88.12 3.18.77.84 1.24 1.91 1.24 3.22 0 4.61-2.81 5.62-5.48 5.92.43.37.82 1.1.82 2.22v3.29c0 .32.19.69.8.58C20.56 21.8 24 17.3 24 12 24 5.37 18.63 0 12 0Z"/>
                                    </svg>
                                    {{ __('View on GitHub') }}
                                </a>
                            @endif

                            @if($project->project_link)
                                <a href="{{ $project->project_link }}"
                                   target="_blank"
                                   rel="noopener noreferrer"
                                   class="flex items-center gap-2 p-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-colors font-medium">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M13.19 8.688a4.5 4.5 0 0 1 1.242 7.244l-4.5 4.5a4.5 4.5 0 0 1-6.364-6.364l1.757-1.757m13.35-.622 1.757-1.757a4.5 4.5 0 0 0-6.364-6.364l-4.5 4.5a4.5 4.5 0 0 0 1.242 7.244" />
                                    </svg>
                                    {{ __('Visit Project') }}
                                </a>
                            @endif
                        </div>
                    </div>

                    <!-- Categories -->
                    @if($project->categories->isNotEmpty())
                        <div class="border-t pt-6 mt-6">
                            <h2 class="text-2xl font-bold text-gray-900 mb-4">{{ __('Categories') }}</h2>
                            <div class="flex flex-wrap gap-3">
                                @foreach($project->categories as $category)
                                    <span class="inline-flex items-center px-4 py-2 bg-red-50 text-red-600 rounded-lg font-medium">
                                        {{ $category->name }}
                                    </span>
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Back Button -->
            <div class="mt-8">
                <a wire:navigate href="{{ route('projects') }}"
                   class="inline-flex items-center gap-2 text-gray-600 hover:text-red-600 transition-colors font-medium">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5 3 12m0 0 7.5-7.5M3 12h18" />
                    </svg>
                    {{ __('Back to Projects') }}
                </a>
            </div>
        </div>
    </section>
</div>
