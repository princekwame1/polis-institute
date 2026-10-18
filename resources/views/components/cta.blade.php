@props(['title', 'text' => null])

<section class="container-site py-16 sm:py-20">
    <div class="shield-pattern reveal relative overflow-hidden rounded-3xl bg-gradient-to-br from-brand-600 to-brand-900 px-6 py-14 text-center text-white sm:px-12">
        <div class="absolute -right-32 -top-32 size-96 rounded-full bg-[radial-gradient(closest-side,rgb(255_255_255/0.14),transparent)]"></div>
        <div class="relative mx-auto max-w-2xl">
            <h2 class="text-3xl font-extrabold sm:text-4xl">{{ $title }}</h2>
            @if ($text)
                <p class="mt-4 text-lg leading-relaxed text-brand-100">{{ $text }}</p>
            @endif
            <div class="mt-8 flex flex-wrap justify-center gap-3">
                {{ $slot }}
            </div>
        </div>
    </div>
</section>
