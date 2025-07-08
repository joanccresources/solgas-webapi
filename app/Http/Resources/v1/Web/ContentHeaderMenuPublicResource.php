<?php

namespace App\Http\Resources\v1\Web;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ContentHeaderMenuPublicResource extends JsonResource
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
            'content' => $this->content,
            'content_format' => $this->content_format,
            'childMenus' => ContentHeaderMenuPublicResource::collection(
                collect($this->childMenus)->sortBy('index', SORT_NATURAL)->values()->all()
            )
        ];
    }
}
