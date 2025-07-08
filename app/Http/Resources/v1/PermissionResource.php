<?php

namespace App\Http\Resources\v1;

use App\Models\Module;
use App\Traits\ModulesTrait;
use Illuminate\Http\Resources\Json\JsonResource;

class PermissionResource extends JsonResource
{
    use ModulesTrait;

    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $sub_module_rel = Module::where('id', $this->module_id)->first();
        if ($sub_module_rel->module_id) {
            $module_rel = Module::where('id', $sub_module_rel->module_id)->first();
        } else {
            $module_rel = $sub_module_rel;
        }

        return [
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->description,
            'operation_rel' => collect($this->operationForPermissions())->first(function (array $value, int $key) {
                return $value['name'] == $this->description;
            }),
            'module_id' => $this->module_id,
            'module_rel' => new ModuleResource($module_rel),
            'sub_module_rel' => $sub_module_rel->module_id ? new ModuleResource($sub_module_rel) : null,
            'created_at' => $this->created_at,
            'created_at_format' => $this->created_at_format,
            'created_at_format_2' => $this->created_at_format2,
            'updated_at' => $this->updated_at,
            'updated_at_format' => $this->updated_at_format,
            'updated_at_format_2' => $this->updated_at_format2,
        ];
    }
}
