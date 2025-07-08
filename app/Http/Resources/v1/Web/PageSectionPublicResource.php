<?php

namespace App\Http\Resources\v1\Web;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PageSectionPublicResource extends JsonResource
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
            'multiple_section_rels' => PageMultipleFieldSectionPublicResource::collection($this->whenLoaded('multipleFieldSectionRels')),
            'content_rels' => $this->contentRels,
        ];
    }
}
