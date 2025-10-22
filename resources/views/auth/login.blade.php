
<x-auth-layout>
    <x-slot:title>Login</x-slot:title>
    <div class="min-h-screen bg-gray-100">
        <div class="mx-auto flex min-h-screen w-full max-w-6xl flex-col justify-center px-4 py-12 sm:px-6 lg:px-8">
            <div class="overflow-hidden rounded-2xl bg-white shadow-2xl md:grid md:grid-cols-[3fr_2fr]">
                <!-- Left Section - Login Form -->
                <div class="flex flex-col justify-center px-8 py-12 sm:px-12 lg:px-16">
                    <div class="space-y-8">
                        <!-- Logo and Header -->
                        <a href="{{ route('welcome') }}" class="flex items-center space-x-3 hover:opacity-80 transition">
                            <img src="{{ asset('images/Laravelsn.jpg') }}" alt="Laravel Sénégal Logo"
                                class="h-10 w-10 rounded-lg object-cover">
                            <span class="text-2xl font-bold text-gray-900">Laravel Sénégal</span>
                        </a>

                        <div class="space-y-2">
                            <h1 class="text-4xl font-bold text-gray-900">{{ __('Welcome Back') }}</h1>
                            <p class="text-base text-gray-600">
                                {{ __('Enter your email and password to access your account.') }}
                            </p>
                        </div>

                        <x-validation-errors
                            class="rounded-lg border border-red-200 bg-red-50 p-4 text-sm text-red-600" />

                        @session('status')
                            <div class="rounded-lg border border-emerald-200 bg-emerald-50 p-4 text-sm text-emerald-600">
                                {{ $value }}
                            </div>
                        @endsession

                        <form method="POST" action="{{ route('login') }}" class="space-y-6">
                            @csrf

                            <div class="space-y-2">
                                <label for="email" class="block text-sm font-medium text-gray-700">
                                    {{ __('Email') }}
                                </label>
                                <input id="email" type="email" name="email" value="{{ old('email') }}" required
                                    autofocus autocomplete="username" placeholder="you@email.com"
                                    class="block w-full rounded-lg border border-gray-300 bg-gray-50 px-4 py-3 text-sm text-gray-900 placeholder-gray-500 transition focus:border-red-500 focus:bg-white focus:outline-none focus:ring-2 focus:ring-red-500/20">
                            </div>

                            <div class="space-y-2">
                                <div class="flex items-center justify-between">
                                    <label for="password" class="block text-sm font-medium text-gray-700">
                                        {{ __('Password') }}
                                    </label>
                                    @if (Route::has('password.request'))
                                        <a class="text-sm font-medium text-red-600 transition hover:text-red-500"
                                            href="{{ route('password.request') }}">
                                            {{ __('Forgot Your Password?') }}
                                        </a>
                                    @endif
                                </div>
                                <div class="relative">
                                    <input id="password" type="password" name="password" required
                                        autocomplete="current-password" placeholder="••••••••"
                                        class="block w-full rounded-lg border border-gray-300 bg-gray-50 px-4 py-3 pr-12 text-sm text-gray-900 placeholder-gray-500 transition focus:border-red-500 focus:bg-white focus:outline-none focus:ring-2 focus:ring-red-500/20">
                                    <button type="button" class="absolute inset-y-0 right-0 flex items-center pr-3">
                                        <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z">
                                            </path>
                                        </svg>
                                    </button>
                                </div>
                            </div>

                            <div class="flex items-center justify-between">
                                <label for="remember_me" class="flex items-center gap-3">
                                    <input id="remember_me" type="checkbox" name="remember"
                                        class="h-4 w-4 rounded border-gray-300 text-red-600 focus:ring-red-500">
                                    <span class="text-sm text-gray-600">{{ __('Remember Me') }}</span>
                                </label>
                            </div>

                            <button type="submit"
                                class="flex w-full items-center justify-center rounded-lg bg-gradient-to-r from-red-600 to-red-700 px-4 py-3 text-sm font-semibold text-white shadow-lg shadow-red-600/30 transition hover:from-red-700 hover:to-red-800 focus:outline-none focus:ring-2 focus:ring-red-500/70 focus:ring-offset-2">
                                {{ __('Log In') }}
                            </button>
                        </form>

                        <div class="space-y-3">
                            <p class="text-center text-sm text-gray-500">{{ __('Or Login With') }}</p>
                            <div class="grid gap-3 sm:grid-cols-2">
                                <a href="{{ route('socialite.redirect', 'google') }}"
                                    class="flex items-center justify-center gap-3 rounded-lg border border-gray-300 bg-white px-4 py-3 text-sm font-semibold text-gray-700 transition hover:border-gray-400 hover:text-gray-900 focus:outline-none focus:ring-2 focus:ring-red-500/40">
                                    <span aria-hidden="true" class="inline-flex h-5 w-5 items-center justify-center">
                                        <svg class="h-5 w-5" viewBox="0 0 24 24" aria-hidden="true">
                                            <path fill="#4285F4"
                                                d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z" />
                                            <path fill="#34A853"
                                                d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z" />
                                            <path fill="#FBBC05"
                                                d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z" />
                                            <path fill="#EA4335"
                                                d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z" />
                                        </svg>
                                    </span>
                                    <span>{{ __('Google') }}</span>
                                </a>
                                <a href="{{ route('socialite.redirect', 'github') }}"
                                    class="flex items-center justify-center gap-3 rounded-lg border border-gray-300 bg-white px-4 py-3 text-sm font-semibold text-gray-700 transition hover:border-gray-400 hover:text-gray-900 focus:outline-none focus:ring-2 focus:ring-red-500/40">
                                    <span aria-hidden="true" class="inline-flex h-5 w-5 items-center justify-center">
                                        <svg class="h-5 w-5" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                                            <path
                                                d="M12 0C5.374 0 0 5.373 0 12 0 17.302 3.438 21.8 8.207 23.387c.599.111.793-.261.793-.577v-2.234c-3.338.726-4.033-1.416-4.033-1.416-.546-1.387-1.333-1.756-1.333-1.756-1.089-.745.083-.729.083-.729 1.205.084 1.839 1.237 1.839 1.237 1.07 1.834 2.807 1.304 3.492.997.107-.775.418-1.305.762-1.604-2.665-.305-5.467-1.334-5.467-5.931 0-1.311.469-2.381 1.236-3.221-.124-.303-.535-1.524.117-3.176 0 0 1.008-.322 3.301 1.23A11.509 11.509 0 0112 5.803c1.02.005 2.047.138 3.006.404 2.291-1.552 3.297-1.23 3.297-1.23.653 1.653.242 2.874.118 3.176.77.84 1.235 1.911 1.235 3.221 0 4.609-2.807 5.624-5.479 5.921.43.372.823 1.102.823 2.222v3.293c0 .319.192.694.801.576C20.566 21.797 24 17.3 24 12c0-6.627-5.373-12-12-12z" />
                                        </svg>
                                    </span>
                                    <span>{{ __('GitHub') }}</span>
                                </a>
                            </div>
                        </div>

                        <p class="text-center text-sm text-gray-500">
                            {{ __('Don\'t Have An Account?') }}
                            <a href="{{ route('register') }}"
                                class="font-semibold text-red-600 transition hover:text-red-500">
                                {{ __('Register Now.') }}
                            </a>
                        </p>
                    </div>

                    <div class="mt-10 text-xs text-gray-400">
                        {{ __('Copyright © 2025 Laravel Sénégal Community.') }}
                    </div>
                </div>

                <!-- Right Section - Dashboard Preview -->
                <div
                    class="relative flex flex-col justify-center bg-gradient-to-br from-red-700 via-red-600 to-red-500 px-6 py-10 text-white sm:px-10 lg:px-12">
                    <div
                        class="absolute inset-0 opacity-30 [background-image:radial-gradient(circle,_rgba(255,255,255,0.15)_1px,transparent_1px)] [background-size:34px_34px]">
                    </div>
                    <div class="relative mx-auto w-full max-w-md space-y-8">
                        <div class="space-y-4 text-center">
                            <div
                                class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-white/20 backdrop-blur mb-4">
                                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                            <h2 class="text-3xl font-bold leading-tight sm:text-4xl">
                                {{ __('Welcome back to Laravel Sénégal') }}
                            </h2>
                            <p class="text-base text-white/80">
                                {{ __('Continue your journey with the community. Access your dashboard, connect with peers, and stay updated with the latest developments.') }}
                            </p>
                        </div>

                        <!-- Dashboard Features -->
                        <div class="grid grid-cols-1 gap-4">
                            <div
                                class="flex items-center space-x-3 p-4 rounded-xl bg-white/10 backdrop-blur border border-white/20">
                                <div class="flex-shrink-0">
                                    <svg class="w-6 h-6 text-red-200" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z">
                                        </path>
                                    </svg>
                                </div>
                                <div>
                                    <h3 class="font-semibold text-white">Personal Dashboard</h3>
                                    <p class="text-sm text-white/70">Track your progress and manage your profile</p>
                                </div>
                            </div>

                            <div
                                class="flex items-center space-x-3 p-4 rounded-xl bg-white/10 backdrop-blur border border-white/20">
                                <div class="flex-shrink-0">
                                    <svg class="w-6 h-6 text-red-200" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                                    </svg>
                                </div>
                                <div>
                                    <h3 class="font-semibold text-white">Latest Updates</h3>
                                    <p class="text-sm text-white/70">Stay informed about community news and events</p>
                                </div>
                            </div>

                            <div
                                class="flex items-center space-x-3 p-4 rounded-xl bg-white/10 backdrop-blur border border-white/20">
                                <div class="flex-shrink-0">
                                    <svg class="w-6 h-6 text-red-200" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z">
                                        </path>
                                    </svg>
                                </div>
                                <div>
                                    <h3 class="font-semibold text-white">Community Access</h3>
                                    <p class="text-sm text-white/70">Connect with developers and share knowledge</p>
                                </div>
                            </div>
                        </div>

                        <!-- Call to Action -->
                        <div class="text-center">
                            <div class="inline-flex items-center space-x-2 text-sm text-white/70">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                <span>{{ __('Welcome back! Your community awaits') }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-auth-layout>
