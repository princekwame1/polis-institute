<x-layouts.admin title="Courses">
    <x-admin.header title="Courses" description="Programme areas and the courses in each one. These appear on the Courses page, the home page and the registration form.">
        <a href="{{ route('admin.course-areas.create') }}" class="btn-primary"><x-icon name="plus" class="size-4" /> Add course area</a>
    </x-admin.header>

    @if ($courseAreas->isEmpty())
        <x-admin.empty icon="book" title="No course areas yet" :action="route('admin.course-areas.create')" action-label="Add course area" />
    @else
        <div class="grid gap-4 md:grid-cols-2">
            @foreach ($courseAreas as $area)
                <x-admin.panel class="flex flex-col !p-6">
                    <div class="flex items-start gap-4">
                        <span class="icon-tile"><x-icon :name="$area->icon" /></span>
                        <div class="min-w-0 flex-1">
                            <p class="font-display text-lg font-extrabold leading-snug">{{ $area->title }}</p>
                            <p class="mt-1 text-sm text-muted">
                                {{ count($area->items) }} {{ str('course')->plural(count($area->items)) }}
                                · Position {{ $area->sort_order }}
                                @unless ($area->show_on_home) · Not on home page @endunless
                            </p>
                        </div>
                    </div>
                    <p class="mt-4 line-clamp-2 flex-1 text-sm text-muted">{{ implode(', ', $area->items) }}</p>
                    <div class="-ml-3 mt-4 flex items-center gap-1">
                        <x-admin.edit-link :href="route('admin.course-areas.edit', $area)" />
                        <x-admin.delete :action="route('admin.course-areas.destroy', $area)" confirm="Delete this course area and all the courses listed in it?" />
                    </div>
                </x-admin.panel>
            @endforeach
        </div>
    @endif
</x-layouts.admin>
