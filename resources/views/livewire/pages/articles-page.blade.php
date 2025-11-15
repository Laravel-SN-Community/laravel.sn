<x-slot:title>{{ __('Articles') }}</x-slot:title>
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
                {{ __('Laravel Senegal Blog') }}
            </h1>

            <!-- Subtitle -->
            <p class="text-xl md:text-2xl text-gray-700 mb-8 text-center max-w-4xl mx-auto">
                {{ __('Discover our articles, tutorials and news from the Laravel community in Senegal') }}
                <span class="text-red-600 font-semibold">Laravel</span> au Sénégal
            </p>

            <!-- Search -->
            <div class="max-w-2xl mx-auto mb-12">
                <div class="relative">
                    <input type="text"
                           wire:model.live.debounce.300ms="search"
                           placeholder="{{ __('Search for an article...') }}"
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

    <!-- Articles Section -->
    <section id="articles" class="py-20 bg-white">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            @if($articles->count() > 0)
                <!-- Articles Grid -->
                <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
                    @foreach($articles as $article)
                        <article class="bg-white rounded-xl overflow-hidden transition-all duration-300 flex flex-col">
                            <!-- Article Cover Image -->
                            <a wire:navigate href="{{ route('article.show', $article->slug) }}" class="block">
                                <div class="relative h-64 overflow-hidden bg-gray-100 rounded-xl">
                                    <img src="{{ $article->getFirstMediaUrl('articles') ?: asset('/images/Laravelsn.jpg') }}"
                                        alt="{{ $article->title }}"
                                        class="w-full h-full object-cover transition-transform duration-300">
                                </div>
                            </a>

                            <!-- Article Content -->
                            <div class="p-6 flex flex-col gap-4 flex-1">
                                <!-- Tags -->
                                @if($article->tags->count() > 0)
                                    <div class="flex flex-wrap gap-2">
                                        @foreach($article->tags as $tag)
                                            <span class="inline-flex items-center gap-1.5 px-3 py-1 bg-gray-100 text-gray-700 text-xs font-medium rounded-full border border-gray-200">
                                                <span class="w-2 h-2 rounded-full {{ $loop->index === 0 ? 'bg-red-500' : ($loop->index === 1 ? 'bg-green-500' : 'bg-purple-500') }}"></span>
                                                {{ $tag->name }}
                                            </span>
                                        @endforeach
                                    </div>
                                @endif

                                <!-- Article Title (Clickable) -->
                                <a wire:navigate href="{{ route('article.show', $article->slug) }}" class="block">
                                    <h4 class="text-xl font-bold text-gray-900 hover:text-red-600 transition-colors line-clamp-2">
                                        {{ $article->title }}
                                    </h4>
                                </a>

                                <!-- Article Excerpt -->
                                <p class="text-gray-600 text-sm line-clamp-3 flex-1">
                                    {{ $article->excerpt }}
                                </p>

                                <!-- Article Actions -->
                                <div class="flex items-center justify-between pt-4 border-t border-gray-100">
                                    <div class="flex flex-col gap-2">
                                        <div class="flex items-center text-gray-500 text-xs">
                                            <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                            </svg>
                                            <span class="text-gray-900 text-lg font-semibold">{{ $article->published_at->format('d M Y') }}</span>
                                        </div>
                                        <div class="flex items-center text-gray-500 text-xs">
                                            <span class="text-gray-700 font-medium">{{ number_format($article->views_count) }} {{ __('views') }}</span>
                                        </div>
                                    </div>
                                    <a wire:navigate href="{{ route('article.show', $article->slug) }}"
                                       class="inline-flex items-center gap-1 text-red-600 text-sm font-semibold hover:text-red-700 transition-colors group">
                                        {{ __('Read more') }}
                                        <svg class="w-4 h-4 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                        </svg>
                                    </a>
                                </div>
                            </div>
                        </article>
                    @endforeach
                </div>

                <!-- Pagination -->
                @if($articles->hasPages())
                    <div class="mt-12">
                        {{ $articles->links() }}
                    </div>
                @endif
            @else
                <!-- Empty State -->
                <div class="text-center py-16">
                    <svg class="mx-auto h-24 w-24 text-gray-400 mb-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                    </svg>
                    <h3 class="text-2xl font-bold text-gray-900 mb-4">{{ __('No article found') }}</h3>
                    <p class="text-gray-600 mb-8">
                        @if($search)
                            {{ __('No article found for your search') }} "{{ $search }}".
                        @else
                            {{ __('No article is currently available') }}.
                        @endif
                    </p>
                    @if($search)
                        <button wire:click="$set('search', '')"
                                class="bg-red-600 text-white px-6 py-3 rounded-lg font-semibold hover:bg-red-700 transition-colors">
                            {{ __('View all articles') }}
                        </button>
                    @endif
                </div>
            @endif
        </div>
    </section>

</div>
