<?php

namespace App\Http\Requests;

use App\Models\Enquiry;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreEnquiryRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'type' => ['required', Rule::in(Enquiry::TYPES)],
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
            'phone' => [Rule::requiredIf($this->input('type') !== 'contact'), 'nullable', 'string', 'max:50'],
            'organisation' => [Rule::requiredIf($this->input('type') === 'corporate'), 'nullable', 'string', 'max:255'],
            'course' => [Rule::requiredIf($this->input('type') === 'registration'), 'nullable', 'string', 'max:255'],
            'learning_mode' => ['nullable', Rule::in(['online', 'in-person'])],
            'location' => ['nullable', Rule::in(['Accra', 'Sunyani'])],
            'subject' => ['nullable', 'string', 'max:255'],
            'message' => [Rule::requiredIf($this->input('type') === 'contact'), 'nullable', 'string', 'max:5000'],
        ];
    }
}
