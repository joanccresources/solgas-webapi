<?php

declare(strict_types=1);

namespace App\DTOs\v1\Setting\Role;

use App\Http\Requests\API\v1\Setting\Role\RoleRequest;

class CreateRoleDto
{
    public function __construct(
        public string $name,
        public array $permissions
    ) {
    }

    public static function fromRequest(RoleRequest $request): CreateRoleDto
    {
        return new CreateRoleDto(
            name: $request->get('name'),
            permissions: $request->get('permissions')
        );
    }
}
