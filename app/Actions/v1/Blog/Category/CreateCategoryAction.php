<?php

declare(strict_types=1);

namespace App\Actions\v1\Blog\Category;

use App\DTOs\v1\Blog\Category\CreateCategoryDto;
use App\Http\Controllers\API\v1\Helpers\ApiResponse;
use App\Http\Resources\v1\CategoryResource;
use App\Models\Category;
use Illuminate\Http\JsonResponse;

class CreateCategoryAction
{
    protected $element;

    public function __construct(Category $element)
    {
        $this->element = $element;
    }

    public function execute(CreateCategoryDto $dto)
    {
        return $this
            ->create($dto)
            ->buildResponse($dto);
    }

    protected function create(CreateCategoryDto $dto): self
    {
        $this->element->name = $dto->name;
        $this->element->background_color = $dto->background_color;
        $this->element->point_color = $dto->point_color;
        $this->element->slug = $dto->slug;
        $this->element->active = $dto->active;
        $this->element->save();

        return $this;
    }

    protected function buildResponse($dto): JsonResponse
    {
        return ApiResponse::createResponse()
            ->withData(new CategoryResource($this->element))
            ->withMessage(trans('custom.message.create.success', ['name' => trans('custom.attribute.category')]))
            ->build();
    }
}
