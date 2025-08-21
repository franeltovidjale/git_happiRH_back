<?php

namespace App\Http\Resources;

use App\Http\Resources\EnterpriseResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class EmployerResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'user' => [
                'first_name' => $this->user->first_name,
                'last_name' => $this->user->last_name,
                'email' => $this->user->email,
                'phone' => $this->user->phone,
                'photo' => $this->user->photo,
                ...$this->user->toArray(),
            ],
            'active_enterprise' => $this->whenLoaded('activeEnterprise', function () {
                return new EnterpriseResource($this->activeEnterprise);
            }),
            'enterprises' => $this->whenLoaded('enterprises', function () {
                return EnterpriseResource::collection($this->enterprises);
            }),
        ];
    }
}
