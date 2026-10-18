<x-layouts.app title="Contact Us">

    <x-page-header eyebrow="Contact Us" title="Connect With PROLIS Institute">
        Thinking about a course, looking for staff training or just have a question? We would love to hear from you.
    </x-page-header>

    <section class="container-site py-20 sm:py-24">
        <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-4">
            @foreach ([
                ['mail', 'Email', $contact['email'], 'mailto:'.$contact['email']],
                ['phone', 'Telephone', $contact['phone'], 'tel:'.$contact['phone_link']],
                ['whatsapp', 'WhatsApp', $contact['whatsapp'], 'https://wa.me/'.$contact['whatsapp_link']],
                ['map', 'Locations', $contact['locations'], null],
            ] as [$icon, $label, $value, $href])
                <div class="card reveal">
                    <span class="icon-tile"><x-icon :name="$icon" /></span>
                    <p class="mt-5 text-xs font-extrabold uppercase tracking-widest text-brand-500">{{ $label }}</p>
                    @if ($href)
                        <a href="{{ $href }}" class="mt-1 block break-words font-display font-bold hover:text-brand-600" @if (str_starts_with($href, 'https')) target="_blank" rel="noopener" @endif>{{ $value }}</a>
                    @else
                        <p class="mt-1 font-display font-bold">{{ $value }}</p>
                    @endif
                </div>
            @endforeach
        </div>

        <div class="mt-16 grid gap-12 lg:grid-cols-12">
            <div class="reveal lg:col-span-4">
                <p class="eyebrow">Send Us an Enquiry</p>
                <h2 class="section-title">How can we help?</h2>
                <p class="lead mt-5">Ask us about courses, registration, corporate training or anything else. Use the details above or send us a message with the form.</p>
                <div class="mt-8 flex items-start gap-4 rounded-2xl bg-brand-50 p-6">
                    <x-icon name="clock" class="mt-0.5 size-6 shrink-0 text-brand-600" />
                    <div>
                        <p class="font-bold">Office Hours</p>
                        <p class="text-muted">{{ $contact['hours'] }}</p>
                    </div>
                </div>
            </div>
            <div id="enquiry" class="reveal scroll-mt-28 rounded-3xl border border-brand-100 bg-white p-6 shadow-xl shadow-brand-900/5 sm:p-10 lg:col-span-8">
                <x-enquiry-form type="contact" />
            </div>
        </div>
    </section>
</x-layouts.app>
