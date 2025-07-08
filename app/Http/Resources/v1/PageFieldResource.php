<?php

namespace App\Http\Resources\v1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PageFieldResource extends JsonResource
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
            'value' => $this->value, //for page content controller
            'variable' => $this->variable,
            'index' => $this->index,
            'page_section_id' => $this->page_section_id,
            'page_field_type_id' => $this->page_field_type_id,

            'section_rel' => new PageSectionResource($this->whenLoaded('sectionRel')),
            'type_rel' => new PageFieldTypeResource($this->whenLoaded('typeRel')),

            'created_at' => $this->created_at,
            'created_at_format' => $this->created_at_format,
            'created_at_format_2' => $this->created_at_format2,
            'updated_at' => $this->updated_at,
            'updated_at_format' => $this->updated_at_format,
            'updated_at_format_2' => $this->updated_at_format2,
        ];
    }
}
