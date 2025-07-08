<?php

namespace App\Http\Controllers\API\v1\Setting\Permission;

use App\Actions\v1\Setting\Permission\CreatePermissionAction;
use App\Actions\v1\Setting\Permission\UpdatePermissionAction;
use App\DTOs\v1\Setting\Permission\CreatePermissionDto;
use App\DTOs\v1\Setting\Permission\UpdatePermissionDto;
use App\Http\Controllers\API\v1\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\API\v1\Setting\Permission\PermissionRequest;
use App\Http\Resources\v1\PermissionResource;
use Illuminate\Http\JsonResponse;
use App\Models\Permission;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PermissionController extends Controller
{
    /**
     * Create the controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->authorizeResource(Permission::class, 'permission');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request): JsonResource
    {
        $q = $request->q;
        $elements = new Permission();
        if ($q) {
            $elements = $elements->where(function ($query) use ($q) {
                $query->where('name', 'LIKE', '%' . $q . '%');
                $query->orWhere('description', 'LIKE', '%' . $q . '%');
            });
        }
        if ($request->sort_by) {
            $elements = $elements->orderBy($request->sort_by, $request->descending)->paginate((int) $request->per_page);
        } else {
            $elements = $elements->paginate((int) $request->per_page);
        }

        return PermissionResource::collection($elements);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\API\v1\Setting\Permission\PermissionRequest  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(PermissionRequest $request): JsonResponse
    {
        $dto = CreatePermissionDto::fromRequest($request);

        $element = new CreatePermissionAction(new Permission());

        return $element->execute($dto);
    }

    /**
     * Display the specified resource.
     *
     * @param  \Spatie\Permission\Models\Permission  $permission
     * @return \Illuminate\Http\Resources\Json\JsonResource
     */
    public function show(Permission $permission): JsonResource
    {
        return new PermissionResource($permission);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\API\v1\Setting\Permission\PermissionRequest  $request
     * @param  \Spatie\Permission\Models\Permission  $permission
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(PermissionRequest $request, Permission $permission): JsonResponse
    {
        $dto = UpdatePermissionDto::fromRequest($request);

        $action = new UpdatePermissionAction($permission);

        return $action->execute($dto);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \Spatie\Permission\Models\Permission  $permission
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Permission $permission): JsonResponse
    {
        $permission->delete();

        return ApiResponse::createResponse()
            ->withMessage(trans('custom.message.delete.success', ['name' => trans('custom.attribute.permission')]))
            ->build();
    }
}
