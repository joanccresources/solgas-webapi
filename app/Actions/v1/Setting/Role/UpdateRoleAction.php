<?php

declare(strict_types=1);

namespace App\Actions\v1\Setting\Role;

use App\DTOs\v1\Setting\Role\UpdateRoleDto;
use App\Http\Controllers\API\v1\Helpers\ApiResponse;
use App\Http\Resources\v1\RoleResource;
use Illuminate\Http\JsonResponse;
use Spatie\Permission\Models\Role;

class UpdateRoleAction
{
    private const INITIAL_ROLE = [1];

    protected $element;

    public function __construct(Role $element)
    {
        $this->element = $element;
    }

    public function execute(UpdateRoleDto $dto)
    {
        return $this
            ->updateRole($dto)
            ->deletePermissions($dto)
            ->createPermissions($dto)
            ->buildResponse($dto);
    }

    protected function updateRole(UpdateRoleDto $dto): self
    {
        $this->element->name = $dto->name;
        $this->element->save();

        return $this;
    }

    protected function deletePermissions(UpdateRoleDto $dto): self
    {
        $permissions = $this->element->permissions->pluck('id');
        $this->element->revokePermissionTo($permissions);
        return $this;
    }

    protected function createPermissions(UpdateRoleDto $dto): self
    {
        $this->element->syncPermissions(array_merge(self::INITIAL_ROLE, $dto->permissions));

        return $this;
    }

    protected function buildResponse($dto): JsonResponse
    {
        return ApiResponse::createResponse()
            ->withData(new RoleResource($this->element))
            ->withMessage(trans('custom.message.update.success', ['name' => trans('custom.attribute.role')]))
            ->build();
    }
}
