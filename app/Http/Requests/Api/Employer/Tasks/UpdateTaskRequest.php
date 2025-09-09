<?php

namespace App\Http\Requests\Api\Employer\Tasks;

use App\Enums\TaskPriority;
use App\Enums\TaskStatus;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateTaskRequest extends FormRequest
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
        $taskId = $this->route('id') ?? $this->route('task');
        $projectId = $this->input('project_id');

        // Si project_id n'est pas fourni, récupère celui de la tâche existante
        if (!$projectId && $taskId) {
            $existingTask = \App\Models\Task::find($taskId);
            $projectId = $existingTask ? $existingTask->project_id : null;
        }

        return [
            'name' => [
                'sometimes',
                'string',
                'max:255',
                $projectId ? Rule::unique('tasks', 'name')->where('project_id', $projectId)->ignore($taskId) : 'string'
            ],
            'project_id' => ['sometimes', 'exists:projects,id'],
            'due_date' => ['nullable', 'date', 'after_or_equal:today'],
            'start_time' => ['nullable', 'date_format:H:i'],
            'end_time' => ['nullable', 'date_format:H:i', 'after:start_time'],
            'priority' => ['nullable', Rule::in(TaskPriority::values())],
            'status' => ['sometimes', Rule::in(TaskStatus::values())],
            'assigned_member_id' => [
                'nullable', 
                'exists:members,id',
                function ($attribute, $value, $fail) {
                    if ($value && !isMemberPartOfEnterprise($value)) {
                        $fail('Le membre assigné ne fait pas partie de votre entreprise.');
                    }
                }
            ],
            'notifications' => ['boolean'],
        ];
    }

    /**
     * Get custom messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'name.string' => 'Le nom de la tâche doit être une chaîne de caractères.',
            'name.max' => 'Le nom de la tâche ne doit pas dépasser 255 caractères.',
            'name.unique' => 'Une tâche avec ce nom existe déjà dans ce projet.',
            'project_id.exists' => 'Le projet sélectionné n\'existe pas.',
            'due_date.date' => 'La date d\'échéance doit être une date valide.',
            'due_date.after_or_equal' => 'La date d\'échéance ne peut pas être antérieure à aujourd\'hui.',
            'start_time.date_format' => 'L\'heure de début doit être au format HH:MM.',
            'end_time.date_format' => 'L\'heure de fin doit être au format HH:MM.',
            'end_time.after' => 'L\'heure de fin doit être postérieure à l\'heure de début.',
            'priority.in' => 'La priorité sélectionnée est invalide.',
            'status.in' => 'Le statut sélectionné est invalide.',
            'assigned_member_id.exists' => 'Le membre assigné n\'existe pas.',
            'notifications.boolean' => 'La notification doit être un booléen.',
        ];
    }
}
