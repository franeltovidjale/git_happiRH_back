<?php

namespace App\Http\Requests\Api\Employer;

use App\Models\Member;
use Illuminate\Foundation\Http\FormRequest;

class ChangeEmployeeStatusRequest extends FormRequest
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
            'status' => [
                'required',
                'string',
                'in:' . implode(',', [
                    Member::STATUS_REQUESTED,
                    Member::STATUS_REJECTED,
                    Member::STATUS_ACTIVE,
                    Member::STATUS_SUSPENDED,
                    Member::STATUS_TERMINATED,
                ]),
            ],
            'status_note' => 'nullable|string|max:1000',
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
            'status.required' => 'Le statut est obligatoire',
            'status.in' => 'Le statut doit être l\'un des suivants : requested, rejected, active, suspended, terminated',
            'status_note.max' => 'La note de statut ne peut pas dépasser 1000 caractères',
        ];
    }
}