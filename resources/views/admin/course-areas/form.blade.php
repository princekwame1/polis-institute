<x-layouts.admin :title="$courseArea->exists ? 'Edit course area' : 'Add course area'">
    <a href="{{ route('admin.course-areas.index') }}" class="mb-4 inline-flex items-center gap-1.5 text-sm font-bold text-muted hover:text-ink"><x-icon name="arrow-left" class="size-4" /> Courses</a>
    <x-admin.header :title="$courseArea->exists ? 'Edit course area' : 'Add course area'" />

    <form method="POST" action="{{ $courseArea->exists ? route('admin.course-areas.update', $courseArea) : route('admin.course-areas.store') }}">
        @csrf
        @if ($courseArea->exists) @method('PUT') @endif

        <x-admin.panel class="grid gap-6">
            <x-admin.input name="title" label="Programme area" :value="$courseArea->title" required placeholder="Digital Marketing and Social Media" />
            <x-admin.textarea name="summary" label="Short summary" :value="$courseArea->summary" rows="2" help="Shown on the home page course cards." />
            <x-admin.textarea name="items" label="Courses" :value="implode(PHP_EOL, $courseArea->items ?? [])" rows="8" required help="Put each course on its own line." />

            <fieldset>
                <legend class="form-label">Icon</legend>
                <div class="flex flex-wrap gap-2">
                    @foreach (\App\Models\CourseArea::ICONS as $icon)
                        <label class="cursor-pointer">
                            <input type="radio" name="icon" value="{{ $icon }}" @checked(old('icon', $courseArea->icon) === $icon) class="peer sr-only">
                            <span class="grid size-12 place-items-center rounded-xl border border-gray-200 text-muted transition peer-checked:border-brand-500 peer-checked:bg-brand-50 peer-checked:text-brand-700 peer-focus-visible:ring-4 peer-focus-visible:ring-brand-100 hover:border-brand-300" title="{{ ucfirst($icon) }}">
                                <x-icon :name="$icon" class="size-5" />
                            </span>
                        </label>
                    @endforeach
                </div>
                @error('icon') <p class="form-error">{{ $message }}</p> @enderror
            </fieldset>

            <div class="grid gap-6 border-t border-gray-100 pt-6 sm:grid-cols-2">
                <x-admin.input name="sort_order" label="Position" type="number" min="0" :value="$courseArea->sort_order" required help="Lower numbers show first." />
                <label class="flex items-center gap-3 self-center font-semibold">
                    <input type="checkbox" name="show_on_home" value="1" @checked(old('show_on_home', $courseArea->show_on_home)) class="size-5 accent-brand-600">
                    Show on the home page
                </label>
            </div>
        </x-admin.panel>

        <div class="mt-6 flex gap-3">
            <button type="submit" class="btn-primary">{{ $courseArea->exists ? 'Save changes' : 'Add course area' }}</button>
            <a href="{{ route('admin.course-areas.index') }}" class="btn-outline">Cancel</a>
        </div>
    </form>
</x-layouts.admin>
