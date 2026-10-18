<?php

namespace App\Models;

use Database\Factories\PostFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Scope;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

#[Fillable(['title', 'slug', 'category', 'excerpt', 'body', 'image', 'published_at'])]
class Post extends Model
{
    /** @use HasFactory<PostFactory> */
    use HasFactory;

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'published_at' => 'datetime',
        ];
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    /**
     * The news categories posts can be filed under.
     *
     * @return list<string>
     */
    public static function categories(): array
    {
        return array_column(config('prolis.news_categories'), 0);
    }

    /**
     * Posts that are live on the website, newest first.
     */
    #[Scope]
    protected function published(Builder $query): void
    {
        $query->whereNotNull('published_at')->where('published_at', '<=', now())->latest('published_at');
    }

    /**
     * Estimated minutes to read the article, at roughly 200 words a minute.
     */
    public function readingTime(): int
    {
        return max(1, (int) ceil(str_word_count(strip_tags($this->body)) / 200));
    }

    /**
     * The icon used for this post's category.
     */
    public function categoryIcon(): string
    {
        return collect(config('prolis.news_categories'))->firstWhere(0, $this->category)[2] ?? 'news';
    }

    public function isPublished(): bool
    {
        return $this->published_at !== null && $this->published_at->isPast();
    }

    /**
     * @return Attribute<string|null, never>
     */
    protected function imageUrl(): Attribute
    {
        return Attribute::get(fn (): ?string => $this->image ? asset('storage/'.$this->image) : null);
    }
}
