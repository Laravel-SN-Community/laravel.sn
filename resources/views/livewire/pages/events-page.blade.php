<x-slot:title>{{ __('Events') }}</x-slot:title>
<div class="min-h-screen">

    <!-- Hero Section -->
    <section class="relative py-20">
        <div class="max-w-7xl mx-auto px-8 sm:px-12 lg:px-16">
            <div class="max-w-4xl">
                <!-- Label -->
                <div class="inline-flex items-center gap-2 mb-8">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-5 w-5 text-red-500">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M17.25 6.75 22.5 12l-5.25 5.25m-10.5 0L1.5 12l5.25-5.25m7.5-3-4.5 16.5" />
                    </svg>                      
                    <span class="text-sm font-medium text-red-600 uppercase tracking-wider">{{ __('Events') }}</span>
                </div>

                <!-- Main Title -->
                <h1 class="text-5xl md:text-6xl lg:text-7xl font-bold text-gray-900 mb-10 leading-[1.1] tracking-tight">
                    {{ __('Laravel Senegal Events') }}
                </h1>

                <!-- Subtitle -->
                <p class="text-xl md:text-2xl text-gray-600 mb-16 leading-relaxed font-light max-w-2xl">
                    {{ __('Discover our upcoming meetups, workshops and events from the Laravel community in Senegal') }}
                    <span class="text-red-600 font-normal">Laravel</span> au Sénégal
                </p>

                <!-- Search and Filter -->
                <div class="flex flex-col sm:flex-row gap-4 mb-12">
                    <!-- Search -->
                    <div class="flex-1">
                        <div class="relative">
                            <input type="text"
                                   wire:model.live.debounce.300ms="search"
                                   placeholder="{{ __('Search for an event...') }}"
                                   class="w-full px-4 py-3 pl-10 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-transparent">
                            <svg class="absolute left-3 top-3.5 h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                        </div>
                    </div>

                    <!-- Filter -->
                    <div class="sm:w-48">
                        <select wire:model.live="filter"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-transparent">
                            <option value="all">{{ __('All events') }}</option>
                            <option value="upcoming">{{ __('Upcoming events') }}</option>
                            <option value="past">{{ __('Past events') }}</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Events Section -->
    <section id="events" class="py-20">
        <div class="max-w-7xl mx-auto px-8 sm:px-12 lg:px-16">
            @if($events->count() > 0)
                <!-- Events Grid -->
                <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
                    @foreach($events as $event)
                        <div class="bg-white rounded-xl border border-gray-200 overflow-hidden hover:border-red-300 transition-all duration-200 group">
                            <!-- Event Header -->
                            <div class="p-6 pb-4">
                                <div class="flex items-start justify-between mb-4">
                                    <div class="flex-1">
                                        <a wire:navigate href="{{ route('event.show', $event) }}">
                                            <h3 class="text-xl font-bold text-gray-900 mb-3 line-clamp-2 group-hover:text-red-600 transition-colors">
                                                {{ $event->name }}
                                            </h3>
                                        </a>
                                        <div class="flex items-center text-gray-600 mb-2">
                                            <svg class="w-5 h-5 mr-2 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                            </svg>
                                            <span class="text-sm font-medium">
                                                {{ $event->date->format('d/m/Y à H:i') }}
                                            </span>
                                        </div>
                                        <div class="flex items-center text-gray-600 mb-3">
                                            <svg class="w-5 h-5 mr-2 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                            </svg>
                                            <span class="text-sm">{{ $event->place }}</span>
                                        </div>
                                    </div>
                                </div>

                                <!-- Event Description -->
                                <p class="text-gray-600 text-sm line-clamp-3 mb-4 font-light leading-relaxed">
                                    {{ $event->description }}
                                </p>
                            </div>

                            <!-- Event Actions -->
                            <div class="px-6 pb-6">
                                <a wire:navigate href="{{ route('event.show', $event) }}"
                                   class="inline-flex items-center justify-center w-full bg-red-600 text-white px-4 py-3 rounded-xl text-sm font-semibold hover:bg-red-700 transition-all duration-200 group/btn">
                                    {{ __('View details') }}
                                    <svg class="w-4 h-4 ml-2 group-hover/btn:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                                    </svg>
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Pagination -->
                @if($events->hasPages())
                    <div class="mt-12">
                        {{ $events->links() }}
                    </div>
                @endif
            @else
                <!-- Empty State -->
                <div class="text-center py-16 max-w-2xl mx-auto">
                    <svg class="mx-auto h-20 w-20 text-gray-300 mb-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                    </svg>
                    <h3 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4 leading-tight tracking-tight">{{ __('No event found') }}</h3>
                    <p class="text-lg md:text-xl text-gray-600 mb-10 font-light leading-relaxed">
                        @if($search)
                            {{ __('No event found for your search') }} "{{ $search }}".
                        @else
                            {{ __('No event is currently scheduled') }}.
                        @endif
                    </p>
                    @if($search)
                        <button wire:click="$set('search', '')"
                                class="inline-flex items-center justify-center bg-red-600 text-white px-8 py-4 rounded-xl font-semibold hover:bg-red-700 transition-all duration-200">
                            {{ __('View all events') }}
                        </button>
                    @endif
                </div>
            @endif
        </div>
    </section>

</div>
