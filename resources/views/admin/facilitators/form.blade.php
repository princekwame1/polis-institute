<x-layouts.admin :title="$facilitator->exists ? 'Edit profile' : 'Add profile'">
    <a href="{{ route('admin.facilitators.index') }}" class="mb-4 inline-flex items-center gap-1.5 text-sm font-bold text-muted hover:text-ink"><x-icon name="arrow-left" class="size-4" /> Facilitators</a>
    <x-admin.header :title="$facilitator->exists ? 'Edit profile' : 'Add profile'" />

    <form method="POST" action="{{ $facilitator->exists ? route('admin.facilitators.update', $facilitator) : route('admin.facilitators.store') }}" enctype="multipart/form-data">
        @csrf
        @if ($facilitator->exists) @method('PUT') @endif

        <x-admin.panel class="grid gap-6">
            <x-admin.image name="photo" label="Photo" :url="$facilitator->photo_url" :rounded="true" help="A square headshot works best. Up to 5 MB." />
            <div class="grid gap-6 sm:grid-cols-2">
                <x-admin.input name="name" label="Full name" :value="$facilitator->name" required />
                <x-admin.input name="role" label="Role" :value="$facilitator->role" required placeholder="Lead Facilitator, Digital Marketing" />
            </div>
            <x-admin.textarea name="bio" label="Short bio" :value="$facilitator->bio" rows="5" />
            <x-admin.input name="sort_order" label="Position" type="number" min="0" :value="$facilitator->sort_order" required help="Lower numbers show first." class="max-w-xs" />
        </x-admin.panel>

        <div class="mt-6 flex gap-3">
            <button type="submit" class="btn-primary">{{ $facilitator->exists ? 'Save changes' : 'Add profile' }}</button>
            <a href="{{ route('admin.facilitators.index') }}" class="btn-outline">Cancel</a>
        </div>
    </form>
</x-layouts.admin>
