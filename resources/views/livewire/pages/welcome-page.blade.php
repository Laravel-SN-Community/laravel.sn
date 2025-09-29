<div class="min-h-screen bg-gradient-to-br from-red-50 via-white to-green-50">
    <!-- Navigation Header -->
    <nav class="bg-white shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <div class="flex items-center space-x-3">
                    <img src="{{ asset('images/Laravelsn.jpg') }}" alt="Laravel Senegal" class="h-10 w-10 rounded-full object-cover">
                    <h1 class="text-xl font-bold text-gray-900">Laravel Senegal</h1>
                </div>
                <div class="flex items-center space-x-8">
                    <!-- Navigation links - hidden on mobile, visible on desktop -->
                    <div class="hidden md:flex items-center space-x-8">
                        <a href="#presentation" class="text-gray-900 font-bold hover:text-red-600 transition-colors">{{ __('Presentation') }}</a>
                        <a href="#newsletter" class="text-gray-900 font-bold hover:text-red-600 transition-colors">{{ __('Newsletter') }}</a>
                        <!-- Vertical divider -->
                        <div class="h-6 w-px bg-gray-300"></div>
                    </div>
                    <!-- GitHub icon - always visible -->
                    <a href="https://github.com/Laravel-SN-Community/laravel.sn" target="_blank" class="text-gray-900 hover:text-red-600 transition-colors" title="GitHub">
                        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 0c-6.626 0-12 5.373-12 12 0 5.302 3.438 9.8 8.207 11.387.599.111.793-.261.793-.577v-2.234c-3.338.726-4.033-1.416-4.033-1.416-.546-1.387-1.333-1.756-1.333-1.756-1.089-.745.083-.729.083-.729 1.205.084 1.839 1.237 1.839 1.237 1.07 1.834 2.807 1.304 3.492.997.107-.775.418-1.305.762-1.604-2.665-.305-5.467-1.334-5.467-5.931 0-1.311.469-2.381 1.236-3.221-.124-.303-.535-1.524.117-3.176 0 0 1.008-.322 3.301 1.23.957-.266 1.983-.399 3.003-.404 1.02.005 2.047.138 3.006.404 2.291-1.552 3.297-1.23 3.297-1.23.653 1.653.242 2.874.118 3.176.77.84 1.235 1.911 1.235 3.221 0 4.609-2.807 5.624-5.479 5.921.43.372.823 1.102.823 2.222v3.293c0 .319.192.694.801.576 4.765-1.589 8.199-6.086 8.199-11.386 0-6.627-5.373-12-12-12z"/>
                        </svg>
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="relative min-h-screen flex items-center justify-center text-center bg-gradient-to-br from-gray-50 to-white overflow-hidden">
        <!-- Grid Background -->
        <div class="absolute inset-0 opacity-20">
            <div class="absolute inset-0" style="background-image: 
                linear-gradient(to right, #9ca3af 1px, transparent 1px),
                linear-gradient(to bottom, #9ca3af 1px, transparent 1px);
                background-size: 20px 20px;">
            </div>
        </div>
        
        <!-- Gradient overlay from top to white -->
        <div class="absolute inset-0" style="background: linear-gradient(to bottom, transparent 0%, transparent 30%, rgba(255,255,255,0.7) 60%, white 100%);"></div>
        
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
                <a href="#presentation" class="inline-block bg-red-600 text-white px-8 py-4 rounded-lg text-lg font-semibold hover:bg-red-700 transform hover:scale-105 transition-all duration-300 shadow-lg hover:shadow-xl scroll-smooth">
                    Découvrir la communauté
                </a>
                <a href="https://chat.whatsapp.com/JwITxALLv0uJIGNu7AsVnx" target="_blank" class="inline-block border-2 border-red-600 text-red-600 px-8 py-4 rounded-lg text-lg font-semibold hover:bg-red-600 hover:text-white transition-all duration-300">
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
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M18 18.72a9.094 9.094 0 0 0 3.741-.479 3 3 0 0 0-4.682-2.72m.94 3.198.001.031c0 .225-.012.447-.037.666A11.944 11.944 0 0 1 12 21c-2.17 0-4.207-.576-5.963-1.584A6.062 6.062 0 0 1 6 18.719m12 0a5.971 5.971 0 0 0-.941-3.197m0 0A5.995 5.995 0 0 0 12 12.75a5.995 5.995 0 0 0-5.058 2.772m0 0a3 3 0 0 0-4.681 2.72 8.986 8.986 0 0 0 3.74.477m.94-3.197a5.971 5.971 0 0 0-.94 3.197M15 6.75a3 3 0 1 1-6 0 3 3 0 0 1 6 0Zm6 3a2.25 2.25 0 1 1-4.5 0 2.25 2.25 0 0 1 4.5 0Zm-13.5 0a2.25 2.25 0 1 1-4.5 0 2.25 2.25 0 0 1 4.5 0Z" />
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
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
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
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
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
    <section id="newsletter" class="py-20 bg-gray-50">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h2 class="text-4xl font-bold text-gray-900 mb-4">Newsletter</h2>
            <p class="text-lg text-gray-600 mb-8">
                Restez informé des dernières actualités, événements et ressources Laravel Sénégal
            </p>
            
            <div class="bg-white p-8 rounded-lg shadow-md max-w-md mx-auto">
                <form wire:submit="subscribe" class="space-y-4">
                    <div>
                        <input
                            type="email"
                            wire:model="email"
                            placeholder="Votre adresse email"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-transparent"
                            required
                        >
                        @error('email')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <button
                        type="submit"
                        class="w-full bg-red-600 text-white px-6 py-3 rounded-lg font-semibold hover:bg-red-700 transition-colors disabled:opacity-50"
                        wire:loading.attr="disabled"
                    >
                        <span wire:loading.remove>S'abonner à la newsletter</span>
                        <span wire:loading>Inscription en cours...</span>
                    </button>
                </form>


            </div>
        </div>
    </section>

    <!-- Contact Section -->
    <section id="contact" class="py-20 bg-white">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-4xl font-bold text-gray-900 mb-4">Contact</h2>
                <p class="text-lg text-gray-600">Rejoignez-nous et restons en contact</p>
            </div>
            
            <div class="grid md:grid-cols-2 gap-8">
                <div class="space-y-6">
                    <div class="flex items-start space-x-4">
                        <div class="w-12 h-12 bg-red-100 rounded-lg flex items-center justify-center flex-shrink-0">
                            <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                            </svg>
                        </div>
                        <div>
                            <h3 class="font-semibold text-gray-900">Email</h3>
                            <p class="text-gray-600">laravelsenegal@gmail.com</p>
                        </div>
                    </div>
                    
                    <div class="flex items-start space-x-4">
                        <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center flex-shrink-0">
                            <svg class="w-6 h-6 text-blue-600" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M24 4.557c-.883.392-1.832.656-2.828.775 1.017-.609 1.798-1.574 2.165-2.724-.951.564-2.005.974-3.127 1.195-.897-.957-2.178-1.555-3.594-1.555-3.179 0-5.515 2.966-4.797 6.045-4.091-.205-7.719-2.165-10.148-5.144-1.29 2.213-.669 5.108 1.523 6.574-.806-.026-1.566-.247-2.229-.616-.054 2.281 1.581 4.415 3.949 4.89-.693.188-1.452.232-2.224.084.626 1.956 2.444 3.379 4.6 3.419-2.07 1.623-4.678 2.348-7.29 2.04 2.179 1.397 4.768 2.212 7.548 2.212 9.142 0 14.307-7.721 13.995-14.646.962-.695 1.797-1.562 2.457-2.549z"/>
                            </svg>
                        </div>
                        <div>
                            <h3 class="font-semibold text-gray-900">Twitter</h3>
                            <p class="text-gray-600">@laravel_sn</p>
                        </div>
                    </div>
                </div>
                
                <div class="bg-gray-50 p-6 rounded-lg">
                    <h3 class="text-xl font-semibold text-gray-900 mb-4">Rejoignez notre communauté</h3>
                    <p class="text-gray-600 mb-6">
                        Participez à nos discussions, partagez vos projets et apprenez avec d'autres développeurs Laravel au Sénégal.
                    </p>
                    <div class="space-y-3">
                        <a href="https://chat.whatsapp.com/JwITxALLv0uJIGNu7AsVnx" class="block w-full bg-red-600 text-white text-center px-4 py-2 rounded-lg hover:bg-red-700 transition-colors">
                            Rejoindre notre canal WhatsApp
                        </a>
                        <a href="https://x.com/laravel_sn" class="block w-full bg-blue-500 text-white text-center px-4 py-2 rounded-lg hover:bg-blue-600 transition-colors">
                            Suivre sur Twitter
                        </a>
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
                    <img src="{{ asset('images/Laravelsn.jpg') }}" alt="Laravel Senegal" class="h-8 w-8 rounded-full object-cover">
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
