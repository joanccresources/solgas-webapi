<?php

declare(strict_types=1);

namespace App\Actions\v1\Profile;

use App\DTOs\v1\Profile\UpdatePasswordDto;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\API\v1\Helpers\ApiResponse;
use App\Http\Resources\v1\UserResource;
use App\Models\User;
use Illuminate\Http\JsonResponse;

class UpdatePasswordAction
{

    protected $element;

    public function __construct(User $element)
    {
        $this->element = $element;
    }

    public function execute(UpdatePasswordDto $elementDto)
    {
        return $this
            ->createElement($elementDto)
            ->buildResponse($elementDto);
    }

    protected function createElement(UpdatePasswordDto $elementDto): self
    {
        $this->element->password = Hash::make($elementDto->password);
        $this->element->save();

        return $this;
    }

    protected function buildResponse($elementDto): JsonResponse
    {
        return ApiResponse::createResponse()
            ->withData(new UserResource($this->element))
            ->withMessage(trans('custom.message.update.success', ['name' => trans('custom.attribute.change_password')]))
            ->build();
    }
}
