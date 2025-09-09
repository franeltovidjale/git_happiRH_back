<?php

namespace App\Http\Requests\Api\Employer;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Update Location Request
 */
class UpdateLocationRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'active' => 'boolean',
        ];
    }

    /**
     * Get custom error messages for validation rules.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'name.required' => 'Location name is required',
            'name.max' => 'Location name cannot exceed 255 characters',
            'active.boolean' => 'Active status must be true or false',
        ];
    }
}
