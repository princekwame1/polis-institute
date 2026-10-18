<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\Concerns\HandlesImageUploads;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\PostRequest;
use App\Models\Post;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Str;

class PostController extends Controller
{
    use HandlesImageUploads;

    public function index(): View
    {
        return view('admin.posts.index', ['posts' => Post::latest()->paginate(20)]);
    }

    public function create(): View
    {
        return view('admin.posts.form', ['post' => new Post(['published_at' => now()])]);
    }

    public function store(PostRequest $request): RedirectResponse
    {
        Post::create([
            ...$request->postData(),
            'slug' => $this->uniqueSlug($request->validated('title')),
            'image' => $this->syncImage($request, 'image', 'posts'),
        ]);

        return redirect()->route('admin.posts.index')->with('status', 'Article saved.');
    }

    public function edit(Post $post): View
    {
        return view('admin.posts.form', ['post' => $post]);
    }

    public function update(PostRequest $request, Post $post): RedirectResponse
    {
        $post->update([
            ...$request->postData(),
            'image' => $this->syncImage($request, 'image', 'posts', $post->image),
        ]);

        return redirect()->route('admin.posts.index')->with('status', 'Article updated.');
    }

    public function destroy(Post $post): RedirectResponse
    {
        $this->deleteImage($post->image);
        $post->delete();

        return redirect()->route('admin.posts.index')->with('status', 'Article deleted.');
    }

    private function uniqueSlug(string $title): string
    {
        $base = Str::slug($title) ?: 'article';
        $slug = $base;
        $suffix = 2;

        while (Post::where('slug', $slug)->exists()) {
            $slug = "{$base}-{$suffix}";
            $suffix++;
        }

        return $slug;
    }
}
