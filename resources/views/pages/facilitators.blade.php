<x-layouts.app title="Facilitators and Management">
    <x-page-header eyebrow="Facilitators and Management" title="Meet the People Behind PROLIS Institute">
        Meet the team that leads, organises and teaches our programmes.
    </x-page-header>

    <section class="container-site py-20 sm:py-24">
        <x-section-heading eyebrow="Our Team" title="Leadership, administration and programme delivery" center>
            These are the people who run the Institute and teach our courses.
        </x-section-heading>

        @if ($facilitators->isNotEmpty())
            <div class="mt-14 grid gap-6 sm:grid-cols-2 lg:grid-cols-4">
                @foreach ($facilitators as $facilitator)
                    <article class="card reveal text-center">
                        @if ($facilitator->photo_url)
                            <img src="{{ $facilitator->photo_url }}" alt="Photo of {{ $facilitator->name }}" class="mx-auto size-32 rounded-full object-cover ring-4 ring-brand-100">
                        @else
                            <div class="mx-auto grid size-32 place-items-center rounded-full bg-brand-50 text-brand-300 ring-4 ring-brand-100">
                                <x-icon name="user" class="size-14" />
                            </div>
                        @endif
                        <h3 class="mt-5 text-lg font-extrabold">{{ $facilitator->name }}</h3>
                        <p class="mt-1 text-sm font-bold uppercase tracking-widest text-brand-500">{{ $facilitator->role }}</p>
                        @if ($facilitator->bio)
                            <p class="mt-4 text-sm leading-relaxed text-muted">{{ $facilitator->bio }}</p>
                        @endif
                    </article>
                @endforeach
            </div>
        @else
            <div class="mt-14 grid gap-6 sm:grid-cols-2 lg:grid-cols-4">
                @foreach (['Management', 'Administration', 'Facilitator', 'Facilitator'] as $role)
                    <div class="card reveal text-center">
                        <div class="mx-auto grid size-32 place-items-center rounded-full bg-brand-50 text-brand-300 ring-4 ring-brand-100">
                            <x-icon name="user" class="size-14" />
                        </div>
                        <p class="mt-5 font-display text-lg font-extrabold">Profile coming soon</p>
                        <p class="mt-1 text-sm font-bold uppercase tracking-widest text-brand-500">{{ $role }}</p>
                    </div>
                @endforeach
            </div>

            <p class="reveal mx-auto mt-12 max-w-2xl rounded-2xl bg-brand-50 p-6 text-center leading-relaxed text-brand-800">
                Profiles and photos of our management team and facilitators will be added here soon.
            </p>
        @endif
    </section>

    <x-cta title="Start Your Professional Journey" text="The right skills open the next door. Find a course that suits you and take your next step.">
        <a href="{{ route('courses') }}" class="btn-light">Explore Courses</a>
        <a href="{{ route('contact') }}" class="btn-outline-light">Contact Us</a>
    </x-cta>
</x-layouts.app>
