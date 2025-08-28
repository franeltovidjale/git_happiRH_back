<?php

namespace App\Http\Requests\Api\Employer;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Update WorkingDay Request
 */
class UpdateWorkingDayRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
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
            'weekday' => 'required|in:monday,tuesday,wednesday,thursday,friday,saturday,sunday',
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