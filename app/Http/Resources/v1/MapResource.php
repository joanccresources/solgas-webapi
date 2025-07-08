<?php

namespace App\Http\Resources\v1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MapResource extends JsonResource
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
            'name' => $this->name,
            'address' => $this->address,
            'schedule' => $this->schedule,
            'phone' => $this->phone,
            'latitude' => (float) $this->latitude,
            'longitude' => (float) $this->longitude,
            'code_department' => $this->code_department,
            'code_province' => $this->code_province,
            'code_district' => $this->code_district,
            'coverage_area' => $this->coverage_area,
            'coverage_area_format' => $this->coverage_area_format,
            'index' => $this->index,
            'active' => $this->active,

            'type_map_id' => $this->type_map_id,
            'department' => $this->department,
            'province' => $this->province,
            'district' => $this->district,

            'type_map_rel' => new TypeMapResource($this->whenLoaded('typeMapRel')),

            'created_at' => $this->created_at,
            'created_at_format' => $this->created_at_format,
            'created_at_format_2' => $this->created_at_format2,
            'updated_at' => $this->updated_at,
            'updated_at_format' => $this->updated_at_format,
            'updated_at_format_2' => $this->updated_at_format2,
        ];
    }
}
