<?php

declare(strict_types=1);

namespace App\Actions\v1\Setting\GeneralInformation;

use App\DTOs\v1\Setting\GeneralInformation\UpdateGeneralInformationTokenMapDto;
use App\Http\Controllers\API\v1\Helpers\ApiResponse;
use App\Http\Resources\v1\GeneralInformationResource;
use App\Models\GeneralInformation;
use Illuminate\Http\JsonResponse;

class UpdateGeneralInformationTokenMapAction
{
    protected $element;

    public function __construct(GeneralInformation $element)
    {
        $this->element = $element;
    }

    public function execute(UpdateGeneralInformationTokenMapDto $dto)
    {
        return $this
            ->update($dto)
            ->buildResponse($dto);
    }

    protected function update(UpdateGeneralInformationTokenMapDto $dto): self
    {
        $this->element->token_map = $dto->token_map;
        $this->element->save();

        return $this;
    }

    protected function buildResponse($dto): JsonResponse
    {
        return ApiResponse::createResponse()
            ->withData(new GeneralInformationResource($this->element))
            ->withMessage(trans('custom.message.update.success', ['name' => trans('custom.attribute.general_information')]))
            ->build();
    }
}
