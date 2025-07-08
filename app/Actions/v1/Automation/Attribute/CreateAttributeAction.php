<?php

declare(strict_types=1);

namespace App\Actions\v1\Automation\Attribute;

use App\Actions\v1\Helpers\Max\MaxElementUseCase;
use App\DTOs\v1\Automation\Attribute\CreateAttributeDto;
use App\Http\Controllers\API\v1\Helpers\ApiResponse;
use App\Http\Resources\v1\AttributeResource;
use App\Models\Attribute;
use App\Models\AttributeOption;
use App\Models\AttributeType;
use Illuminate\Http\JsonResponse;

class CreateAttributeAction
{
    protected $element;

    public function __construct(Attribute $element)
    {
        $this->element = $element;
    }

    public function execute(CreateAttributeDto $dto)
    {
        return $this
            ->create($dto)
            ->createOptions($dto)
            ->buildResponse($dto);
    }

    protected function create(CreateAttributeDto $dto): self
    {
        $generateMaxValue = new MaxElementUseCase(Attribute::selectRaw('MAX(id),MAX(`index`) as "value"')->where('model', $dto->model)->get());
        $max_value = $generateMaxValue->execute();

        $this->element->column_code = $dto->column_code;
        $this->element->name = $dto->name;
        $this->element->model_lookup = $dto->model_lookup;
        $this->element->is_required = $dto->is_required;
        $this->element->is_unique = $dto->is_unique;
        $this->element->model = $dto->model;
        $this->element->index = $max_value;
        $this->element->attribute_type_id = $dto->attribute_type_id;
        $this->element->active = $dto->active;
        $this->element->save();

        return $this;
    }

    protected function createOptions(CreateAttributeDto $dto): self
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
        }

        return $this;
    }

    protected function buildResponse($dto): JsonResponse
    {
        $this->element->load(['optionRels', 'valueRels']);
        return ApiResponse::createResponse()
            ->withData(new AttributeResource($this->element))
            ->withMessage(trans('custom.message.create.success', ['name' => trans('custom.attribute.attribute')]))
            ->build();
    }
}
