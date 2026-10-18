@props(['icon' => 'inbox', 'title', 'action' => null, 'actionLabel' => null])

<div class="rounded-2xl border-2 border-dashed border-gray-200 bg-white px-6 py-16 text-center">
    <span class="mx-auto grid size-14 place-items-center rounded-2xl bg-brand-50 text-brand-500"><x-icon :name="$icon" class="size-7" /></span>
    <p class="mt-4 font-display text-lg font-extrabold">{{ $title }}</p>
    @if ($slot->isNotEmpty())
        <p class="mx-auto mt-1 max-w-md text-muted">{{ $slot }}</p>
    @endif
    @if ($action)
        <a href="{{ $action }}" class="btn-primary mt-6"><x-icon name="plus" class="size-4" /> {{ $actionLabel }}</a>
    @endif
</div>
