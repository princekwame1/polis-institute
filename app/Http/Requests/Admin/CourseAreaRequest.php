<?php

namespace App\Http\Requests\Admin;

use App\Models\CourseArea;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class CourseAreaRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation(): void
    {
        $this->merge(['show_on_home' => $this->boolean('show_on_home')]);
    }

    /**
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:255', Rule::unique('course_areas', 'title')->ignore($this->route('course_area'))],
            'icon' => ['required', Rule::in(CourseArea::ICONS)],
            'summary' => ['nullable', 'string', 'max:500'],
            'items' => ['required', 'string', 'max:5000'],
            'show_on_home' => ['boolean'],
            'sort_order' => ['required', 'integer', 'min:0'],
        ];
    }

    /**
     * @return array<string, string>
     */
    public function attributes(): array
    {
        return ['items' => 'courses'];
    }

    /**
     * The validated data ready to save, with the course list split into lines.
     *
     * @return array<string, mixed>
     */
    public function courseAreaData(): array
    {
        return [
            ...$this->validated(),
            'slug' => Str::slug($this->validated('title')),
            'items' => collect(preg_split('/\R/', $this->validated('items')))
                ->map(fn (string $item): string => trim($item))
                ->filter()
                ->values()
                ->all(),
        ];
    }
}
