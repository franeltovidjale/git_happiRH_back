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

            // Professional fields
            'username' => 'nullable|string|unique:employees,username',
            'role' => 'required|string|max:255',
            'designation' => 'nullable|string|max:255',
            'joining_date' => 'required|date',
            'location_id' => 'nullable|exists:locations,id',

            // Banking fields
            'bank_account_number' => 'nullable|string|max:50',
            'bank_name' => 'nullable|string|max:255',
            'pan_number' => 'nullable|string|max:20',
            'ifsc_code' => 'nullable|string|max:20',

            // Salary and Payment fields
            'salary_basis' => 'nullable|string|max:100',
            'effective_date' => 'nullable|date',
            'monthly_salary_amount' => 'nullable|numeric|min:0|max:99999999.99',
            'type_of_payment' => 'nullable|string|max:100',
            'billing_rate' => 'nullable|numeric|min:0|max:99999999.99',

            // Job Information
            'job_type' => 'nullable|in:remote,hybrid,in-office',
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

            // Professional messages
            'username.unique' => 'Ce nom d\'utilisateur est déjà utilisé',
            'role.required' => 'Le rôle est obligatoire',
            'role.max' => 'Le rôle ne peut pas dépasser 255 caractères',
            'designation.max' => 'La désignation ne peut pas dépasser 255 caractères',
            'joining_date.required' => 'La date d\'embauche est obligatoire',
            'joining_date.date' => 'La date d\'embauche doit être une date valide',
            'location_id.exists' => 'L\'emplacement sélectionné n\'existe pas',

            // Banking messages
            'bank_account_number.max' => 'Le numéro de compte bancaire ne peut pas dépasser 50 caractères',
            'bank_name.max' => 'Le nom de la banque ne peut pas dépasser 255 caractères',
            'pan_number.max' => 'Le numéro PAN ne peut pas dépasser 20 caractères',
            'ifsc_code.max' => 'Le code IFSC ne peut pas dépasser 20 caractères',

            // Salary and Payment messages
            'salary_basis.max' => 'La base de salaire ne peut pas dépasser 100 caractères',
            'effective_date.date' => 'La date d\'effet doit être une date valide',
            'monthly_salary_amount.numeric' => 'Le montant du salaire mensuel doit être un nombre',
            'monthly_salary_amount.min' => 'Le montant du salaire mensuel doit être positif',
            'monthly_salary_amount.max' => 'Le montant du salaire mensuel ne peut pas dépasser 99,999,999.99',
            'type_of_payment.max' => 'Le type de paiement ne peut pas dépasser 100 caractères',
            'billing_rate.numeric' => 'Le taux de facturation doit être un nombre',
            'billing_rate.min' => 'Le taux de facturation doit être positif',
            'billing_rate.max' => 'Le taux de facturation ne peut pas dépasser 99,999,999.99',

            // Job Information messages
            'job_type.in' => 'Le type de travail doit être remote, hybrid ou in-office',
        ];
    }
}