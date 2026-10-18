<x-layouts.app title="News and Publications">
    <x-page-header eyebrow="News and Publications" title="Insights, Updates, and Professional Development">
        News from the Institute, plus ideas and advice to help you grow in your career.
    </x-page-header>

    <section class="container-site py-20 sm:py-24">
        @if ($posts->isNotEmpty())
            <nav aria-label="News categories" class="reveal flex flex-wrap gap-2">
                <a href="{{ route('news') }}" @class(['rounded-full px-4 py-2 text-sm font-bold transition', 'bg-brand-600 text-white' => ! $category, 'border border-brand-200 text-brand-700 hover:bg-brand-50' => $category])>All</a>
                @foreach (config('prolis.news_categories') as [$title])
                    <a href="{{ route('news', ['category' => $title]) }}" @class(['rounded-full px-4 py-2 text-sm font-bold transition', 'bg-brand-600 text-white' => $category === $title, 'border border-brand-200 text-brand-700 hover:bg-brand-50' => $category !== $title])>{{ $title }}</a>
                @endforeach
            </nav>

            @php($featured = ! $category && $posts->onFirstPage() ? $posts->first() : null)

            @if ($featured)
                <x-post-card :post="$featured" featured class="reveal mt-10" />
            @endif

            <div class="mt-8 grid gap-6 md:grid-cols-2 lg:grid-cols-3">
                @foreach ($featured ? $posts->slice(1) : $posts as $post)
                    <x-post-card :post="$post" class="reveal" />
                @endforeach
            </div>

            <div class="mt-12">{{ $posts->links() }}</div>
        @else
            <x-section-heading eyebrow="Explore" title="What you'll find here" center>
                This is where we share Institute news, professional insights and practical career advice.
            </x-section-heading>

            <div class="mt-14 grid gap-6 md:grid-cols-2">
                @foreach (config('prolis.news_categories') as [$title, $text, $icon])
                    <article class="card reveal group overflow-hidden p-0">
                        <div class="shield-pattern flex h-40 items-end bg-gradient-to-br from-brand-600 to-brand-900 p-7">
                            <span class="grid size-14 place-items-center rounded-2xl bg-white text-brand-600 shadow-lg"><x-icon :name="$icon" class="size-7" /></span>
                        </div>
                        <div class="p-7">
                            <h2 class="text-xl font-extrabold">{{ $title }}</h2>
                            <p class="mt-3 leading-relaxed text-muted">{{ $text }}</p>
                            <p class="mt-5 inline-flex items-center gap-2 rounded-full bg-brand-50 px-3 py-1 text-xs font-bold text-brand-700">Articles coming soon</p>
                        </div>
                    </article>
                @endforeach
            </div>
        @endif
    </section>

    <x-cta title="Stay Informed" text="Check back here for new programmes, registration dates and upcoming events.">
        <a href="{{ route('contact') }}" class="btn-light">Contact Us</a>
        <a href="{{ route('courses') }}" class="btn-outline-light">Explore Courses</a>
    </x-cta>
</x-layouts.app>
