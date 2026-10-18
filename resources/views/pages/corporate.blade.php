<x-layouts.app title="Corporate Training">
    @php($site = config('prolis'))

    <x-page-header eyebrow="Corporate Training" title="Professional Development for Organisations">
        Invest in skills. Strengthen your organisation.
    </x-page-header>

    <section class="container-site grid items-center gap-14 py-20 sm:py-24 lg:grid-cols-2">
        <div class="reveal">
            <p class="eyebrow">For Organisations</p>
            <h2 class="section-title">Strong organisations are built by people who keep learning.</h2>
            <div class="mt-6 space-y-4 leading-relaxed text-muted">
                <p>Good organisations depend on staff who keep developing their skills. We are here to help with that.</p>
                <p>Our corporate training helps businesses, institutions and other organisations build their teams' abilities and keep up as the workplace changes.</p>
                <p class="font-semibold text-ink">Tell us what your team needs, and we will put together training that fits.</p>
            </div>
            <a href="#request" class="btn-primary mt-8">Request Corporate Training <x-icon name="arrow" class="size-4" /></a>
        </div>
        <div class="reveal grid grid-cols-2 gap-4">
            @foreach ([['building', 'Businesses'], ['graduation', 'Institutions'], ['users', 'Teams'], ['trending', 'Performance']] as [$icon, $label])
                <div @class(['grid aspect-square place-items-center rounded-3xl p-6 text-center', 'bg-brand-600 text-white' => $loop->odd, 'bg-brand-50 text-brand-700' => $loop->even])>
                    <div>
                        <x-icon :name="$icon" class="mx-auto size-10" />
                        <p class="mt-3 font-display text-lg font-extrabold">{{ $label }}</p>
                    </div>
                </div>
            @endforeach
        </div>
    </section>

    <section class="bg-brand-50/60 py-20 sm:py-24">
        <div class="container-site">
            <x-section-heading eyebrow="What We Offer" title="Our Corporate Training Areas" center />
            <div class="mt-14 grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
                @foreach ($site['corporate_areas'] as $area)
                    <div class="card reveal flex items-center gap-4 p-5">
                        <span class="icon-tile"><x-icon name="check" /></span>
                        <p class="font-bold">{{ $area }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <section id="request" class="container-site scroll-mt-28 py-20 sm:py-24">
        <div class="grid gap-12 lg:grid-cols-12">
            <div class="reveal lg:col-span-4">
                <p class="eyebrow">Get in Touch</p>
                <h2 class="section-title">Let's Develop Your Team</h2>
                <p class="lead mt-5">Send us a few details and we will get back to you to talk about training for your organisation.</p>
            </div>
            <div class="reveal rounded-3xl border border-brand-100 bg-white p-6 shadow-xl shadow-brand-900/5 sm:p-10 lg:col-span-8">
                <x-enquiry-form type="corporate" submit-label="Request Corporate Training" />
            </div>
        </div>
    </section>
</x-layouts.app>
