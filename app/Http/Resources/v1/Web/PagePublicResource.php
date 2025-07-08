<?php

namespace App\Http\Resources\v1\Web;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PagePublicResource extends JsonResource
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
            'slug' => $this->slug,
            'path' => $this->path,
            'seo_description' => $this->seo_description,
            'seo_keywords' => $this->seo_keywords,
            'seo_image' => $this->seo_image,
            'seo_image_format' => $this->seo_image_format,
            'seo_image_format2' => $this->seo_image_format2,
            'section_rels' => PageSectionPublicResource::collection($this->whenLoaded('sectionRels')),
        ];
    }
}
