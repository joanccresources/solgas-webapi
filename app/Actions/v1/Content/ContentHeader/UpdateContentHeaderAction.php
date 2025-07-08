<?php

declare(strict_types=1);

namespace App\Actions\v1\Content\ContentHeader;

use App\DTOs\v1\Content\ContentHeader\UpdateContentHeaderDto;
use App\Http\Controllers\API\v1\Helpers\ApiResponse;
use App\Http\Resources\v1\ContentHeaderResource;
use App\Models\ContentHeader;
use Illuminate\Http\JsonResponse;

class UpdateContentHeaderAction
{
    protected $element;

    public function __construct(ContentHeader $element)
    {
        $this->element = $element;
    }

    public function execute(UpdateContentHeaderDto $dto)
    {
        return $this
            ->create($dto)
            ->buildResponse($dto);
    }

    protected function create(UpdateContentHeaderDto $dto): self
    {
        $this->element->name = $dto->name;
        $this->element->active = $dto->active;
        $this->element->save();

        return $this;
    }

    protected function buildResponse($dto): JsonResponse
    {
        return ApiResponse::createResponse()
            ->withData(new ContentHeaderResource($this->element))
            ->withMessage(trans('custom.message.update.success', ['name' => trans('custom.attribute.element')]))
            ->build();
    }
}
