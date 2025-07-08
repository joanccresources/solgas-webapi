<?php

declare(strict_types=1);

namespace App\Actions\v1\Lead\LeadEmailDestination;

use App\DTOs\v1\Lead\LeadEmailDestination\UpdateLeadEmailDestinationDto;
use App\Http\Controllers\API\v1\Helpers\ApiResponse;
use App\Http\Resources\v1\LeadEmailDestinationResource;
use App\Models\LeadEmailDestination;
use Illuminate\Http\JsonResponse;

class UpdateLeadEmailDestinationAction
{
    protected $element;

    public function __construct(LeadEmailDestination $element)
    {
        $this->element = $element;
    }

    public function execute(UpdateLeadEmailDestinationDto $dto)
    {
        return $this
            ->update($dto)
            ->buildResponse($dto);
    }

    protected function update(UpdateLeadEmailDestinationDto $dto): self
    {
        $this->element->name = $dto->name;
        $this->element->email = $dto->email;
        $this->element->save();

        return $this;
    }

    protected function buildResponse($dto): JsonResponse
    {
        return ApiResponse::createResponse()
            ->withData(new LeadEmailDestinationResource($this->element))
            ->withMessage(trans('custom.message.update.success', ['name' => trans('custom.attribute.element')]))
            ->build();
    }
}
