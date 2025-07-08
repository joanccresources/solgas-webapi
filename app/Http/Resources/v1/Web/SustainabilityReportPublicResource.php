<?php

namespace App\Http\Resources\v1\Web;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SustainabilityReportPublicResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'title' => $this->title,
            'pdf' => $this->pdf,
            'pdf_format' => $this->pdf_format,
            'title_milestones' => $this->title_milestones,
            'sustainability_report_objects_rels' => SustainabilityReportObjectPublicResource::collection($this->whenLoaded('reportObjectsRels'))
        ];
    }
}
