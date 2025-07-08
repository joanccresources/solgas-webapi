<?php

declare(strict_types=1);

namespace App\Actions\v1\Setting\Permission;

use App\DTOs\v1\Setting\Permission\UpdatePermissionDto;
use App\Http\Controllers\API\v1\Helpers\ApiResponse;
use App\Http\Resources\v1\PermissionResource;
use App\Models\Module;
use App\Traits\ModulesTrait;
use Spatie\Permission\Models\Permission;
use Illuminate\Http\JsonResponse;

class UpdatePermissionAction
{
    use ModulesTrait;

    protected $element;

    public function __construct(Permission $element)
    {
        $this->element = $element;
    }

    public function execute(UpdatePermissionDto $dto)
    {
        return $this
            ->update($dto)
            ->buildResponse($dto);
    }

    protected function update(UpdatePermissionDto $dto): self
    {
        $operation_id = $dto->operation_id;
        $module = Module::where('id', $dto->submodule_id ? $dto->submodule_id : $dto->module_id)->first();
        $operation = collect($this->operationForPermissions())->first(function (array $value, int $key) use ($operation_id) {
            return $value['id'] == $operation_id;
        });

        $this->element->name = $module->assigned . $operation['id'];
        $this->element->description = $operation['name'];
        $this->element->guard_name = 'web';
        $this->element->module_id = $dto->submodule_id ? $dto->submodule_id : $dto->module_id;
        $this->element->save();

        return $this;
    }

    protected function buildResponse($dto): JsonResponse
    {
        return ApiResponse::createResponse()
            ->withData(new PermissionResource($this->element))
            ->withMessage(trans('custom.message.update.success', ['name' => trans('custom.attribute.permission')]))
            ->build();
    }
}
