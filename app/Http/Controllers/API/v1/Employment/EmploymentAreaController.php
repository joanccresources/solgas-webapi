<?php

namespace App\Http\Controllers\API\v1\Employment;

use App\Actions\v1\Employment\EmploymentArea\CreateEmploymentAreaAction;
use App\Actions\v1\Employment\EmploymentArea\UpdateEmploymentAreaAction;
use App\DTOs\v1\Employment\EmploymentArea\CreateEmploymentAreaDto;
use App\DTOs\v1\Employment\EmploymentArea\UpdateEmploymentAreaDto;
use App\Http\Controllers\API\v1\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\API\v1\Employment\EmploymentAreaRequest;
use App\Http\Resources\v1\EmploymentAreaResource;
use App\Models\EmploymentArea;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class EmploymentAreaController extends Controller
{
    /**
     * Create the controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->authorizeResource(EmploymentArea::class, 'employment_area');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request): JsonResource
    {
        $q = $request->q;
        $elements = EmploymentArea::withCount('employmentRels');
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

        return EmploymentAreaResource::collection($elements);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\API\v1\Employment\EmploymentAreaRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(EmploymentAreaRequest $request): JsonResponse
    {
        $dto = CreateEmploymentAreaDto::fromRequest($request);

        $element = new CreateEmploymentAreaAction(new EmploymentArea());

        return $element->execute($dto);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\EmploymentArea  $employmentArea
     * @return \Illuminate\Http\Response
     */
    public function show(EmploymentArea $employmentArea): JsonResource
    {
        $employmentArea->loadCount('employmentRels');
        return new EmploymentAreaResource($employmentArea);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\API\v1\Employment\EmploymentAreaRequest  $request
     * @param  \App\Models\EmploymentArea  $employmentArea
     * @return \Illuminate\Http\Response
     */
    public function update(EmploymentAreaRequest $request, EmploymentArea $employmentArea): JsonResponse
    {
        $dto = UpdateEmploymentAreaDto::fromRequest($request);

        $element = new UpdateEmploymentAreaAction($employmentArea);

        return $element->execute($dto);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\EmploymentArea  $employmentArea
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(EmploymentArea $employmentArea): JsonResponse
    {
        if ($employmentArea->employmentRels()->count() > 0) {
            return ApiResponse::createResponse()
                ->withStatusCode(422)
                ->withMessage("El área no se puede eliminar porque tiene empleos asociados.")
                ->build();
        }

        $employmentArea->delete();

        return ApiResponse::createResponse()
            ->withMessage(trans('custom.message.delete.success', ['name' => trans('custom.attribute.employment_area')]))
            ->build();
    }
}
