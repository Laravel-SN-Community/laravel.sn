<x-slot:title>{{ __('RSS Feeds') }}</x-slot:title>
<div class="min-h-screen">

    <!-- Hero Section -->
    <section class="relative py-20">
        <div class="max-w-7xl mx-auto px-8 sm:px-12 lg:px-16">
            <div class="max-w-4xl">
                <!-- Label -->
                <div class="inline-flex items-center gap-2 mb-8">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-5 w-5 text-orange-500">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12.75 19.5v-.75a7.5 7.5 0 0 0-7.5-7.5H4.5m0-6.75h.75c7.87 0 14.25 6.38 14.25 14.25v.75M6 18.75a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0Z" />
                    </svg>
                    <span class="text-sm font-medium text-orange-600 uppercase tracking-wider">{{ __('RSS Feeds') }}</span>
                </div>

                <!-- Main Title -->
                <h1 class="text-5xl md:text-6xl lg:text-7xl font-bold text-gray-900 mb-10 leading-[1.1] tracking-tight">
                    {{ __('Laravel News Aggregator') }}
                </h1>

                <!-- Subtitle -->
                <p class="text-xl md:text-2xl text-gray-600 mb-16 leading-relaxed font-light max-w-2xl">
                    {{ __('Stay updated with the latest news from the') }}
                    <span class="text-orange-600 font-normal">Laravel</span> {{ __('ecosystem') }}
                </p>

                <!-- Filters -->
                <div class="flex flex-col sm:flex-row gap-4 mb-8">
                    <!-- Search -->
                    <div class="relative flex-1">
                        <input type="text"
                               wire:model.live.debounce.300ms="search"
                               placeholder="{{ __('Search feeds...') }}"
                               class="w-full px-4 py-3 pl-10 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-transparent">
                        <svg class="absolute left-3 top-3.5 h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                    </div>

                    <!-- Source Filter -->
                    @if($sources->count() > 1)
                        <div class="sm:w-64">
                            <select wire:model.live="selectedSourceId"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-transparent">
                                <option value="">{{ __('All sources') }}</option>
                                @foreach($sources as $sourceId => $sourceName)
                                    <option value="{{ $sourceId }}">{{ $sourceName }}</option>
                                @endforeach
                            </select>
                        </div>
                    @endif

                    <!-- Clear Filters -->
                    @if($search || $selectedSourceId)
                        <button wire:click="clearFilters"
                                class="px-4 py-3 text-gray-600 hover:text-gray-900 border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors">
                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    @endif
                </div>
            </div>
        </div>
    </section>

    <!-- Feeds Section -->
    <section id="feeds" class="py-20">
        <div class="max-w-7xl mx-auto px-8 sm:px-12 lg:px-16">
            @if($feedItems->count() > 0)
                <!-- Feed Items Grid -->
                <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($feedItems as $item)
                        <article wire:key="feed-{{ $loop->index }}" class="bg-white rounded-xl border border-gray-200 overflow-hidden hover:border-orange-300 hover:shadow-lg transition-all duration-200 flex flex-col group">
                            <div class="p-6 flex flex-col gap-4 flex-1">
                                <!-- Source Badge -->
                                <div class="flex items-center gap-2">
                                    <span class="inline-flex items-center gap-1.5 px-3 py-1 bg-orange-50 text-orange-700 text-xs font-medium rounded-full border border-orange-200">
                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12.75 19.5v-.75a7.5 7.5 0 0 0-7.5-7.5H4.5m0-6.75h.75c7.87 0 14.25 6.38 14.25 14.25v.75M6 18.75a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0Z"></path>
                                        </svg>
                                        {{ $item['source_name'] }}
                                    </span>
                                </div>

                                <!-- Title -->
                                <a href="{{ $item['link'] }}" target="_blank" rel="noopener noreferrer" class="block">
                                    <h4 class="text-lg font-bold text-gray-900 group-hover:text-orange-600 transition-colors line-clamp-2">
                                        {{ $item['title'] }}
                                    </h4>
                                </a>

                                <!-- Description -->
                                <p class="text-gray-600 text-sm line-clamp-3 flex-1 font-light leading-relaxed">
                                    {{ $item['description'] }}
                                </p>

                                <!-- Footer -->
                                <div class="flex items-center justify-between pt-4 border-t border-gray-100">
                                    <div class="flex items-center text-gray-500 text-xs">
                                        <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                        @if($item['published_at'])
                                            <span class="text-gray-900 font-medium">{{ $item['published_at']->diffForHumans() }}</span>
                                        @else
                                            <span class="text-gray-500">{{ __('Unknown date') }}</span>
                                        @endif
                                    </div>
                                    <a href="{{ $item['link'] }}" target="_blank" rel="noopener noreferrer"
                                       class="inline-flex items-center gap-1 text-orange-600 text-sm font-semibold hover:text-orange-700 transition-colors group/link">
                                        {{ __('Read') }}
                                        <svg class="w-4 h-4 group-hover/link:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path>
                                        </svg>
                                    </a>
                                </div>
                            </div>
                        </article>
                    @endforeach
                </div>
            @else
                <!-- Empty State -->
                <div class="text-center py-16 max-w-2xl mx-auto">
                    <svg class="mx-auto h-20 w-20 text-gray-300 mb-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M12.75 19.5v-.75a7.5 7.5 0 0 0-7.5-7.5H4.5m0-6.75h.75c7.87 0 14.25 6.38 14.25 14.25v.75M6 18.75a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0Z"></path>
                    </svg>
                    <h3 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4 leading-tight tracking-tight">{{ __('No feeds available') }}</h3>
                    <p class="text-lg md:text-xl text-gray-600 mb-10 font-light leading-relaxed">
                        @if($search || $selectedSourceId)
                            {{ __('No feed items match your current filters.') }}
                        @else
                            {{ __('No RSS sources have been configured yet, or no feeds are currently available.') }}
                        @endif
                    </p>
                    @if($search || $selectedSourceId)
                        <button wire:click="clearFilters"
                                class="inline-flex items-center justify-center bg-orange-600 text-white px-8 py-4 rounded-xl font-semibold hover:bg-orange-700 transition-all duration-200">
                            {{ __('Clear filters') }}
                        </button>
                    @endif
                </div>
            @endif
        </div>
    </section>

    <!-- Loading indicator -->
    <div wire:loading.flex class="fixed inset-0 bg-white/50 z-50 items-center justify-center">
        <div class="animate-spin rounded-full h-12 w-12 border-b-2 border-orange-600"></div>
    </div>

</div>




