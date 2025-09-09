<?php

namespace App\Http\Requests\Api\Employer\Projects;

use App\Enums\ProjectStatus;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateProjectRequest extends FormRequest
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
            'name' => ['sometimes', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'status' => ['nullable', Rule::in(ProjectStatus::values())],
            'lead_member_id' => [
                'nullable', 
                'exists:members,id',
                function ($attribute, $value, $fail) {
                    if ($value && !isMemberPartOfEnterprise($value)) {
                        $fail('Le chef de projet sélectionné ne fait pas partie de votre entreprise.');
                    }
                }
            ],
        ];
    }

    /**
     * Get custom messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'name.string' => 'Le nom du projet doit être une chaîne de caractères.',
            'name.max' => 'Le nom du projet ne doit pas dépasser 255 caractères.',
            'status.in' => 'Le statut du projet sélectionné est invalide.',
            'lead_member_id.exists' => 'Le chef de projet sélectionné n\'existe pas.',
        ];
    }
}
