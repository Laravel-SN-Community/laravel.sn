<div class="min-h-screen bg-gradient-to-br from-red-50 via-white to-green-50">
    <!-- Navigation Header -->
    <nav class="bg-white shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <div class="flex items-center space-x-3">
                    <img src="{{ asset('images/Laravelsn.jpg') }}" alt="Laravel Senegal" class="h-10 w-10 rounded-full object-cover">
                    <h1 class="text-xl font-bold text-gray-900">Laravel Senegal</h1>
                </div>
                <div class="hidden md:flex space-x-8">
                    <a href="#presentation" class="text-gray-700 hover:text-red-600 transition-colors">Présentation</a>
                    <a href="#newsletter" class="text-gray-700 hover:text-red-600 transition-colors">Newsletter</a>
                    <a href="#contact" class="text-gray-700 hover:text-red-600 transition-colors">Contact</a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="relative py-20 text-center">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <img src="{{ asset('images/Laravelsn.jpg') }}" alt="Laravel Senegal" class="mx-auto h-24 w-24 rounded-full object-cover mb-8 shadow-lg">
            <h1 class="text-5xl font-bold text-gray-900 mb-6">
                Bienvenue dans la communauté 
                <span class="text-red-600">Laravel Sénégal</span>
            </h1>
            <p class="text-xl text-gray-600 mb-8 max-w-2xl mx-auto">
                Rejoignez la plus grande communauté de développeurs Laravel au Sénégal. 
                Apprenez, partagez et grandissez ensemble.
            </p>
            <a href="#presentation" class="inline-block bg-red-600 text-white px-8 py-3 rounded-lg font-semibold hover:bg-red-700 transition-colors">
                Découvrir la communauté
            </a>
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
                <div wire:click="subscribe" class="space-y-4">
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
                
                @if (session()->has('message'))
                    <div class="mt-4 p-3 bg-green-100 text-green-700 rounded-lg">
                        {{ session('message') }}
                    </div>
                @endif
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
