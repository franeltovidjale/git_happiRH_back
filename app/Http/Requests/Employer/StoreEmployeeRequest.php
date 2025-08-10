<?php

namespace App\Http\Requests\Employer;

use Illuminate\Foundation\Http\FormRequest;

class StoreEmployeeRequest extends FormRequest
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
            // User-related fields
            'first_name' => 'required|string|max:100',
            'last_name' => 'required|string|max:100',
            'email' => 'required|email|unique:users,email',
            'phone' => 'required|string|max:20',
            'enterprise_id' => 'required|exists:enterprises,id',

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
            'email.required' => 'L\'adresse email est obligatoire',
            'email.email' => 'L\'adresse email doit être valide',
            'email.unique' => 'Cette adresse email est déjà utilisée',
            'phone.required' => 'Le téléphone est obligatoire',
            'phone.max' => 'Le téléphone ne peut pas dépasser 20 caractères',
            'enterprise_id.required' => 'L\'entreprise est obligatoire',
            'enterprise_id.exists' => 'L\'entreprise sélectionnée n\'existe pas',

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