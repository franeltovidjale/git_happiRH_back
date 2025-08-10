<?php

namespace App\Http\Requests\Employer;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Store Enterprise Request
 */
class StoreEnterpriseRequest extends FormRequest
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
            'ifu' => 'nullable|string|max:16',
            'name' => 'required|string|max:100',
            'active' => 'boolean',
        ];
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'name.required' => 'Enterprise name is required.',
            'name.max' => 'Enterprise name cannot exceed 100 characters.',
            'ifu.max' => 'IFU cannot exceed 16 characters.',
        ];
    }
}