<?php

declare(strict_types=1);

namespace App\Actions\v1\Setting\User;

use Illuminate\Support\Facades\Hash;
use App\Actions\v1\Helpers\Storage\GenerateOptimizedImageAction;
use App\DTOs\v1\Setting\User\CreateUserDto;
use App\DTOs\v1\Helpers\Storage\GenerateFileDto;
use App\Http\Controllers\API\v1\Helpers\ApiResponse;
use App\Http\Resources\v1\UserResource;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Spatie\Permission\Models\Role;

class CreateUserAction
{
    private const FOLDER_PRINCIPAL = 'private' . DIRECTORY_SEPARATOR;
    private const FOLDER_IMAGE = 'images' . DIRECTORY_SEPARATOR . 'users';

    protected $element;
    protected $storage;
    protected $image;

    public function __construct(User $element, $storage)
    {
        $this->element = $element;
        $this->storage = $storage;
        $this->image = '';
    }

    public function execute(CreateUserDto $dto)
    {
        return $this
            ->createImage($dto)
            ->createUser($dto)
            ->buildResponse($dto);
    }

    protected function createImage($dto): self
    {
        if ($dto->image) {
            $imageDto = GenerateFileDto::fromArray(['file' => $dto->image]);
            $generate = new GenerateOptimizedImageAction($this->storage);
            $this->image = $generate->execute(
                $imageDto->file,
                self::FOLDER_PRINCIPAL . self::FOLDER_IMAGE
            );
        }

        return $this;
    }

    protected function createUser(CreateUserDto $dto): self
    {
        $this->element->name = $dto->name;
        $this->element->email = $dto->email;
        $this->element->phone = $dto->phone;
        $this->element->image =  $this->image;
        $this->element->password = Hash::make($dto->password);
        $this->element->active = $dto->active;
        $this->element->save();

        $role = Role::where('id', $dto->rol_id)->first();
        $this->element->assignRole($role);

        return $this;
    }

    protected function buildResponse($dto): JsonResponse
    {
        return ApiResponse::createResponse()
            ->withData(new UserResource($this->element))
            ->withMessage(trans('custom.message.create.success', ['name' => trans('custom.attribute.user')]))
            ->build();
    }
}
