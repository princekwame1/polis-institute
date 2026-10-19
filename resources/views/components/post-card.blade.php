@props(['post', 'featured' => false])

<article {{ $attributes->class([
    'group relative flex overflow-hidden rounded-2xl border border-gray-200 bg-white transition duration-300 hover:border-brand-200 hover:shadow-lg hover:shadow-brand-900/5',
    'flex-col md:flex-row' => $featured,
    'flex-col' => ! $featured,
]) }}>
    <div @class(['relative overflow-hidden bg-brand-50', 'aspect-[16/10] md:aspect-auto md:w-1/2 md:min-h-80' => $featured, 'aspect-[16/10]' => ! $featured])>
        @if ($post->image_url)
            <img src="{{ $post->image_url }}" alt="" loading="lazy" class="absolute inset-0 size-full object-cover transition duration-500 group-hover:scale-[1.03]">
        @else
            <div class="absolute inset-0 grid place-items-center text-brand-300">
                <x-icon :name="$post->categoryIcon()" @class(['size-14' => $featured, 'size-10' => ! $featured]) />
            </div>
        @endif
    </div>

    <div @class(['flex flex-1 flex-col', 'p-7 md:p-10 md:justify-center' => $featured, 'p-6' => ! $featured])>
        <p class="flex flex-wrap items-center gap-x-2 text-xs font-bold uppercase tracking-wider">
            <span class="text-brand-600">{{ $post->category }}</span>
            <span class="text-gray-300" aria-hidden="true">/</span>
            <time datetime="{{ $post->published_at->toDateString() }}" class="text-muted">{{ $post->published_at->format('j M Y') }}</time>
        </p>

        <h2 @class([
            'mt-3 font-display font-extrabold leading-snug text-ink transition group-hover:text-brand-700',
            'text-2xl md:text-3xl' => $featured,
            'text-lg' => ! $featured,
        ])>
            <a href="{{ route('news.show', $post) }}" class="after:absolute after:inset-0">{{ $post->title }}</a>
        </h2>

        @if ($post->excerpt)
            <p @class(['mt-3 leading-relaxed text-muted', 'line-clamp-4 text-lg' => $featured, 'line-clamp-3 text-sm' => ! $featured])>{{ \App\Support\RichText::plain($post->excerpt) }}</p>
        @endif

        <p @class(['flex items-center justify-between gap-4 pt-5 text-sm font-semibold text-muted', 'mt-auto' => ! $featured, 'mt-6' => $featured])>
            <span class="inline-flex items-center gap-1.5"><x-icon name="clock" class="size-4" /> {{ $post->readingTime() }} min read</span>
            <span class="inline-flex items-center gap-1 font-bold text-brand-600">Read <x-icon name="arrow" class="size-4 transition group-hover:translate-x-1" /></span>
        </p>
    </div>
</article>
