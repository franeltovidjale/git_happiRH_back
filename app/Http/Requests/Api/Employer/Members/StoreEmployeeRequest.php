<?php

namespace App\Http\Requests\Api\Employer\Members;

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

            // Personal Information
            'birth_date' => [
                'required',
                'date',
                'before_or_equal:' . now()->subYears(18)->format('Y-m-d'),
            ],
            'marital_status' => 'nullable|in:single,married,divorced,widowed',
            'gender' => 'required|in:male,female,other',
            'nationality' => 'nullable|string|max:255',

            // Address Information
            'address' => 'nullable|string',
            'city' => 'nullable|string|max:255',
            'state' => 'nullable|string|max:255',
            'zip_code' => 'nullable|string|max:20',

            // Professional Information
            'username' => 'nullable|string|unique:employees,username',
            'role' => 'required|string|max:255',
            'joining_date' => 'required|date',
            'location_id' => 'nullable|exists:locations,id',
            'department_id' => 'required|exists:departments,id',

            // Employment Information
            'contract_type' => 'required|in:cdi,cdd,permanent',
            'job_type' => 'nullable|in:remote,hybrid,in-office',

            // Banking Information
            'bank_account_number' => 'nullable|string|max:50',
            'bank_name' => 'nullable|string|max:255',
            'pan_number' => 'nullable|string|max:20',
            'ifsc_code' => 'nullable|string|max:20',

            // Salary and Payment Information
            'salary_basis' => 'nullable|string|max:100',
            'effective_date' => 'nullable|date',
            'monthly_salary_amount' => 'nullable|numeric|min:0|max:99999999.99',
            'type_of_payment' => 'nullable|string|max:100',
            'billing_rate' => 'nullable|numeric|min:0|max:99999999.99',

            // Contact Information
            'contact_person_full_name' => 'nullable|string|max:255',
            'contact_person_phone' => 'nullable|string|max:20',

            // Status
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

            // Personal Information messages
            'birth_date.required' => 'La date de naissance est obligatoire',
            'birth_date.date' => 'La date de naissance doit être une date valide',
            'birth_date.before_or_equal' => 'L\'employé doit avoir au moins 18 ans',
            'marital_status.in' => 'Le statut marital doit être single, married, divorced ou widowed',
            'gender.required' => 'Le genre est obligatoire',
            'gender.in' => 'Le genre doit être male, female ou other',
            'nationality.max' => 'La nationalité ne peut pas dépasser 255 caractères',

            // Address Information messages
            'city.max' => 'La ville ne peut pas dépasser 255 caractères',
            'state.max' => 'L\'état ne peut pas dépasser 255 caractères',
            'zip_code.max' => 'Le code postal ne peut pas dépasser 20 caractères',

            // Professional Information messages
            'username.unique' => 'Ce nom d\'utilisateur est déjà utilisé',
            'role.required' => 'Le rôle est obligatoire',
            'role.max' => 'Le rôle ne peut pas dépasser 255 caractères',

            'joining_date.required' => 'La date d\'embauche est obligatoire',
            'joining_date.date' => 'La date d\'embauche doit être une date valide',
            'location_id.exists' => 'L\'emplacement sélectionné n\'existe pas',
            'department_id.required' => 'Le département est obligatoire',
            'department_id.exists' => 'Le département sélectionné n\'existe pas',

            // Employment Information messages
            'contract_type.required' => 'Le type de contrat est obligatoire',
            'contract_type.in' => 'Le type de contrat doit être cdi, cdd ou permanent',
            'job_type.in' => 'Le type de travail doit être remote, hybrid ou in-office',

            // Banking Information messages
            'bank_account_number.max' => 'Le numéro de compte bancaire ne peut pas dépasser 50 caractères',
            'bank_name.max' => 'Le nom de la banque ne peut pas dépasser 255 caractères',
            'pan_number.max' => 'Le numéro PAN ne peut pas dépasser 20 caractères',
            'ifsc_code.max' => 'Le code IFSC ne peut pas dépasser 20 caractères',

            // Salary and Payment Information messages
            'salary_basis.max' => 'La base de salaire ne peut pas dépasser 100 caractères',
            'effective_date.date' => 'La date d\'effet doit être une date valide',
            'monthly_salary_amount.numeric' => 'Le montant du salaire mensuel doit être un nombre',
            'monthly_salary_amount.min' => 'Le montant du salaire mensuel doit être positif',
            'monthly_salary_amount.max' => 'Le montant du salaire mensuel ne peut pas dépasser 99,999,999.99',
            'type_of_payment.max' => 'Le type de paiement ne peut pas dépasser 100 caractères',
            'billing_rate.numeric' => 'Le taux de facturation doit être un nombre',
            'billing_rate.min' => 'Le taux de facturation doit être positif',
            'billing_rate.max' => 'Le taux de facturation ne peut pas dépasser 99,999,999.99',

            // Contact Information messages
            'contact_person_full_name.max' => 'Le nom complet de la personne de contact ne peut pas dépasser 255 caractères',
            'contact_person_phone.max' => 'Le téléphone de la personne de contact ne peut pas dépasser 20 caractères',

            // Status messages
            'active.boolean' => 'Le statut actif doit être vrai ou faux',
        ];
    }
}
