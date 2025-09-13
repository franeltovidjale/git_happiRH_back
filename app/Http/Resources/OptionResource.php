<?php

namespace App\Http\Resources;

use App\Models\Option;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OptionResource extends JsonResource
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
            'key' => $this->key,
            'value' => Option::parseValue($this->value, $this->type),
            'type' => $this->type,
            'label' => $this->label,
            'description' => $this->description,
            'options' => $this->options,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
