<?php

declare(strict_types=1);

namespace App\Http\Controllers\API\v1\Authentication;

use App\DTOs\v1\Authentication\LoginDto;
use App\Http\Controllers\Controller as Controller;
use App\Http\Requests\API\v1\Authentication\LoginRequest;
use App\Actions\v1\Authentication\LogOutUser;
use App\Actions\v1\Authentication\VerifyUser;
use App\Actions\v1\Authentication\VerifyUserAdmin;
use Illuminate\Http\JsonResponse;

class LoginController extends Controller
{
    public function login(LoginRequest $request): JsonResponse
    {
        $loginDto = LoginDto::fromRequest($request);
        $user = new VerifyUser();

        return $user->execute($loginDto);
    }

    public function logout(): JsonResponse
    {
        $logout = new LogOutUser(auth()->user());

        return $logout->execute();
    }
}
