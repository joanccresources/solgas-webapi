<?php

namespace App\Http\Resources\v1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ContentHeaderMenuResource extends JsonResource
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
            'content' => $this->content,
            'content_format' => $this->content_format,
            'content_format_2' => $this->content_format2,
            'index' => $this->index,
            'active' => $this->active,

            'content_header_id' => $this->content_header_id,
            'content_header_menu_id' => $this->content_header_menu_id,
            'content_menu_type_id' => $this->content_menu_type_id,

            'content_menu_type_rel' => new ContentMenuTypeResource($this->menuTypeRel),
            'content_header_rel' => new ContentHeaderResource($this->whenLoaded('contentHeaderRel')),

            'parent' => new ContentHeaderMenuResource($this->whenLoaded('parentMenu')),
            'children' => ContentHeaderMenuResource::collection($this->whenLoaded('childMenus')),
            'children_count' => $this->whenCounted('childMenus'),

            'created_at' => $this->created_at,
            'created_at_format' => $this->created_at_format,
            'created_at_format_2' => $this->created_at_format2,
            'updated_at' => $this->updated_at,
            'updated_at_format' => $this->updated_at_format,
            'updated_at_format_2' => $this->updated_at_format2,
        ];
    }
}
