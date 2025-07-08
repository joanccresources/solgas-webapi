<?php

declare(strict_types=1);

namespace App\Actions\v1\Employment\EmploymentArea;

use App\DTOs\v1\Employment\EmploymentArea\UpdateEmploymentAreaDto;
use App\Http\Controllers\API\v1\Helpers\ApiResponse;
use App\Http\Resources\v1\EmploymentAreaResource;
use App\Models\EmploymentArea;
use Illuminate\Http\JsonResponse;

class UpdateEmploymentAreaAction
{
    protected $element;

    public function __construct(EmploymentArea $element)
    {
        $this->element = $element;
    }

    public function execute(UpdateEmploymentAreaDto $dto)
    {
        return $this
            ->update($dto)
            ->buildResponse($dto);
    }

    protected function update(UpdateEmploymentAreaDto $dto): self
    {
        $this->element->name = $dto->name;
        $this->element->active = $dto->active;
        $this->element->save();

        return $this;
    }

    protected function buildResponse($dto): JsonResponse
    {
        return ApiResponse::createResponse()
            ->withData(new EmploymentAreaResource($this->element))
            ->withMessage(trans('custom.message.update.success', ['name' => trans('custom.attribute.employment_area')]))
            ->build();
    }
}
