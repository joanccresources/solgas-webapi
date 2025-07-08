<?php

declare(strict_types=1);

namespace App\DTOs\v1\Authentication;

use App\Http\Requests\API\v1\Authentication\LoginRequest;

class LoginDto
{
    public function __construct(
        public string $email,
        public string $password
    ) {
    }

    public static function fromRequest(LoginRequest $request): LoginDto
    {
        return new self(
            email: $request->get('email'),
            password: $request->get('password')
        );
    }
}
