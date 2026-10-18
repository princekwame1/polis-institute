@props(['eyebrow' => null, 'title', 'center' => false])

<div {{ $attributes->class(['reveal max-w-3xl', 'mx-auto text-center' => $center]) }}>
    @if ($eyebrow)
        <p class="eyebrow">{{ $eyebrow }}</p>
    @endif
    <h2 class="section-title">{{ $title }}</h2>
    @if ($slot->isNotEmpty())
        <div class="lead mt-4">{{ $slot }}</div>
    @endif
</div>
