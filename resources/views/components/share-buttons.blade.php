@props(['url', 'title'])

@php
    $networks = [
        'Facebook' => ['facebook', 'https://www.facebook.com/sharer/sharer.php?'.http_build_query(['u' => $url])],
        'X' => ['x', 'https://x.com/intent/post?'.http_build_query(['url' => $url, 'text' => $title])],
        'LinkedIn' => ['linkedin', 'https://www.linkedin.com/sharing/share-offsite/?'.http_build_query(['url' => $url])],
        'WhatsApp' => ['whatsapp', 'https://wa.me/?'.http_build_query(['text' => "{$title} {$url}"])],
        'Email' => ['mail', 'mailto:?'.http_build_query(['subject' => $title, 'body' => $url], '', '&', PHP_QUERY_RFC3986)],
    ];
@endphp

<div {{ $attributes->class('flex flex-wrap items-center gap-3') }}>
    <p class="mr-1 text-sm font-extrabold uppercase tracking-widest text-ink">Share</p>
    @foreach ($networks as $network => [$icon, $shareUrl])
        <a href="{{ $shareUrl }}" @if ($icon !== 'mail') target="_blank" rel="noopener" @endif class="grid size-11 place-items-center rounded-full border border-brand-100 text-brand-700 transition hover:border-brand-600 hover:bg-brand-600 hover:text-white" aria-label="Share on {{ $network }}">
            <x-icon :name="$icon" class="size-5" />
        </a>
    @endforeach
    <button type="button" data-copy-link="{{ $url }}" class="grid size-11 place-items-center rounded-full border border-brand-100 text-brand-700 transition hover:border-brand-600 hover:bg-brand-600 hover:text-white" aria-label="Copy link">
        <x-icon name="link" class="size-5" />
    </button>
    <button type="button" data-native-share data-share-url="{{ $url }}" data-share-title="{{ $title }}" class="hidden size-11 place-items-center rounded-full border border-brand-100 text-brand-700 transition hover:border-brand-600 hover:bg-brand-600 hover:text-white" aria-label="More ways to share">
        <x-icon name="share" class="size-5" />
    </button>
    <span data-copy-link-status role="status" class="text-sm font-semibold text-brand-600"></span>
</div>
