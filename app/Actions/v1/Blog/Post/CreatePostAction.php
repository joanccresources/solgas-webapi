<?php

declare(strict_types=1);

namespace App\Actions\v1\Blog\Post;

use App\Actions\v1\Helpers\Storage\GenerateOptimizedImageAction;
use App\DTOs\v1\Helpers\Storage\GenerateFileDto;
use App\DTOs\v1\Blog\Post\CreatePostDto;
use App\Http\Controllers\API\v1\Helpers\ApiResponse;
use App\Http\Resources\v1\PostResource;
use App\Models\Post;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Carbon;

class CreatePostAction
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

    public function execute(CreatePostDto $dto)
    {
        return $this
            ->createImage($dto)
            ->createThumbnail($dto)
            ->create($dto)
            ->createTags($dto)
            ->createCategories($dto)
            ->createSimilarPosts($dto)
            ->buildResponse($dto);
    }

    protected function createImage(CreatePostDto $dto): self
    {
        if ($dto->image) {
            $imageDto = GenerateFileDto::fromArray(['file' => $dto->image]);
            $generate = new GenerateOptimizedImageAction($this->storage);
            $this->image = $generate->execute(
                $imageDto->file,
                self::FOLDER_PRINCIPAL . self::FOLDER_IMAGE
            );
        }

        return $this;
    }

    protected function createThumbnail(CreatePostDto $dto): self
    {
        if ($dto->thumbnail) {
            $imageDto = GenerateFileDto::fromArray(['file' => $dto->thumbnail]);
            $generate = new GenerateOptimizedImageAction($this->storage);
            $this->thumbnail = $generate->execute(
                $imageDto->file,
                self::FOLDER_PRINCIPAL . self::FOLDER_IMAGE
            );
        }

        return $this;
    }

    protected function createTags(CreatePostDto $dto): self
    {
        if ($dto->tags) {
            $this->element->toManyTagPostRels()->sync($dto->tags);
        }

        return $this;
    }

    protected function createCategories(CreatePostDto $dto): self
    {
        if ($dto->categories) {
            $this->element->toManyCategoryPostRels()->sync($dto->categories);
        }

        return $this;
    }

    protected function createSimilarPosts(CreatePostDto $dto): self
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


    protected function create(CreatePostDto $dto): self
    {
        $this->element->title = $dto->title;
        $this->element->slug = $dto->slug;
        $this->element->active = $dto->active;
        $this->element->short_description = $dto->short_description;
        $this->element->content = $dto->content;
        $this->element->image = $this->image;
        $this->element->thumbnail = $this->thumbnail;
        $this->element->user_id = auth()->user()->id;
        $this->element->publication_at = Carbon::createFromFormat('d-m-Y H:i:s', $dto->publication_at);
        $this->element->save();

        return $this;
    }

    protected function buildResponse($dto): JsonResponse
    {
        return ApiResponse::createResponse()
            ->withData(new PostResource($this->element))
            ->withMessage(trans('custom.message.create.success', ['name' => trans('custom.attribute.post')]))
            ->build();
    }
}
