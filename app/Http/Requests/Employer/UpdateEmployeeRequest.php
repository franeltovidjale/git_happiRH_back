<?php

namespace App\Http\Requests\Employer;

use App\Models\Employee;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

/**
 * Update Employee Request
 */
class UpdateEmployeeRequest extends FormRequest
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
        $employeeId = $this->route('employee');
        $userId = Employee::find($employeeId)?->user_id;

        return [
            // User-related fields
            'first_name' => 'required|string|max:100',
            'last_name' => 'required|string|max:100',
            'phone' => 'required|string|max:20',
            'email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('users', 'email')->ignore($userId)
            ],

            // Employee-specific fields
            'birth_date' => 'nullable|date',
            'marital_status' => 'nullable|in:single,married,divorced,widowed',
            'gender' => 'nullable|in:male,female,other',
            'nationality' => 'nullable|string|max:255',
            'address' => 'nullable|string',
            'city' => 'nullable|string|max:255',
            'state' => 'nullable|string|max:255',
            'zip_code' => 'nullable|string|max:20',
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
            // User-related messages
            'first_name.required' => 'Le prénom est obligatoire',
            'first_name.max' => 'Le prénom ne peut pas dépasser 100 caractères',
            'last_name.required' => 'Le nom est obligatoire',
            'last_name.max' => 'Le nom ne peut pas dépasser 100 caractères',
            'phone.required' => 'Le téléphone est obligatoire',
            'phone.max' => 'Le téléphone ne peut pas dépasser 20 caractères',
            'email.required' => 'L\'adresse email est obligatoire',
            'email.email' => 'L\'adresse email doit être valide',
            'email.unique' => 'Cette adresse email est déjà utilisée',

            // Employee-specific messages
            'birth_date.date' => 'La date de naissance doit être une date valide',
            'marital_status.in' => 'Le statut marital doit être single, married, divorced ou widowed',
            'gender.in' => 'Le genre doit être male, female ou other',
            'nationality.max' => 'La nationalité ne peut pas dépasser 255 caractères',
            'city.max' => 'La ville ne peut pas dépasser 255 caractères',
            'state.max' => 'L\'état ne peut pas dépasser 255 caractères',
            'zip_code.max' => 'Le code postal ne peut pas dépasser 20 caractères',
            'active.boolean' => 'Le statut actif doit être vrai ou faux',
        ];
    }
}