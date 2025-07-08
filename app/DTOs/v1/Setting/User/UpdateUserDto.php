<?php

declare(strict_types=1);

namespace App\DTOs\v1\Setting\User;

use App\Http\Requests\API\v1\Setting\User\UserRequest;
use Illuminate\Http\UploadedFile;

class UpdateUserDto
{
    public function __construct(
        public string $name,
        public UploadedFile|null $image,
        public int $rol_id,
        public string $email,
        public string|null $password,
        public string|null $phone,
        public bool|null $active
    ) {
    }

    public static function fromRequest(UserRequest $request): UpdateUserDto
    {
        return new UpdateUserDto(
            name: $request->get('name'),
            image: $request->file('image'),
            rol_id: (int) $request->get('rol_id'),
            email: $request->get('email'),
            password: $request->get('password'),
            phone: $request->get('phone'),
            active: (bool) $request->get('active')
        );
    }
}
