<?php

declare(strict_types=1);

namespace App\Actions\v1\Page\Page;

use App\Actions\v1\Helpers\Storage\GenerateOptimizedImageAction;
use App\DTOs\v1\Helpers\Storage\GenerateFileDto;
use App\DTOs\v1\Page\Page\CreatePageDto;
use App\Http\Controllers\API\v1\Helpers\ApiResponse;
use App\Http\Resources\v1\PageResource;
use App\Models\Page;
use Illuminate\Http\JsonResponse;

class CreatePageAction
{
    private const FOLDER_PRINCIPAL = 'public' . DIRECTORY_SEPARATOR;
    private const FOLDER_IMAGE = 'images' . DIRECTORY_SEPARATOR . 'pages';

    protected $element;
    protected $storage;
    protected $image;

    public function __construct(Page $element, $storage)
    {
        $this->element = $element;
        $this->storage = $storage;
        $this->image = '';
    }

    public function execute(CreatePageDto $dto)
    {
        return $this
            ->createImage($dto)
            ->create($dto)
            ->buildResponse($dto);
    }

    protected function createImage($dto): self
    {
        if ($dto->seo_image) {
            $imageDto = GenerateFileDto::fromArray(['file' => $dto->seo_image]);
            $generate = new GenerateOptimizedImageAction($this->storage);
            $this->image = $generate->execute(
                $imageDto->file,
                self::FOLDER_PRINCIPAL . self::FOLDER_IMAGE
            );
        }

        return $this;
    }

    protected function create(CreatePageDto $dto): self
    {
        $this->element->name = $dto->name;
        $this->element->slug = $dto->slug;
        $this->element->active = $dto->active;
        $this->element->seo_description = $dto->seo_description;
        $this->element->seo_keywords = $dto->seo_keywords;
        $this->element->seo_image = $this->image;
        $this->element->save();

        return $this;
    }

    protected function buildResponse($dto): JsonResponse
    {
        return ApiResponse::createResponse()
            ->withData(new PageResource($this->element))
            ->withMessage(trans('custom.message.create.success', ['name' => trans('custom.attribute.page')]))
            ->build();
    }
}
