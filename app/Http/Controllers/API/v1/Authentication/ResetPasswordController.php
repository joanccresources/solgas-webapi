<?php

namespace App\Http\Controllers\API\v1\Authentication;

use App\Http\Controllers\API\v1\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\API\v1\Authentication\ResetPasswordRequest;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Hash;

class ResetPasswordController extends Controller
{
    public function reset(ResetPasswordRequest $request)
    {
        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) {
                $user->forceFill([
                    'password' => Hash::make($password)
                ]);

                $user->save();

                event(new PasswordReset($user));
            }
        );

        return $status ===  Password::PASSWORD_RESET
            ?  ApiResponse::createResponse()
            ->withMessage('Contraseña restablecida correctamente')
            ->build()
            :
            ApiResponse::createResponse()
            ->withMessage('No se pudo restablecer la contraseña')
            ->withStatusCode(500)
            ->build();
    }
}
