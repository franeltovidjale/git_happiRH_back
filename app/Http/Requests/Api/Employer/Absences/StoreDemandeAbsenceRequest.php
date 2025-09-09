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
            'end_date' => ['nullable', 'date', 'after_or_equal:start_date'],
            'type' => ['required', Rule::in(DemandeAbsenceType::values())],
            'period' => [
                'required',
                'string',
                'regex:/^\d+[hdjms]$/', // Format: 3h, 1d, 1w, 2m, etc.
                function ($attribute, $value, $fail) {
                    $this->validatePeriod($value, $fail);
                },
            ],
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

    private function validatePeriod(string $period, \Closure $fail): void
    {
        // Extract number and unit
        if (! preg_match('/^(\d+)([hdjms])$/', $period, $matches)) {
            $fail('Le format de période doit être: nombre + unité (h=heures, d=jours, j=jours, m=mois, s=semaines).');

            return;
        }

        $number = (int) $matches[1];
        $unit = $matches[2];

        // Validate constraints based on unit
        match ($unit) {
            'h' => $number < 1 || $number > 24 ? $fail('Les heures doivent être entre 1 et 24.') : null,
            'd', 'j' => $number < 1 || $number > 365 ? $fail('Les jours doivent être entre 1 et 365.') : null,
            's' => $number < 1 || $number > 52 ? $fail('Les semaines doivent être entre 1 et 52.') : null,
            'm' => $number < 1 || $number > 12 ? $fail('Les mois doivent être entre 1 et 12.') : null,
            default => $fail('Unité non supportée. Utilisez: h (heures), d/j (jours), s (semaines), m (mois).')
        };

        // Validate end_date is provided for multi-day periods
        if (in_array($unit, ['d', 'j', 's', 'm']) && $number > 1 && ! $this->filled('end_date')) {
            $fail('La date de fin est obligatoire pour les périodes de plus d\'un jour.');
        }
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
            'end_date.date' => 'La date de fin doit être une date valide.',
            'end_date.after_or_equal' => 'La date de fin doit être postérieure ou égale à la date de début.',
            'type.required' => 'Le type de demande est obligatoire.',
            'type.in' => 'Le type de demande sélectionné est invalide.',
            'period.required' => 'La période est obligatoire.',
            'period.string' => 'La période doit être une chaîne de caractères.',
            'period.regex' => 'Le format de période est invalide. Exemple: 3h, 1d, 1s, 2m.',
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
