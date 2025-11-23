{{-- <x-slot:title>Home</x-slot:title> --}}
<div class="min-h-screen">

        <!-- Content Container -->
        <div class="w-full max-w-7xl mx-auto px-8 sm:px-12 lg:px-16 py-20">
            <div class="max-w-4xl">
                <!-- Label -->
                <div class="inline-flex items-center gap-2 mb-8">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-5 w-5 text-red-500">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M17.25 6.75 22.5 12l-5.25 5.25m-10.5 0L1.5 12l5.25-5.25m7.5-3-4.5 16.5" />
                    </svg>
                    <span class="text-sm font-medium text-red-600 uppercase tracking-wider">Laravel Senegal</span>
                </div>

                <!-- Main Title -->
                <h1 class="text-6xl md:text-7xl lg:text-8xl font-bold text-gray-900 mb-10 leading-[1.1] tracking-tight">
                    {{ __('Laravel Senegal') }}
                </h1>

                <!-- Subtitle -->
                <p class="text-2xl md:text-3xl lg:text-4xl text-gray-700 mb-12 font-light leading-relaxed max-w-3xl">
                    {{ __('Welcome to the largest community of developers') }}
                    <span class="text-red-600 font-normal">Laravel</span> {{ __('in Senegal') }}
                </p>

                <!-- Description -->
                <p class="text-xl md:text-2xl text-gray-600 mb-16 max-w-2xl leading-relaxed font-light">
                    {{ __('Join a dynamic community of') }} <span class="font-medium text-gray-900">500+</span>
                    {{ __('passionate about Laravel. Participate in our events, share your projects and accelerate your career in web development.') }}
                </p>

                <!-- CTA Buttons -->
                <div class="flex flex-col sm:flex-row gap-6 items-start">
                    <a href="#presentation"
                        class="inline-flex items-center justify-center bg-red-600 text-white px-10 py-5 rounded-xl text-lg font-semibold hover:bg-red-700 transition-all duration-200 shadow-sm hover:shadow-md group">
                        {{ __('Discover the community') }}
                        <svg class="w-5 h-5 ml-2 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                        </svg>
                    </a>
                    <a href="https://chat.whatsapp.com/JwITxALLv0uJIGNu7AsVnx" target="_blank"
                        class="inline-flex items-center justify-center border-2 border-gray-300 text-gray-900 px-10 py-5 rounded-xl text-lg font-semibold hover:border-red-600 hover:text-red-600 transition-all duration-200">
                        {{ __('Join the WhatsApp community') }}
                    </a>
                </div>
            </div>
        </div>
       
        <div class="max-w-7xl mx-auto px-8 sm:px-12 lg:px-16">
            <!-- Header -->
            <div class="max-w-4xl mb-20">
                <div class="inline-flex items-center gap-2 mb-8">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-5 w-5 text-red-500">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M17.25 6.75 22.5 12l-5.25 5.25m-10.5 0L1.5 12l5.25-5.25m7.5-3-4.5 16.5" />
                    </svg>
                    <span class="text-sm font-medium text-red-600 uppercase tracking-wider">{{ __('Community') }}</span>
                </div>

                <h2 class="text-5xl md:text-6xl lg:text-7xl font-bold text-gray-900 mb-8 leading-[1.1] tracking-tight">
                    {{ __('A Vibrant Community') }}
                </h2>

                <p class="text-xl md:text-2xl text-gray-600 leading-relaxed font-light max-w-2xl">
                    {{ __('Gather, form and inspire the next generation of Laravel developers in Senegal') }}
                </p>
            </div>

            <!-- Event Gallery Carousel -->
            <livewire:pages.gallery.auto-scroll-event-image />
        </div>

</div>
