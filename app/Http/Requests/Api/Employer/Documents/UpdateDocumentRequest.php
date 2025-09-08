<?php

namespace App\Http\Requests\Api\Employer;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateDocumentRequest extends FormRequest
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
            'name' => ['sometimes', 'required', 'string', 'max:255'],
            'key' => ['nullable', 'string', 'max:255'],
            'file' => ['sometimes', 'file', 'max:10240'], // 10MB max
            'active' => ['boolean'],
            'scope' => ['sometimes', Rule::in(['private', 'public'])],
        ];
    }

    /**
     * Get custom messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'name.required' => 'Le nom du document est requis.',
            'name.max' => 'Le nom du document ne peut pas dépasser 255 caractères.',
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
        // Generate key from name if not provided and name is being updated
        if (!$this->has('key') && $this->has('name')) {
            $this->merge([
                'key' => \Illuminate\Support\Str::slug($this->name),
            ]);
        }
    }
}