<?php

namespace App\Http\Requests\Employer;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreDepartmentRequest extends FormRequest
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
        $enterpriseId = auth()->user()->active_enterprise_id;

        return [
            'name' => 'required|string|max:255',
            'active' => 'boolean',
            'slug' => [
                'nullable',
                'string',
                'max:255',
                Rule::unique('departments')->where(function ($query) use ($enterpriseId) {
                    return $query->where('enterprise_id', $enterpriseId);
                }),
            ],
            'late_penalty' => 'boolean',
            'work_model' => 'required|string|max:255',
            'meeting_participation_score' => 'boolean',
            'attendance_score' => 'boolean',
            'overtime_recording_score' => 'nullable|string|max:255',
            'overtime_clocking_score' => 'nullable|string|max:255',
            'supervisor_id' => 'nullable|integer|exists:members,id',
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
            'name.required' => 'Le nom du département est obligatoire',
            'name.max' => 'Le nom du département ne peut pas dépasser 255 caractères',
            'active.boolean' => 'Le statut actif doit être vrai ou faux',
            'slug.unique' => 'Ce slug est déjà utilisé dans cette entreprise',
            'slug.max' => 'Le slug ne peut pas dépasser 255 caractères',
            'late_penalty.boolean' => 'La pénalité de retard doit être vrai ou faux',
            'work_model.required' => 'Le modèle de travail est obligatoire',
            'work_model.max' => 'Le modèle de travail ne peut pas dépasser 255 caractères',
            'meeting_participation_score.boolean' => 'Le score de participation aux réunions doit être vrai ou faux',
            'attendance_score.boolean' => 'Le score de présence doit être vrai ou faux',
            'overtime_recording_score.max' => 'Le score d\'enregistrement des heures supplémentaires ne peut pas dépasser 255 caractères',
            'overtime_clocking_score.max' => 'Le score de pointage des heures supplémentaires ne peut pas dépasser 255 caractères',
            'supervisor_id.integer' => 'L\'ID du superviseur doit être un nombre entier',
            'supervisor_id.exists' => 'Le superviseur sélectionné n\'existe pas',
        ];
    }
}
