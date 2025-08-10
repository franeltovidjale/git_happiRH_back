<?php

namespace App\Http\Requests\Employer;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Store Department Request
 */
class StoreDepartmentRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
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
            'enterprise_id' => 'required|exists:enterprises,id',
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
            'enterprise_id.required' => 'Enterprise is required',
            'enterprise_id.exists' => 'Selected enterprise does not exist',
            'name.required' => 'Department name is required',
            'name.max' => 'Department name cannot exceed 255 characters',
            'active.boolean' => 'Active status must be true or false',
        ];
    }
}