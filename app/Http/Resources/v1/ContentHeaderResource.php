<?php

namespace App\Http\Resources\v1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ContentHeaderResource extends JsonResource
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
            'active' => $this->active,

            'content_header_menu_rels' => ContentHeaderMenuResource::collection($this->whenLoaded('contentHeaderMenuRels')),
            'content_header_menu_rels_count' => $this->whenCounted('contentHeaderMenuRels'),

            'created_at' => $this->created_at,
            'created_at_format' => $this->created_at_format,
            'created_at_format_2' => $this->created_at_format2,
            'updated_at' => $this->updated_at,
            'updated_at_format' => $this->updated_at_format,
            'updated_at_format_2' => $this->updated_at_format2,
        ];
    }
}
