<?php

namespace App\Models;

use Database\Factories\CourseAreaFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Scope;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

#[Fillable(['title', 'slug', 'icon', 'summary', 'items', 'show_on_home', 'sort_order'])]
class CourseArea extends Model
{
    /** @use HasFactory<CourseAreaFactory> */
    use HasFactory;

    /**
     * Icons available for course areas in the admin dashboard.
     */
    public const ICONS = ['megaphone', 'device', 'news', 'star', 'calendar', 'users', 'clipboard', 'heart', 'mic', 'briefcase', 'book', 'graduation', 'trending', 'building'];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'items' => 'array',
            'show_on_home' => 'boolean',
            'sort_order' => 'integer',
        ];
    }

    #[Scope]
    protected function ordered(Builder $query): void
    {
        $query->orderBy('sort_order')->orderBy('id');
    }
}
