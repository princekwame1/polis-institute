<x-layouts.app title="Courses and Programmes">
    @php($site = config('prolis'))

    <x-page-header eyebrow="Courses and Programmes" title="Explore Our Professional Courses">
        Short professional courses that help you build skills, move up in your career and feel ready for work.
    </x-page-header>

    <section class="container-site py-20 sm:py-24">
        <div class="grid items-center gap-10 lg:grid-cols-12">
            <div class="reveal lg:col-span-7">
                <p class="lead">Our programmes cover a wide range of professions, so you can focus on the skills that match your career and your goals.</p>
            </div>
            <div class="reveal grid grid-cols-2 gap-4 lg:col-span-5">
                <div class="rounded-2xl bg-brand-600 p-6 text-white">
                    <x-icon name="clock" class="size-7" />
                    <p class="mt-3 font-display text-lg font-extrabold">One month</p>
                    <p class="text-sm text-brand-100">per course</p>
                </div>
                <div class="rounded-2xl bg-brand-950 p-6 text-white">
                    <x-icon name="device" class="size-7" />
                    <p class="mt-3 font-display text-lg font-extrabold">Online or in person</p>
                    <p class="text-sm text-brand-100">the choice is yours</p>
                </div>
            </div>
        </div>

        {{-- Jump links --}}
        <nav aria-label="Programme areas" class="reveal mt-14 flex flex-wrap gap-2">
            @foreach ($courseAreas as $area)
                <a href="#{{ $area->slug }}" class="rounded-full border border-brand-200 px-4 py-2 text-sm font-bold text-brand-700 transition hover:bg-brand-600 hover:text-white">{{ $area->title }}</a>
            @endforeach
        </nav>

        <div class="mt-14 grid gap-6 md:grid-cols-2">
            @foreach ($courseAreas as $area)
                <article id="{{ $area->slug }}" class="card reveal scroll-mt-32">
                    <div class="flex items-center gap-4">
                        <span class="icon-tile"><x-icon :name="$area->icon" /></span>
                        <h2 class="text-xl font-extrabold leading-snug">{{ $area->title }}</h2>
                    </div>
                    <ul class="mt-6 grid gap-2.5">
                        @foreach ($area->items as $course)
                            <li class="flex items-start gap-3 text-ink">
                                <x-icon name="check-circle" class="mt-0.5 size-5 shrink-0 text-brand-500" />
                                <span>{{ $course }}</span>
                            </li>
                        @endforeach
                    </ul>
                    <a href="{{ route('admissions', ['course' => $area->title]) }}#register" class="mt-7 inline-flex items-center gap-1.5 text-sm font-bold text-brand-600 hover:text-brand-800">Register your interest <x-icon name="arrow" class="size-4" /></a>
                </article>
            @endforeach
        </div>
    </section>

    <x-cta title="Interested in a course?" text="Get in touch and we will tell you about available courses, fees, registration and upcoming start dates.">
        <a href="{{ route('admissions') }}#register" class="btn-light">Register Your Interest</a>
        <a href="{{ route('contact') }}" class="btn-outline-light">Contact Us</a>
    </x-cta>
</x-layouts.app>
