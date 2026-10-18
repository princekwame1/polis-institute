<x-layouts.admin title="Facilitators">
    <x-admin.header title="Facilitators and management" description="Profiles shown on the Facilitators and Management page.">
        <a href="{{ route('admin.facilitators.create') }}" class="btn-primary"><x-icon name="plus" class="size-4" /> Add profile</a>
    </x-admin.header>

    @if ($facilitators->isEmpty())
        <x-admin.empty icon="users" title="No profiles yet" :action="route('admin.facilitators.create')" action-label="Add profile">
            Until you add a profile, the website shows "Profile coming soon" cards.
        </x-admin.empty>
    @else
        <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
            @foreach ($facilitators as $facilitator)
                <x-admin.panel class="text-center">
                    @if ($facilitator->photo_url)
                        <img src="{{ $facilitator->photo_url }}" alt="" class="mx-auto size-24 rounded-full object-cover">
                    @else
                        <span class="mx-auto grid size-24 place-items-center rounded-full bg-brand-50 text-brand-300"><x-icon name="user" class="size-10" /></span>
                    @endif
                    <p class="mt-4 font-display text-lg font-extrabold">{{ $facilitator->name }}</p>
                    <p class="text-sm font-semibold text-brand-600">{{ $facilitator->role }}</p>
                    <div class="mt-4 flex justify-center gap-1">
                        <x-admin.edit-link :href="route('admin.facilitators.edit', $facilitator)" />
                        <x-admin.delete :action="route('admin.facilitators.destroy', $facilitator)" confirm="Delete this profile?" />
                    </div>
                </x-admin.panel>
            @endforeach
        </div>
    @endif
</x-layouts.admin>
