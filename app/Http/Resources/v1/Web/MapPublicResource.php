<?php

namespace App\Http\Resources\v1\Web;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MapPublicResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'name' => $this->name,
            'address' => $this->address,
            'schedule' => $this->schedule,
            'phone' => $this->phone,
            'latitude' => $this->latitude,
            'longitude' => $this->longitude,
            'code_department' => $this->code_department,
            'code_province' => $this->code_province,
            'code_district' => $this->code_district,
            'coverage_area' => $this->coverage_area,
            'coverage_area_format' => $this->coverage_area_format,
        ];
    }
}
