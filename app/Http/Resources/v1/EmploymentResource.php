<?php

namespace App\Http\Resources\v1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class EmploymentResource extends JsonResource
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
            'description' => $this->description,
            'address' => $this->address,
            'code_ubigeo' => $this->code_ubigeo,
            'active' => $this->active,

            'employment_type_id' => $this->employment_type_id,
            'employment_area_id' => $this->employment_area_id,

            'code_ubigeo_rel' => new MasterUbigeoResource($this->whenLoaded('codeUbigeoRel')),
            'type_rel' => new EmploymentTypeResource($this->whenLoaded('typeRel')),
            'area_rel' => new EmploymentAreaResource($this->whenLoaded('areaRel')),

            'lead_work_with_us_rels_count' => $this->whenCounted('leadWorkWithUsRels'),
            'lead_work_with_us_rels' => LeadWorkWithUsResource::collection($this->whenLoaded('leadWorkWithUsRels')),
            'similar_employment_rels_count' => $this->whenCounted('similarEmploymentRels'),
            'similar_employment_rels' => EmploymentSimilarResource::collection($this->whenLoaded('similarEmploymentRels')),

            'created_at' => $this->created_at,
            'created_at_format' => $this->created_at_format,
            'created_at_format_2' => $this->created_at_format2,
            'updated_at' => $this->updated_at,
            'updated_at_format' => $this->updated_at_format,
            'updated_at_format_2' => $this->updated_at_format2,
            'posted_at' => $this->posted_at,
            'posted_at_format' => $this->posted_at_format,
            'posted_at_format_2' => $this->posted_at_format2,
        ];
    }
}
