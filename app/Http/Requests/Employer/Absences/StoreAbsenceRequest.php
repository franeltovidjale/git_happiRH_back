<?php

namespace App\Http\Requests\Employer\Absences;

use App\Enums\AbsenceStatus;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreAbsenceRequest extends FormRequest
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
            'absence_date' => ['required', 'date'],
            'member_id' => ['required', 'exists:users,id'],
            'enterprise_id' => ['required', 'exists:enterprises,id'],
            'status' => ['nullable', Rule::in(AbsenceStatus::values())],
            'reason' => ['nullable', 'string', 'max:1000'],
        ];
    }

    /**
     * Get custom messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'absence_date.required' => 'La date d\'absence est obligatoire.',
            'absence_date.date' => 'La date d\'absence doit être une date valide.',
            'member_id.required' => 'Le membre est obligatoire.',
            'member_id.exists' => 'Le membre sélectionné n\'existe pas.',
            'enterprise_id.required' => 'L\'entreprise est obligatoire.',
            'enterprise_id.exists' => 'L\'entreprise sélectionnée n\'existe pas.',
            'status.in' => 'Le statut sélectionné est invalide.',
            'reason.string' => 'La raison doit être une chaîne de caractères.',
            'reason.max' => 'La raison ne doit pas dépasser 1000 caractères.',
        ];
    }
}
