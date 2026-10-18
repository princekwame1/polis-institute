<x-layouts.admin title="News articles">
    <x-admin.header title="News articles" description="Articles shown on the News and Publications page.">
        <a href="{{ route('admin.posts.create') }}" class="btn-primary"><x-icon name="plus" class="size-4" /> Write article</a>
    </x-admin.header>

    @if ($posts->isEmpty())
        <x-admin.empty icon="news" title="No articles yet" :action="route('admin.posts.create')" action-label="Write article">
            Until you publish an article, the News page shows the four news categories.
        </x-admin.empty>
    @else
        <div class="overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-sm">
            <ul class="divide-y divide-gray-100">
                @foreach ($posts as $post)
                    <li class="flex flex-wrap items-center gap-4 p-4">
                        <div class="h-16 w-24 shrink-0 overflow-hidden rounded-lg bg-brand-100">
                            @if ($post->image_url)
                                <img src="{{ $post->image_url }}" alt="" class="size-full object-cover">
                            @endif
                        </div>
                        <div class="min-w-0 flex-1">
                            <p class="font-bold">{{ $post->title }}</p>
                            <p class="text-sm text-muted">
                                {{ $post->category }} ·
                                @if ($post->isPublished())
                                    <span class="font-semibold text-green-700">Published {{ $post->published_at->format('j M Y') }}</span>
                                @elseif ($post->published_at)
                                    <span class="font-semibold text-amber-700">Scheduled for {{ $post->published_at->format('j M Y, g:i a') }}</span>
                                @else
                                    <span class="font-semibold text-gray-500">Draft</span>
                                @endif
                            </p>
                        </div>
                        <div class="flex items-center gap-1">
                            @if ($post->isPublished())
                                <a href="{{ route('news.show', $post) }}" target="_blank" class="inline-flex items-center gap-1.5 rounded-lg px-3 py-2 text-sm font-bold text-muted hover:bg-gray-100"><x-icon name="external" class="size-4" /> View</a>
                            @endif
                            <x-admin.edit-link :href="route('admin.posts.edit', $post)" />
                            <x-admin.delete :action="route('admin.posts.destroy', $post)" confirm="Delete this article?" />
                        </div>
                    </li>
                @endforeach
            </ul>
        </div>

        <div class="mt-6">{{ $posts->links() }}</div>
    @endif
</x-layouts.admin>
