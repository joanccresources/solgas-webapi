<?php

declare(strict_types=1);

namespace App\Actions\v1\Automation\Attribute;

use App\DTOs\v1\Automation\Attribute\UpdateAttributeDto;
use App\Http\Controllers\API\v1\Helpers\ApiResponse;
use App\Http\Resources\v1\AttributeResource;
use App\Models\Attribute;
use App\Models\AttributeOption;
use App\Models\AttributeType;
use Illuminate\Http\JsonResponse;

class UpdateAttributeAction
{
    protected $element;

    public function __construct(Attribute $element)
    {
        $this->element = $element;
    }

    public function execute(UpdateAttributeDto $dto)
    {
        return $this
            ->update($dto)
            ->createOptions($dto)
            ->buildResponse($dto);
    }

    protected function update(UpdateAttributeDto $dto): self
    {
        $this->element->column_code = $dto->column_code;
        $this->element->name = $dto->name;
        $this->element->model_lookup = $dto->model_lookup;
        $this->element->is_required = $dto->is_required;
        $this->element->is_unique = $dto->is_unique;
        $this->element->model = $dto->model;
        $this->element->active = $dto->active;
        $this->element->attribute_type_id = $dto->attribute_type_id;
        $this->element->active = $dto->active;
        $this->element->save();

        return $this;
    }

    protected function createOptions(UpdateAttributeDto $dto): self
    {
        $attribute_type = AttributeType::where('id', $dto->attribute_type_id)->first();
        if ($attribute_type && $attribute_type->type == 'select') {
            foreach ($dto->attribute_options as $key => $value) {
                $attribute_option = new AttributeOption();
                $attribute_option->name = $value;
                $attribute_option->index = $key + 1;
                $attribute_option->attribute_id = $this->element->id;
                $attribute_option->save();
            }
        } else {
            $this->element->optionRels()->delete();
        }

        return $this;
    }

    protected function buildResponse($dto): JsonResponse
    {
        $this->element->load(['optionRels', 'valueRels']);
        return ApiResponse::createResponse()
            ->withData(new AttributeResource($this->element))
            ->withMessage(trans('custom.message.update.success', ['name' => trans('custom.attribute.attribute')]))
            ->build();
    }
}
