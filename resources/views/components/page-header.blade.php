@props(['title', 'eyebrow' => null])

<section class="shield-pattern relative overflow-hidden bg-brand-700 text-white">
    <div class="absolute -right-48 -top-48 size-[36rem] rounded-full bg-[radial-gradient(closest-side,rgb(154_63_165/0.45),transparent)]"></div>
    <div class="absolute -bottom-56 -left-40 size-[32rem] rounded-full bg-[radial-gradient(closest-side,rgb(58_15_62/0.6),transparent)]"></div>
    <img src="{{ asset('images/badge.png') }}" alt="" class="pointer-events-none absolute -right-16 top-1/2 hidden w-80 -translate-y-1/2 opacity-10 lg:block">

    <div class="container-site relative py-16 sm:py-24">
        @if ($eyebrow)
            <p class="mb-3 text-xs font-extrabold uppercase tracking-[0.2em] text-brand-200">{{ $eyebrow }}</p>
        @endif
        <h1 class="max-w-3xl text-4xl font-extrabold leading-tight sm:text-5xl">{{ $title }}</h1>
        @if ($slot->isNotEmpty())
            <div class="mt-5 max-w-2xl text-lg leading-relaxed text-brand-100">{{ $slot }}</div>
        @endif

        <nav aria-label="Breadcrumb" class="mt-8 text-sm font-semibold text-brand-200">
            <a href="{{ route('home') }}" class="hover:text-white">Home</a>
            <span class="mx-2">/</span>
            <span class="text-white">{{ $eyebrow ?? $title }}</span>
        </nav>
    </div>
</section>
