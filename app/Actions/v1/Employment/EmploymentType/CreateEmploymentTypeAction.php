<?php

declare(strict_types=1);

namespace App\Actions\v1\Employment\EmploymentType;

use App\DTOs\v1\Employment\EmploymentType\CreateEmploymentTypeDto;
use App\Http\Controllers\API\v1\Helpers\ApiResponse;
use App\Http\Resources\v1\EmploymentTypeResource;
use App\Models\EmploymentType;
use Illuminate\Http\JsonResponse;

class CreateEmploymentTypeAction
{
    protected $element;

    public function __construct(EmploymentType $element)
    {
        $this->element = $element;
    }

    public function execute(CreateEmploymentTypeDto $dto)
    {
        return $this
            ->create($dto)
            ->buildResponse($dto);
    }

    protected function create(CreateEmploymentTypeDto $dto): self
    {
        $this->element->name = $dto->name;
        $this->element->active = $dto->active;
        $this->element->save();

        return $this;
    }

    protected function buildResponse($dto): JsonResponse
    {
        return ApiResponse::createResponse()
            ->withData(new EmploymentTypeResource($this->element))
            ->withMessage(trans('custom.message.create.success', ['name' => trans('custom.attribute.employment_type')]))
            ->build();
    }
}
