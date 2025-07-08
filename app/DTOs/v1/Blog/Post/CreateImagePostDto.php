<?php

declare(strict_types=1);

namespace App\DTOs\v1\Blog\Post;

use App\Http\Requests\API\v1\Blog\ImagePostRequest;
use Illuminate\Http\UploadedFile;

class CreateImagePostDto
{
    public function __construct(
        public UploadedFile $image,
    ) {}

    public static function fromRequest(ImagePostRequest $request): CreateImagePostDto
    {
        return new self(
            image: $request->file('image'),
        );
    }
}
