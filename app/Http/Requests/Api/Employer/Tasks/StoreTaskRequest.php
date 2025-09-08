<?php

namespace App\Http\Requests\Api\Employer\Tasks;

use App\Enums\TaskPriority;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreTaskRequest extends FormRequest
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
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('tasks', 'name')->where('project_id', $this->input('project_id'))
            ],
            'project_id' => ['required', 'exists:projects,id'],
            'project_lead_id' => ['nullable', 'exists:users,id'],
            'due_date' => ['nullable', 'date', 'after_or_equal:today'],
            'start_time' => ['nullable', 'date_format:H:i'],
            'end_time' => ['nullable', 'date_format:H:i', 'after:start_time'],
            'priority' => ['nullable', Rule::in(TaskPriority::values())],
            'assigned_to' => ['nullable', 'exists:users,id'],
            'notifications' => ['boolean'],
        ];
    }

    /**
     * Get custom messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'name.required' => 'Le nom de la tâche est obligatoire.',
            'name.string' => 'Le nom de la tâche doit être une chaîne de caractères.',
            'name.max' => 'Le nom de la tâche ne doit pas dépasser 255 caractères.',
            'name.unique' => 'Une tâche avec ce nom existe déjà dans ce projet.',
            'project_id.required' => 'Le projet est obligatoire.',
            'project_id.exists' => 'Le projet sélectionné n\'existe pas.',
            'project_lead_id.exists' => 'Le chef de projet sélectionné n\'existe pas.',
            'due_date.date' => 'La date d\'échéance doit être une date valide.',
            'due_date.after_or_equal' => 'La date d\'échéance ne peut pas être antérieure à aujourd\'hui.',
            'start_time.date_format' => 'L\'heure de début doit être au format HH:MM.',
            'end_time.date_format' => 'L\'heure de fin doit être au format HH:MM.',
            'end_time.after' => 'L\'heure de fin doit être postérieure à l\'heure de début.',
            'priority.required' => 'La priorité est obligatoire.',
            'priority.in' => 'La priorité sélectionnée est invalide.',
            'assigned_to.exists' => 'L\'utilisateur assigné n\'existe pas.',
            'notifications.boolean' => 'La notification doit être un booléen.',
        ];
    }
}
