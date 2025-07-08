<?php

namespace App\Actions\v1\Authentication;

use App\Http\Controllers\API\v1\Helpers\ApiResponse;
use App\Models\User;
use Illuminate\Http\JsonResponse;

class LogOutUser
{
    protected $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function execute()
    {
        return $this->revokeTokens()
            ->buildResponse();
    }

    protected function revokeTokens(): self
    {
        $this->user->tokens()->delete();

        return $this;
    }

    protected function buildResponse(): JsonResponse
    {
        return ApiResponse::createResponse()
            ->withMessage(__('auth.logout'))
            ->build();
    }
}
