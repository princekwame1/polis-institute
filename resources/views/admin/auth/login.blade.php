<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="noindex, nofollow">
    <title>Sign in | PROLIS Admin</title>
    <link rel="icon" href="{{ asset('favicon.ico') }}" sizes="any">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('favicon-32x32.png') }}">
    @fonts
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-white">
    <div class="grid min-h-screen lg:grid-cols-[1.1fr_1fr]">
        {{-- Abstract brand panel --}}
        <aside class="relative hidden overflow-hidden bg-brand-950 lg:block" aria-hidden="true">
            {{-- Soft glows --}}
            <div class="login-blob absolute -left-40 -top-40 size-[36rem] rounded-full bg-brand-600/60 blur-3xl"></div>
            <div class="login-blob login-blob-slow absolute -bottom-48 -right-40 size-[34rem] rounded-full bg-brand-500/30 blur-3xl"></div>

            {{-- One large shield from the logo outline --}}
            <svg class="absolute -bottom-24 -right-24 w-[34rem] text-white/[0.06]" viewBox="0 0 328 300" fill="none">
                <path d="M0 6 76 30V0l88 26 88-26v30l76-24v150c0 92-70 150-164 196C70 306 0 248 0 156Z" stroke="currentColor" stroke-width="3" />
            </svg>

            {{-- Message --}}
            <div class="relative flex h-full flex-col justify-between p-12 text-white xl:p-16">
                <a href="{{ route('home') }}" class="flex items-center gap-3">
                    <img src="{{ asset('images/preloader-logo.png') }}" alt="" class="size-12 rounded-full ring-4 ring-white/10">
                    <span class="font-display text-lg font-extrabold">PROLIS Institute</span>
                </a>

                <div class="max-w-md">
                    <p class="text-xs font-extrabold uppercase tracking-[0.25em] text-brand-200">Admin dashboard</p>
                    <h2 class="mt-4 text-4xl font-extrabold leading-tight xl:text-5xl">Keep the website fresh, one update at a time.</h2>
                    <p class="mt-5 text-lg leading-relaxed text-brand-100">Reply to enquiries, publish news, update courses and manage the home page, all from one place.</p>
                </div>

                <p class="font-display text-sm font-bold text-brand-200">{{ config('prolis.tagline') }}</p>
            </div>
        </aside>

        {{-- Form --}}
        <main class="relative flex items-center justify-center overflow-hidden px-6 py-12 sm:px-12">
            {{-- Soft abstract shapes behind the form on small screens --}}
            <div class="absolute -right-24 -top-24 size-72 rounded-full bg-brand-100 blur-3xl lg:hidden" aria-hidden="true"></div>
            <div class="absolute -bottom-24 -left-24 size-72 rounded-full bg-brand-50 blur-3xl" aria-hidden="true"></div>

            <div class="relative w-full max-w-sm">
                <img src="{{ asset('images/logo.png') }}" alt="PROLIS Institute" class="h-14 w-auto">

                <h1 class="mt-10 text-3xl font-extrabold">Welcome back</h1>
                <p class="mt-2 text-muted">Sign in to manage the PROLIS Institute website.</p>

                @if (session('status'))
                    <div role="status" class="mt-6 flex items-center gap-2 rounded-xl border border-green-200 bg-green-50 p-3 text-sm font-semibold text-green-800">
                        <x-icon name="check-circle" class="size-5 shrink-0" /> {{ session('status') }}
                    </div>
                @endif

                @if ($errors->any())
                    <div role="alert" class="mt-6 flex items-start gap-2 rounded-xl border border-red-200 bg-red-50 p-3 text-sm font-semibold text-red-700">
                        <x-icon name="lock" class="mt-0.5 size-4 shrink-0" /> {{ $errors->first() }}
                    </div>
                @endif

                <form method="POST" action="{{ route('admin.login.store') }}" class="mt-8 grid gap-5">
                    @csrf

                    <div>
                        <label for="email" class="form-label">Email address</label>
                        <div class="relative">
                            <x-icon name="mail" class="pointer-events-none absolute left-4 top-1/2 size-5 -translate-y-1/2 text-gray-400" />
                            <input id="email" name="email" type="email" value="{{ old('email') }}" required autofocus autocomplete="username" placeholder="you@prolisinstitute.com" @class(['form-input pl-12', 'border-red-400' => $errors->has('email')])>
                        </div>
                    </div>

                    <div>
                        <label for="password" class="form-label">Password</label>
                        <div class="relative">
                            <x-icon name="lock" class="pointer-events-none absolute left-4 top-1/2 size-5 -translate-y-1/2 text-gray-400" />
                            <input id="password" name="password" type="password" required autocomplete="current-password" placeholder="Your password" @class(['form-input pl-12 pr-12', 'border-red-400' => $errors->has('password')])>
                            <button type="button" data-password-toggle="password" class="absolute right-2 top-1/2 grid size-9 -translate-y-1/2 place-items-center rounded-lg text-gray-400 hover:bg-gray-100 hover:text-brand-700" aria-label="Show password" aria-pressed="false">
                                <x-icon name="eye" class="size-5" />
                            </button>
                        </div>
                    </div>

                    <label class="flex items-center gap-2 text-sm font-semibold text-muted">
                        <input type="checkbox" name="remember" value="1" @checked(old('remember')) class="size-4 accent-brand-600"> Keep me signed in
                    </label>

                    <button type="submit" class="btn-primary mt-2 w-full py-3.5 text-base">Sign in <x-icon name="arrow" class="size-4" /></button>
                </form>

                <p class="mt-10 border-t border-gray-100 pt-6 text-sm text-muted">
                    Trouble signing in? Contact
                    <a href="mailto:{{ config('prolis.contact.email') }}" class="font-bold text-brand-600 hover:underline">{{ config('prolis.contact.email') }}</a>
                    for help.
                </p>

                <a href="{{ route('home') }}" class="mt-4 inline-flex items-center gap-1.5 text-sm font-bold text-muted hover:text-ink">
                    <x-icon name="arrow-left" class="size-4" /> Back to the website
                </a>
            </div>
        </main>
    </div>
</body>
</html>
