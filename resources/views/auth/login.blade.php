<x-guest-layout>
    <div class="min-h-screen bg-slate-100">
        <div class="mx-auto flex min-h-screen w-full max-w-6xl flex-col justify-center px-4 py-12 sm:px-6 lg:px-8">
            <div class="overflow-hidden rounded-3xl bg-white shadow-xl md:grid md:grid-cols-2">
                <div class="flex flex-col justify-center px-6 py-10 sm:px-10 lg:px-12">
                    <div class="space-y-8">
                        <div class="space-y-2">
                            <h1 class="text-3xl font-semibold text-slate-900 sm:text-4xl">{{ __('Welcome Back') }}</h1>
                            <p class="text-base text-slate-600">
                                {{ __('Sign in to stay connected with the Laravel Sénégal community and access your workspace.') }}
                            </p>
                        </div>

                        <x-validation-errors class="rounded-lg border border-red-200 bg-red-50 p-4 text-sm text-red-600" />

                        @session('status')
                            <div class="rounded-lg border border-emerald-200 bg-emerald-50 p-4 text-sm text-emerald-600">
                                {{ $value }}
                            </div>
                        @endsession

                        <form method="POST" action="{{ route('login') }}" class="space-y-6">
                            @csrf

                            <div class="space-y-2">
                                <label for="email" class="block text-sm font-medium text-slate-700">
                                    {{ __('Email address') }}
                                </label>
                                <input
                                    id="email"
                                    type="email"
                                    name="email"
                                    value="{{ old('email') }}"
                                    required
                                    autofocus
                                    autocomplete="username"
                                    class="block w-full rounded-lg border border-slate-300 bg-white px-4 py-3 text-sm text-slate-900 shadow-sm transition focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500/60"
                                >
                            </div>

                            <div class="space-y-2">
                                <div class="flex items-center justify-between">
                                    <label for="password" class="block text-sm font-medium text-slate-700">
                                        {{ __('Password') }}
                                    </label>
                                    @if (Route::has('password.request'))
                                        <a
                                            class="text-sm font-medium text-blue-600 transition hover:text-blue-500"
                                            href="{{ route('password.request') }}"
                                        >
                                            {{ __('Forgot password?') }}
                                        </a>
                                    @endif
                                </div>
                                <input
                                    id="password"
                                    type="password"
                                    name="password"
                                    required
                                    autocomplete="current-password"
                                    class="block w-full rounded-lg border border-slate-300 bg-white px-4 py-3 text-sm text-slate-900 shadow-sm transition focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500/60"
                                >
                            </div>

                            <label for="remember_me" class="flex items-center gap-3">
                                <input
                                    id="remember_me"
                                    type="checkbox"
                                    name="remember"
                                    class="h-4 w-4 rounded border-slate-300 text-blue-600 focus:ring-blue-500"
                                >
                                <span class="text-sm text-slate-600">{{ __('Remember me') }}</span>
                            </label>

                            <button
                                type="submit"
                                class="flex w-full items-center justify-center rounded-lg bg-blue-600 px-4 py-3 text-sm font-semibold text-white shadow-lg shadow-blue-600/30 transition hover:bg-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500/70 focus:ring-offset-2"
                            >
                                {{ __('Log in') }}
                            </button>
                        </form>

                        <div class="space-y-3">
                            <p class="text-xs font-semibold uppercase tracking-wide text-slate-400">{{ __('Or continue with') }}</p>
                            <div class="grid gap-3 sm:grid-cols-2">
                                <a
                                    href="#"
                                    class="flex items-center justify-center gap-3 rounded-lg border border-slate-300 bg-white px-4 py-3 text-sm font-semibold text-slate-700 transition hover:border-blue-200 hover:text-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500/40"
                                >
                                    <span aria-hidden="true" class="inline-flex h-5 w-5 items-center justify-center">
                                        <svg class="h-5 w-5" viewBox="0 0 24 24" aria-hidden="true">
                                            <path fill="#EA4335" d="M12 11h11c.06.32.09.65.09 1 0 5.52-4.48 10-10 10a9.99 9.99 0 01-9.45-6.9l3.89-3.02A5.99 5.99 0 0012 17c1.62 0 3.09-.62 4.21-1.64L12 11z" />
                                            <path fill="#34A853" d="M2.55 14.1A9.99 9.99 0 0112 2c2.7 0 5.15 1.06 6.93 2.78l-3.54 3.54A5.96 5.96 0 0012 5c-2.45 0-4.51 1.58-5.26 3.78l-4.19-3.24z" />
                                            <path fill="#FBBC05" d="M6.74 8.78A5.98 5.98 0 006 11c0 .74.13 1.44.34 2.1l-3.89 3.02A9.98 9.98 0 012 11c0-1.12.19-2.2.55-3.19l4.19 3.24z" />
                                            <path fill="#4285F4" d="M23 12c0-.34-.03-.68-.09-1H12V8h11a10 10 0 010 4z" />
                                        </svg>
                                    </span>
                                    <span>{{ __('Google') }}</span>
                                </a>
                                <a
                                    href="#"
                                    class="flex items-center justify-center gap-3 rounded-lg border border-slate-300 bg-white px-4 py-3 text-sm font-semibold text-slate-700 transition hover:border-blue-200 hover:text-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500/40"
                                >
                                    <span aria-hidden="true" class="inline-flex h-5 w-5 items-center justify-center">
                                        <svg class="h-5 w-5" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                                            <path d="M16.365 2c-.917.063-2.014.63-2.64 1.353-.575.667-1.089 1.762-.9 2.79.964.03 1.959-.55 2.541-1.28.601-.742 1.056-1.835.999-2.863zM19.7 10.28c-.03-2.97 2.431-4.403 2.544-4.472-1.391-2.03-3.553-2.307-4.31-2.343-1.836-.144-3.585 1.085-4.516 1.085-.949 0-2.394-1.06-3.933-1.03-2.022.03-3.886 1.178-4.924 3.005-2.114 3.666-.538 9.09 1.52 12.077 1.008 1.454 2.211 3.084 3.778 3.024 1.52-.06 2.09-.98 3.93-.98 1.82 0 2.36.98 3.94.95 1.63-.03 2.66-1.48 3.66-2.94 1.15-1.68 1.62-3.31 1.65-3.39-.04-.02-3.17-1.22-3.2-4.986z" />
                                        </svg>
                                    </span>
                                    <span>{{ __('Apple') }}</span>
                                </a>
                            </div>
                        </div>

                        <p class="text-sm text-slate-500">
                            {{ __('Don\'t have an account?') }}
                            <a href="{{ route('register') }}" class="font-semibold text-blue-600 transition hover:text-blue-500">
                                {{ __('Register now') }}
                            </a>
                        </p>
                    </div>

                    <div class="mt-10 flex flex-wrap gap-x-6 gap-y-2 text-xs text-slate-400">
                        <a href="#" class="hover:text-blue-600">{{ __('Help Center') }}</a>
                        <a href="#" class="hover:text-blue-600">{{ __('Terms') }}</a>
                        <a href="#" class="hover:text-blue-600">{{ __('Privacy') }}</a>
                    </div>
                </div>

                <div class="relative flex flex-col justify-center bg-gradient-to-br from-blue-700 via-blue-600 to-blue-500 px-6 py-10 text-white sm:px-10 lg:px-12">
                    <div class="absolute inset-0 opacity-30 [background-image:radial-gradient(circle,_rgba(255,255,255,0.15)_1px,transparent_1px)] [background-size:34px_34px]"></div>
                    <div class="relative mx-auto w-full max-w-md space-y-6 text-center">
                        <div class="space-y-4">
                            <span class="inline-flex items-center justify-center rounded-full bg-white/15 px-3 py-1 text-xs font-semibold uppercase tracking-wider text-white/80">
                                {{ __('Laravel Sénégal') }}
                            </span>
                            <h2 class="text-3xl font-semibold leading-tight sm:text-4xl">
                                {{ __('Build together. Grow together.') }}
                            </h2>
                            <p class="text-base text-white/80">
                                {{ __('Connect with artisans across Sénégal and access resources that elevate your Laravel projects.') }}
                            </p>
                        </div>

                        <div class="relative mx-auto mt-8 w-full max-w-[360px] rounded-2xl bg-white/10 p-6 shadow-xl shadow-blue-900/20 backdrop-blur">
                            <div class="rounded-xl border border-white/30 bg-white/5 p-6">
                                <img
                                    src="{{ asset('images/Laravelsn.png') }}"
                                    alt="Logo de la communauté Laravel Sénégal"
                                    class="mx-auto max-w-[220px] sm:max-w-[260px] md:max-w-[320px] lg:max-w-[360px]"
                                >
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-guest-layout>
