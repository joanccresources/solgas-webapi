<?php

namespace App\Http\Resources\v1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AttributeResource extends JsonResource
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
            'column_code' => $this->column_code,
            'name' => $this->name,
            'index' => $this->index,
            'model_lookup' => $this->model_lookup,
            'model_lookup_exist' => $this->model_lookup_exist,
            'is_required' => $this->is_required,
            'is_unique' => $this->is_unique,
            'model' => $this->model,
            'model_exist' => $this->model_exist,
            'active' => $this->active,
            'attribute_type_id' => $this->attribute_type_id,
            'attribute_type_rel' => new AttributeTypeResource($this->typeRel),

            'option_rels' => AttributeOptionResource::collection($this->whenLoaded('optionRels')),
            'value_rels' => AttributeValueResource::collection($this->whenLoaded('valueRels')),

            'created_at' => $this->created_at,
            'created_at_format' => $this->created_at_format,
            'created_at_format_2' => $this->created_at_format2,
            'updated_at' => $this->updated_at,
            'updated_at_format' => $this->updated_at_format,
            'updated_at_format_2' => $this->updated_at_format2,
        ];
    }
}
