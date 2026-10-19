@props(['data'])

<script type="application/ld+json">{!! json_encode(['@context' => 'https://schema.org', ...$data], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_HEX_TAG) !!}</script>
