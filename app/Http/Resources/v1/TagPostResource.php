<?php

namespace App\Http\Resources\v1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TagPostResource extends JsonResource
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

            'post_id' => $this->post_id,
            'tag_id' => $this->tag_id,

            'tag_rel' => new TagResource($this->whenLoaded('tagRel')),
            'post_rel' => new PostResource($this->whenLoaded('postRel'))
        ];
    }
}
