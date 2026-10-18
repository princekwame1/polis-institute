<x-layouts.app title="About Us">
    @php($site = config('prolis'))

    <x-page-header eyebrow="About Us" title="About PROLIS Institute">
        Helping people build practical, professional skills since 2006.
    </x-page-header>

    <section class="container-site grid gap-14 py-20 sm:py-24 lg:grid-cols-12">
        <div class="reveal lg:col-span-7">
            <p class="eyebrow">Who We Are</p>
            <h2 class="section-title">Helping people grow in their careers.</h2>
            <div class="mt-6 space-y-4 leading-relaxed text-muted">
                <p>PROLIS Institute, short for Professional Learning and Industry Skills Institute, was founded in 2006 to help people keep learning and keep growing at work.</p>
                <p>We run short professional courses and training that help people sharpen the skills they already have, pick up new ones and get ready for what the workplace expects of them.</p>
                <p>Our courses cover communication, public relations, digital marketing, branding, event management, leadership, project management, health communication, public speaking and other professional fields.</p>
                <p>The world of work keeps changing, and staying good at what you do means continuing to learn long after school.</p>
                <p class="font-semibold text-ink">That is why everything we teach is aimed at helping you grow in your career, do your job well and keep learning.</p>
            </div>
        </div>
        <div class="reveal lg:col-span-5">
            <div class="grid gap-6">
                <div class="rounded-3xl bg-brand-600 p-8 text-white shadow-xl shadow-brand-600/20">
                    <span class="grid size-12 place-items-center rounded-xl bg-white/15"><x-icon name="target" /></span>
                    <h3 class="mt-5 text-2xl font-extrabold">Our Mission</h3>
                    <p class="mt-3 leading-relaxed text-brand-100">To offer professional learning that is accessible, relevant and of high quality, giving people the skills they need to grow in their careers and do well at work.</p>
                </div>
                <div class="rounded-3xl bg-brand-950 p-8 text-white">
                    <span class="grid size-12 place-items-center rounded-xl bg-white/10"><x-icon name="eye" /></span>
                    <h3 class="mt-5 text-2xl font-extrabold">Our Vision</h3>
                    <p class="mt-3 leading-relaxed text-brand-100">To be a respected name in professional learning across Ghana and West Africa, known for excellence, for teaching what industry needs and for the capable professionals we help develop.</p>
                </div>
            </div>
        </div>
    </section>

    <section class="bg-brand-50/60 py-20 sm:py-24">
        <div class="container-site">
            <x-section-heading eyebrow="What We Aim For" title="Our Objectives" center />
            <ol class="mt-14 grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
                @foreach ($site['objectives'] as $objective)
                    <li class="card reveal flex gap-5">
                        <span class="font-display text-3xl font-extrabold text-brand-200">{{ str_pad($loop->iteration, 2, '0', STR_PAD_LEFT) }}</span>
                        <p class="leading-relaxed text-ink">{{ $objective }}</p>
                    </li>
                @endforeach
            </ol>
        </div>
    </section>

    <section class="container-site py-20 sm:py-24">
        <x-section-heading eyebrow="What Guides Us" title="Our Core Values" center />
        <div class="mt-14 grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
            @foreach ($site['values'] as [$value, $description])
                <div class="card reveal">
                    <span class="icon-tile"><x-icon name="star" /></span>
                    <h3 class="mt-5 text-xl font-extrabold">{{ $value }}</h3>
                    <p class="mt-2 leading-relaxed text-muted">{{ $description }}</p>
                </div>
            @endforeach
        </div>
    </section>

    <section class="container-site pb-4">
        <div class="reveal flex flex-col items-center gap-8 rounded-3xl border-2 border-dashed border-brand-200 p-8 text-center sm:flex-row sm:p-12 sm:text-left">
            <span class="grid size-20 shrink-0 place-items-center rounded-2xl bg-brand-600 text-white"><x-icon name="link" class="size-9" /></span>
            <div>
                <p class="eyebrow">Our Affiliation</p>
                <h2 class="text-2xl font-extrabold">Affiliated with Greenfield University College</h2>
                <p class="mt-3 leading-relaxed text-muted">PROLIS Institute is affiliated with Greenfield University College. More details about this affiliation will be shared soon.</p>
            </div>
        </div>
    </section>

    <x-cta title="Start Your Professional Journey" text="The right skills open the next door. Find a course that suits you and take your next step.">
        <a href="{{ route('courses') }}" class="btn-light">Explore Courses</a>
        <a href="{{ route('admissions') }}#register" class="btn-outline-light">Register Now</a>
    </x-cta>
</x-layouts.app>
