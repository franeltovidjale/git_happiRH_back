<?php

namespace App\Http\Requests\Api\Employer\Presences;

use App\Enums\PresenceStatus;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StorePresenceRequest extends FormRequest
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
            'member_id' => ['required', 'exists:members,id'],
            'presence_date' => [
                'required',
                'date',
                Rule::unique('presences')->where(function ($query) {
                    return $query->where('member_id', $this->input('member_id'));
                }),
            ],
            'check_in_time' => ['nullable', 'date_format:H:i'],
            'check_out_time' => ['nullable', 'date_format:H:i', 'after:check_in_time'],
            'status' => ['required', Rule::in(PresenceStatus::values())],
            'notes' => ['nullable', 'string', 'max:1000'],
        ];
    }

    /**
     * Get custom messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'user_id.required' => 'L\'utilisateur est obligatoire.',
            'user_id.exists' => 'L\'utilisateur sélectionné n\'existe pas.',
            'presence_date.required' => 'La date de présence est obligatoire.',
            'presence_date.date' => 'La date de présence doit être une date valide.',
            'presence_date.unique' => 'Une présence existe déjà pour cet utilisateur à cette date.',
            'check_in_time.date_format' => 'L\'heure d\'arrivée doit être au format HH:MM.',
            'check_out_time.date_format' => 'L\'heure de départ doit être au format HH:MM.',
            'check_out_time.after' => 'L\'heure de départ doit être postérieure à l\'heure d\'arrivée.',
            'status.required' => 'Le statut est obligatoire.',
            'status.in' => 'Le statut sélectionné est invalide.',
            'notes.string' => 'Les notes doivent être une chaîne de caractères.',
            'notes.max' => 'Les notes ne doivent pas dépasser 1000 caractères.',
        ];
    }
}
