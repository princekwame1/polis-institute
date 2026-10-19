{!! '<?xml version="1.0" encoding="UTF-8"?>' !!}
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
@foreach ($pages as $url)
    <url>
        <loc>{{ $url }}</loc>
    </url>
@endforeach
@foreach ($posts as $post)
    <url>
        <loc>{{ route('news.show', $post) }}</loc>
        <lastmod>{{ $post->updated_at->toAtomString() }}</lastmod>
    </url>
@endforeach
@foreach ($policies as $url)
    <url>
        <loc>{{ $url }}</loc>
    </url>
@endforeach
</urlset>
