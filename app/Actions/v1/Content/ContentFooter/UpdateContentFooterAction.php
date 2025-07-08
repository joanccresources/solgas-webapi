<?php

declare(strict_types=1);

namespace App\Actions\v1\Content\ContentFooter;

use App\DTOs\v1\Content\ContentFooter\UpdateContentFooterDto;
use App\Http\Controllers\API\v1\Helpers\ApiResponse;
use App\Http\Resources\v1\ContentFooterResource;
use App\Models\ContentFooter;
use Illuminate\Http\JsonResponse;

class UpdateContentFooterAction
{
    protected $element;

    public function __construct(ContentFooter $element)
    {
        $this->element = $element;
    }

    public function execute(UpdateContentFooterDto $dto)
    {
        return $this
            ->create($dto)
            ->buildResponse($dto);
    }

    protected function create(UpdateContentFooterDto $dto): self
    {
        $this->element->name = $dto->name;
        $this->element->active = $dto->active;
        $this->element->save();

        return $this;
    }

    protected function buildResponse($dto): JsonResponse
    {
        return ApiResponse::createResponse()
            ->withData(new ContentFooterResource($this->element))
            ->withMessage(trans('custom.message.update.success', ['name' => trans('custom.attribute.element')]))
            ->build();
    }
}
