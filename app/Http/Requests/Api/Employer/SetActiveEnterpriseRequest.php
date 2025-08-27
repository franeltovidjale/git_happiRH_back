<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

class SetActiveEnterpriseRequest extends FormRequest
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
            'enterprise_id' => 'required|integer|exists:enterprises,id',
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
            'enterprise_id.required' => 'L\'identifiant de l\'entreprise est requis.',
            'enterprise_id.integer' => 'L\'identifiant de l\'entreprise doit être un nombre entier.',
            'enterprise_id.exists' => 'L\'entreprise spécifiée n\'existe pas.',
        ];
    }

    /**
     * Get custom error messages for authorization.
     *
     * @return array<string, string>
     */
    public function failedAuthorization(): void
    {
        abort(403, 'Vous n\'êtes pas autorisé à définir cette entreprise comme active.');
    }
}
