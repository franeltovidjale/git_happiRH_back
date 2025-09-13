<?php

namespace App\Http\Requests\Api\Employer\Members;

use App\Models\Option;
use App\Enums\EnterpriseOptionKey;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

/**
 * Update WorkingHour Request
 */
class UpdateWorkingHourRequest extends FormRequest
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
        $worksDays = Option::getOption(EnterpriseOptionKey::WorkDays);
        return [
            'weekday' => ['required', Rule::in($worksDays)],
            'start_hour' => 'required|date_format:H:i',
            'end_hour' => 'required|date_format:H:i|after:start_hour',
            'active' => 'boolean',
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
            'weekday.required' => 'Weekday is required',
            'weekday.in' => 'Weekday must be a valid day of the week',
            'start_hour.required' => 'Start hour is required',
            'start_hour.date_format' => 'Start hour must be in HH:MM format',
            'end_hour.required' => 'End hour is required',
            'end_hour.date_format' => 'End hour must be in HH:MM format',
            'end_hour.after' => 'End hour must be after start hour',
            'active.boolean' => 'Active status must be true or false',
        ];
    }
}
