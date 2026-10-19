<x-layouts.app title="Frequently Asked Questions" description="Answers to common questions about PROLIS Institute courses, registration and training.">
    <x-page-header eyebrow="FAQs" title="Frequently Asked Questions">
        Answers to common questions about PROLIS Institute, our courses and registration.
    </x-page-header>

    <section class="container-site py-20 sm:py-24">
        <div class="mx-auto grid max-w-3xl gap-4">
            @foreach ($faqs as $faq)
                <details class="reveal group rounded-2xl border border-brand-100 bg-white shadow-sm open:border-brand-300 open:shadow-lg open:shadow-brand-900/5" @if ($loop->first) open @endif>
                    <summary class="flex cursor-pointer items-center justify-between gap-4 p-6 font-display text-lg font-bold">
                        {{ $faq->question }}
                        <span class="grid size-8 shrink-0 place-items-center rounded-full bg-brand-50 text-brand-600 group-open:bg-brand-600 group-open:text-white">
                            <x-icon name="chevron" class="faq-chevron size-4 transition" />
                        </span>
                    </summary>
                    <div class="rich-text px-6 pb-6 leading-relaxed text-muted">{{ \App\Support\RichText::render($faq->answer) }}</div>
                </details>
            @endforeach
        </div>
    </section>

    <x-cta title="Still have questions?" text="Our team is happy to help with course, registration and corporate training enquiries.">
        <a href="{{ route('contact') }}" class="btn-light">Contact Us</a>
        <a href="{{ route('admissions') }}#register" class="btn-outline-light">Register Now</a>
    </x-cta>
</x-layouts.app>
