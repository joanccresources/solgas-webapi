<?php

declare(strict_types=1);

namespace App\Actions\v1\Blog\Post;

use App\Actions\v1\Helpers\Storage\GenerateOptimizedImageAction;
use App\DTOs\v1\Helpers\Storage\GenerateFileDto;
use App\DTOs\v1\Blog\Post\UpdatePostDto;
use App\Http\Controllers\API\v1\Helpers\ApiResponse;
use App\Http\Resources\v1\PostResource;
use App\Models\Post;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Carbon;

class UpdatePostAction
{
    private const FOLDER_PRINCIPAL = 'public' . DIRECTORY_SEPARATOR;
    private const FOLDER_IMAGE = 'images' . DIRECTORY_SEPARATOR . 'posts';

    protected $element;
    protected $storage;
    protected $image;
    protected $thumbnail;

    public function __construct(Post $element, $storage)
    {
        $this->element = $element;
        $this->storage = $storage;
        $this->image = '';
        $this->thumbnail = '';
    }

    public function execute(UpdatePostDto $dto)
    {
        return $this
            ->createImage($dto)
            ->createThumbnail($dto)
            ->update($dto)
            ->updateTags($dto)
            ->updateCategories($dto)
            ->updateSimilarPosts($dto)
            ->buildResponse($dto);
    }

    protected function createImage($dto): self
    {
        if ($dto->image) {
            $imageDto = GenerateFileDto::fromArray(['file' => $dto->image]);
            $generate = new GenerateOptimizedImageAction($this->storage);
            $this->image = $generate->execute(
                $imageDto->file,
                self::FOLDER_PRINCIPAL . self::FOLDER_IMAGE
            );
        } else {
            $this->image = $this->element->image;
        }

        if ($dto->image && $this->element->image) {
            $this->storage->delete(self::FOLDER_PRINCIPAL . self::FOLDER_IMAGE . DIRECTORY_SEPARATOR . $this->element->image);
        }

        return $this;
    }

    protected function createThumbnail($dto): self
    {
        if ($dto->thumbnail) {
            $imageDto = GenerateFileDto::fromArray(['file' => $dto->thumbnail]);
            $generate = new GenerateOptimizedImageAction($this->storage);
            $this->thumbnail = $generate->execute(
                $imageDto->file,
                self::FOLDER_PRINCIPAL . self::FOLDER_IMAGE
            );
        } else {
            $this->thumbnail = $this->element->thumbnail;
        }

        if ($dto->thumbnail && $this->element->thumbnail) {
            $this->storage->delete(self::FOLDER_PRINCIPAL . self::FOLDER_IMAGE . DIRECTORY_SEPARATOR . $this->element->thumbnail);
        }

        return $this;
    }

    protected function updateTags(UpdatePostDto $dto): self
    {
        if ($dto->tags) {
            $this->element->toManyTagPostRels()->sync($dto->tags);
        }

        return $this;
    }

    protected function updateCategories(UpdatePostDto $dto): self
    {
        if ($dto->categories) {
            $this->element->toManyCategoryPostRels()->sync($dto->categories);
        }

        return $this;
    }

    protected function updateSimilarPosts(UpdatePostDto $dto): self
    {
        if ($dto->similar_posts) {
            $this->element->similarPostRels()->delete();

            foreach ($dto->similar_posts as $similarPostId) {
                $this->element->similarPostRels()->insert([
                    'post_id' => $this->element->id,
                    'post_similar_id' => $similarPostId,
                ]);
            }
        }

        return $this;
    }

    protected function update(UpdatePostDto $dto): self
    {
        $this->element->title = $dto->title;
        $this->element->slug = $dto->slug;
        $this->element->active = $dto->active;
        $this->element->short_description = $dto->short_description;
        $this->element->content = $dto->content;
        $this->element->image = $this->image;
        $this->element->thumbnail = $this->thumbnail;
        $this->element->publication_at = Carbon::createFromFormat('d-m-Y H:i:s', $dto->publication_at);
        $this->element->save();

        return $this;
    }

    protected function buildResponse($dto): JsonResponse
    {
        return ApiResponse::createResponse()
            ->withData(new PostResource($this->element))
            ->withMessage(trans('custom.message.update.success', ['name' => trans('custom.attribute.post')]))
            ->build();
    }
}
