<?php

declare(strict_types=1);

namespace App\Actions\v1\Setting\Role;

use App\DTOs\v1\Setting\Role\CreateRoleDto;
use App\Http\Controllers\API\v1\Helpers\ApiResponse;
use App\Http\Resources\v1\RoleResource;
use Illuminate\Http\JsonResponse;
use Spatie\Permission\Models\Role;

class CreateRoleAction
{
    private const INITIAL_ROLE = [1];

    protected $element;

    public function __construct(Role $element)
    {
        $this->element = $element;
    }

    public function execute(CreateRoleDto $dto)
    {
        return $this
            ->createRole($dto)
            ->createPermissions($dto)
            ->buildResponse($dto);
    }

    protected function createRole(CreateRoleDto $dto): self
    {
        $this->element->name = $dto->name;
        $this->element->guard_name =  'web';
        $this->element->save();

        return $this;
    }

    protected function createPermissions(CreateRoleDto $dto): self
    {
        $this->element->syncPermissions(array_merge(self::INITIAL_ROLE, $dto->permissions));

        return $this;
    }

    protected function buildResponse($dto): JsonResponse
    {
        return ApiResponse::createResponse()
            ->withData(new RoleResource($this->element))
            ->withMessage(trans('custom.message.create.success', ['name' => trans('custom.attribute.role')]))
            ->build();
    }
}
