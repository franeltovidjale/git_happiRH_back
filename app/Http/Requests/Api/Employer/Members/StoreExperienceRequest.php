<?php

namespace App\Http\Requests\Api\Employer\Members;

use Illuminate\Foundation\Http\FormRequest;

class StoreExperienceRequest extends FormRequest
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
            'member_id' => 'required|integer|exists:members,id',
            'job_title' => 'required|string|max:255',
            'sector' => 'nullable|string|max:255',
            'company_name' => 'required|string|max:255',
            'start_date' => 'required|date|before_or_equal:today',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'responsibilities' => 'nullable|string|max:1000',
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
            'member_id.required' => 'L\'ID du membre est requis',
            'member_id.integer' => 'L\'ID du membre doit être un nombre entier',
            'member_id.exists' => 'Le membre sélectionné n\'existe pas',
            'job_title.required' => 'Le titre du poste est requis',
            'job_title.string' => 'Le titre du poste doit être une chaîne de caractères',
            'job_title.max' => 'Le titre du poste ne peut pas dépasser 255 caractères',
            'sector.string' => 'Le secteur doit être une chaîne de caractères',
            'sector.max' => 'Le secteur ne peut pas dépasser 255 caractères',
            'company_name.required' => 'Le nom de l\'entreprise est requis',
            'company_name.string' => 'Le nom de l\'entreprise doit être une chaîne de caractères',
            'company_name.max' => 'Le nom de l\'entreprise ne peut pas dépasser 255 caractères',
            'start_date.required' => 'La date de début est requise',
            'start_date.date' => 'La date de début doit être une date valide',
            'start_date.before_or_equal' => 'La date de début ne peut pas être dans le futur',
            'end_date.date' => 'La date de fin doit être une date valide',
            'end_date.after_or_equal' => 'La date de fin doit être postérieure ou égale à la date de début',
            'responsibilities.string' => 'Les responsabilités doivent être une chaîne de caractères',
            'responsibilities.max' => 'Les responsabilités ne peuvent pas dépasser 1000 caractères',
        ];
    }
}
