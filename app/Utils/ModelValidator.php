<?php

namespace App\Utils;

use App\Http\Controllers\API\v1\Helpers\ApiResponse;

class ModelValidator
{
    /**
     * Validate if a model is active
     *
     * @param mixed $model
     * @return mixed
     */
    public static function validateActive($model)
    {
        if (!$model->active->value) {
            return ApiResponse::createResponse()
                ->withStatusCode(404)
                ->withMessage("El recurso solicitado no existe")
                ->build();
        }

        return null;
    }
}
