<?php

declare(strict_types=1);

namespace App\Actions\v1\Blog\Tag;

use App\DTOs\v1\Blog\Tag\UpdateTagDto;
use App\Http\Controllers\API\v1\Helpers\ApiResponse;
use App\Http\Resources\v1\TagResource;
use App\Models\Tag;
use Illuminate\Http\JsonResponse;

class UpdateTagAction
{
    protected $element;

    public function __construct(Tag $element)
    {
        $this->element = $element;
    }

    public function execute(UpdateTagDto $dto)
    {
        return $this
            ->update($dto)
            ->buildResponse($dto);
    }

    protected function update(UpdateTagDto $dto): self
    {
        $this->element->name = $dto->name;
        $this->element->slug = $dto->slug;
        $this->element->active = $dto->active;
        $this->element->save();

        return $this;
    }

    protected function buildResponse($dto): JsonResponse
    {
        return ApiResponse::createResponse()
            ->withData(new TagResource($this->element))
            ->withMessage(trans('custom.message.update.success', ['name' => trans('custom.attribute.tag')]))
            ->build();
    }
}
