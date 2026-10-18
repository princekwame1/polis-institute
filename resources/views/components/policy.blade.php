@props(['title'])

<x-layouts.app :title="$title">
    <x-page-header eyebrow="Policies" :title="$title" />

    <section class="container-site py-16 sm:py-20">
        <article class="mx-auto max-w-3xl space-y-6 leading-relaxed text-muted [&_h2]:mt-10 [&_h2]:text-2xl [&_h2]:font-extrabold [&_h2]:text-ink [&_ul]:list-disc [&_ul]:space-y-2 [&_ul]:pl-6">
            <p class="text-sm font-semibold text-brand-600">Last updated: {{ now()->format('F Y') }}</p>
            {{ $slot }}
            <h2>Contact</h2>
            <p>For questions about this policy, email <a href="mailto:{{ $contact['email'] }}" class="font-bold text-brand-600">{{ $contact['email'] }}</a> or call {{ $contact['phone'] }}.</p>
        </article>
    </section>
</x-layouts.app>
