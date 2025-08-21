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
            'username' => $this->username,
            'code' => $this->code,
            'birth_date' => $this->birth_date,
            'marital_status' => $this->marital_status,
            'nationality' => $this->nationality,
            'address' => $this->address,
            'city' => $this->city,
            'state' => $this->state,
            'zip_code' => $this->zip_code,
            'designation' => $this->designation,
            'joining_date' => $this->joining_date,
            'location_id' => $this->location_id,
            'bank_account_number' => $this->bank_account_number,
            'bank_name' => $this->bank_name,
            'pan_number' => $this->pan_number,
            'ifsc_code' => $this->ifsc_code,
            'salary_basis' => $this->salary_basis,
            'effective_date' => $this->effective_date,
            'monthly_salary_amount' => $this->monthly_salary_amount,
            'type_of_payment' => $this->type_of_payment,
            'billing_rate' => $this->billing_rate,
            'job_type' => $this->job_type,
            'status_note' => $this->status_note,
            'status_date' => $this->status_date,
            'status_by' => $this->status_by,
            'status_stories' => $this->status_stories,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
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
        ];
    }
}
