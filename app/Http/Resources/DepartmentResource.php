<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DepartmentResource extends JsonResource
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
            'enterprise_id' => $this->enterprise_id,
            'name' => $this->name,
            'active' => $this->active,
            'slug' => $this->slug,
            'late_penalty' => $this->late_penalty,
            'work_model' => $this->work_model,
            'meeting_participation_score' => $this->meeting_participation_score,
            'attendance_score' => $this->attendance_score,
            'overtime_recording_score' => $this->overtime_recording_score,
            'overtime_clocking_score' => $this->overtime_clocking_score,
            'supervisor_id' => $this->supervisor_id,
            'supervisor' => $this->whenLoaded('supervisor', function () {
                return new MemberResource($this->supervisor);
            }),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'enterprise' => $this->whenLoaded('enterprise', function () {
                return [
                    'id' => $this->enterprise->id,
                    'name' => $this->enterprise->name,
                    'code' => $this->enterprise->code,
                    'active' => $this->enterprise->active,
                    'status' => $this->enterprise->status,
                ];
            }),
            'members' => $this->whenLoaded('members', function () {
                return MemberResource::collection($this->members);
            }),
            'members_count' => $this->whenCounted('members'),
        ];
    }
}
