<?php

namespace App\Http\Resources\v1\Web;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PageMultipleFieldSectionPublicResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'multiple_field_rel' => new PageMultipleFieldPublicResource($this->whenLoaded('multipleFieldRel')),
        ];
    }
}
