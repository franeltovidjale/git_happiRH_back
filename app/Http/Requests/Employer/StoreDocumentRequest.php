<?php

namespace App\Http\Requests\Employer;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class StoreDocumentRequest extends FormRequest
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
            'member_id' => ['required', 'integer', 'exists:members,id'],
            'name' => ['required', 'string', 'max:255'],
            'key' => ['nullable', 'string', 'max:255'],
            'file' => ['required', 'file', 'max:10240'], // 10MB max
            'active' => ['boolean'],
            'scope' => ['nullable', Rule::in(['private', 'public'])],
        ];
    }

    /**
     * Get custom messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'member_id.required' => 'Le membre est requis.',
            'member_id.exists' => 'Le membre sélectionné n\'existe pas.',
            'name.required' => 'Le nom du document est requis.',
            'name.max' => 'Le nom du document ne peut pas dépasser 255 caractères.',
            'file.required' => 'Le fichier est requis.',
            'file.file' => 'Le fichier doit être un fichier valide.',
            'file.max' => 'Le fichier ne peut pas dépasser 10MB.',
            'scope.in' => 'Le scope doit être privé ou public.',
        ];
    }

    /**
     * Prepare the data for validation.
     */
    protected function prepareForValidation(): void
    {
        // Generate key from name if not provided
        if (!$this->has('key') && $this->has('name')) {
            $this->merge([
                'key' => Str::slug($this->name),
            ]);
        }
    }
}
