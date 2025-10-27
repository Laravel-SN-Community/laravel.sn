{{-- <x-slot:title>Home</x-slot:title> --}}
<div class="min-h-screen bg-linear-to-br from-red-50 via-white to-green-50 snap-y snap-mandatory overflow-y-scroll">
    
    <!-- Hero Section -->
    <section
        class="relative min-h-screen flex items-center justify-center text-center bg-gradient-to-br from-gray-50 to-white overflow-hidden snap-start snap-always">
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

        <div class="relative max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
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
    <section id="presentation"
        class="min-h-screen py-20 bg-gradient-to-br from-white via-red-50/30 to-green-50/30 snap-start snap-always">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Header avec badge -->
            <div class="text-center mb-16">

                <h2 class="text-4xl md:text-5xl font-bold text-gray-900 mb-4">
                    Une Communauté <span class="text-red-600">Vibrante</span>
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
                        <div
                            class="aspect-[4/3] bg-gradient-to-br from-red-200 to-green-200 flex items-center justify-center">
                            <img src="{{ asset('images/Laravelsn.jpg') }}" alt="Laravel Senegal"
                                class="w-full h-full object-cover">
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
                                <svg class="w-5 h-5 text-red-600" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                            </div>
                            <span class="text-gray-700 font-medium">Événements mensuels</span>
                        </div>
                        <div class="flex items-center space-x-3">
                            <div class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center">
                                <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                                </svg>
                            </div>
                            <span class="text-gray-700 font-medium">Ressources gratuites</span>
                        </div>
                        <div class="flex items-center space-x-3">
                            <div class="w-10 h-10 bg-yellow-100 rounded-lg flex items-center justify-center">
                                <svg class="w-5 h-5 text-yellow-600" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 11a7 7 0 01-7 7m0 0a7 7 0 01-7-7m7 7v4m0 0H8m4 0h4m-4-8a3 3 0 01-3-3V5a3 3 0 116 0v6a3 3 0 01-3 3z" />
                                </svg>
                            </div>
                            <span class="text-gray-700 font-medium">Mentorat actif</span>
                        </div>
                        <div class="flex items-center space-x-3">
                            <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center">
                                <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4" />
                                </svg>
                            </div>
                            <span class="text-gray-700 font-medium">Projets collaboratifs</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Featured Projects Section -->
    @if($featuredProjects->count() > 0)
    <section class="py-20 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-4xl md:text-5xl font-bold text-gray-900 dark:text-white mb-4">
                    Projets <span class="text-transparent bg-clip-text bg-gradient-to-r from-red-600 to-red-500">Vedettes</span>
                </h2>
                <p class="text-lg text-gray-600 dark:text-gray-400 max-w-3xl mx-auto">
                    Découvrez les projets les plus populaires de notre communauté Laravel Sénégal
                </p>
            </div>

            <div class="grid gap-6 md:grid-cols-2 lg:grid-cols-4">
                @foreach($featuredProjects as $project)
                <a href="{{ route('projects.show', $project->slug) }}" class="group h-full">
                    <div class="bg-white dark:bg-zinc-800 rounded-xl shadow-md hover:shadow-2xl ring-1 ring-gray-200 dark:ring-zinc-700 overflow-hidden transition-all duration-300 hover:scale-105 h-full flex flex-col">
                        
                        <!-- Image Container -->
                        <div class="relative w-full h-48 bg-gradient-to-br from-gray-200 to-gray-300 dark:from-zinc-700 dark:to-zinc-800 overflow-hidden">
                            @if($project->image_url && file_exists(public_path($project->image_url)))
                                <img 
                                    src="{{ $project->image_url }}" 
                                    alt="{{ $project->title }}"
                                    class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-300"
                                >
                            @else
                                <!-- Placeholder -->
                                <div class="w-full h-full flex items-center justify-center bg-gradient-to-br from-red-100 to-orange-100 dark:from-red-950 dark:to-orange-950">
                                    <div class="text-center">
                                        <svg class="w-12 h-12 text-red-400 dark:text-red-600 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                        </svg>
                                        <p class="text-xs text-red-600 dark:text-red-400 font-medium">Pas d'image</p>
                                    </div>
                                </div>
                            @endif

                            <!-- Category Badge -->
                            @if($project->category)
                            <div class="absolute top-3 right-3">
                                <span class="inline-block bg-red-600 text-white text-xs font-semibold px-3 py-1 rounded-full shadow-lg">
                                    {{ $project->category->name }}
                                </span>
                            </div>
                            @endif
                        </div>

                        <!-- Content Container -->
                        <div class="p-5 flex flex-col flex-grow">
                            <!-- Title -->
                            <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-2 group-hover:text-red-600 dark:group-hover:text-red-500 transition-colors line-clamp-2">
                                {{ $project->title }}
                            </h3>

                            <!-- Description -->
                            <p class="text-sm text-gray-600 dark:text-gray-400 mb-4 line-clamp-2 flex-grow">
                                {{ $project->excerpt ?? 'Aucune description disponible' }}
                            </p>

                            <!-- Footer -->
                            <div class="border-t border-gray-200 dark:border-zinc-700 pt-3 flex items-center justify-between">
                                <div class="flex items-center gap-2">
                                    <div class="flex items-center text-red-600 dark:text-red-500">
                                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                                        </svg>
                                        <span class="text-xs font-semibold ml-1">{{ $project->votes_count ?? 0 }}</span>
                                    </div>
                                </div>
                                <span class="text-xs text-gray-500 dark:text-gray-400 font-medium">
                                    {{ $project->user->name ?? 'Anonyme' }}
                                </span>
                            </div>
                        </div>
                    </div>
                </a>
                @endforeach
            </div>
        </div>
    </section>
    @endif


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
    <section id="contact" class="min-h-screen py-24 bg-white snap-start snap-always">
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
                                    <svg xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" class="w-6 h-6"
                                        viewBox="0 0 48 48">
                                        <path fill="#fff"
                                            d="M4.868,43.303l2.694-9.835C5.9,30.59,5.026,27.324,5.027,23.979C5.032,13.514,13.548,5,24.014,5c5.079,0.002,9.845,1.979,13.43,5.566c3.584,3.588,5.558,8.356,5.556,13.428c-0.004,10.465-8.522,18.98-18.986,18.98c-0.001,0,0,0,0,0h-0.008c-3.177-0.001-6.3-0.798-9.073-2.311L4.868,43.303z">
                                        </path>
                                        <path fill="#fff"
                                            d="M4.868,43.803c-0.132,0-0.26-0.052-0.355-0.148c-0.125-0.127-0.174-0.312-0.127-0.483l2.639-9.636c-1.636-2.906-2.499-6.206-2.497-9.556C4.532,13.238,13.273,4.5,24.014,4.5c5.21,0.002,10.105,2.031,13.784,5.713c3.679,3.683,5.704,8.577,5.702,13.781c-0.004,10.741-8.746,19.48-19.486,19.48c-3.189-0.001-6.344-0.788-9.144-2.277l-9.875,2.589C4.953,43.798,4.911,43.803,4.868,43.803z">
                                        </path>
                                        <path fill="#cfd8dc"
                                            d="M24.014,5c5.079,0.002,9.845,1.979,13.43,5.566c3.584,3.588,5.558,8.356,5.556,13.428c-0.004,10.465-8.522,18.98-18.986,18.98h-0.008c-3.177-0.001-6.3-0.798-9.073-2.311L4.868,43.303l2.694-9.835C5.9,30.59,5.026,27.324,5.027,23.979C5.032,13.514,13.548,5,24.014,5 M24.014,42.974C24.014,42.974,24.014,42.974,24.014,42.974C24.014,42.974,24.014,42.974,24.014,42.974 M24.014,42.974C24.014,42.974,24.014,42.974,24.014,42.974C24.014,42.974,24.014,42.974,24.014,42.974 M24.014,4C24.014,4,24.014,4,24.014,4C12.998,4,4.032,12.962,4.027,23.979c-0.001,3.367,0.849,6.685,2.461,9.622l-2.585,9.439c-0.094,0.345,0.002,0.713,0.254,0.967c0.19,0.192,0.447,0.297,0.711,0.297c0.085,0,0.17-0.011,0.254-0.033l9.687-2.54c2.828,1.468,5.998,2.243,9.197,2.244c11.024,0,19.99-8.963,19.995-19.98c0.002-5.339-2.075-10.359-5.848-14.135C34.378,6.083,29.357,4.002,24.014,4L24.014,4z">
                                        </path>
                                        <path fill="#40c351"
                                            d="M35.176,12.832c-2.98-2.982-6.941-4.625-11.157-4.626c-8.704,0-15.783,7.076-15.787,15.774c-0.001,2.981,0.833,5.883,2.413,8.396l0.376,0.597l-1.595,5.821l5.973-1.566l0.577,0.342c2.422,1.438,5.2,2.198,8.032,2.199h0.006c8.698,0,15.777-7.077,15.78-15.776C39.795,19.778,38.156,15.814,35.176,12.832z">
                                        </path>
                                        <path fill="#fff" fill-rule="evenodd"
                                            d="M19.268,16.045c-0.355-0.79-0.729-0.806-1.068-0.82c-0.277-0.012-0.593-0.011-0.909-0.011c-0.316,0-0.83,0.119-1.265,0.594c-0.435,0.475-1.661,1.622-1.661,3.956c0,2.334,1.7,4.59,1.937,4.906c0.237,0.316,3.282,5.259,8.104,7.161c4.007,1.58,4.823,1.266,5.693,1.187c0.87-0.079,2.807-1.147,3.202-2.255c0.395-1.108,0.395-2.057,0.277-2.255c-0.119-0.198-0.435-0.316-0.909-0.554s-2.807-1.385-3.242-1.543c-0.435-0.158-0.751-0.237-1.068,0.238c-0.316,0.474-1.225,1.543-1.502,1.859c-0.277,0.317-0.554,0.357-1.028,0.119c-0.474-0.238-2.002-0.738-3.815-2.354c-1.41-1.257-2.362-2.81-2.639-3.285c-0.277-0.474-0.03-0.731,0.208-0.968c0.213-0.213,0.474-0.554,0.712-0.831c0.237-0.277,0.316-0.475,0.474-0.791c0.158-0.317,0.079-0.594-0.04-0.831C20.612,19.329,19.69,16.983,19.268,16.045z"
                                            clip-rule="evenodd"></path>
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
                                    <svg xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" class="w-6 h-6"
                                        viewBox="0 0 48 48">
                                        <path fill="#0288D1"
                                            d="M42,37c0,2.762-2.238,5-5,5H11c-2.761,0-5-2.238-5-5V11c0-2.762,2.239-5,5-5h26c2.762,0,5,2.238,5,5V37z">
                                        </path>
                                        <path fill="#FFF"
                                            d="M12 19H17V36H12zM14.485 17h-.028C12.965 17 12 15.888 12 14.499 12 13.08 12.995 12 14.514 12c1.521 0 2.458 1.08 2.486 2.499C17 15.887 16.035 17 14.485 17zM36 36h-5v-9.099c0-2.198-1.225-3.698-3.192-3.698-1.501 0-2.313 1.012-2.707 1.99C24.957 25.543 25 26.511 25 27v9h-5V19h5v2.616C25.721 20.5 26.85 19 29.738 19c3.578 0 6.261 2.25 6.261 7.274L36 36 36 36z">
                                        </path>
                                    </svg>
                                    LinkedIn
                                </span>
                                <span class="text-xs opacity-60 group-hover:opacity-100">Suivre →</span>
                            </a>
                        </div>
                    </div>
                </div>

                <div class="space-y-6">
                    <div class="rounded-3xl border border-white/60 bg-white p-8 shadow-xl">
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

</div>
