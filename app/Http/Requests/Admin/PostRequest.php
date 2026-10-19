<?php

namespace App\Http\Requests\Admin;

use App\Models\Post;
use App\Support\RichText;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class PostRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'excerpt' => RichText::sanitize($this->input('excerpt')),
            'body' => RichText::sanitize($this->input('body')),
        ]);
    }

    /**
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:255'],
            'category' => ['required', Rule::in(Post::categories())],
            'excerpt' => ['nullable', 'string', 'max:500'],
            'body' => ['required', 'string', 'max:50000'],
            'image' => ['nullable', 'image', 'max:5120'],
            'status' => ['required', Rule::in(['published', 'draft'])],
            'published_at' => ['nullable', 'date'],
        ];
    }

    /**
     * The validated data ready to save, with the publish date resolved from the status.
     *
     * @return array<string, mixed>
     */
    public function postData(): array
    {
        $data = $this->safe()->except(['image', 'status']);

        $data['published_at'] = $this->validated('status') === 'draft'
            ? null
            : ($this->validated('published_at') ?? now());

        return $data;
    }
}
