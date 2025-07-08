<?php

declare(strict_types=1);

namespace App\Actions\v1\Map;

use App\Actions\v1\Helpers\Max\MaxElementUseCase;
use App\DTOs\v1\Map\CreateMapServiceStationDto;
use App\Http\Controllers\API\v1\Helpers\ApiResponse;
use App\Http\Resources\v1\MapResource;
use App\Models\Map;
use Illuminate\Http\JsonResponse;

class CreateMapServiceStationAction
{
    protected $element;

    public function __construct(Map $element)
    {
        $this->element = $element;
    }

    public function execute(CreateMapServiceStationDto $dto)
    {
        return $this
            ->create($dto)
            ->buildResponse($dto);
    }

    protected function create(CreateMapServiceStationDto $dto): self
    {
        $generateMaxValue = new MaxElementUseCase(Map::selectRaw('MAX(id),MAX(`index`) as "value"')->where('type_map_id', $dto->type_map_id)->get());
        $max_value = $generateMaxValue->execute();

        $this->element->index = $max_value;
        $this->element->active = $dto->active;
        $this->element->name = $dto->name;
        $this->element->address = $dto->address;
        $this->element->schedule = $dto->schedule;
        $this->element->phone = $dto->phone;
        $this->element->latitude = $dto->latitude;
        $this->element->longitude = $dto->longitude;
        $this->element->code_department = $dto->code_department;
        $this->element->code_province = $dto->code_province;
        $this->element->code_district = $dto->code_district;
        $this->element->type_map_id = $dto->type_map_id;
        $this->element->save();

        return $this;
    }

    protected function buildResponse($dto): JsonResponse
    {
        $this->element->load(['typeMapRel']);
        return ApiResponse::createResponse()
            ->withData(new MapResource($this->element))
            ->withMessage(trans('custom.message.create.success', ['name' => trans('custom.attribute.element')]))
            ->build();
    }
}
