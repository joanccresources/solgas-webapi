<?php

declare(strict_types=1);

namespace App\Actions\v1\Authentication;

use App\DTOs\v1\Authentication\LoginDto;
use App\Http\Controllers\API\v1\Helpers\ApiResponse;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Hash;

class VerifyUser
{
    protected $user;
    protected $token_expiration_date;

    public function execute(LoginDto $dto): JsonResponse
    {
        if (!$tokenUser = $this->generateToken($dto)) {
            return ApiResponse::createResponse()
                ->withMessage(__('auth.failed'))
                ->withStatusCode(401)
                ->build();
        }

        return $this->responseWithToken($tokenUser);
    }

    protected function validateCredentials(LoginDto $dto): bool
    {
        $this->user = User::where('email', $dto->email)->first();

        if (
            $this->user === null ||
            !Hash::check($dto->password, $this->user->password) ||
            !$this->user->active->value === 1
        ) {
            return false;
        }

        return true;
    }

    protected function generateToken(LoginDto $dto)
    {
        $token = false;
        $tokenUser = false;
        $this->token_expiration_date = Carbon::now()->addWeek();
        if ($this->validateCredentials($dto)) {
            $tokenUser = $this->user->createToken('user_solgas', ['*'], $this->token_expiration_date);
            $token = $tokenUser->plainTextToken;
        }

        return $token;
    }

    protected function responseWithToken($tokenUser): JsonResponse
    {
        return ApiResponse::createResponse()
            ->withMessage('Bienvenido ' . $this->user->name)
            ->withData([
                'token' => $tokenUser,
                'user' => $this->user->name,
                'token_expiration_date' => $this->token_expiration_date
            ])
            ->build();
    }
}
