@props(['title' => null, 'description' => null, 'image' => null, 'imageAlt' => null, 'type' => 'website', 'head' => null])

@php
    $site = config('prolis');
    $pageTitle = $title ? "{$title} | {$site['name']}" : "{$site['name']} | {$site['full_name']}";
    $metaDescription = $description ?: 'PROLIS Institute provides professional short courses in communication, public relations, digital marketing, branding, events, leadership and project management in Accra and Sunyani, Ghana.';
    $canonicalUrl = request()->integer('page') > 1 ? url()->current().'?page='.request()->integer('page') : url()->current();
    $shareImage = $image ?: asset('images/badge.png');
@endphp

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $pageTitle }}</title>
    <meta name="description" content="{{ $metaDescription }}">
    <meta name="theme-color" content="#7b2181">
    <link rel="canonical" href="{{ $canonicalUrl }}">

    <meta property="og:site_name" content="{{ $site['name'] }}">
    <meta property="og:locale" content="en_GB">
    <meta property="og:type" content="{{ $type }}">
    <meta property="og:title" content="{{ $title ?? $pageTitle }}">
    <meta property="og:description" content="{{ $metaDescription }}">
    <meta property="og:url" content="{{ $canonicalUrl }}">
    <meta property="og:image" content="{{ $shareImage }}">
    <meta property="og:image:alt" content="{{ $imageAlt ?? $title ?? $site['name'] }}">

    <meta name="twitter:card" content="{{ $image ? 'summary_large_image' : 'summary' }}">
    <meta name="twitter:title" content="{{ $title ?? $pageTitle }}">
    <meta name="twitter:description" content="{{ $metaDescription }}">
    <meta name="twitter:image" content="{{ $shareImage }}">
    <meta name="twitter:image:alt" content="{{ $imageAlt ?? $title ?? $site['name'] }}">

    {{ $head }}

    <link rel="icon" href="{{ asset('favicon.ico') }}" sizes="any">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('favicon-32x32.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('favicon-16x16.png') }}">
    <link rel="apple-touch-icon" href="{{ asset('apple-touch-icon.png') }}">
    <link rel="manifest" href="{{ asset('site.webmanifest') }}">

    @fonts

    <link rel="preload" as="image" href="{{ asset('images/preloader-logo.png') }}">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
    {{-- Preloader --}}
    <div id="preloader" role="status" aria-label="Loading">
        <div class="relative grid size-24 place-items-center">
            <span class="preloader-ring"></span>
            <img src="{{ asset('images/preloader-logo.png') }}" alt="" class="preloader-logo size-16 rounded-full">
        </div>
    </div>

    <a href="#main" class="sr-only focus:not-sr-only focus:fixed focus:left-4 focus:top-4 focus:z-50 focus:rounded-lg focus:bg-white focus:px-4 focus:py-2 focus:font-bold">Skip to content</a>

    {{-- Top bar --}}
    <div class="hidden bg-brand-900 text-xs font-semibold text-brand-100 md:block">
        <div class="container-site flex items-center justify-between py-2">
            <div class="flex items-center gap-6">
                <a href="mailto:{{ $contact['email'] }}" class="flex items-center gap-1.5 hover:text-white">
                    <x-icon name="mail" class="size-4" /> {{ $contact['email'] }}
                </a>
                <a href="tel:{{ $contact['phone_link'] }}" class="flex items-center gap-1.5 hover:text-white">
                    <x-icon name="phone" class="size-4" /> {{ $contact['phone'] }}
                </a>
                <span class="flex items-center gap-1.5">
                    <x-icon name="map" class="size-4" /> {{ $contact['locations'] }}
                </span>
            </div>
            <a href="{{ route('portal') }}" class="flex items-center gap-1.5 hover:text-white">
                <x-icon name="lock" class="size-4" /> Student Portal
            </a>
        </div>
    </div>

    {{-- Header --}}
    <header data-site-header class="sticky top-0 z-40 border-b border-brand-100/60 bg-white transition-shadow">
        <div class="container-site flex items-center justify-between gap-6 py-3">
            <a href="{{ route('home') }}" class="shrink-0" aria-label="{{ $site['name'] }} home">
                <img src="{{ asset('images/logo.png') }}" alt="{{ $site['name'] }} logo" class="h-12 w-auto sm:h-14">
            </a>

            <nav aria-label="Main" class="hidden items-center gap-6 xl:flex">
                @foreach ($site['nav'] as $routeName => $label)
                    <a href="{{ route($routeName) }}" class="nav-link" @if (request()->routeIs($routeName)) aria-current="page" @endif>{{ $label }}</a>
                @endforeach
            </nav>

            <div class="flex items-center gap-3">
                <a href="{{ route('admissions') }}#register" class="btn-primary hidden sm:inline-flex">Register Now</a>
                <button type="button" data-nav-toggle aria-expanded="false" aria-controls="mobile-menu" class="grid size-11 place-items-center rounded-xl border border-brand-100 text-brand-700 xl:hidden">
                    <span class="sr-only">Toggle menu</span>
                    <x-icon name="menu" data-icon-open />
                    <x-icon name="close" data-icon-close class="hidden size-6" />
                </button>
            </div>
        </div>

        <nav id="mobile-menu" data-nav-menu aria-label="Mobile" class="hidden border-t border-brand-100 bg-white xl:hidden">
            <div class="container-site grid gap-1 py-4">
                @foreach ($site['footer_links'] as $routeName => $label)
                    <a href="{{ route($routeName) }}" @class(['rounded-lg px-3 py-2.5 font-bold', 'bg-brand-50 text-brand-700' => request()->routeIs($routeName), 'text-ink hover:bg-brand-50' => ! request()->routeIs($routeName)])>{{ $label }}</a>
                @endforeach
                <a href="{{ route('admissions') }}#register" class="btn-primary mt-3 sm:hidden">Register Now</a>
            </div>
        </nav>
    </header>

    <main id="main">
        {{ $slot }}
    </main>

    {{-- Footer --}}
    <footer class="bg-brand-950 text-brand-100">
        <div class="container-site grid gap-12 py-16 sm:grid-cols-2 lg:grid-cols-12">
            <div class="lg:col-span-4">
                <div class="flex items-center gap-4">
                    <img src="{{ asset('images/badge.png') }}" alt="" class="size-20 rounded-full">
                    <div>
                        <p class="font-display text-xl font-extrabold text-white">{{ $site['name'] }}</p>
                        <p class="text-sm">{{ $site['full_name'] }}.</p>
                    </div>
                </div>
                <p class="mt-6 font-display text-sm font-bold text-brand-300">{{ $site['tagline'] }}</p>
                <a href="{{ route('admissions') }}#register" class="btn-light mt-6">Register Now <x-icon name="arrow" class="size-4" /></a>

                @php($socials = array_filter(['Facebook' => $contact['facebook'] ?? null, 'Instagram' => $contact['instagram'] ?? null, 'LinkedIn' => $contact['linkedin'] ?? null, 'YouTube' => $contact['youtube'] ?? null]))
                @if ($socials)
                    <ul class="mt-6 flex flex-wrap gap-2 text-xs font-bold">
                        @foreach ($socials as $network => $url)
                            <li><a href="{{ $url }}" target="_blank" rel="noopener" class="inline-block rounded-full bg-white/10 px-3 py-1.5 hover:bg-white hover:text-brand-800">{{ $network }}</a></li>
                        @endforeach
                    </ul>
                @endif
            </div>

            <div class="lg:col-span-3">
                <h2 class="text-sm font-extrabold uppercase tracking-widest text-white">Quick Links</h2>
                <ul class="mt-5 grid gap-2.5 text-sm">
                    @foreach ($site['footer_links'] as $routeName => $label)
                        <li><a href="{{ route($routeName) }}" class="hover:text-white">{{ $label }}</a></li>
                    @endforeach
                </ul>
            </div>

            <div class="lg:col-span-3">
                <h2 class="text-sm font-extrabold uppercase tracking-widest text-white">Contact Information</h2>
                <ul class="mt-5 grid gap-3.5 text-sm">
                    <li class="flex gap-3"><x-icon name="mail" class="mt-0.5 size-4 shrink-0 text-brand-300" /><a href="mailto:{{ $contact['email'] }}" class="hover:text-white">{{ $contact['email'] }}</a></li>
                    <li class="flex gap-3"><x-icon name="phone" class="mt-0.5 size-4 shrink-0 text-brand-300" /><a href="tel:{{ $contact['phone_link'] }}" class="hover:text-white">{{ $contact['phone'] }}</a></li>
                    <li class="flex gap-3"><x-icon name="whatsapp" class="mt-0.5 size-4 shrink-0 text-brand-300" /><a href="https://wa.me/{{ $contact['whatsapp_link'] }}" target="_blank" rel="noopener" class="hover:text-white">{{ $contact['whatsapp'] }}</a></li>
                    <li class="flex gap-3"><x-icon name="map" class="mt-0.5 size-4 shrink-0 text-brand-300" />{{ $contact['locations'] }}</li>
                    <li class="flex gap-3"><x-icon name="clock" class="mt-0.5 size-4 shrink-0 text-brand-300" />{{ $contact['hours'] }}</li>
                </ul>
            </div>

            <div class="lg:col-span-2">
                <h2 class="text-sm font-extrabold uppercase tracking-widest text-white">Policies</h2>
                <ul class="mt-5 grid gap-2.5 text-sm">
                    <li><a href="{{ route('policy', 'privacy-policy') }}" class="hover:text-white">Privacy Policy</a></li>
                    <li><a href="{{ route('policy', 'terms-and-conditions') }}" class="hover:text-white">Terms and Conditions</a></li>
                    <li><a href="{{ route('policy', 'registration-and-refund-policy') }}" class="hover:text-white">Registration and Refund Policy</a></li>
                </ul>
            </div>
        </div>

        <div class="border-t border-white/10">
            <div class="container-site flex flex-col items-center justify-between gap-2 py-6 text-xs sm:flex-row">
                <p>&copy; {{ date('Y') }} {{ $site['name'] }}. All rights reserved.</p>
                <p>Affiliated with Greenfield University College.</p>
            </div>
        </div>
    </footer>

    {{-- Floating WhatsApp button --}}
    <a href="https://wa.me/{{ $contact['whatsapp_link'] }}" target="_blank" rel="noopener" class="fixed bottom-5 right-5 z-30 grid size-14 place-items-center rounded-full bg-[#25D366] text-white shadow-xl transition hover:scale-110" aria-label="Chat with us on WhatsApp">
        <svg class="size-7" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M17.47 14.38c-.3-.15-1.75-.86-2.02-.96-.27-.1-.47-.15-.67.15-.2.3-.77.96-.94 1.16-.17.2-.35.22-.64.07-.3-.15-1.25-.46-2.38-1.47-.88-.79-1.47-1.76-1.65-2.06-.17-.3-.02-.46.13-.6.13-.14.3-.35.45-.52.15-.17.2-.3.3-.5.1-.2.05-.37-.03-.52-.07-.15-.67-1.61-.92-2.2-.24-.58-.49-.5-.67-.51h-.57c-.2 0-.52.07-.79.37-.27.3-1.04 1.02-1.04 2.48s1.06 2.88 1.21 3.08c.15.2 2.1 3.2 5.08 4.48.71.31 1.26.49 1.69.63.71.22 1.36.19 1.87.12.57-.09 1.75-.72 2-1.41.25-.69.25-1.29.17-1.41-.07-.13-.27-.2-.57-.35M12.05 21.79h-.01a9.87 9.87 0 0 1-5.03-1.38l-.36-.21-3.74.98 1-3.65-.24-.37a9.86 9.86 0 0 1-1.51-5.26c0-5.45 4.44-9.88 9.89-9.88 2.64 0 5.12 1.03 6.99 2.9a9.83 9.83 0 0 1 2.89 6.99c0 5.45-4.44 9.88-9.88 9.88m8.41-18.3A11.81 11.81 0 0 0 12.05 0C5.5 0 .16 5.34.16 11.89c0 2.1.55 4.14 1.59 5.95L.06 24l6.3-1.65a11.88 11.88 0 0 0 5.68 1.45h.01c6.55 0 11.89-5.34 11.89-11.89a11.82 11.82 0 0 0-3.48-8.41"/></svg>
    </a>
</body>
</html>
