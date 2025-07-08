<?php

namespace App\Http\Resources\v1\Web;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ContentFooterPublicResource extends JsonResource
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
            'content_footer_menu_rels' => ContentFooterMenuPublicResource::collection(
                collect($this->contentFooterMenuRels->filter(function ($value, $key) {
                    return $value->active->value === 1 && !$value->content_footer_menu_id;
                }))->sortBy('index', SORT_NATURAL)->values()->all()
            ),
        ];
    }
}
