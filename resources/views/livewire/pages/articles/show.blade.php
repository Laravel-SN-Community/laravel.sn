<x-slot:title>{{ $article->title }}</x-slot:title>

<div class="min-h-screen bg-gradient-to-br from-red-50 via-white to-green-50">

    <!-- Back Button -->
    <section class="relative py-8 bg-white">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <a wire:navigate href="{{ route('articles') }}"
               class="inline-flex items-center text-red-600 hover:text-red-700 font-medium transition-colors">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                </svg>
                Retour au blog
            </a>
        </div>

    <!-- Article Content -->
    <section class="py-12 bg-white">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            {{-- @dd($article->getFirstMedia('articles')->getUrl()) --}}
            <!-- Article Cover Image -->
            @if($article->hasMedia('articles'))
                <div class="relative mb-8 rounded-xl overflow-hidden shadow-lg">
                    <img src="{{ $article->getFirstMediaUrl('articles') ?: asset('/images/Laravelsn.jpg') }}"
                         alt="{{ $article->title }}"
                         class="w-full h-auto max-h-[500px] object-cover">
                </div>
            @endif

            <!-- Article Header -->
            <header class="mb-8">
                <h1 class="text-4xl md:text-5xl font-bold text-gray-900 mb-4 leading-tight">
                    {{ $article->title }}
                </h1>

                <div class="flex items-center text-gray-600 mb-6">
                    <svg class="w-5 h-5 mr-2 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                    </svg>
                    <span class="text-lg">
                        Publié le {{ $article->published_at->format('d F Y') }}
                    </span>
                </div>

                <!-- Divider -->
                <div class="w-24 h-1 bg-red-600 rounded-full"></div>
            </header>

            <!-- Article Content -->
            <article class="prose prose-lg max-w-none prose-headings:text-gray-900 prose-headings:font-bold prose-p:text-gray-800 prose-p:leading-relaxed prose-a:text-red-600 prose-a:no-underline hover:prose-a:underline prose-strong:text-gray-900 prose-code:bg-gray-100 prose-code:px-1 prose-code:py-0.5 prose-code:rounded prose-code:text-sm prose-blockquote:border-l-red-600 prose-blockquote:bg-gray-50 prose-blockquote:py-2 prose-blockquote:px-4 prose-blockquote:rounded-r-lg prose-ul:list-disc prose-ol:list-decimal prose-li:text-gray-800">
                <div class="text-gray-800 leading-relaxed">
                    {!! $article->content_html !!}
                </div>
            </article>

            <!-- Article Footer -->
            <footer class="mt-12 pt-8 border-t border-gray-200">
                <div class="flex items-center justify-between">
                    <div class="flex items-center space-x-4">
                        <span class="text-gray-600">Partager cet article :</span>
                        <div class="flex space-x-3">
                            <a href="https://twitter.com/intent/tweet?text={{ urlencode($article->title) }}&url={{ urlencode(request()->url()) }}"
                               target="_blank"
                               class="text-gray-400 hover:text-red-600 transition-colors">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M18.9 1.98h3.28l-7.17 8.2 8.43 11.84h-6.6l-5.17-6.78-5.91 6.78H1.47l7.67-8.8L1 1.98h6.8l4.7 6.17 6.4-6.17Z"/>
                                </svg>
                            </a>
                            <a href="https://www.linkedin.com/sharing/share-offsite/?url={{ urlencode(request()->url()) }}"
                               target="_blank"
                               class="text-gray-400 hover:text-red-600 transition-colors">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/>
                                </svg>
                            </a>
                        </div>
                    </div>

                </div>
            </footer>
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