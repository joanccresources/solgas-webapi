<?php

declare(strict_types=1);

namespace App\DTOs\v1\Setting\Role;

use App\Http\Requests\API\v1\Setting\Role\RoleRequest;

class UpdateRoleDto
{
    public function __construct(
        public string $name,
        public array $permissions
    ) {
    }

    public static function fromRequest(RoleRequest $request): UpdateRoleDto
    {
        return new UpdateRoleDto(
            name: $request->get('name'),
            permissions: $request->get('permissions')
        );
    }
}
