<x-layouts.admin title="Home slider">
    <x-admin.header title="Home slider" description="The large rotating banner at the top of the home page.">
        <a href="{{ route('admin.slides.create') }}" class="btn-primary"><x-icon name="plus" class="size-4" /> Add slide</a>
    </x-admin.header>

    @if ($slides->isEmpty())
        <x-admin.empty icon="image" title="No slides yet" :action="route('admin.slides.create')" action-label="Add slide">
            The home page shows a simple banner until you add a slide.
        </x-admin.empty>
    @else
        <div class="grid gap-4">
            @foreach ($slides as $slide)
                <x-admin.panel class="flex flex-wrap items-center gap-5 !p-4">
                    <div class="h-24 w-40 shrink-0 overflow-hidden rounded-xl bg-brand-900">
                        @if ($slide->image_url)
                            <img src="{{ $slide->image_url }}" alt="" class="size-full object-cover">
                        @endif
                    </div>
                    <div class="min-w-0 flex-1">
                        <div class="flex flex-wrap items-center gap-2">
                            <span class="rounded-full bg-gray-100 px-2 py-0.5 text-xs font-bold text-muted">#{{ $slide->sort_order }}</span>
                            @unless ($slide->is_active)
                                <span class="rounded-full bg-amber-100 px-2 py-0.5 text-xs font-bold text-amber-800">Hidden</span>
                            @endunless
                        </div>
                        <p class="mt-1 font-display text-lg font-extrabold">{{ $slide->title }}</p>
                        <p class="line-clamp-1 text-sm text-muted">{{ $slide->text }}</p>
                    </div>
                    <div class="flex items-center gap-1">
                        <x-admin.edit-link :href="route('admin.slides.edit', $slide)" />
                        <x-admin.delete :action="route('admin.slides.destroy', $slide)" confirm="Delete this slide?" />
                    </div>
                </x-admin.panel>
            @endforeach
        </div>
    @endif
</x-layouts.admin>
