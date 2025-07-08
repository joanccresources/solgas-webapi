<?php

namespace App\Http\Resources\v1;

use App\Traits\ModulesTrait;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Str;

class ModuleResource extends JsonResource
{
    use ModulesTrait;

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
            'singular_name' => $this->singular_name,
            'assigned' => $this->assigned,
            'slug' => $this->slug,
            'icon' => $this->icon,
            'per_page' => $this->per_page,
            'page' => $this->page,
            'index' => $this->index,
            'sort_by' => $this->sort_by,
            'order_direction' => $this->order_direction,
            'order_direction_rel' => collect($this->orderDirections())->first(function (array $value, int $key) {
                return $value['id'] == Str::upper($this->order_direction);
            }),
            'is_crud' => $this->is_crud,
            'show_in_sidebar' => $this->show_in_sidebar,
            'is_removable' => $this->is_removable,
            'module_id' => $this->module_id,
            'active' => $this->active,
            'submodule_rel' => ModuleResource::collection($this->whenLoaded('submoduleRels')),
            'submodules_count' => $this->whenCounted('submoduleRels'),
            'permissions_count' => $this->whenCounted('permissionRels'),
            'permissions_rel' => PermissionResource::collection($this->whenLoaded('permissionRels')),
            'module_rel' => new ModuleResource($this->whenLoaded('moduleRel')),

            'endpoint' => $this->endpoint,
            'element' => $this->element,
            'additional_custom_actions' => $this->additional_custom_actions,

            'path' => $this->path,
            'path_format' => $this->path_format,
            'columns' => $this->columns,
            'columns_format' => $this->columns_format,
            'create_edit' => $this->create_edit,
            'create_edit_format' => $this->create_edit_format,

            'created_at' => $this->created_at,
            'created_at_format' => $this->created_at_format,
            'created_at_format_2' => $this->created_at_format2,
            'updated_at' => $this->updated_at,
            'updated_at_format' => $this->updated_at_format,
            'updated_at_format_2' => $this->updated_at_format2,
        ];
    }
}
