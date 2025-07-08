<?php

namespace App\Http\Resources\v1\Web;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TagPostPublicResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'tag_rel' => new TagPublicResource($this->whenLoaded('tagRel'))
        ];
    }
}
