<?php

declare(strict_types=1);

namespace App\Actions\v1\Content\ContentFooter;

use App\DTOs\v1\Content\ContentFooter\CreateContentFooterDto;
use App\Http\Controllers\API\v1\Helpers\ApiResponse;
use App\Http\Resources\v1\ContentFooterResource;
use App\Models\ContentFooter;
use Illuminate\Http\JsonResponse;

class CreateContentFooterAction
{
    protected $element;

    public function __construct(ContentFooter $element)
    {
        $this->element = $element;
    }

    public function execute(CreateContentFooterDto $dto)
    {
        return $this
            ->create($dto)
            ->buildResponse($dto);
    }

    protected function create(CreateContentFooterDto $dto): self
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
            ->withMessage(trans('custom.message.create.success', ['name' => trans('custom.attribute.element')]))
            ->build();
    }
}
