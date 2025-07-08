<?php

declare(strict_types=1);

namespace App\DTOs\v1\Profile;

use App\Http\Requests\API\v1\Profile\UpdatePasswordRequest;

class UpdatePasswordDto
{
    public function __construct(
        public string $password,
    ) {
    }

    public static function fromRequest(UpdatePasswordRequest $request): UpdatePasswordDto
    {
        return new UpdatePasswordDto(
            password: $request->get('password')
        );
    }
}
