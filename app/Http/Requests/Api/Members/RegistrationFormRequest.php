<?php

namespace App\Http\Requests\Api\Members;

use App\Models\Member;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class RegistrationFormRequest extends FormRequest
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
            // User fields from User fillable
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'string', 'max:20'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],

            // Enterprise identification
            'enterprise_code' => ['required', 'string', 'exists:enterprises,code'],

            // Member fields (optional for registration)
            'birth_date' => ['nullable', 'date', 'before_or_equal:' . now()->subYears(18)->format('Y-m-d')],
            'marital_status' => ['nullable', 'string', Rule::in([
                Member::MARITAL_STATUS_SINGLE,
                Member::MARITAL_STATUS_MARRIED,
                Member::MARITAL_STATUS_DIVORCED,
                Member::MARITAL_STATUS_WIDOWED,
            ])],
            'nationality' => ['nullable', 'string', 'max:255'],
            'location_id' => ['nullable', 'integer', 'exists:locations,id'],
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
            'first_name.required' => 'Le prénom est obligatoire.',
            'last_name.required' => 'Le nom de famille est obligatoire.',
            'email.required' => 'L\'adresse e-mail est obligatoire.',
            'email.email' => 'L\'adresse e-mail doit être valide.',
            'email.unique' => 'Cette adresse e-mail est déjà utilisée.',
            'password.required' => 'Le mot de passe est obligatoire.',
            'password.min' => 'Le mot de passe doit contenir au moins 8 caractères.',
            'password.confirmed' => 'La confirmation du mot de passe ne correspond pas.',
            'enterprise_code.required' => 'Le code d\'entreprise est obligatoire.',
            'enterprise_code.exists' => 'Le code d\'entreprise n\'existe pas.',
            'birth_date.date' => 'La date de naissance doit être une date valide.',
            'birth_date.before_or_equal' => 'Vous devez avoir au moins 18 ans pour vous inscrire.',
            'joining_date.date' => 'La date d\'embauche doit être une date valide.',
            'location_id.exists' => 'L\'emplacement sélectionné n\'existe pas.',
            'department_id.exists' => 'Le département sélectionné n\'existe pas.',
        ];
    }
}
