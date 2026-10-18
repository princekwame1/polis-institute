<x-layouts.app :title="$post->title" :description="$post->excerpt">
    <x-page-header :eyebrow="$post->category" :title="$post->title">
        {{ $post->published_at->format('j F Y') }}
    </x-page-header>

    <article class="container-site py-16 sm:py-20">
        <div class="mx-auto max-w-3xl">
            @if ($post->image_url)
                <img src="{{ $post->image_url }}" alt="" class="mb-10 aspect-[16/9] w-full rounded-3xl object-cover shadow-xl shadow-brand-900/10">
            @endif

            @if ($post->excerpt)
                <p class="lead font-semibold text-ink">{{ $post->excerpt }}</p>
            @endif

            <div class="mt-6 space-y-5 text-lg leading-relaxed text-muted">
                @foreach (preg_split('/\R{2,}/', trim($post->body)) as $paragraph)
                    <p>{!! nl2br(e($paragraph)) !!}</p>
                @endforeach
            </div>

            <a href="{{ route('news') }}" class="btn-outline mt-12"><x-icon name="arrow-left" class="size-4" /> Back to News</a>
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
