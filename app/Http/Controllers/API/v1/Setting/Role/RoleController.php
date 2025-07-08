<?php

namespace App\Http\Controllers\API\v1\Setting\Role;

use App\Actions\v1\Setting\Role\CreateRoleAction;
use App\Actions\v1\Setting\Role\UpdateRoleAction;
use App\DTOs\v1\Setting\Role\CreateRoleDto;
use App\DTOs\v1\Setting\Role\UpdateRoleDto;
use App\Http\Controllers\API\v1\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\API\v1\Setting\Role\RoleRequest;
use App\Http\Resources\v1\RoleResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Models\Role;

class RoleController extends Controller
{
    /**
     * Create the controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->authorizeResource(Role::class, 'role');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $q = $request->q;
        $elements = Role::with('permissions')->where('id', '<>', 1); //analizar porque ocultar el superadministrador
        if ($q) {
            $elements = $elements->where(function ($query) use ($q) {
                $query->where('name', 'LIKE', '%' . $q . '%');
            });
        }
        if ($request->sort_by) {
            $elements = $elements->orderBy($request->sort_by, $request->descending)->paginate((int) $request->per_page);
        } else {
            $elements = $elements->paginate((int) $request->per_page);
        }
        return RoleResource::collection($elements);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\API\v1\Setting\Role\RoleRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(RoleRequest $request)
    {
        $dto = CreateRoleDto::fromRequest($request);

        $element = new CreateRoleAction(new Role());

        return $element->execute($dto);
    }

    /**
     * Display the specified resource.
     *
     * @param  \Spatie\Permission\Models\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function show(Role $role)
    {
        return new RoleResource($role);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\API\v1\Setting\Role\RoleRequest  $request
     * @param  \Spatie\Permission\Models\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function update(RoleRequest $request, Role $role)
    {
        //ya no manejaré los roles por nombre sino por ID, excepto el superadministrador
        $dto = UpdateRoleDto::fromRequest($request);

        $element = new UpdateRoleAction($role);

        return $element->execute($dto);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \Spatie\Permission\Models\Role  $role
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Role $role): JsonResponse
    {
        if ($role->id == 1) {
            return ApiResponse::createResponse()
                ->withStatusCode(422)
                ->withMessage('No se puede eliminar el rol predeterminado: ' . $role->name)
                ->build();
        }

        $role->delete();

        return ApiResponse::createResponse()
            ->withMessage(trans('custom.message.delete.success', ['name' => trans('custom.attribute.role')]))
            ->build();
    }
}
