<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Event Orbit') }} | Login</title>
    <link rel="icon" type="image/svg+xml" href="{{ asset('branding/logo-mark.svg') }}">
    <link rel="shortcut icon" href="{{ asset('branding/logo-mark.svg') }}">
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-slate-100">
    <div class="min-h-screen grid lg:grid-cols-2">
        <section class="relative hidden lg:flex overflow-hidden">
            <div class="absolute inset-0 bg-cover bg-center" style="background-image:linear-gradient(130deg, rgba(2, 6, 23, .70), rgba(8, 47, 73, .54)), url('https://images.unsplash.com/photo-1521737604893-d14cc237f11d?auto=format&fit=crop&w=1800&q=80');"></div>
            <div class="relative z-10 w-full h-full flex flex-col justify-between p-14 text-white">
                <a href="{{ route('home') }}" class="inline-flex items-center gap-3">
                    <img src="{{ asset('branding/logo-mark.svg') }}" alt="Event Orbit" class="h-10 w-10 rounded-md bg-white/15 p-1.5">
                    <span class="text-2xl font-semibold tracking-wide">Event Orbit</span>
                </a>

                <div class="max-w-xl">
                    <p class="text-sm uppercase tracking-[0.28em] text-cyan-100/90 mb-4">Professional Event Operations</p>
                    <h1 class="text-4xl xl:text-5xl leading-tight font-bold mb-5">Plan. Coordinate. Deliver exceptional events with your team.</h1>
                    <p class="text-base text-slate-100/90">Secure admin console for managers, coordinators, finance, and support staff.</p>
                </div>
            </div>
        </section>

        <section class="flex items-center justify-center p-6 sm:p-10">
            <div class="w-full max-w-md">
                <div class="mb-8 lg:hidden text-center">
                    <a href="{{ route('home') }}" class="inline-flex items-center justify-center gap-3">
                        <img src="{{ asset('branding/logo-mark.svg') }}" alt="Event Orbit" class="h-10 w-10">
                        <span class="text-xl font-semibold text-slate-900">Event Orbit</span>
                    </a>
                </div>

                <div class="bg-white shadow-2xl shadow-slate-300/60 rounded-2xl border border-slate-200 px-6 sm:px-8 py-8">
                    <h2 class="text-2xl font-bold text-slate-900">Welcome Back</h2>
                    <p class="text-sm text-slate-500 mt-1 mb-7">Sign in to access your admin panel.</p>

                    <x-auth-session-status class="mb-4" :status="session('status')" />

                    <form method="POST" action="{{ route('login') }}" class="space-y-5">
                        @csrf

                        <div>
                            <label for="email" class="block text-sm font-medium text-slate-700 mb-2">{{ __('Email') }}</label>
                            <div class="relative">
                                <span class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3 text-slate-400">
                                    <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor"><path d="M4 6h16v12H4z" stroke-width="1.8"/><path d="m4 7 8 7 8-7" stroke-width="1.8"/></svg>
                                </span>
                                <input id="email" name="email" type="email" value="{{ old('email') }}" required autofocus autocomplete="username" class="w-full rounded-xl border border-slate-300 pl-11 pr-4 py-3 text-slate-900 focus:border-cyan-600 focus:ring-cyan-600" placeholder="you@company.com">
                            </div>
                            @error('email') <p class="mt-2 text-sm text-red-600">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label for="password" class="block text-sm font-medium text-slate-700 mb-2">{{ __('Password') }}</label>
                            <div class="relative">
                                <span class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3 text-slate-400">
                                    <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor"><rect x="4" y="10" width="16" height="10" rx="2" stroke-width="1.8"/><path d="M8 10V7a4 4 0 0 1 8 0v3" stroke-width="1.8"/></svg>
                                </span>
                                <input id="password" name="password" type="password" required autocomplete="current-password" class="w-full rounded-xl border border-slate-300 pl-11 pr-4 py-3 text-slate-900 focus:border-cyan-600 focus:ring-cyan-600" placeholder="Enter your password">
                            </div>
                            @error('password') <p class="mt-2 text-sm text-red-600">{{ $message }}</p> @enderror
                        </div>

                        <div class="flex items-center justify-between">
                            <label for="remember_me" class="inline-flex items-center">
                                <input id="remember_me" type="checkbox" class="rounded border-slate-300 text-cyan-700 shadow-sm focus:ring-cyan-600" name="remember" @checked(old('remember'))>
                                <span class="ms-2 text-sm text-slate-600">{{ __('Remember me') }}</span>
                            </label>
                            @if (Route::has('password.request'))
                                <a class="underline text-sm text-slate-600 hover:text-slate-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-cyan-500" href="{{ route('password.request') }}">
                                    {{ __('Forgot your password?') }}
                                </a>
                            @endif
                        </div>

                        <button type="submit" class="w-full rounded-xl bg-slate-900 text-white font-semibold py-3.5 tracking-wide hover:bg-slate-700 transition-colors duration-200">
                            {{ __('Log in') }}
                        </button>
                    </form>
                </div>
            </div>
        </section>
    </div>
</body>
</html>
