<?php

namespace App\Http\Resources\v1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SustainabilityReportObjectResource extends JsonResource
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
            'image' => $this->image,
            'image_format' => $this->image_format,
            'image_format_2' => $this->image_format2,
            'index' => $this->index,
            'active' => $this->active,
            'sustainability_report_id' => $this->sustainability_report_id,

            'sustainability_report_objects_rel' => new SustainabilityReportResource($this->whenLoaded('reportObjectsRel')),

            'created_at' => $this->created_at,
            'created_at_format' => $this->created_at_format,
            'created_at_format_2' => $this->created_at_format2,
            'updated_at' => $this->updated_at,
            'updated_at_format' => $this->updated_at_format,
            'updated_at_format_2' => $this->updated_at_format2,
        ];
    }
}
