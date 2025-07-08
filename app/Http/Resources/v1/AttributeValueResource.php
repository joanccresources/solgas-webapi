<?php

namespace App\Http\Resources\v1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AttributeValueResource extends JsonResource
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
            'text_value' => $this->text_value,
            'boolean_value' => $this->boolean_value,
            'integer_value' => $this->integer_value,
            'float_value' => $this->float_value,
            'date_value' => $this->date_value,
            'date_value_format' => $this->date_value_format,
            'datetime_value' => $this->datetime_value,
            'datetime_value_format' => $this->datetime_value_format,
            'json_value' => $this->json_value,
            'json_value_format' => $this->json_value_format,
            'entity_id' => $this->entity_id,
            'attribute_id' => $this->attribute_id,
            'attribute_rel' => new AttributeResource($this->attributeRel),

            'created_at' => $this->created_at,
            'created_at_format' => $this->created_at_format,
            'created_at_format_2' => $this->created_at_format2,
            'updated_at' => $this->updated_at,
            'updated_at_format' => $this->updated_at_format,
            'updated_at_format_2' => $this->updated_at_format2,
        ];
    }
}
