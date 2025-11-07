<div class="space-y-8">
    {{-- Welcome Hero Section --}}
    <div class="relative overflow-hidden rounded-2xl bg-gradient-to-br from-red-600 via-red-700 to-red-800 px-8 py-12 shadow-xl">
        <div class="relative z-10">
            <h1 class="text-4xl font-bold text-white mb-4">
                {{ __('Welcome back, :name! 🎉', ['name' => auth()->user()->name]) }}
            </h1>
            <p class="text-xl text-blue-100 max-w-2xl">
                {{ __('Thank you for joining Laravel Sénégal! We\'re thrilled to have you as part of our growing community of passionate developers and tech enthusiasts.') }}
            </p>
        </div>
        {{-- Decorative Elements --}}
        <div class="absolute top-0 right-0 -mt-4 -mr-4 h-32 w-32 rounded-full bg-blue-500 opacity-20 blur-3xl"></div>
        <div class="absolute bottom-0 left-0 -mb-8 -ml-8 h-40 w-40 rounded-full bg-indigo-500 opacity-20 blur-3xl"></div>
    </div>

    {{-- Join Our Community Section --}}
<div>
        <div class="mb-6">
            <h2 class="text-2xl font-bold text-gray-900">
                {{ __('Connect With Us') }}
            </h2>
            <p class="mt-2 text-gray-600">
                {{ __('Join our vibrant community across different platforms. Stay updated, share knowledge, and grow together!') }}
            </p>
        </div>

        {{-- Platform Cards --}}
        <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-2">
            {{-- WhatsApp Community --}}
            <a href="https://chat.whatsapp.com/JwITxALLv0uJIGNu7AsVnx" target="_blank" class="group relative overflow-hidden rounded-xl bg-white p-6 shadow-md ring-1 ring-gray-200 transition-all duration-300 hover:shadow-xl hover:ring-green-500 hover:-translate-y-1">
                <div class="flex items-start gap-4">
                    <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-lg bg-green-100 text-green-600 transition-colors group-hover:bg-green-600 group-hover:text-white">
                        <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413Z"/>
                        </svg>
                    </div>
                    <div class="flex-1">
                        <h3 class="font-semibold text-gray-900 mb-1">{{ __('WhatsApp Community') }}</h3>
                        <p class="text-sm text-gray-600">{{ __('Join our WhatsApp community to chat in real-time and network with fellow developers.') }}</p>
                    </div>
                </div>
                <div class="mt-4">
                    <span class="text-sm font-medium text-green-600 group-hover:text-green-700">
                        {{ __('Join Community') }} →
                    </span>
                </div>
            </a>

            {{-- Twitter/X --}}
            <a href="https://x.com/laravel_sn" target="_blank" class="group relative overflow-hidden rounded-xl bg-white p-6 shadow-md ring-1 ring-gray-200 transition-all duration-300 hover:shadow-xl hover:ring-gray-900 hover:-translate-y-1">
                <div class="flex items-start gap-4">
                    <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-lg bg-gray-100 text-gray-900 transition-colors group-hover:bg-gray-900 group-hover:text-white">
                        <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/>
                        </svg>
                    </div>
                    <div class="flex-1">
                        <h3 class="font-semibold text-gray-900 mb-1">{{ __('Follow on X') }}</h3>
                        <p class="text-sm text-gray-600">{{ __('Stay updated with the latest news, events, and Laravel tips.') }}</p>
                    </div>
                </div>
                <div class="mt-4">
                    <span class="text-sm font-medium text-gray-900 group-hover:text-gray-950">
                        {{ __('Follow Us') }} →
                    </span>
                </div>
            </a>

            {{-- GitHub --}}
            <a href="https://github.com/Laravel-SN-Community/laravel.sn" target="_blank" class="group relative overflow-hidden rounded-xl bg-white p-6 shadow-md ring-1 ring-gray-200 transition-all duration-300 hover:shadow-xl hover:ring-gray-800 hover:-translate-y-1">
                <div class="flex items-start gap-4">
                    <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-lg bg-gray-100 text-gray-800 transition-colors group-hover:bg-gray-800 group-hover:text-white">
                        <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 0c-6.626 0-12 5.373-12 12 0 5.302 3.438 9.8 8.207 11.387.599.111.793-.261.793-.577v-2.234c-3.338.726-4.033-1.416-4.033-1.416-.546-1.387-1.333-1.756-1.333-1.756-1.089-.745.083-.729.083-.729 1.205.084 1.839 1.237 1.839 1.237 1.07 1.834 2.807 1.304 3.492.997.107-.775.418-1.305.762-1.604-2.665-.305-5.467-1.334-5.467-5.931 0-1.311.469-2.381 1.236-3.221-.124-.303-.535-1.524.117-3.176 0 0 1.008-.322 3.301 1.23.957-.266 1.983-.399 3.003-.404 1.02.005 2.047.138 3.006.404 2.291-1.552 3.297-1.23 3.297-1.23.653 1.653.242 2.874.118 3.176.77.84 1.235 1.911 1.235 3.221 0 4.609-2.807 5.624-5.479 5.921.43.372.823 1.102.823 2.222v3.293c0 .319.192.694.801.576 4.765-1.589 8.199-6.086 8.199-11.386 0-6.627-5.373-12-12-12z"/>
                        </svg>
                    </div>
                    <div class="flex-1">
                        <h3 class="font-semibold text-gray-900 mb-1">{{ __('GitHub Repository') }}</h3>
                        <p class="text-sm text-gray-600">{{ __('Contribute to open-source projects and collaborate on code.') }}</p>
                    </div>
                </div>
                <div class="mt-4">
                    <span class="text-sm font-medium text-gray-800 group-hover:text-gray-900">
                        {{ __('View Repository') }} →
                    </span>
                </div>
            </a>

            {{-- LinkedIn --}}
            <a href="https://www.linkedin.com/company/laravel-senegal" target="_blank" class="group relative overflow-hidden rounded-xl bg-white p-6 shadow-md ring-1 ring-gray-200 transition-all duration-300 hover:shadow-xl hover:ring-blue-700 hover:-translate-y-1">
                <div class="flex items-start gap-4">
                    <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-lg bg-blue-100 text-blue-700 transition-colors group-hover:bg-blue-700 group-hover:text-white">
                        <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/>
                        </svg>
                    </div>
                    <div class="flex-1">
                        <h3 class="font-semibold text-gray-900 mb-1">{{ __('LinkedIn Company') }}</h3>
                        <p class="text-sm text-gray-600">{{ __('Network professionally and explore career opportunities.') }}</p>
                    </div>
                </div>
                <div class="mt-4">
                    <span class="text-sm font-medium text-blue-700 group-hover:text-blue-800">
                        {{ __('Follow Us') }} →
                    </span>
                </div>
            </a>
        </div>
    </div>

    {{-- Inspiring Message --}}
    <div class="rounded-xl bg-gradient-to-r from-amber-50 to-orange-50 p-8 border border-amber-200">
        <div class="flex items-start gap-4">
            <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-lg bg-amber-500 text-white">
                <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                </svg>
            </div>
            <div>
                <h3 class="text-lg font-semibold text-gray-900 mb-2">
                    {{ __('Your Journey Starts Here') }}
                </h3>
                <p class="text-gray-700 leading-relaxed">
                    {{ __('Whether you\'re just starting with Laravel or you\'re a seasoned developer, Laravel Sénégal is your home for growth, learning, and collaboration. Together, we\'re building the future of tech in Senegal and beyond. Let\'s code, learn, and inspire each other!') }}
                </p>
            </div>
        </div>
    </div>

    {{-- Support Section --}}
    <div class="text-center py-6">
        <p class="text-sm text-gray-600">
            {{ __('Need help? We\'re here for you!') }}
            <a href="mailto:support@laravel-senegal.com" class="font-medium text-blue-600 hover:text-blue-700 underline">
                {{ __('Contact Support') }}
            </a>
        </p>
    </div>
</div>
