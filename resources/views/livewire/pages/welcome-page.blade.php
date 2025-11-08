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
                {{ __('Laravel Senegal') }}
            </h1>

            <!-- Subtitle -->
            <p class="text-xl md:text-2xl lg:text-3xl text-gray-700 mb-8 font-light max-w-4xl mx-auto">
                {{ __('Welcome to the largest community of developers') }}
                <span class="text-red-600 font-semibold">Laravel</span> {{ __('in Senegal') }}
            </p>

            <!-- Description -->
            <p class="text-lg md:text-xl text-gray-600 mb-10 max-w-3xl mx-auto leading-relaxed">
                {{ __('Join a dynamic community of') }} <span class="font-semibold text-gray-800">500+ developers</span>
                {{ __('passionate about Laravel. Participate in our events, share your projects and
                accelerate your career in web development.') }}
            </p>

            <!-- CTA Buttons -->
            <div class="flex flex-col sm:flex-row gap-4 justify-center items-center mb-16">
                <a href="#presentation"
                    class="inline-block bg-red-600 text-white px-8 py-4 rounded-lg text-lg font-semibold hover:bg-red-700 transform hover:scale-105 transition-all duration-300 shadow-lg hover:shadow-xl scroll-smooth">
                    {{ __('Discover the community') }}
                </a>
                <a href="https://chat.whatsapp.com/JwITxALLv0uJIGNu7AsVnx" target="_blank"
                    class="inline-block border-2 border-red-600 text-red-600 px-8 py-4 rounded-lg text-lg font-semibold hover:bg-red-600 hover:text-white transition-all duration-300">
                    {{ __('Join the WhatsApp community') }}
                </a>
            </div>

        </div>

    </section>

    <!-- Presentation Section -->
    <section id="presentation"
        class="py-16 md:py-20 bg-gradient-to-br from-white via-red-50/30 to-green-50/30 snap-start snap-always">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Header avec badge -->
            <div class="text-center mb-12">
                <h2 class="text-4xl md:text-5xl font-bold text-gray-900 mb-4">
                    {{ __('A Vibrant Community') }}
                </h2>
                <p class="text-xl text-gray-600 max-w-3xl mx-auto">
                    {{ __('Gather, form and inspire the next generation of Laravel developers in Senegal') }}
                </p>
            </div>

            <!-- Event Gallery Carousel -->
            <livewire:pages.gallery.auto-scroll-event-image />
        </div>
    </section>

</div>
