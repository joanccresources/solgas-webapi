<?php

declare(strict_types=1);

namespace App\Actions\v1\Blog\Tag;

use App\DTOs\v1\Blog\Tag\CreateTagDto;
use App\Http\Controllers\API\v1\Helpers\ApiResponse;
use App\Http\Resources\v1\TagResource;
use App\Models\Tag;
use Illuminate\Http\JsonResponse;

class CreateTagAction
{
    protected $element;

    public function __construct(Tag $element)
    {
        $this->element = $element;
    }

    public function execute(CreateTagDto $dto)
    {
        return $this
            ->create($dto)
            ->buildResponse($dto);
    }

    protected function create(CreateTagDto $dto): self
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
            ->withMessage(trans('custom.message.create.success', ['name' => trans('custom.attribute.tag')]))
            ->build();
    }
}
