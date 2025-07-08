<?php

namespace App\Http\Resources\v1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SustainabilityReportResource extends JsonResource
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
            'title' => $this->title,
            'pdf' => $this->pdf,
            'pdf_format' => $this->pdf_format,
            'pdf_format_2' => $this->pdf_format2,
            'index' => $this->index,
            'active' => $this->active,
            'title_milestones' => $this->title_milestones,

            'sustainability_report_objects_rels' => SustainabilityReportObjectResource::collection($this->whenLoaded('reportObjectsRels')),
            'sustainability_report_objects_rels_count' => $this->whenCounted('reportObjectsRels'),

            'created_at' => $this->created_at,
            'created_at_format' => $this->created_at_format,
            'created_at_format_2' => $this->created_at_format2,
            'updated_at' => $this->updated_at,
            'updated_at_format' => $this->updated_at_format,
            'updated_at_format_2' => $this->updated_at_format2,
        ];
    }
}
