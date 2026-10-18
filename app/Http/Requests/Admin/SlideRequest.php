<?php

namespace App\Http\Requests\Admin;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class SlideRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation(): void
    {
        $this->merge(['is_active' => $this->boolean('is_active')]);
    }

    /**
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $link = ['nullable', 'string', 'max:255', 'regex:#^(/|https?://)#'];

        return [
            'title' => ['required', 'string', 'max:255'],
            'text' => ['nullable', 'string', 'max:1000'],
            'image' => ['nullable', 'image', 'max:5120'],
            'image_alt' => ['nullable', 'string', 'max:255'],
            'primary_button_text' => ['nullable', 'string', 'max:60', 'required_with:primary_button_url'],
            'primary_button_url' => [...$link, 'required_with:primary_button_text'],
            'secondary_button_text' => ['nullable', 'string', 'max:60', 'required_with:secondary_button_url'],
            'secondary_button_url' => [...$link, 'required_with:secondary_button_text'],
            'sort_order' => ['required', 'integer', 'min:0'],
            'is_active' => ['boolean'],
        ];
    }

    /**
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'primary_button_url.regex' => 'Links must start with / for a page on this site, or with http:// or https://.',
            'secondary_button_url.regex' => 'Links must start with / for a page on this site, or with http:// or https://.',
        ];
    }
}
