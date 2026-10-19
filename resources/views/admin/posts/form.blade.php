<x-layouts.admin :title="$post->exists ? 'Edit article' : 'Write article'">
    <a href="{{ route('admin.posts.index') }}" class="mb-4 inline-flex items-center gap-1.5 text-sm font-bold text-muted hover:text-ink"><x-icon name="arrow-left" class="size-4" /> News articles</a>
    <x-admin.header :title="$post->exists ? 'Edit article' : 'Write article'" />

    <form method="POST" action="{{ $post->exists ? route('admin.posts.update', $post) : route('admin.posts.store') }}" enctype="multipart/form-data">
        @csrf
        @if ($post->exists) @method('PUT') @endif

        <div class="grid gap-8 lg:grid-cols-3">
            <x-admin.panel class="grid content-start gap-6 lg:col-span-2">
                <x-admin.input name="title" label="Title" :value="$post->title" required />
                <x-admin.textarea name="excerpt" label="Summary" :value="$post->excerpt" rows="2" help="A sentence or two shown on the News page and at the top of the article." />
                <x-admin.textarea name="body" label="Article" :value="$post->body" rows="16" required toolbar="full" />
            </x-admin.panel>

            <div class="grid content-start gap-8">
                <x-admin.panel class="grid gap-5">
                    @php($status = old('status', $post->exists && ! $post->published_at ? 'draft' : 'published'))
                    <fieldset>
                        <legend class="form-label">Status</legend>
                        <div class="grid gap-2">
                            <label class="flex items-center gap-2 font-semibold"><input type="radio" name="status" value="published" @checked($status === 'published') class="accent-brand-600"> Published</label>
                            <label class="flex items-center gap-2 font-semibold"><input type="radio" name="status" value="draft" @checked($status === 'draft') class="accent-brand-600"> Draft (hidden)</label>
                        </div>
                        @error('status') <p class="form-error">{{ $message }}</p> @enderror
                    </fieldset>
                    <x-admin.input name="published_at" label="Publish date" type="datetime-local" :value="$post->published_at?->format('Y-m-d\TH:i')" help="Choose a future date to schedule the article." />

                    <div>
                        <label for="category" class="form-label">Category <span class="text-brand-600">*</span></label>
                        <select id="category" name="category" required class="form-input">
                            @foreach (\App\Models\Post::categories() as $category)
                                <option @selected(old('category', $post->category) === $category)>{{ $category }}</option>
                            @endforeach
                        </select>
                        @error('category') <p class="form-error">{{ $message }}</p> @enderror
                    </div>
                </x-admin.panel>

                <x-admin.panel>
                    <x-admin.image name="image" label="Cover photo" :url="$post->image_url" />
                </x-admin.panel>
            </div>
        </div>

        <div class="mt-6 flex gap-3">
            <button type="submit" class="btn-primary">{{ $post->exists ? 'Save changes' : 'Save article' }}</button>
            <a href="{{ route('admin.posts.index') }}" class="btn-outline">Cancel</a>
        </div>
    </form>
</x-layouts.admin>
