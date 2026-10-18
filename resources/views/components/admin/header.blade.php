@props(['title', 'description' => null])

<div class="mb-8 flex flex-wrap items-end justify-between gap-4">
    <div>
        <h1 class="text-2xl font-extrabold text-ink sm:text-3xl">{{ $title }}</h1>
        @if ($description)
            <p class="mt-1 text-muted">{{ $description }}</p>
        @endif
    </div>
    @if ($slot->isNotEmpty())
        <div class="flex flex-wrap gap-3">{{ $slot }}</div>
    @endif
</div>
