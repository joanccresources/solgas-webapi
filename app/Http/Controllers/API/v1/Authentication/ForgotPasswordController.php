<?php

namespace App\Http\Controllers\API\v1\Authentication;

use App\Http\Controllers\API\v1\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\API\v1\Authentication\ForgotPasswordRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Password;

class ForgotPasswordController extends Controller
{
    public function sendResetLinkEmail(ForgotPasswordRequest $request): JsonResponse
    {
        $status = Password::sendResetLink(
            $request->only('email')
        );

        return $status === Password::RESET_LINK_SENT
            ?  ApiResponse::createResponse()
            ->withMessage('Se ha enviado un correo electrónico para el restablecimiento de contraseña')
            ->build()
            :
            ApiResponse::createResponse()
            ->withMessage('No se pudo enviar el correo electrónico de restablecimiento de contraseña')
            ->withStatusCode(500)
            ->build();
    }
}
