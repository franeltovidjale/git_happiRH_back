<?php

namespace App\Http\Resources\Api\Employer;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DemandeAbsenceResource extends JsonResource
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
            'start_date' => $this->start_date,
            'end_date' => $this->end_date,
            'type' => $this->type,
            'status' => $this->status,
            'reason' => $this->reason,
            'description' => $this->description,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,

            // Member information
            'member' => [
                'id' => $this->member->id,
                'user' => $this->when(
                    $this->member && $this->member->user,
                    [
                        'id' => $this->member->user?->id,
                        'first_name' => $this->member->user?->first_name,
                        'last_name' => $this->member->user?->last_name,
                        'email' => $this->member->user?->email,
                        'photo' => $this->member->user?->photo,
                    ]
                ),
            ],

            // User shortcut for easier frontend access
            'user' => $this->when(
                $this->member && $this->member->user,
                [
                    'id' => $this->member->user?->id,
                    'first_name' => $this->member->user?->first_name,
                    'last_name' => $this->member->user?->last_name,
                    'full_name' => $this->member->user?->first_name . ' ' . $this->member->user?->last_name,
                    'email' => $this->member->user?->email,
                    'photo' => $this->member->user?->photo,
                ]
            ),

            // Creator information
            'creator' => $this->when(
                $this->creator && $this->creator->user,
                [
                    'id' => $this->creator->user?->id,
                    'first_name' => $this->creator->user?->first_name,
                    'last_name' => $this->creator->user?->last_name,
                    'email' => $this->creator->user?->email,
                ]
            ),
        ];
    }
}
