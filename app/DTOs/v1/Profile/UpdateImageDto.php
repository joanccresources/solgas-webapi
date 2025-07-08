<?php

declare(strict_types=1);

namespace App\DTOs\v1\Profile;

use App\Http\Requests\API\v1\Profile\UpdateImageRequest;
use Illuminate\Http\UploadedFile;

class UpdateImageDto
{
    public function __construct(
        public UploadedFile $image
    ) {
    }

    public static function fromRequest(UpdateImageRequest $request): UpdateImageDto
    {
        return new UpdateImageDto(
            image: $request->file('image')
        );
    }
}
