<?php

namespace App\Http\Resources\v1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ContentFooterMenuResource extends JsonResource
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

            'content_footer_id' => $this->content_footer_id,
            'content_footer_menu_id' => $this->content_footer_menu_id,
            'content_menu_type_id' => $this->content_menu_type_id,

            'content_menu_type_rel' => new ContentMenuTypeResource($this->menuTypeRel),
            'content_footer_rel' => new ContentFooterResource($this->whenLoaded('contentFooterRel')),

            'parent' => new ContentFooterMenuResource($this->whenLoaded('parentMenu')),
            'children' => ContentFooterMenuResource::collection($this->whenLoaded('childMenus')),
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
