<?php

namespace App\Http\Resources\v1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PageSectionResource extends JsonResource
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
            'index' => $this->index,
            'page_id' => $this->page_id,

            'page_rel' => new PageResource($this->whenLoaded('pageRel')),
            'field_count' => $this->whenCounted('fieldRels'),
            'content_count' => $this->whenCounted('contentRels'),
            'multiple_field_section_count' => $this->whenCounted('multipleFieldSectionRels'),
            'multiple_field_section_rels' => PageMultipleFieldSectionResource::collection($this->whenLoaded('multipleFieldSectionRels')),
            'content_rels' => PageContentResource::collection($this->whenLoaded('contentRels')),
            'field_rels' => PageFieldResource::collection($this->whenLoaded('fieldRels')),

            'created_at' => $this->created_at,
            'created_at_format' => $this->created_at_format,
            'created_at_format_2' => $this->created_at_format2,
            'updated_at' => $this->updated_at,
            'updated_at_format' => $this->updated_at_format,
            'updated_at_format_2' => $this->updated_at_format2,
        ];
    }
}
