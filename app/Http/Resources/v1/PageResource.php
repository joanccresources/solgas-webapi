<?php

namespace App\Http\Resources\v1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PageResource extends JsonResource
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
            'slug' => $this->slug,
            'path' => $this->path,
            'seo_description' => $this->seo_description,
            'seo_keywords' => $this->seo_keywords,
            'seo_image' => $this->seo_image,
            'seo_image_format' => $this->seo_image_format,
            'seo_image_format_2' => $this->seo_image_format2,
            'active' => $this->active,

            'section_rels' => PageSectionResource::collection($this->whenLoaded('sectionRels')),
            'section_count' => $this->whenCounted('sectionRels'),

            'created_at' => $this->created_at,
            'created_at_format' => $this->created_at_format,
            'created_at_format_2' => $this->created_at_format2,
            'updated_at' => $this->updated_at,
            'updated_at_format' => $this->updated_at_format,
            'updated_at_format_2' => $this->updated_at_format2,
        ];
    }
}
