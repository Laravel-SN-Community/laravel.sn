<x-slot:title>{{ $article->title }}</x-slot:title>

<div class="min-h-screen">

    <!-- Back Button -->
    <section class="relative py-8">
        <div class="max-w-7xl mx-auto px-8 sm:px-12 lg:px-16">
            <a wire:navigate href="{{ route('articles') }}"
               class="inline-flex items-center text-gray-600 hover:text-red-600 font-medium transition-colors group">
                <svg class="w-5 h-5 mr-2 group-hover:-translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                </svg>
                Retour au blog
            </a>
        </div>
    </section>

    <!-- Article Content -->
    <section class="py-12">
        <div class="max-w-7xl mx-auto px-8 sm:px-12 lg:px-16">
            <div class="max-w-4xl">
                {{-- @dd($article->getFirstMedia('articles')->getUrl()) --}}
                <!-- Article Cover Image -->
                @if($article->hasMedia('articles'))
                    <div class="relative mb-12 rounded-xl overflow-hidden border border-gray-200">
                        <img src="{{ $article->getFirstMediaUrl('articles') ?: asset('/images/Laravelsn.jpg') }}"
                             alt="{{ $article->title }}"
                             class="w-full h-auto max-h-[500px] object-cover">
                    </div>
                @endif

                <!-- Article Header -->
                <header class="mb-12">
                    <!-- Label -->
                    <div class="inline-flex items-center gap-2 mb-8">
                        <span class="h-px w-12 bg-red-500"></span>
                        <span class="text-sm font-medium text-red-600 uppercase tracking-wider">Article</span>
                    </div>

                    <h1 class="text-5xl md:text-6xl lg:text-7xl font-bold text-gray-900 mb-10 leading-[1.1] tracking-tight">
                        {{ $article->title }}
                    </h1>

                    <div class="flex flex-wrap items-center gap-4 text-gray-600 mb-8">
                        <div class="flex items-center">
                            <svg class="w-5 h-5 mr-2 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                            <span class="text-lg font-light">
                                Publié le {{ $article->published_at->format('d F Y') }}
                            </span>
                        </div>
                        <span class="w-1.5 h-1.5 rounded-full bg-red-600"></span>
                        <div class="flex items-center">
                            <span class="text-lg font-light text-gray-600">
                                {{ number_format($article->views_count) }} {{ __('views') }}
                            </span>
                        </div>
                    </div>
                </header>

                <!-- Article Content -->
                <article class="prose prose-lg md:prose-xl max-w-none prose-headings:text-gray-900 prose-headings:font-bold prose-headings:tracking-tight prose-p:text-gray-700 prose-p:leading-relaxed prose-p:font-light prose-a:text-red-600 prose-a:no-underline hover:prose-a:underline prose-strong:text-gray-900 prose-strong:font-semibold prose-code:bg-gray-100 prose-code:px-1 prose-code:py-0.5 prose-code:rounded prose-code:text-sm prose-blockquote:border-l-red-600 prose-blockquote:bg-gray-50 prose-blockquote:py-2 prose-blockquote:px-4 prose-blockquote:rounded-r-lg prose-ul:list-disc prose-ol:list-decimal prose-li:text-gray-700 prose-li:font-light mb-16">
                    <div class="text-gray-700 leading-relaxed">
                        {!! $article->content_html !!}
                    </div>
                </article>

                <!-- Article Footer -->
                <footer class="pt-12 border-t border-gray-200">
                    <div class="flex flex-col sm:flex-row items-start sm:items-center gap-4">
                        <span class="text-gray-600 font-light">Partager cet article :</span>
                        <div class="flex gap-4">
                            <a href="https://twitter.com/intent/tweet?text={{ urlencode($article->title) }}&url={{ urlencode(request()->url()) }}"
                               target="_blank"
                               class="flex items-center justify-center w-10 h-10 rounded-lg border border-gray-300 text-gray-600 hover:border-red-600 hover:text-red-600 transition-all duration-200">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M18.9 1.98h3.28l-7.17 8.2 8.43 11.84h-6.6l-5.17-6.78-5.91 6.78H1.47l7.67-8.8L1 1.98h6.8l4.7 6.17 6.4-6.17Z"/>
                                </svg>
                            </a>
                            <a href="https://www.linkedin.com/sharing/share-offsite/?url={{ urlencode(request()->url()) }}"
                               target="_blank"
                               class="flex items-center justify-center w-10 h-10 rounded-lg border border-gray-300 text-gray-600 hover:border-red-600 hover:text-red-600 transition-all duration-200">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/>
                                </svg>
                            </a>
                        </div>
                    </div>
                </footer>
            </div>
        </div>
    </section>
</div>

<!-- Initialize Prism.js after content is loaded -->
<script>
    function initializePrism() {
        if (typeof Prism !== 'undefined') {
            Prism.highlightAll();
        }
    }

    // Initialize on page load
    document.addEventListener('DOMContentLoaded', initializePrism);

    // Initialize after Livewire navigation
    document.addEventListener('livewire:navigated', initializePrism);

    // Also initialize after Livewire updates (fallback)
    document.addEventListener('livewire:updated', initializePrism);
</script>