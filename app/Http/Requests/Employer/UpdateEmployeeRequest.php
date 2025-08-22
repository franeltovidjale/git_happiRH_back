<?php

namespace App\Http\Requests\Employer;

use App\Models\Member;
use Illuminate\Foundation\Http\FormRequest;

/**
 * Update Employee Request
 */
class UpdateEmployeeRequest extends FormRequest
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
        $memberId = $this->route('employee');

        return [
            // User-related fields - only validate if provided
            'first_name' => 'sometimes|required|string|max:100',
            'last_name' => 'sometimes|required|string|max:100',
            'phone' => 'sometimes|required|string|max:20',

            // Personal Information - only validate if provided
            'birth_date' => [
                'sometimes',
                'required',
                'date',
                'before_or_equal:' . now()->subYears(18)->format('Y-m-d'),
            ],
            'marital_status' => 'sometimes|nullable|in:single,married,divorced,widowed',
            'gender' => 'sometimes|nullable|in:male,female,other',
            'nationality' => 'sometimes|nullable|string|max:255',

            // Address Information - only validate if provided
            'address' => 'sometimes|nullable|string',
            'city' => 'sometimes|nullable|string|max:255',
            'state' => 'sometimes|nullable|string|max:255',
            'zip_code' => 'sometimes|nullable|string|max:20',

            // Professional Information - only validate if provided
            'username' => [
                'sometimes',
                'nullable',
                'string',
                'unique:members,username,' . $memberId,
            ],
            'role' => 'sometimes|required|string|max:255',
            'designation' => 'sometimes|nullable|string|max:255',
            'joining_date' => 'sometimes|required|date',
            'location_id' => 'sometimes|nullable|exists:locations,id',

            // Employment Information - only validate if provided
            'contract_type' => 'sometimes|nullable|in:cdi,cdd,permanent',
            'job_type' => 'sometimes|nullable|in:remote,hybrid,in-office',

            // Banking Information - only validate if provided
            'bank_account_number' => 'sometimes|required|string|max:50',
            'bank_name' => 'sometimes|required|string|max:255',
            'pan_number' => 'sometimes|required|string|max:20',
            'ifsc_code' => 'sometimes|required|string|max:20',

            // Salary and Payment Information - only validate if provided
            'salary_basis' => 'sometimes|nullable|string|max:100',
            'effective_date' => 'sometimes|nullable|date',
            'monthly_salary_amount' => 'sometimes|nullable|numeric|min:0|max:99999999.99',
            'type_of_payment' => 'sometimes|nullable|string|max:100',
            'billing_rate' => 'sometimes|nullable|numeric|min:0|max:99999999.99',

            // Contact Information - only validate if provided
            'contact_person_full_name' => 'sometimes|required|string|max:255',
            'contact_person_phone' => 'sometimes|required|string|max:20',

            // Status - only validate if provided
            'active' => 'sometimes|boolean',
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

            // Personal Information messages
            'birth_date.date' => 'La date de naissance doit être une date valide',
            'birth_date.before_or_equal' => 'L\'employé doit avoir au moins 18 ans',
            'marital_status.in' => 'Le statut marital doit être single, married, divorced ou widowed',
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
            'designation.max' => 'La désignation ne peut pas dépasser 255 caractères',
            'joining_date.required' => 'La date d\'embauche est obligatoire',
            'joining_date.date' => 'La date d\'embauche doit être une date valide',
            'location_id.exists' => 'L\'emplacement sélectionné n\'existe pas',

            // Employment Information messages
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
            'contact_person_full_name.max' => 'Le nom complet du contact ne peut pas dépasser 255 caractères',
            'contact_person_phone.max' => 'Le téléphone du contact ne peut pas dépasser 20 caractères',

            // Status messages
            'active.boolean' => 'Le statut actif doit être vrai ou faux',
        ];
    }

    /**
     * Get only the validated data that was actually provided in the request.
     *
     * @return array<string, mixed>
     */
    public function validatedData(): array
    {
        return $this->only(array_keys($this->rules()));
    }
}