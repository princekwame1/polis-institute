<x-layouts.app>
    @php($site = config('prolis'))
    <x-slot:head>
        <x-json-ld :data="[
            '@type' => 'EducationalOrganization',
            'name' => $site['name'],
            'alternateName' => $site['full_name'],
            'slogan' => $site['tagline'],
            'url' => route('home'),
            'logo' => asset('images/logo.png'),
            'email' => $contact['email'],
            'telephone' => $contact['phone_link'],
            'areaServed' => 'Ghana',
            'sameAs' => array_values(array_filter([$contact['facebook'] ?? null, $contact['instagram'] ?? null, $contact['linkedin'] ?? null, $contact['youtube'] ?? null])),
        ]" />
    </x-slot:head>

    {{-- Hero slider --}}
    <section data-hero-slider class="relative overflow-hidden bg-brand-950 text-white" aria-roledescription="carousel" aria-label="Highlights">
        @forelse ($slides as $slide)
            <div class="hero-slide" aria-roledescription="slide" aria-label="{{ $loop->iteration }} of {{ $slides->count() }}">
                @if ($slide->image_url)
                    <img src="{{ $slide->image_url }}" alt="{{ $slide->image_alt }}" class="hero-image absolute inset-0 size-full object-cover" @if ($loop->first) fetchpriority="high" @endif>
                @endif
                <div class="absolute inset-0 bg-gradient-to-r from-brand-950/95 via-brand-800/85 to-brand-700/40"></div>
                <div class="absolute inset-0 bg-gradient-to-t from-brand-950/70 via-transparent to-transparent"></div>

                <div class="container-site relative flex min-h-[90svh] items-center pb-40 pt-20 lg:pb-44">
                    <div class="slide-content max-w-3xl">
                        <p class="mb-5 inline-flex items-center gap-2 rounded-full bg-white/10 px-4 py-1.5 text-xs font-extrabold uppercase tracking-[0.2em] text-brand-100 ring-1 ring-white/20">
                            <x-icon name="graduation" class="size-4" /> {{ $site['tagline'] }}
                        </p>
                        <h1 class="text-4xl font-extrabold leading-[1.1] sm:text-5xl lg:text-6xl">{{ $slide->title }}</h1>
                        <div>
                            @if ($slide->text)
                                <div class="rich-text mt-6 max-w-2xl text-lg leading-relaxed text-brand-100">{{ \App\Support\RichText::render($slide->text) }}</div>
                            @endif
                            <div class="mt-9 flex flex-wrap gap-3">
                                @if ($slide->primary_button_text && $slide->primary_button_url)
                                    <a href="{{ url($slide->primary_button_url) }}" class="btn-light">{{ $slide->primary_button_text }} <x-icon name="arrow" class="size-4" /></a>
                                @endif
                                @if ($slide->secondary_button_text && $slide->secondary_button_url)
                                    <a href="{{ url($slide->secondary_button_url) }}" class="btn-outline-light">{{ $slide->secondary_button_text }}</a>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="container-site relative flex min-h-[90svh] items-center pb-36 pt-20">
                <div class="max-w-3xl">
                    <h1 class="text-4xl font-extrabold leading-[1.1] sm:text-5xl lg:text-6xl">{{ $site['name'] }}</h1>
                    <p class="mt-6 text-lg text-brand-100">{{ $site['tagline'] }}</p>
                    <a href="{{ route('courses') }}" class="btn-light mt-9">Explore Our Courses <x-icon name="arrow" class="size-4" /></a>
                </div>
            </div>
        @endforelse

        @if ($slides->count() > 1)
        <div class="container-site pointer-events-none absolute inset-x-0 bottom-20 z-10 lg:bottom-24">
            <div class="pointer-events-auto flex items-center gap-4">
                <button type="button" data-slide-prev class="grid size-10 place-items-center rounded-full bg-white/10 ring-1 ring-white/30 transition hover:bg-white hover:text-brand-700" aria-label="Previous slide">
                    <x-icon name="arrow-left" class="size-4" />
                </button>
                <div class="flex items-center gap-2">
                    @foreach ($slides as $slide)
                        <button type="button" data-slide-to="{{ $loop->index }}" class="h-3 w-3 rounded-full bg-white/40 transition-all" aria-label="Go to slide {{ $loop->iteration }}"></button>
                    @endforeach
                </div>
                <button type="button" data-slide-next class="grid size-10 place-items-center rounded-full bg-white/10 ring-1 ring-white/30 transition hover:bg-white hover:text-brand-700" aria-label="Next slide">
                    <x-icon name="arrow" class="size-4" />
                </button>
            </div>
        </div>
        @endif
    </section>

    {{-- Quick highlights --}}
    <section class="relative z-10 -mt-10">
        <div class="container-site">
            <div class="grid gap-px overflow-hidden rounded-2xl bg-brand-100 shadow-xl shadow-brand-900/10 sm:grid-cols-2 lg:grid-cols-4">
                @foreach ([['Since 2006', 'Two decades of professional learning', 'shield'], [$courseAreas->count().' Programme Areas', 'Courses across many professions', 'book'], ['Flexible Learning', 'Online or in person', 'device'], ['Corporate Training', 'Training for your team', 'building']] as [$title, $text, $icon])
                    <div class="flex items-center gap-4 bg-white p-6">
                        <span class="icon-tile"><x-icon :name="$icon" /></span>
                        <div>
                            <p class="font-display font-extrabold text-ink">{{ $title }}</p>
                            <p class="text-sm text-muted">{{ $text }}</p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- Welcome --}}
    <section class="container-site grid items-center gap-14 py-20 sm:py-24 lg:grid-cols-2">
        <div class="reveal order-last lg:order-first">
            <img src="{{ $welcomeImage['url'] }}" alt="{{ $welcomeImage['alt'] }}" loading="lazy" class="aspect-[6/5] w-full rounded-xl object-cover">
        </div>

        <div class="reveal">
            <p class="eyebrow">Welcome to PROLIS Institute</p>
            <h2 class="section-title">Skills that make a real difference at work.</h2>
            <div class="mt-6 space-y-4 leading-relaxed text-muted">
                <p>PROLIS Institute runs short professional courses that help people grow in their careers and do their jobs better.</p>
                <p>A certificate alone is not enough. We teach the practical, communication, digital and leadership skills today's workplace expects, for graduates, National Service Personnel, working professionals and organisations.</p>
            </div>
            <a href="{{ route('about') }}" class="btn-primary mt-8">Learn More About Us <x-icon name="arrow" class="size-4" /></a>
        </div>
    </section>

    {{-- Courses --}}
    <section class="bg-brand-50/60 py-20 sm:py-24">
        <div class="container-site">
            <x-section-heading eyebrow="Our Programmes" title="Explore Our Courses" center>
                Browse courses across a range of professions, each one designed to help you move forward in your career.
            </x-section-heading>

            <div class="mt-14 grid gap-6 sm:grid-cols-2 lg:grid-cols-4">
                @foreach ($courseAreas->where('show_on_home', true) as $area)
                    <a href="{{ route('courses') }}#{{ $area->slug }}" class="card reveal group flex flex-col">
                        <span class="icon-tile transition group-hover:bg-brand-600 group-hover:text-white"><x-icon :name="$area->icon" /></span>
                        <h3 class="mt-5 text-lg font-extrabold leading-snug">{{ $area->title }}</h3>
                        <div class="rich-text mt-3 flex-1 text-sm leading-relaxed text-muted">{{ \App\Support\RichText::render($area->summary) }}</div>
                        <span class="mt-5 inline-flex items-center gap-1.5 text-sm font-bold text-brand-600">View courses <x-icon name="arrow" class="size-4 transition group-hover:translate-x-1" /></span>
                    </a>
                @endforeach
            </div>

            <div class="mt-12 text-center">
                <a href="{{ route('courses') }}" class="btn-primary">View All Courses <x-icon name="arrow" class="size-4" /></a>
            </div>
        </div>
    </section>

    {{-- Why choose --}}
    <section class="container-site py-20 sm:py-24">
        <div class="grid gap-14 lg:grid-cols-12">
            <div class="lg:col-span-4">
                <div class="lg:sticky lg:top-32">
                    <x-section-heading eyebrow="Why PROLIS" title="Why Choose PROLIS Institute?">
                        Here is what you can expect when you learn with us.
                    </x-section-heading>
                    <a href="{{ route('admissions') }}" class="btn-outline reveal mt-8">How to Register</a>
                </div>
            </div>
            <div class="grid gap-6 sm:grid-cols-2 lg:col-span-8">
                @foreach ($site['why_choose'] as $index => [$title, $text, $icon])
                    <div @class(['card reveal', 'sm:col-span-2' => $loop->last])>
                        <div class="flex items-start gap-5">
                            <span class="icon-tile"><x-icon :name="$icon" /></span>
                            <div>
                                <p class="font-display text-xs font-extrabold text-brand-400">0{{ $index + 1 }}</p>
                                <h3 class="mt-1 text-lg font-extrabold">{{ $title }}</h3>
                                <p class="mt-2 text-sm leading-relaxed text-muted">{{ $text }}</p>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- Who can learn --}}
    <section class="shield-pattern bg-brand-900 py-20 text-white sm:py-24">
        <div class="container-site grid items-center gap-12 lg:grid-cols-2">
            <div class="reveal">
                <p class="mb-3 text-xs font-extrabold uppercase tracking-[0.2em] text-brand-300">Our Learners</p>
                <h2 class="text-3xl font-extrabold sm:text-4xl">Who Can Learn With Us?</h2>
                <p class="mt-5 text-lg leading-relaxed text-brand-100">Our courses are open to university graduates, National Service Personnel, young professionals, working professionals, entrepreneurs, business owners and organisations that believe in learning for life.</p>
            </div>
            <ul class="reveal grid gap-3 sm:grid-cols-2">
                @foreach ($site['audiences'] as $audience)
                    <li class="flex items-center gap-3 rounded-xl bg-white/5 p-4 font-bold ring-1 ring-white/10">
                        <span class="grid size-8 place-items-center rounded-full bg-brand-500"><x-icon name="check" class="size-4" /></span>
                        {{ $audience }}
                    </li>
                @endforeach
            </ul>
        </div>
    </section>

    {{-- Corporate training --}}
    <section class="container-site py-20 sm:py-24">
        <div class="reveal grid items-center gap-10 overflow-hidden rounded-3xl border border-brand-100 bg-white shadow-xl shadow-brand-900/5 lg:grid-cols-2">
            <div class="p-8 sm:p-12">
                <p class="eyebrow">Corporate Training</p>
                <h2 class="section-title">Invest in Skills. Strengthen Your Organisation.</h2>
                <p class="lead mt-5">We help organisations build their staff's skills, improve performance at work and keep their teams learning, with training shaped around what they need.</p>
                <a href="{{ route('corporate') }}" class="btn-primary mt-8">Explore Corporate Training <x-icon name="arrow" class="size-4" /></a>
            </div>
            <div class="grid h-full gap-3 bg-brand-50 p-8 sm:grid-cols-2 sm:p-12">
                @foreach (array_slice($site['corporate_areas'], 0, 6) as $area)
                    <div class="flex items-center gap-3 rounded-xl bg-white p-4 text-sm font-bold shadow-sm">
                        <x-icon name="check-circle" class="size-5 shrink-0 text-brand-600" /> {{ $area }}
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <x-cta title="Start Your Professional Journey" text="The right skills open the next door. Find a course that suits you and take your next step.">
        <a href="{{ route('courses') }}" class="btn-light">Explore Courses</a>
        <a href="{{ route('admissions') }}#register" class="btn-outline-light">Register Now</a>
    </x-cta>
</x-layouts.app>
