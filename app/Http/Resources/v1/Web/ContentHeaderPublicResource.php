<?php

namespace App\Http\Resources\v1\Web;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ContentHeaderPublicResource extends JsonResource
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
            'content_header_menu_rels' => ContentHeaderMenuPublicResource::collection(
                collect($this->contentHeaderMenuRels->filter(function ($value, $key) {
                    return $value->active->value === 1 && !$value->content_header_menu_id;
                }))->sortBy('index', SORT_NATURAL)->values()->all()
            ),
        ];
    }
}
