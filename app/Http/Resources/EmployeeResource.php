<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class EmployeeResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'user_id' => $this->user_id,
            'enterprise_id' => $this->enterprise_id,
            'type' => $this->type,
            'status' => $this->status,
            'code' => $this->code,
            'birth_date' => $this->birth_date,
            'marital_status' => $this->marital_status,
            'nationality' => $this->nationality,
            'role' => $this->role,
            'location_id' => $this->location_id,
            'status_note' => $this->status_note,
            'status_date' => $this->status_date,
            'status_by' => $this->status_by,
            'status_stories' => $this->status_stories,
            'created_at' => $this->created_at,
            'full_name' => "{$this->user->first_name} {$this->user->last_name}",
            'profession' => [
                'code' => $this->code,
                'designation' => $this->role,
                'username' => $this->username,
                'joining_date' => $this->joining_date,
                'email' => $this->user->email,
            ],
            'department' => $this->whenLoaded('department', function () {
                return new DepartmentResource($this->department);
            }),
            // Address information
            'address' => $this->whenLoaded('address', function () {
                return [
                    'address' => $this->address->address,
                    'city' => $this->address->city,
                    'state' => $this->address->state,
                    'zip_code' => $this->address->zip_code,
                ];
            }),

            // Banking information
            'banking' => $this->whenLoaded('banking', function () {
                return [
                    'bank_account_number' => $this->banking->bank_account_number,
                    'bank_name' => $this->banking->bank_name,
                    'pan_number' => $this->banking->pan_number,
                    'ifsc_code' => $this->banking->ifsc_code,
                ];
            }),

            // Salary information
            'salary' => $this->whenLoaded('salary', function () {
                return [
                    'salary_basis' => $this->salary->salary_basis,
                    'effective_date' => $this->salary->effective_date,
                    'monthly_salary_amount' => $this->salary->monthly_salary_amount,
                    'type_of_payment' => $this->salary->type_of_payment,
                    'billing_rate' => $this->salary->billing_rate,
                ];
            }),

            // Employment information
            'employment' => $this->whenLoaded('employment', function () {
                return [
                    'job_type' => $this->employment->job_type,
                    'contract_type' => $this->employment->contract_type,
                ];
            }),

            // Contact Person information
            'contact_person' => $this->whenLoaded('contactPerson', function () {
                return [
                    'full_name' => $this->contactPerson->full_name,
                    'phone' => $this->contactPerson->phone,
                ];
            }),

            'user' => [
                'id' => $this->user->id,
                'first_name' => $this->user->first_name,
                'last_name' => $this->user->last_name,
                'email' => $this->user->email,
                'phone' => $this->user->phone,
                'photo' => $this->user->photo,
                'type' => $this->user->type,
                'is_deletable' => $this->user->is_deletable,
                'active_enterprise_id' => $this->user->active_enterprise_id,
                'created_at' => $this->user->created_at,
                'updated_at' => $this->user->updated_at,
            ],
            'enterprise' => $this->whenLoaded('enterprise', function () {
                return [
                    'id' => $this->enterprise->id,
                    'name' => $this->enterprise->name,
                    'code' => $this->enterprise->code,
                    'active' => $this->enterprise->active,
                    'status' => $this->enterprise->status,
                ];
            }),
            'location' => $this->whenLoaded('location', function () {
                return [
                    'id' => $this->location->id,
                    'name' => $this->location->name,
                    'address' => $this->location->address,
                    'city' => $this->location->city,
                    'state' => $this->location->state,
                    'zip_code' => $this->location->zip_code,
                ];
            }),
            'working_hours' => $this->whenLoaded('workingHours', function () {
                return $this->workingHours->map(function ($workHour) {
                    return  WorkingHourResource::make($workHour);
                });
            }),
            'experiences' => $this->whenLoaded('experiences', function () {
                return $this->experiences->map(function ($experience) {
                    return [
                        'id' => $experience->id,
                        'job_title' => $experience->job_title,
                        'sector' => $experience->sector,
                        'company_name' => $experience->company_name,
                        'start_date' => $experience->start_date,
                        'end_date' => $experience->end_date,
                        'responsibilities' => $experience->responsibilities,
                        'created_at' => $experience->created_at,
                        'updated_at' => $experience->updated_at,
                    ];
                });
            }),
        ];
    }
}
