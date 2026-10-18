<x-layouts.app title="Admissions and Registration">
    @php($site = config('prolis'))

    <x-page-header eyebrow="Admissions and Registration" title="Start Your Learning Journey">
        Your next step starts with choosing a course that fits your interests and goals.
    </x-page-header>

    <section class="container-site grid items-center gap-12 py-20 sm:py-24 lg:grid-cols-2">
        <div class="reveal">
            <p class="eyebrow">Admissions</p>
            <h2 class="section-title">Everyone who wants to grow is welcome.</h2>
            <p class="lead mt-5">If you want to learn something new, get better at what you do or prepare for a new opportunity, you are in the right place.</p>
        </div>
        <div class="card reveal">
            <span class="icon-tile"><x-icon name="users" /></span>
            <h3 class="mt-5 text-xl font-extrabold">Who Can Apply?</h3>
            <p class="mt-3 leading-relaxed text-muted">Our courses are open to university graduates, National Service Personnel, young professionals, working professionals, entrepreneurs and anyone keen to develop professionally.</p>
        </div>
    </section>

    <section class="bg-brand-50/60 py-20 sm:py-24">
        <div class="container-site">
            <x-section-heading eyebrow="Five Simple Steps" title="How to Register" center />
            <ol class="relative mt-14 grid gap-6 md:grid-cols-5">
                <div class="absolute left-0 right-0 top-8 hidden h-0.5 bg-brand-200 md:block" aria-hidden="true"></div>
                @foreach ($site['registration_steps'] as [$title, $text])
                    <li class="reveal relative text-center">
                        <span class="relative mx-auto grid size-16 place-items-center rounded-full bg-brand-600 font-display text-xl font-extrabold text-white ring-8 ring-brand-50">{{ $loop->iteration }}</span>
                        <p class="mt-5 text-xs font-extrabold uppercase tracking-widest text-brand-500">Step {{ $loop->iteration }}</p>
                        <h3 class="mt-1 font-extrabold">{{ $title }}</h3>
                        <p class="mt-2 text-sm leading-relaxed text-muted">{{ $text }}</p>
                    </li>
                @endforeach
            </ol>
        </div>
    </section>

    <section id="register" class="container-site scroll-mt-28 py-20 sm:py-24">
        <div class="grid gap-12 lg:grid-cols-12">
            <div class="reveal lg:col-span-4">
                <p class="eyebrow">Registration Form</p>
                <h2 class="section-title">Ready to Register?</h2>
                <p class="lead mt-5">Fill in the form and our team will get in touch to help you get started.</p>
                <div class="mt-8 rounded-2xl bg-brand-950 p-6 text-brand-100">
                    <p class="font-bold text-white">Need help with registration?</p>
                    <p class="mt-2 text-sm">Call or WhatsApp <a href="tel:{{ $contact['phone_link'] }}" class="font-bold text-white underline">{{ $contact['phone'] }}</a> or email <a href="mailto:{{ $contact['email'] }}" class="font-bold text-white underline">{{ $contact['email'] }}</a>.</p>
                </div>
            </div>
            <div class="reveal rounded-3xl border border-brand-100 bg-white p-6 shadow-xl shadow-brand-900/5 sm:p-10 lg:col-span-8">
                <x-enquiry-form type="registration" submit-label="Register Now" />
            </div>
        </div>
    </section>
</x-layouts.app>
