<x-layouts.admin :title="$slide->exists ? 'Edit slide' : 'Add slide'">
    <a href="{{ route('admin.slides.index') }}" class="mb-4 inline-flex items-center gap-1.5 text-sm font-bold text-muted hover:text-ink"><x-icon name="arrow-left" class="size-4" /> Home slider</a>
    <x-admin.header :title="$slide->exists ? 'Edit slide' : 'Add slide'" />

    <form method="POST" action="{{ $slide->exists ? route('admin.slides.update', $slide) : route('admin.slides.store') }}" enctype="multipart/form-data">
        @csrf
        @if ($slide->exists) @method('PUT') @endif

        <x-admin.panel class="grid gap-6">
            <x-admin.input name="title" label="Headline" :value="$slide->title" required maxlength="255" />
            <x-admin.textarea name="text" label="Text" :value="$slide->text" rows="3" help="One or two short sentences shown under the headline." />
            <x-admin.image name="image" label="Background photo" :url="$slide->image_url" help="Use a wide landscape photo, ideally 1920 × 1080 pixels. Up to 5 MB." />
            <x-admin.input name="image_alt" label="Photo description" :value="$slide->image_alt" help="Describe the photo for people using screen readers." />

            <div class="grid gap-6 border-t border-gray-100 pt-6 sm:grid-cols-2">
                <x-admin.input name="primary_button_text" label="Main button text" :value="$slide->primary_button_text" />
                <x-admin.input name="primary_button_url" label="Main button link" :value="$slide->primary_button_url" placeholder="/courses-and-programmes" help="A page on this site, like /contact-us, or a full web address." />
                <x-admin.input name="secondary_button_text" label="Second button text" :value="$slide->secondary_button_text" />
                <x-admin.input name="secondary_button_url" label="Second button link" :value="$slide->secondary_button_url" placeholder="/contact-us" />
            </div>

            <div class="grid gap-6 border-t border-gray-100 pt-6 sm:grid-cols-2">
                <x-admin.input name="sort_order" label="Position" type="number" min="0" :value="$slide->sort_order" required help="Lower numbers show first." />
                <label class="flex items-center gap-3 self-center font-semibold">
                    <input type="checkbox" name="is_active" value="1" @checked(old('is_active', $slide->is_active)) class="size-5 accent-brand-600">
                    Show this slide on the website
                </label>
            </div>
        </x-admin.panel>

        <div class="mt-6 flex gap-3">
            <button type="submit" class="btn-primary">{{ $slide->exists ? 'Save changes' : 'Add slide' }}</button>
            <a href="{{ route('admin.slides.index') }}" class="btn-outline">Cancel</a>
        </div>
    </form>
</x-layouts.admin>
