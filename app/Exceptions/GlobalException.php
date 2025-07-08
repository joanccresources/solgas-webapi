<?php

namespace App\Exceptions;

use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\QueryException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Throwable;
use App\Http\Controllers\API\v1\Helpers\ApiResponse;
use Illuminate\Http\Exceptions\ThrottleRequestsException;
use TypeError;

use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class GlobalException extends Exception
{
    /**
     * Report the exception.
     */
    public function report(): void
    {
        // ...
    }

    /**
     * Render the exception into an HTTP response.
     */
    public function render(Throwable $exception, Request $request)
    {
        if ($exception instanceof NotFoundHttpException) {
            return ApiResponse::createResponse()
                ->withMessage('El recurso solicitado no existe.')
                ->withStatusCode(404)
                ->build();
        }

        if ($exception instanceof ValidationException) {
            return $this->convertValidationExceptionToResponse($exception, $request);
        }

        if ($exception instanceof AuthenticationException) {
            return $this->unauthenticated($request, $exception);
        }

        if ($exception instanceof AuthorizationException) {
            return ApiResponse::createResponse()
                ->withMessage('No tiene permisos para realizar la solicitud.')
                ->withStatusCode(403)
                ->build();
        }

        if ($exception instanceof AccessDeniedHttpException) {
            return ApiResponse::createResponse()
                ->withMessage('No tiene permisos para realizar la solicitud.')
                ->withStatusCode(403)
                ->build();
        }

        if ($exception instanceof MethodNotAllowedHttpException) {
            return ApiResponse::createResponse()
                ->withMessage('El método especificado en la petición no es válido.')
                ->withStatusCode(405)
                ->build();
        }

        if ($exception instanceof ThrottleRequestsException) {
            return ApiResponse::createResponse()
                ->withMessage('Demasiadas solicitudes. Inténtelo de nuevo más tarde.')
                ->withStatusCode(429)
                ->build();
        }

        if ($exception instanceof HttpException) {
            return ApiResponse::createResponse()
                ->withMessage($exception->getMessage())
                ->withStatusCode($exception->getStatusCode())
                ->build();
        }

        if ($exception instanceof QueryException) {
            $codigo = $exception->errorInfo[1];

            if ($codigo == 1451) {
                return ApiResponse::createResponse()
                    ->withMessage('No se puede eliminar de forma permanente el recurso porque está relacionado con algún otro.')
                    ->withStatusCode(409)
                    ->build();
            }
        }

        if (!config('app.debug')) {
            return ApiResponse::createResponse()
                ->withMessage('Falla inesperada. Intente luego.')
                ->withStatusCode(500)
                ->build();
        }
    }

    protected function convertValidationExceptionToResponse(ValidationException $e, $request)
    {
        $errors = $e->validator->errors()->getMessages();

        if ($this->isFronted($request)) {
            return $request->ajax() ? response()->json($errors, 422) : redirect()->back()->withInput($request->input())->withErrors($errors);
        }

        return ApiResponse::createResponse()
            ->withErrors($errors)
            ->withStatusCode(422)
            ->build();
    }

    protected function unauthenticated($request, AuthenticationException $exception)
    {
        if ($this->isFronted($request)) {
            //return redirect()->guest('login'); //página de login
        }

        return ApiResponse::createResponse()
            ->withMessage('No autenticado.')
            ->withStatusCode(401)
            ->build();
    }

    private function isFronted($request)
    {
        return $request->acceptsHtml() && collect($request->route()->middleware())->contains('web');
    }
}
