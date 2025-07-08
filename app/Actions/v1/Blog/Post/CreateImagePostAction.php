<?php

declare(strict_types=1);

namespace App\Actions\v1\Blog\Post;

use App\Actions\v1\Helpers\Storage\GenerateFileAction;
use App\Actions\v1\Helpers\Storage\GenerateOptimizedImageAction;
use App\DTOs\v1\Helpers\Storage\GenerateFileDto;
use App\DTOs\v1\Blog\Post\CreateImagePostDto;
use App\Http\Controllers\API\v1\Helpers\ApiResponse;
use Illuminate\Http\JsonResponse;

class CreateImagePostAction
{
    private const FOLDER_PRINCIPAL = 'public' . DIRECTORY_SEPARATOR;
    private const FOLDER_IMAGE = 'images' . DIRECTORY_SEPARATOR . 'posts';

    protected $storage;
    protected $image;

    public function __construct($storage)
    {
        $this->storage = $storage;
        $this->image = '';
    }

    public function execute(CreateImagePostDto $dto)
    {
        return $this
            ->createImage($dto)
            ->buildResponse();
    }

    protected function createImage(CreateImagePostDto $dto): self
    {
        if ($dto->image) {
            $imageDto = GenerateFileDto::fromArray(['file' => $dto->image]);
            $generate = $this->generateFileAction($imageDto->file);

            $this->image = $generate->execute(
                $imageDto->file,
                self::FOLDER_PRINCIPAL . self::FOLDER_IMAGE
            );
        }

        return $this;
    }

    protected function generateFileAction($file)
    {
        if ($this->isSvg($file)) {
            return new GenerateFileAction($this->storage);
        }

        return new GenerateOptimizedImageAction($this->storage);
    }

    protected function isSvg($file): bool
    {
        return $file->getClientOriginalExtension() === 'svg' || $file->getMimeType() === 'image/svg+xml';
    }

    protected function buildResponse(): JsonResponse
    {
        return ApiResponse::createResponse()
            ->withData([
                'image' => $this->image,
                'image_format' => config('services.s3_bucket.url_bucket_public')
                    . DIRECTORY_SEPARATOR
                    . self::FOLDER_PRINCIPAL
                    . self::FOLDER_IMAGE
                    . DIRECTORY_SEPARATOR . $this->image,
            ])
            ->withMessage(trans('custom.message.create.success', ['name' => trans('custom.attribute.image_post')]))
            ->build();
    }
}
