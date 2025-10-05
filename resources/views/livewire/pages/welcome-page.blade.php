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
 <!-- Presentation Section - Design Alternatif -->
<section id="presentation" class="py-20 bg-gradient-to-br from-white via-red-50/30 to-green-50/30">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header avec badge -->
        <div class="text-center mb-16">
          
            <h2 class="text-4xl md:text-5xl font-bold text-gray-900 mb-4">
                Une Communauté <span class="text-transparent bg-clip-text bg-gradient-to-r from-red-600 to-green-600">Vibrante</span>
            </h2>
            <p class="text-xl text-gray-600 max-w-3xl mx-auto">
                Rassembler, former et inspirer la prochaine génération de développeurs Laravel au Sénégal
            </p>
        </div>

        <!-- Grid principale avec image et stats -->
        <div class="grid lg:grid-cols-2 gap-12 items-center mb-16">
            <!-- Colonne de gauche - Image et stats -->
            <div class="relative">
                <div class="relative rounded-2xl overflow-hidden shadow-2xl">
                    <div class="aspect-[4/3] bg-gradient-to-br from-red-200 to-green-200 flex items-center justify-center">
                        <!-- Placeholder pour image communautaire -->
                        <div class="text-center text-gray-600">
                            <svg class="w-24 h-24 mx-auto mb-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                            </svg>
                            <p class="text-lg font-semibold">Image de la communauté</p>
                        </div>
                    </div>
                </div>

                <!-- Stats overlay -->
                <div class="absolute -bottom-6 -right-6 bg-white rounded-2xl shadow-xl p-6 border border-gray-100">
                    <div class="flex items-center space-x-4">
                        <div class="flex items-center space-x-2">
                            <div class="w-3 h-3 bg-green-500 rounded-full animate-pulse"></div>
                            <span class="text-2xl font-bold text-gray-900">500+</span>
                        </div>
                        <span class="text-gray-600">Développeurs actifs</span>
                    </div>
                </div>
            </div>

            <!-- Colonne de droite - Contenu -->
            <div class="space-y-6">
                <h3 class="text-3xl font-bold text-gray-900">
                    Construisons ensemble <br>l'écosystème Laravel <span class="text-red-600">Sénégalais</span>
                </h3>

                <p class="text-lg text-gray-600 leading-relaxed">
                    Laravel Sénégal est bien plus qu'une communauté de développeurs. C'est un espace d'échange,
                    d'apprentissage et d'innovation où les passionnés du framework Laravel se rencontrent,
                    partagent et grandissent ensemble.
                </p>

                <div class="grid grid-cols-2 gap-4 pt-4">
                    <div class="flex items-center space-x-3">
                        <div class="w-10 h-10 bg-red-100 rounded-lg flex items-center justify-center">
                            <svg class="w-5 h-5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                        </div>
                        <span class="text-gray-700 font-medium">Événements mensuels</span>
                    </div>
                    <div class="flex items-center space-x-3">
                        <div class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center">
                            <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                            </svg>
                        </div>
                        <span class="text-gray-700 font-medium">Ressources gratuites</span>
                    </div>
                    <div class="flex items-center space-x-3">
                        <div class="w-10 h-10 bg-yellow-100 rounded-lg flex items-center justify-center">
                            <svg class="w-5 h-5 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11a7 7 0 01-7 7m0 0a7 7 0 01-7-7m7 7v4m0 0H8m4 0h4m-4-8a3 3 0 01-3-3V5a3 3 0 116 0v6a3 3 0 01-3 3z"/>
                            </svg>
                        </div>
                        <span class="text-gray-700 font-medium">Mentorat actif</span>
                    </div>
                    <div class="flex items-center space-x-3">
                        <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center">
                            <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4"/>
                            </svg>
                        </div>
                        <span class="text-gray-700 font-medium">Projets collaboratifs</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Valeurs et piliers -->
        <div class="grid md:grid-cols-3 gap-8 mt-16">
            <!-- Carte 1 -->
            <div class="group relative bg-white rounded-2xl p-8 shadow-lg hover:shadow-xl transition-all duration-300 border border-gray-100 hover:border-red-200">
                <div class="absolute -top-4 left-6">
                    <div class="w-12 h-12 bg-gradient-to-r from-red-500 to-red-600 rounded-xl flex items-center justify-center text-white shadow-lg">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                        </svg>
                    </div>
                </div>
                <h3 class="text-2xl font-bold text-gray-900 mt-4 mb-4">Communauté Inclusive</h3>
                <p class="text-gray-600 leading-relaxed mb-4">
                    Un espace accueillant pour tous les développeurs, du débutant au expert.
                    Nous croyons en la force de la diversité et de l'entraide.
                </p>
                <ul class="space-y-2 text-gray-600">
                    <li class="flex items-center">
                        <svg class="w-4 h-4 text-green-500 mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                        </svg>
                        Échanges bienveillants
                    </li>
                    <li class="flex items-center">
                        <svg class="w-4 h-4 text-green-500 mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                        </svg>
                        Mentorat par les pairs
                    </li>
                    <li class="flex items-center">
                        <svg class="w-4 h-4 text-green-500 mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                        </svg>
                        Réseautage qualité
                    </li>
                </ul>
            </div>

            <!-- Carte 2 -->
            <div class="group relative bg-white rounded-2xl p-8 shadow-lg hover:shadow-xl transition-all duration-300 border border-gray-100 hover:border-green-200">
                <div class="absolute -top-4 left-6">
                    <div class="w-12 h-12 bg-gradient-to-r from-green-500 to-green-600 rounded-xl flex items-center justify-center text-white shadow-lg">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                    </div>
                </div>
                <h3 class="text-2xl font-bold text-gray-900 mt-4 mb-4">Événements Réguliers</h3>
                <p class="text-gray-600 leading-relaxed mb-4">
                    Meetups, ateliers pratiques et conférences pour rester à la pointe
                    des technologies et des meilleures pratiques Laravel.
                </p>
                <ul class="space-y-2 text-gray-600">
                    <li class="flex items-center">
                        <svg class="w-4 h-4 text-green-500 mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                        </svg>
                        Meetups mensuels
                    </li>
                    <li class="flex items-center">
                        <svg class="w-4 h-4 text-green-500 mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                        </svg>
                        Ateliers pratiques
                    </li>
                    <li class="flex items-center">
                        <svg class="w-4 h-4 text-green-500 mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                        </svg>
                        Conférences annuelles
                    </li>
                </ul>
            </div>

            <!-- Carte 3 -->
            <div class="group relative bg-white rounded-2xl p-8 shadow-lg hover:shadow-xl transition-all duration-300 border border-gray-100 hover:border-yellow-200">
                <div class="absolute -top-4 left-6">
                    <div class="w-12 h-12 bg-gradient-to-r from-yellow-500 to-yellow-600 rounded-xl flex items-center justify-center text-white shadow-lg">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                        </svg>
                    </div>
                </div>
                <h3 class="text-2xl font-bold text-gray-900 mt-4 mb-4">Innovation Continue</h3>
                <p class="text-gray-600 leading-relaxed mb-4">
                    Stimuler l'innovation technologique et promouvoir l'open source
                    pour contribuer activement à l'écosystème Laravel mondial.
                </p>
                <ul class="space-y-2 text-gray-600">
                    <li class="flex items-center">
                        <svg class="w-4 h-4 text-green-500 mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                        </svg>
                        Projets open source
                    </li>
                    <li class="flex items-center">
                        <svg class="w-4 h-4 text-green-500 mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                        </svg>
                        Veille technologique
                    </li>
                    <li class="flex items-center">
                        <svg class="w-4 h-4 text-green-500 mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                        </svg>
                        Contributions actives
                    </li>
                </ul>
            </div>
        </div>


    </div>
</section>

    <!-- Newsletter Section -->
    <section id="newsletter" class="py-20 bg-gray-50">
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
    </section>

    <!-- Contact Section -->
    <section id="contact" class="py-24 bg-white dark:bg-gray-950">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-14">

                <h2 class="mt-3 text-4xl font-bold tracking-tight text-gray-900 dark:text-white">Restons en contact
                </h2>
                <p class="mt-3 text-lg text-gray-600 dark:text-gray-400">Rejoignez la communauté ou suivez nos
                    actualités.</p>
            </div>

            <div class="grid gap-8 md:grid-cols-2">
                <div class="space-y-6">
                    <div class="rounded-2xl border border-gray-200 p-6 shadow-sm dark:border-white/10 dark:bg-white/5">
                        <div class="flex items-start gap-4">
                            <div
                                class="flex h-12 w-12 items-center justify-center rounded-xl bg-rose-100 text-rose-600 dark:bg-rose-500/15 dark:text-rose-300">
                                <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                                        d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8m-16 11h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Email</h3>
                                <p class="text-gray-600 dark:text-gray-400">laravelsenegal@gmail.com</p>
                                <a href="mailto:laravelsenegal@gmail.com"
                                    class="mt-2 inline-flex items-center text-sm font-medium text-rose-600 hover:underline dark:text-rose-300">Écrire
                                    un email →</a>
                            </div>
                        </div>
                    </div>

                    <div class="rounded-2xl border border-gray-200 p-6 shadow-sm dark:border-white/10 dark:bg-white/5">
                        <h3 class="mb-4 text-lg font-semibold text-gray-900 dark:text-white">Réseaux & Communauté</h3>
                        <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
                            <a href="https://chat.whatsapp.com/JwITxALLv0uJIGNu7AsVnx" target="_blank"
                                class="group inline-flex items-center justify-between rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-emerald-800 transition hover:shadow-md dark:border-emerald-500/20 dark:bg-emerald-500/10 dark:text-emerald-200">
                                <span class="inline-flex items-center gap-2 font-medium">
                                    <svg class="h-5 w-5" viewBox="0 0 32 32" fill="currentColor">
                                        <path
                                            d="M16 .6a15.3 15.3 0 0 0-13 23.3L2 31.4l7.7-1.9A15.4 15.4 0 1 0 16 .6Zm8.9 24a12.2 12.2 0 0 1-7 3.8 12.4 12.4 0 0 1-10-2.7l-.7-.5-4.6 1.1 1.2-4.5-.5-.8a12.4 12.4 0 0 1 1.8-15.4 12.2 12.2 0 0 1 17.3.6A12.3 12.3 0 0 1 24.9 24.6Z" />
                                    </svg>
                                    WhatsApp
                                </span>
                                <span class="text-xs opacity-60 group-hover:opacity-100">Rejoindre →</span>
                            </a>

                            <a href="https://x.com/laravel_sn" target="_blank"
                                class="group inline-flex items-center justify-between rounded-xl border border-gray-200 bg-gray-50 px-4 py-3 text-gray-900 transition hover:shadow-md dark:border-white/10 dark:bg-white/5 dark:text-gray-200">
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
                                class="group inline-flex items-center justify-between rounded-xl border border-gray-200 bg-gray-50 px-4 py-3 text-gray-900 transition hover:shadow-md dark:border-white/10 dark:bg-white/5 dark:text-gray-200">
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
                                class="group inline-flex items-center justify-between rounded-xl border border-blue-200 bg-blue-50 px-4 py-3 text-blue-800 transition hover:shadow-md dark:border-blue-500/20 dark:bg-blue-500/10 dark:text-blue-200">
                                <span class="inline-flex items-center gap-2 font-medium">
                                  <svg class="h-5 w-5" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                                        <path
                                            d="M4.98 3.5C4.98 4.88 3.86 6 2.5 6S0 4.88 0 3.5 1.12 1 2.5 1s2.48 1.12 2.48 2.5zM.5 8h4V24h-4V8zm7.5 0h3.8v2.2h.05c.53-1 1.83-2.2 3.77-2.2 4.03 0 4.78 2.65 4.78 6.1V24h-4v-7.2c0-1.72-.03-3.94-2.4-3.94-2.4 0-2.77 1.87-2.77 3.8V24h-4V8z" />
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
                        class="rounded-3xl border border-white/60 bg-white p-8 shadow-xl dark:border-white/10 dark:bg-white/5">
                        <h3 class="mb-2 text-2xl font-semibold text-gray-900 dark:text-white">Proposer un talk</h3>
                        <p class="mb-6 text-sm text-gray-600 dark:text-gray-400">Pitch rapide par email — notre équipe
                            programme les prochains meetups.</p>

                        <a href="mailto:laravelsenegal@gmail.com?subject=Proposition%20de%20talk%20Laravel%20S%C3%A9n%C3%A9gal"
                            class="inline-flex items-center justify-center gap-2 rounded-xl bg-rose-600 px-6 py-3 font-semibold text-white shadow-lg transition hover:scale-[1.01] hover:bg-rose-700 focus:outline-none focus:ring-2 focus:ring-rose-300 dark:bg-rose-500 dark:hover:bg-rose-400">
                            <svg class="h-5 w-5" viewBox="0 0 24 24" fill="currentColor">
                                <path
                                    d="M12 12.713 1.2 6.053C1.69 4.86 2.79 4 4.11 4h15.78c1.33 0 2.42.86 2.91 2.053L12 12.713zm0 2.574L.75 7.5v10.39C.75 19.06 1.69 20 2.86 20h18.28c1.17 0 2.11-.94 2.11-2.11V7.5L12 15.287z" />
                            </svg>
                            Envoyer ma proposition
                        </a>

                        <p class="mt-5 text-xs text-gray-500 dark:text-gray-400">En nous contactant, vous acceptez
                            notre politique de confidentialité.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-gray-900 text-white py-12">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center">
                <div class="flex items-center justify-center space-x-3 mb-4">
                    <img src="{{ asset('images/Laravelsn.jpg') }}" alt="Laravel Senegal"
                        class="h-8 w-8 rounded-full object-cover">
                    <h3 class="text-xl font-bold">Laravel Sénégal</h3>
                </div>
                <p class="text-gray-400 mb-4">
                    La communauté Laravel du Sénégal - Ensemble, construisons l'avenir du développement web
                </p>
                <p class="text-gray-500 text-sm">
                    © {{ date('Y') }} Laravel Sénégal. Tous droits réservés.
                </p>
            </div>
        </div>
    </footer>
</div>
