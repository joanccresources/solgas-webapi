<?php

declare(strict_types=1);

namespace App\Actions\v1\Profile;

use App\Actions\v1\Helpers\Storage\GenerateOptimizedImageAction;
use App\DTOs\v1\Profile\UpdateImageDto;
use App\DTOs\v1\Helpers\Storage\GenerateFileDto;
use App\Http\Controllers\API\v1\Helpers\ApiResponse;
use App\Http\Resources\v1\UserResource;
use App\Models\User;
use Illuminate\Http\JsonResponse;

class UpdateImageAction
{
    private const FOLDER_PRINCIPAL = 'private' . DIRECTORY_SEPARATOR;
    private const FOLDER_IMAGE = 'images' . DIRECTORY_SEPARATOR . 'users';

    protected $element;
    protected $storage;
    protected $image;

    public function __construct(User $element, $storage)
    {
        $this->element = $element;
        $this->storage = $storage;
        $this->image = '';
    }

    public function execute(UpdateImageDto $elementDto)
    {
        return $this
            ->createImage($elementDto->image)
            ->createElement($elementDto)
            ->buildResponse($elementDto);
    }

    protected function createImage($image): self
    {
        if ($image) {
            $imageDto = GenerateFileDto::fromArray(['file' => $image]);
            $generate = new GenerateOptimizedImageAction($this->storage);
            $this->image = $generate->execute(
                $imageDto->file,
                self::FOLDER_PRINCIPAL . self::FOLDER_IMAGE
            );
        } else {
            $this->image = $this->element->image;
        }

        if ($image && $this->element->image) {
            $this->storage->delete(self::FOLDER_PRINCIPAL . self::FOLDER_IMAGE . DIRECTORY_SEPARATOR . $this->element->image);
        }

        return $this;
    }

    protected function createElement(UpdateImageDto $elementDto): self
    {
        $this->element->image = $this->image;
        $this->element->save();

        return $this;
    }

    protected function buildResponse($elementDto): JsonResponse
    {
        return ApiResponse::createResponse()
            ->withData(new UserResource($this->element))
            ->withMessage(trans('custom.message.update.success', ['name' => trans('custom.attribute.image')]))
            ->build();
    }
}
