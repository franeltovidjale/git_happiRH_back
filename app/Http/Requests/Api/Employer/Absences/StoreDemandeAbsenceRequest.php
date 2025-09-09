<?php

namespace App\Http\Requests\Api\Employer\Absences;

use App\Enums\AbsenceStatus;
use App\Enums\DemandeAbsenceType;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreDemandeAbsenceRequest extends FormRequest
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
            'start_date' => ['required', 'date', 'after_or_equal:today'],
            'end_date' => ['required', 'date', 'after_or_equal:start_date'],
            'type' => ['required', Rule::in(DemandeAbsenceType::values())],
            'member_id' => [
                'required',
                'exists:members,id',
                function ($attribute, $value, $fail) {
                    if ($value && ! isMemberPartOfEnterprise($value)) {
                        $fail('Le membre sélectionné ne fait pas partie de votre entreprise.');
                    }
                },
            ],
            'status' => ['nullable', Rule::in(AbsenceStatus::values())],
            'reason' => ['nullable', 'string', 'max:1000'],
            'description' => ['nullable', 'string', 'max:2000'],
        ];
    }


    /**
     * Get custom messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'start_date.required' => 'La date de début est obligatoire.',
            'start_date.date' => 'La date de début doit être une date valide.',
            'start_date.after_or_equal' => 'La date de début ne peut pas être antérieure à aujourd\'hui.',
            'end_date.required' => 'La date de fin est obligatoire.',
            'end_date.date' => 'La date de fin doit être une date valide.',
            'end_date.after_or_equal' => 'La date de fin doit être postérieure ou égale à la date de début.',
            'type.required' => 'Le type de demande est obligatoire.',
            'type.in' => 'Le type de demande sélectionné est invalide.',
            'member_id.required' => 'Le membre est obligatoire.',
            'member_id.exists' => 'Le membre sélectionné n\'existe pas.',
            'status.in' => 'Le statut sélectionné est invalide.',
            'reason.string' => 'La raison doit être une chaîne de caractères.',
            'reason.max' => 'La raison ne doit pas dépasser 1000 caractères.',
            'description.string' => 'La description doit être une chaîne de caractères.',
            'description.max' => 'La description ne doit pas dépasser 2000 caractères.',
        ];
    }
}
