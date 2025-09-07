<?php

namespace App\Http\Requests\Employer\Plannings;

use App\Enums\PlanningStatus;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StorePlanningRequest extends FormRequest
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
            'assignee_id' => ['required', 'exists:users,id'],
            'date_and_time' => ['required', 'date', 'after:now'],
            'address' => ['required', 'string', 'max:500'],
            'task_id' => ['nullable', 'exists:tasks,id'],
            'status' => ['nullable', Rule::in(PlanningStatus::values())],
            'description' => ['nullable', 'string', 'max:1000'],
        ];
    }

    /**
     * Get custom messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'assignee_id.required' => 'L\'assigné est obligatoire.',
            'assignee_id.exists' => 'L\'assigné sélectionné n\'existe pas.',
            'date_and_time.required' => 'La date et heure sont obligatoires.',
            'date_and_time.date' => 'La date et heure doivent être une date valide.',
            'date_and_time.after' => 'La date et heure doivent être dans le futur.',
            'address.required' => 'L\'adresse est obligatoire.',
            'address.string' => 'L\'adresse doit être une chaîne de caractères.',
            'address.max' => 'L\'adresse ne doit pas dépasser 500 caractères.',
            'task_id.exists' => 'La tâche sélectionnée n\'existe pas.',
            'status.in' => 'Le statut sélectionné est invalide.',
            'description.string' => 'La description doit être une chaîne de caractères.',
            'description.max' => 'La description ne doit pas dépasser 1000 caractères.',
        ];
    }
}
