<?php

namespace App\Http\Controllers\API\v1\Employment;

use App\Actions\v1\Employment\EmploymentType\CreateEmploymentTypeAction;
use App\Actions\v1\Employment\EmploymentType\UpdateEmploymentTypeAction;
use App\DTOs\v1\Employment\EmploymentType\CreateEmploymentTypeDto;
use App\DTOs\v1\Employment\EmploymentType\UpdateEmploymentTypeDto;
use App\Http\Controllers\API\v1\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\API\v1\Employment\EmploymentTypeRequest;
use App\Http\Resources\v1\EmploymentTypeResource;
use App\Models\EmploymentType;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class EmploymentTypeController extends Controller
{
    /**
     * Create the controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->authorizeResource(EmploymentType::class, 'employment_type');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request): JsonResource
    {
        $q = $request->q;
        $elements = EmploymentType::withCount('employmentRels');
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

        return EmploymentTypeResource::collection($elements);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\API\v1\Employment\EmploymentTypeRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(EmploymentTypeRequest $request): JsonResponse
    {
        $dto = CreateEmploymentTypeDto::fromRequest($request);

        $element = new CreateEmploymentTypeAction(new EmploymentType());

        return $element->execute($dto);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\EmploymentType  $employmentType
     * @return \Illuminate\Http\Response
     */
    public function show(EmploymentType $employmentType): JsonResource
    {
        $employmentType->loadCount('employmentRels');
        return new EmploymentTypeResource($employmentType);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\API\v1\Employment\EmploymentTypeRequest  $request
     * @param  \App\Models\EmploymentType  $employmentType
     * @return \Illuminate\Http\Response
     */
    public function update(EmploymentTypeRequest $request, EmploymentType $employmentType): JsonResponse
    {
        $dto = UpdateEmploymentTypeDto::fromRequest($request);

        $element = new UpdateEmploymentTypeAction($employmentType);

        return $element->execute($dto);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\EmploymentType  $employmentType
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(EmploymentType $employmentType): JsonResponse
    {
        if ($employmentType->employmentRels()->count() > 0) {
            return ApiResponse::createResponse()
                ->withStatusCode(422)
                ->withMessage("El tipo no se puede eliminar porque tiene empleos asociados.")
                ->build();
        }

        $employmentType->delete();

        return ApiResponse::createResponse()
            ->withMessage(trans('custom.message.delete.success', ['name' => trans('custom.attribute.employment_type')]))
            ->build();
    }
}
