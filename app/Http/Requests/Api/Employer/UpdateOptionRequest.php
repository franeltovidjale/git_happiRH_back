<?php

namespace App\Http\Requests\Api\Employer;

use App\Enums\EnterpriseOptionKey;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

/**
 * Update Option Request
 */
class UpdateOptionRequest extends FormRequest
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
        $rules = [
            'key' => ['bail', 'required', 'string', Rule::in(EnterpriseOptionKey::values())],
        ];
        $optionRules = EnterpriseOptionKey::rules();
        $rules['value'] = $optionRules[$this->key];

        return $rules;
    }
}
