@php($summary = \App\Support\RichText::plain($post->excerpt) ?: \Illuminate\Support\Str::limit(\App\Support\RichText::plain($post->body), 160))

<x-layouts.app :title="$post->title" :description="$summary" :image="$post->image_url" type="article">
    <x-slot:head>
        <meta property="article:published_time" content="{{ $post->published_at->toIso8601String() }}">
        <meta property="article:modified_time" content="{{ $post->updated_at->toIso8601String() }}">
        <meta property="article:section" content="{{ $post->category }}">
        <x-json-ld :data="[
            '@type' => 'BlogPosting',
            'headline' => $post->title,
            'description' => $summary,
            'image' => $post->image_url ? [$post->image_url] : [asset('images/badge.png')],
            'datePublished' => $post->published_at->toIso8601String(),
            'dateModified' => $post->updated_at->toIso8601String(),
            'articleSection' => $post->category,
            'wordCount' => str_word_count(\App\Support\RichText::plain($post->body)),
            'mainEntityOfPage' => ['@type' => 'WebPage', '@id' => route('news.show', $post)],
            'author' => ['@type' => 'Organization', 'name' => config('prolis.name'), 'url' => route('home')],
            'publisher' => ['@type' => 'Organization', 'name' => config('prolis.name'), 'logo' => ['@type' => 'ImageObject', 'url' => asset('images/logo.png')]],
        ]" />
    </x-slot:head>

    <x-page-header :eyebrow="$post->category" :title="$post->title">
        {{ $post->published_at->format('j F Y') }}
    </x-page-header>

    <article class="container-site py-16 sm:py-20">
        <div class="mx-auto max-w-3xl">
            @if ($post->image_url)
                <img src="{{ $post->image_url }}" alt="{{ $post->title }}" class="mb-10 aspect-[16/9] w-full rounded-3xl object-cover shadow-xl shadow-brand-900/10">
            @endif

            @if ($post->excerpt)
                <div class="rich-text lead font-semibold text-ink">{{ \App\Support\RichText::render($post->excerpt) }}</div>
            @endif

            <div class="rich-text mt-6 text-lg leading-relaxed text-muted">
                {{ \App\Support\RichText::render($post->body) }}
            </div>

            <x-share-buttons :url="route('news.show', $post)" :title="$post->title" class="mt-12 border-t border-brand-100 pt-8" />

            <a href="{{ route('news') }}" class="btn-outline mt-10"><x-icon name="arrow-left" class="size-4" /> Back to News</a>
        </div>
    </article>

    @if ($related->isNotEmpty())
        <section class="bg-brand-50/60 py-16">
            <div class="container-site">
                <h2 class="section-title">More from the Institute</h2>
                <div class="mt-8 grid gap-6 md:grid-cols-3">
                    @foreach ($related as $item)
                        <x-post-card :post="$item" />
                    @endforeach
                </div>
            </div>
        </section>
    @endif
</x-layouts.app>
