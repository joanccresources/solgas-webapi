<?php

declare(strict_types=1);

namespace App\Actions\v1\Content\ContentSeo;

use App\Actions\v1\Helpers\Storage\GenerateOptimizedImageAction;
use App\DTOs\v1\Content\ContentSeo\UpdateContentSeoDto;
use App\DTOs\v1\Helpers\Storage\GenerateFileDto;
use App\Http\Controllers\API\v1\Helpers\ApiResponse;
use App\Http\Resources\v1\ContentSeoResource;
use App\Models\Page;
use Illuminate\Http\JsonResponse;

class UpdateContentSeoAction
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

    public function execute(UpdateContentSeoDto $dto)
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
        } else {
            $this->image = $this->element->seo_image;
        }

        if ($dto->seo_image && $this->element->seo_image) {
            $this->storage->delete(self::FOLDER_PRINCIPAL . self::FOLDER_IMAGE . DIRECTORY_SEPARATOR . $this->element->seo_image);
        }

        return $this;
    }

    protected function create(UpdateContentSeoDto $dto): self
    {
        $this->element->name = $dto->name;
        $this->element->seo_description = $dto->seo_description;
        $this->element->seo_keywords = $dto->seo_keywords;
        $this->element->seo_image = $this->image;
        $this->element->save();

        return $this;
    }

    protected function buildResponse($dto): JsonResponse
    {
        return ApiResponse::createResponse()
            ->withData(new ContentSeoResource($this->element))
            ->withMessage(trans('custom.message.update.success', ['name' => trans('custom.attribute.content_seo')]))
            ->build();
    }
}
