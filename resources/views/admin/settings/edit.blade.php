<x-layouts.admin title="Site settings">
    <x-admin.header title="Site settings" description="The home page photo, contact details and social links used across the website." />

    <form method="POST" action="{{ route('admin.settings.update') }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <x-admin.panel class="mb-8 grid gap-6">
            <div>
                <h2 class="text-lg font-extrabold">Home page</h2>
                <p class="text-sm text-muted">The photo beside the welcome text on the home page.</p>
            </div>
            <x-admin.image name="welcome_image" label="Welcome photo" :url="$welcomeImage['url']" help="A landscape photo works best, around 1200 × 1000 pixels. Up to 5 MB. Removing it brings back the default photo." />
            <x-admin.input name="welcome_image_alt" label="Photo description" :value="$welcomeImageAlt" placeholder="Professionals attending a training session" help="Describe the photo for people using screen readers." />
        </x-admin.panel>

        <x-admin.panel class="grid gap-6">
            <h2 class="text-lg font-extrabold">Contact details</h2>
            <div class="grid gap-6 sm:grid-cols-2">
                <x-admin.input name="email" label="Email address" type="email" :value="$values['email']" required />
                <x-admin.input name="phone" label="Telephone" :value="$values['phone']" required />
                <x-admin.input name="whatsapp" label="WhatsApp number" :value="$values['whatsapp']" required help="Include the country code, for example +233." />
                <x-admin.input name="locations" label="Locations" :value="$values['locations']" required />
                <x-admin.input name="hours" label="Office hours" :value="$values['hours']" required class="sm:col-span-2" />
            </div>

            <h2 class="border-t border-gray-100 pt-6 text-lg font-extrabold">Social media</h2>
            <p class="-mt-4 text-sm text-muted">Links appear in the website footer. Leave a field empty to hide it.</p>
            <div class="grid gap-6 sm:grid-cols-2">
                @foreach (['facebook', 'instagram', 'linkedin', 'youtube'] as $network)
                    <x-admin.input :name="$network" :label="\App\Models\Setting::FIELDS[$network]" type="url" :value="$values[$network] ?? null" placeholder="https://" />
                @endforeach
            </div>
        </x-admin.panel>

        <div class="mt-6">
            <button type="submit" class="btn-primary">Save settings</button>
        </div>
    </form>
</x-layouts.admin>
