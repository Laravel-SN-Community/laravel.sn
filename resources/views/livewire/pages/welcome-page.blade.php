<div class="min-h-screen bg-linear-to-br from-red-50 via-white to-green-50">
    <!-- Navigation Header -->
    <nav class="bg-white shadow-xs">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <div class="flex items-center space-x-3">
                    <img src="{{ asset('images/Laravelsn.jpg') }}" alt="Laravel Senegal"
                        class="h-10 w-10 rounded-full object-cover">
                    <h1 class="text-xl font-bold text-gray-900">Laravel Senegal</h1>
                </div>
                <div class="flex items-center space-x-8">
                    <!-- Navigation links - hidden on mobile, visible on desktop -->
                    <div class="hidden md:flex items-center space-x-8">
                        <a href="#presentation"
                            class="text-gray-900 font-bold hover:text-red-600 transition-colors">{{ __('Presentation') }}</a>
                        <a href="#newsletter"
                            class="text-gray-900 font-bold hover:text-red-600 transition-colors">{{ __('Newsletter') }}</a>
                        <!-- Vertical divider -->
                        <div class="h-6 w-px bg-gray-300"></div>
                    </div>
                    <!-- GitHub icon - always visible -->
                    <a href="https://github.com/Laravel-SN-Community/laravel.sn" target="_blank"
                        class="text-gray-900 hover:text-red-600 transition-colors" title="GitHub">
                        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                            <path
                                d="M12 0c-6.626 0-12 5.373-12 12 0 5.302 3.438 9.8 8.207 11.387.599.111.793-.261.793-.577v-2.234c-3.338.726-4.033-1.416-4.033-1.416-.546-1.387-1.333-1.756-1.333-1.756-1.089-.745.083-.729.083-.729 1.205.084 1.839 1.237 1.839 1.237 1.07 1.834 2.807 1.304 3.492.997.107-.775.418-1.305.762-1.604-2.665-.305-5.467-1.334-5.467-5.931 0-1.311.469-2.381 1.236-3.221-.124-.303-.535-1.524.117-3.176 0 0 1.008-.322 3.301 1.23.957-.266 1.983-.399 3.003-.404 1.02.005 2.047.138 3.006.404 2.291-1.552 3.297-1.23 3.297-1.23.653 1.653.242 2.874.118 3.176.77.84 1.235 1.911 1.235 3.221 0 4.609-2.807 5.624-5.479 5.921.43.372.823 1.102.823 2.222v3.293c0 .319.192.694.801.576 4.765-1.589 8.199-6.086 8.199-11.386 0-6.627-5.373-12-12-12z" />
                        </svg>
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section
        class="relative min-h-screen flex items-center justify-center text-center bg-gradient-to-br from-gray-50 to-white overflow-hidden">
        <!-- Grid Background -->
        <div class="absolute inset-0 opacity-20">
            <div class="absolute inset-0"
                style="background-image:
                linear-gradient(to right, #9ca3af 1px, transparent 1px),
                linear-gradient(to bottom, #9ca3af 1px, transparent 1px);
                background-size: 20px 20px;">
            </div>
        </div>

        <!-- Gradient overlay from top to white -->
        <div class="absolute inset-0"
            style="background: linear-gradient(to bottom, transparent 0%, transparent 30%, rgba(255,255,255,0.7) 60%, white 100%);">
        </div>

        <div class="relative z-10 max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">

            <!-- Main Title -->
            <h1 class="text-5xl md:text-6xl lg:text-7xl font-bold text-gray-900 mb-6 leading-tight">
                Laravel Sénégal
            </h1>

            <!-- Subtitle -->
            <p class="text-xl md:text-2xl lg:text-3xl text-gray-700 mb-8 font-light max-w-4xl mx-auto">
                Bienvenue dans la plus grande communauté de développeurs
                <span class="text-red-600 font-semibold">Laravel</span> au Sénégal
            </p>

            <!-- Description -->
            <p class="text-lg md:text-xl text-gray-600 mb-10 max-w-3xl mx-auto leading-relaxed">
                Rejoignez une communauté dynamique de <span class="font-semibold text-gray-800">500+ développeurs</span>
                passionnés par Laravel. Participez à nos événements, partagez vos projets et
                accélérez votre carrière dans le développement web.
            </p>

            <!-- CTA Buttons -->
            <div class="flex flex-col sm:flex-row gap-4 justify-center items-center mb-16">
                <a href="#presentation"
                    class="inline-block bg-red-600 text-white px-8 py-4 rounded-lg text-lg font-semibold hover:bg-red-700 transform hover:scale-105 transition-all duration-300 shadow-lg hover:shadow-xl scroll-smooth">
                    Découvrir la communauté
                </a>
                <a href="https://chat.whatsapp.com/JwITxALLv0uJIGNu7AsVnx" target="_blank"
                    class="inline-block border-2 border-red-600 text-red-600 px-8 py-4 rounded-lg text-lg font-semibold hover:bg-red-600 hover:text-white transition-all duration-300">
                    Rejoindre la communauté WhatsApp
                </a>
            </div>

        </div>

    </section>

    <!-- Presentation Section -->
    <section id="presentation" class="py-20 bg-white">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-4xl font-bold text-gray-900 mb-4">Présentation</h2>
                <p class="text-lg text-gray-600">Découvrez qui nous sommes et notre mission</p>
            </div>

            <div class="grid md:grid-cols-3 gap-8">
                <div class="text-center p-6">
                    <div class="w-16 h-16 bg-red-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="size-6">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M18 18.72a9.094 9.094 0 0 0 3.741-.479 3 3 0 0 0-4.682-2.72m.94 3.198.001.031c0 .225-.012.447-.037.666A11.944 11.944 0 0 1 12 21c-2.17 0-4.207-.576-5.963-1.584A6.062 6.062 0 0 1 6 18.719m12 0a5.971 5.971 0 0 0-.941-3.197m0 0A5.995 5.995 0 0 0 12 12.75a5.995 5.995 0 0 0-5.058 2.772m0 0a3 3 0 0 0-4.681 2.72 8.986 8.986 0 0 0 3.74.477m.94-3.197a5.971 5.971 0 0 0-.94 3.197M15 6.75a3 3 0 1 1-6 0 3 3 0 0 1 6 0Zm6 3a2.25 2.25 0 1 1-4.5 0 2.25 2.25 0 0 1 4.5 0Zm-13.5 0a2.25 2.25 0 1 1-4.5 0 2.25 2.25 0 0 1 4.5 0Z" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold mb-3">Communauté</h3>
                    <p class="text-gray-600">
                        Une communauté dynamique de développeurs passionnés par Laravel au Sénégal.
                    </p>
                </div>

                <div class="text-center p-6">
                    <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253">
                            </path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold mb-3">Événements</h3>
                    <p class="text-gray-600">
                        Nous organisons des meetups, ateliers et événements réguliers.
                    </p>
                </div>

                <div class="text-center p-6">
                    <div class="w-16 h-16 bg-yellow-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold mb-3">Innovation</h3>
                    <p class="text-gray-600">
                        Nous encourageons l'innovation et les projets open source.
                        Ensemble, nous contribuons à l'écosystème Laravel.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- Newsletter Section -->
    {{-- <section id="newsletter" class="py-20 bg-gray-50">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h2 class="text-4xl font-bold text-gray-900 mb-4">Newsletter</h2>
            <p class="text-lg text-gray-600 mb-8">
                Restez informé des dernières actualités, événements et ressources Laravel Sénégal
            </p>

            <div class="bg-white p-8 rounded-lg shadow-md max-w-md mx-auto">
                <form wire:submit="subscribe" class="space-y-4">
                    <div>
                        <input type="email" wire:model="email" placeholder="Votre adresse email"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-transparent"
                            required>
                        @error('email')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <button type="submit"
                        class="w-full bg-red-600 text-white px-6 py-3 rounded-lg font-semibold hover:bg-red-700 transition-colors disabled:opacity-50"
                        wire:loading.attr="disabled">
                        <span wire:loading.remove>S'abonner à la newsletter</span>
                        <span wire:loading>Inscription en cours...</span>
                    </button>
                </form>


            </div>
        </div>
    </section> --}}

    <!-- Contact Section -->
    <section id="contact" class="py-24 bg-white">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-14">
               
                <h2 class="mt-3 text-4xl font-bold tracking-tight text-gray-900">Restons en contact
                </h2>
                <p class="mt-3 text-lg text-gray-600">Rejoignez la communauté ou suivez nos
                    actualités.</p>
            </div>

            <div class="grid gap-8 md:grid-cols-2">
                <div class="space-y-6">
                    <div class="rounded-2xl border border-gray-200 p-6 shadow-sm">
                        <div class="flex items-start gap-4">
                            <div
                                class="flex h-12 w-12 items-center justify-center rounded-xl bg-rose-100 text-rose-600">
                                <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                                        d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8m-16 11h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-lg font-semibold text-gray-900">Email</h3>
                                <p class="text-gray-600">laravelsenegal@gmail.com</p>
                                <a href="mailto:laravelsenegal@gmail.com"
                                    class="mt-2 inline-flex items-center text-sm font-medium text-rose-600 hover:underline">Écrire
                                    un email →</a>
                            </div>
                        </div>
                    </div>

                    <div class="rounded-2xl border border-gray-200 p-6 shadow-sm">
                        <h3 class="mb-4 text-lg font-semibold text-gray-900">Réseaux & Communauté</h3>
                        <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
                            <a href="https://chat.whatsapp.com/JwITxALLv0uJIGNu7AsVnx" target="_blank"
                                class="group inline-flex items-center justify-between rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-emerald-800 transition hover:shadow-md">
                                <span class="inline-flex items-center gap-2 font-medium">
                                    <svg xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" class="w-6 h-6" viewBox="0 0 48 48">
                                        <path fill="#fff" d="M4.868,43.303l2.694-9.835C5.9,30.59,5.026,27.324,5.027,23.979C5.032,13.514,13.548,5,24.014,5c5.079,0.002,9.845,1.979,13.43,5.566c3.584,3.588,5.558,8.356,5.556,13.428c-0.004,10.465-8.522,18.98-18.986,18.98c-0.001,0,0,0,0,0h-0.008c-3.177-0.001-6.3-0.798-9.073-2.311L4.868,43.303z"></path><path fill="#fff" d="M4.868,43.803c-0.132,0-0.26-0.052-0.355-0.148c-0.125-0.127-0.174-0.312-0.127-0.483l2.639-9.636c-1.636-2.906-2.499-6.206-2.497-9.556C4.532,13.238,13.273,4.5,24.014,4.5c5.21,0.002,10.105,2.031,13.784,5.713c3.679,3.683,5.704,8.577,5.702,13.781c-0.004,10.741-8.746,19.48-19.486,19.48c-3.189-0.001-6.344-0.788-9.144-2.277l-9.875,2.589C4.953,43.798,4.911,43.803,4.868,43.803z"></path><path fill="#cfd8dc" d="M24.014,5c5.079,0.002,9.845,1.979,13.43,5.566c3.584,3.588,5.558,8.356,5.556,13.428c-0.004,10.465-8.522,18.98-18.986,18.98h-0.008c-3.177-0.001-6.3-0.798-9.073-2.311L4.868,43.303l2.694-9.835C5.9,30.59,5.026,27.324,5.027,23.979C5.032,13.514,13.548,5,24.014,5 M24.014,42.974C24.014,42.974,24.014,42.974,24.014,42.974C24.014,42.974,24.014,42.974,24.014,42.974 M24.014,42.974C24.014,42.974,24.014,42.974,24.014,42.974C24.014,42.974,24.014,42.974,24.014,42.974 M24.014,4C24.014,4,24.014,4,24.014,4C12.998,4,4.032,12.962,4.027,23.979c-0.001,3.367,0.849,6.685,2.461,9.622l-2.585,9.439c-0.094,0.345,0.002,0.713,0.254,0.967c0.19,0.192,0.447,0.297,0.711,0.297c0.085,0,0.17-0.011,0.254-0.033l9.687-2.54c2.828,1.468,5.998,2.243,9.197,2.244c11.024,0,19.99-8.963,19.995-19.98c0.002-5.339-2.075-10.359-5.848-14.135C34.378,6.083,29.357,4.002,24.014,4L24.014,4z"></path><path fill="#40c351" d="M35.176,12.832c-2.98-2.982-6.941-4.625-11.157-4.626c-8.704,0-15.783,7.076-15.787,15.774c-0.001,2.981,0.833,5.883,2.413,8.396l0.376,0.597l-1.595,5.821l5.973-1.566l0.577,0.342c2.422,1.438,5.2,2.198,8.032,2.199h0.006c8.698,0,15.777-7.077,15.78-15.776C39.795,19.778,38.156,15.814,35.176,12.832z"></path><path fill="#fff" fill-rule="evenodd" d="M19.268,16.045c-0.355-0.79-0.729-0.806-1.068-0.82c-0.277-0.012-0.593-0.011-0.909-0.011c-0.316,0-0.83,0.119-1.265,0.594c-0.435,0.475-1.661,1.622-1.661,3.956c0,2.334,1.7,4.59,1.937,4.906c0.237,0.316,3.282,5.259,8.104,7.161c4.007,1.58,4.823,1.266,5.693,1.187c0.87-0.079,2.807-1.147,3.202-2.255c0.395-1.108,0.395-2.057,0.277-2.255c-0.119-0.198-0.435-0.316-0.909-0.554s-2.807-1.385-3.242-1.543c-0.435-0.158-0.751-0.237-1.068,0.238c-0.316,0.474-1.225,1.543-1.502,1.859c-0.277,0.317-0.554,0.357-1.028,0.119c-0.474-0.238-2.002-0.738-3.815-2.354c-1.41-1.257-2.362-2.81-2.639-3.285c-0.277-0.474-0.03-0.731,0.208-0.968c0.213-0.213,0.474-0.554,0.712-0.831c0.237-0.277,0.316-0.475,0.474-0.791c0.158-0.317,0.079-0.594-0.04-0.831C20.612,19.329,19.69,16.983,19.268,16.045z" clip-rule="evenodd"></path>
                                    </svg>
                                    WhatsApp
                                </span>
                                <span class="text-xs opacity-60 group-hover:opacity-100">Rejoindre →</span>
                            </a>

                            <a href="https://x.com/laravel_sn" target="_blank"
                                class="group inline-flex items-center justify-between rounded-xl border border-gray-200 bg-gray-50 px-4 py-3 text-gray-900 transition hover:shadow-md">
                                <span class="inline-flex items-center gap-2 font-medium">
                                    <svg class="h-5 w-5" viewBox="0 0 24 24" fill="currentColor">
                                        <path
                                            d="M18.9 1.98h3.28l-7.17 8.2 8.43 11.84h-6.6l-5.17-6.78-5.91 6.78H1.47l7.67-8.8L1 1.98h6.8l4.7 6.17 6.4-6.17Z" />
                                    </svg>
                                    X (Twitter)
                                </span>
                                <span class="text-xs opacity-60 group-hover:opacity-100">@laravel_sn</span>
                            </a>

                            <a href="https://github.com/Laravel-SN-Community/laravel.sn" target="_blank"
                                class="group inline-flex items-center justify-between rounded-xl border border-gray-200 bg-gray-50 px-4 py-3 text-gray-900 transition hover:shadow-md">
                                <span class="inline-flex items-center gap-2 font-medium">
                                    <svg class="h-5 w-5" viewBox="0 0 24 24" fill="currentColor">
                                        <path
                                            d="M12 0C5.37 0 0 5.37 0 12c0 5.3 3.44 9.8 8.2 11.39.6.11.79-.26.79-.58v-2.23c-3.34.72-4.03-1.42-4.03-1.42-.55-1.39-1.34-1.76-1.34-1.76-1.09-.75.08-.73.08-.73 1.2.08 1.84 1.24 1.84 1.24 1.07 1.83 2.81 1.3 3.49.99.11-.78.42-1.3.76-1.6-2.67-.31-5.47-1.34-5.47-5.93 0-1.31.47-2.38 1.24-3.22-.12-.3-.53-1.52.12-3.18 0 0 1.01-.32 3.3 1.23.96-.27 1.98-.4 3-.4s2.04.13 3 .4c2.29-1.55 3.3-1.23 3.3-1.23.65 1.66.24 2.88.12 3.18.77.84 1.24 1.91 1.24 3.22 0 4.61-2.81 5.62-5.48 5.92.43.37.82 1.1.82 2.22v3.29c0 .32.19.69.8.58C20.56 21.8 24 17.3 24 12 24 5.37 18.63 0 12 0Z" />
                                    </svg>
                                    GitHub
                                </span>
                                <span class="text-xs opacity-60 group-hover:opacity-100">Open Source →</span>
                            </a>

                            <a href="https://www.linkedin.com/company/laravel-senegal" target="_blank"
                                class="group inline-flex items-center justify-between rounded-xl border border-blue-200 bg-blue-50 px-4 py-3 text-blue-800 transition hover:shadow-md">
                                <span class="inline-flex items-center gap-2 font-medium">
                                    <svg xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" class="w-6 h-6" viewBox="0 0 48 48">
                                        <path fill="#0288D1" d="M42,37c0,2.762-2.238,5-5,5H11c-2.761,0-5-2.238-5-5V11c0-2.762,2.239-5,5-5h26c2.762,0,5,2.238,5,5V37z"></path><path fill="#FFF" d="M12 19H17V36H12zM14.485 17h-.028C12.965 17 12 15.888 12 14.499 12 13.08 12.995 12 14.514 12c1.521 0 2.458 1.08 2.486 2.499C17 15.887 16.035 17 14.485 17zM36 36h-5v-9.099c0-2.198-1.225-3.698-3.192-3.698-1.501 0-2.313 1.012-2.707 1.99C24.957 25.543 25 26.511 25 27v9h-5V19h5v2.616C25.721 20.5 26.85 19 29.738 19c3.578 0 6.261 2.25 6.261 7.274L36 36 36 36z"></path>
                                    </svg>
                                    LinkedIn
                                </span>
                                <span class="text-xs opacity-60 group-hover:opacity-100">Suivre →</span>
                            </a>
                        </div>
                    </div>
                </div>

                <div class="space-y-6">
                    <div
                        class="rounded-3xl border border-white/60 bg-white p-8 shadow-xl">
                        <h3 class="mb-2 text-2xl font-semibold text-gray-900">Proposer un talk</h3>
                        <p class="mb-6 text-sm text-gray-600">Pitch rapide par email — notre équipe
                            programme les prochains meetups.</p>

                        <a href="mailto:laravelsenegal@gmail.com?subject=Proposition%20de%20talk%20Laravel%20S%C3%A9n%C3%A9gal"
                            class="inline-flex items-center justify-center gap-2 rounded-xl bg-rose-600 px-6 py-3 font-semibold text-white shadow-lg transition hover:scale-[1.01] hover:bg-rose-700 focus:outline-none focus:ring-2 focus:ring-rose-300">
                            <svg class="h-5 w-5" viewBox="0 0 24 24" fill="currentColor">
                                <path
                                    d="M12 12.713 1.2 6.053C1.69 4.86 2.79 4 4.11 4h15.78c1.33 0 2.42.86 2.91 2.053L12 12.713zm0 2.574L.75 7.5v10.39C.75 19.06 1.69 20 2.86 20h18.28c1.17 0 2.11-.94 2.11-2.11V7.5L12 15.287z" />
                            </svg>
                            Envoyer ma proposition
                        </a>

                        <p class="mt-5 text-xs text-gray-500">En nous contactant, vous acceptez
                            notre politique de confidentialité.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="relative bg-gray-900 text-white overflow-hidden">
        <!-- Background Pattern -->
        <div class="absolute inset-0 bg-gradient-to-br from-gray-800 to-gray-900"></div>
        <div class="absolute inset-0 bg-[url('data:image/svg+xml,%3Csvg width="60" height="60" viewBox="0 0 60 60" xmlns="http://www.w3.org/2000/svg"%3E%3Cg fill="none" fill-rule="evenodd"%3E%3Cg fill="%23ffffff" fill-opacity="0.03"%3E%3Ccircle cx="30" cy="30" r="1"/%3E%3C/g%3E%3C/g%3E%3C/svg%3E')] opacity-40"></div>
        
        <!-- Watermark LaravelSn -->
        <div class="absolute inset-0 flex items-center justify-center pointer-events-none">
            <h1 class="font-black leading-none tracking-tight text-transparent bg-clip-text bg-gradient-to-r from-gray-600/20 to-gray-400/20 select-none
                       text-[clamp(4rem,20vw,16rem)] whitespace-nowrap opacity-30">
                LaravelSn
            </h1>
        </div>
        
        <!-- Main Footer Content -->
        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8 lg:gap-12">
                
                <!-- Brand Section -->
                <div class="lg:col-span-2">
                    <div class="flex items-center gap-3 mb-6">
                        <img src="{{ asset('images/Laravelsn.jpg') }}" alt="Laravel Sénégal"
                             class="h-10 w-10 rounded-full object-cover ring-2">
                        <h3 class="text-2xl font-bold bg-gradient-to-r from-white to-gray-300 bg-clip-text text-transparent">
                            Laravel Sénégal
                        </h3>
                    </div>
                    <p class="text-gray-300 text-lg mb-6 max-w-md">
                        La communauté Laravel du Sénégal. Ensemble, construisons l'avenir du développement web au Sénégal.
                    </p>
                    
                    <!-- Social Links -->
                    <div class="flex gap-4">
                        <a href="https://x.com/laravel_sn" target="_blank" 
                           class="group flex items-center justify-center w-10 h-10 bg-gray-800 rounded-lg hover:bg-rose-600 transition-all duration-300 hover:scale-110">
                            <svg class="w-5 h-5 group-hover:text-white" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M18.9 1.98h3.28l-7.17 8.2 8.43 11.84h-6.6l-5.17-6.78-5.91 6.78H1.47l7.67-8.8L1 1.98h6.8l4.7 6.17 6.4-6.17Z"/>
                            </svg>
                        </a>
                        <a href="https://chat.whatsapp.com/JwITxALLv0uJIGNu7AsVnx" target="_blank"
                           class="group flex items-center justify-center w-10 h-10 bg-gray-800 rounded-lg hover:bg-emerald-600 transition-all duration-300 hover:scale-110">
                            <svg class="w-5 h-5 group-hover:text-white" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893A11.821 11.821 0 0020.885 3.488"/>
                            </svg>
                        </a>
                        <a href="https://github.com/Laravel-SN-Community/laravel.sn" target="_blank"
                           class="group flex items-center justify-center w-10 h-10 bg-gray-800 rounded-lg hover:bg-gray-700 transition-all duration-300 hover:scale-110">
                            <svg class="w-5 h-5 group-hover:text-white" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12 0C5.37 0 0 5.37 0 12c0 5.3 3.44 9.8 8.2 11.39.6.11.79-.26.79-.58v-2.23c-3.34.72-4.03-1.42-4.03-1.42-.55-1.39-1.34-1.76-1.34-1.76-1.09-.75.08-.73.08-.73 1.2.08 1.84 1.24 1.84 1.24 1.07 1.83 2.81 1.3 3.49.99.11-.78.42-1.3.76-1.6-2.67-.31-5.47-1.34-5.47-5.93 0-1.31.47-2.38 1.24-3.22-.12-.3-.53-1.52.12-3.18 0 0 1.01-.32 3.3 1.23.96-.27 1.98-.4 3-.4s2.04.13 3 .4c2.29-1.55 3.3-1.23 3.3-1.23.65 1.66.24 2.88.12 3.18.77.84 1.24 1.91 1.24 3.22 0 4.61-2.81 5.62-5.48 5.92.43.37.82 1.1.82 2.22v3.29c0 .32.19.69.8.58C20.56 21.8 24 17.3 24 12 24 5.37 18.63 0 12 0Z"/>
                            </svg>
                        </a>
                        <a href="https://www.linkedin.com/company/laravel-senegal" target="_blank"
                           class="group flex items-center justify-center w-10 h-10 bg-gray-800 rounded-lg hover:bg-blue-600 transition-all duration-300 hover:scale-110">
                            <svg class="w-5 h-5 group-hover:text-white" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/>
                            </svg>
                        </a>
                    </div>
                </div>

                <!-- Quick Links -->
                <div>
                    <h4 class="text-lg font-semibold mb-6 text-white">Liens Rapides</h4>
                    <ul class="space-y-3">
                        <li><a href="#about" class="text-gray-300 hover:text-rose-400 transition-colors duration-300">À Propos</a></li>
                        <li><a href="#events" class="text-gray-300 hover:text-rose-400 transition-colors duration-300">Événements</a></li>
                        <li><a href="#community" class="text-gray-300 hover:text-rose-400 transition-colors duration-300">Communauté</a></li>
                        <li><a href="#contact" class="text-gray-300 hover:text-rose-400 transition-colors duration-300">Contact</a></li>
                    </ul>
                </div>

                <!-- Contact Info -->
                <div>
                    <h4 class="text-lg font-semibold mb-6 text-white">Contact</h4>
                    <div class="space-y-3">
                        <div class="flex items-start gap-3">
                            <svg class="w-5 h-5 text-rose-400 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8m-16 11h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                            </svg>
                            <a href="mailto:laravelsenegal@gmail.com" class="text-gray-300 hover:text-rose-400 transition-colors duration-300">
                                laravelsenegal@gmail.com
                            </a>
                        </div>
                        <div class="flex items-start gap-3">
                            <svg class="w-5 h-5 text-rose-400 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                            </svg>
                            <span class="text-gray-300">Dakar, Sénégal</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Bottom Bar -->
        <div class="relative border-t border-gray-800">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
                <div class="flex flex-col md:flex-row justify-between items-center gap-4">
                    <p class="text-gray-400 text-sm">
                    © {{ date('Y') }} Laravel Sénégal. Tous droits réservés.
                </p>
                    <div class="flex gap-6 text-sm">
                        <a href="#" class="text-gray-400 hover:text-rose-400 transition-colors duration-300">Mentions légales</a>
                        <a href="#" class="text-gray-400 hover:text-rose-400 transition-colors duration-300">Politique de confidentialité</a>
                        <a href="#" class="text-gray-400 hover:text-rose-400 transition-colors duration-300">CGU</a>
                    </div>
                </div>
            </div>
        </div>
    </footer>
      
    
</div>
