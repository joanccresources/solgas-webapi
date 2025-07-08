<?php

namespace App\Http\Resources\v1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PageMultipleFieldResource extends JsonResource
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

            'data_rels' => PageMultipleFieldDataResource::collection($this->whenLoaded('dataRels')),
            'data_count' => $this->whenCounted('dataRels'),

            'multiple_field_section_rels' => PageMultipleFieldSectionResource::collection($this->whenLoaded('multipleFieldSectionRels')),
            'multiple_field_section_count' => $this->whenCounted('multipleFieldSectionRels'),

            'multiple_content_rels' => PageMultipleContentResource::collection($this->whenLoaded('multipleContentRels')),
            'multiple_content_count' => $this->whenCounted('multipleContentRels'),

            'created_at' => $this->created_at,
            'created_at_format' => $this->created_at_format,
            'created_at_format_2' => $this->created_at_format2,
            'updated_at' => $this->updated_at,
            'updated_at_format' => $this->updated_at_format,
            'updated_at_format_2' => $this->updated_at_format2,
        ];
    }
}
