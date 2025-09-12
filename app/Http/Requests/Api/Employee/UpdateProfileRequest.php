<?php

namespace App\Http\Requests\Api\Employee;

use App\Models\Member;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateProfileRequest extends FormRequest
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
            // User fields
            'first_name' => ['sometimes', 'string', 'max:255'],
            'last_name' => ['sometimes', 'string', 'max:255'],
            'phone' => ['sometimes', 'nullable', 'string', 'max:20'],

            // Member fields
            'birth_date' => ['sometimes', 'nullable', 'date', 'before_or_equal:' . now()->subYears(18)->format('Y-m-d')],
            'marital_status' => ['sometimes', 'nullable', 'string', Rule::in([
                Member::MARITAL_STATUS_SINGLE,
                Member::MARITAL_STATUS_MARRIED,
                Member::MARITAL_STATUS_DIVORCED,
                Member::MARITAL_STATUS_WIDOWED,
            ])],
            'nationality' => ['sometimes', 'nullable', 'string', 'max:255'],
        ];
    }

    /**
     * Get custom error messages for validator errors.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'first_name.max' => 'Le prénom ne peut pas dépasser 255 caractères.',
            'last_name.max' => 'Le nom de famille ne peut pas dépasser 255 caractères.',
            'phone.max' => 'Le numéro de téléphone ne peut pas dépasser 20 caractères.',
            'birth_date.date' => 'La date de naissance doit être une date valide.',
            'birth_date.before_or_equal' => 'Vous devez avoir au moins 18 ans.',
            'nationality.max' => 'La nationalité ne peut pas dépasser 255 caractères.',
        ];
    }
}
