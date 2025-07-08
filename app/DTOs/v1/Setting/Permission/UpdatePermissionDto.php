<?php

declare(strict_types=1);

namespace App\DTOs\v1\Setting\Permission;

use App\Http\Requests\API\v1\Setting\Permission\PermissionRequest;

class UpdatePermissionDto
{
    public function __construct(
        public int $module_id,
        public int|null $submodule_id,
        public string|null $operation_id
    ) {
    }

    public static function fromRequest(PermissionRequest $request): UpdatePermissionDto
    {
        return new self(
            module_id: $request->get('module_id'),
            submodule_id: $request->get('submodule_id'),
            operation_id: $request->get('operation_id')
        );
    }
}
