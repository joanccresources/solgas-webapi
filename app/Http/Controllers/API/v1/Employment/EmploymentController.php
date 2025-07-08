<?php

namespace App\Http\Controllers\API\v1\Employment;

use App\Actions\v1\Employment\Employment\CreateEmploymentAction;
use App\Actions\v1\Employment\Employment\UpdateEmploymentAction;
use App\DTOs\v1\Employment\Employment\CreateEmploymentDto;
use App\DTOs\v1\Employment\Employment\UpdateEmploymentDto;
use App\Http\Controllers\API\v1\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\API\v1\Employment\EmploymentRequest;
use App\Http\Resources\v1\EmploymentResource;
use App\Models\Employment;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class EmploymentController extends Controller
{
    /**
     * Create the controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->authorizeResource(Employment::class, 'employment');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request): JsonResource
    {
        $q = $request->q;
        $elements = Employment::with(['codeUbigeoRel', 'typeRel', 'areaRel', 'similarEmploymentRels.similarEmploymentRel'])->withCount(['similarEmploymentRels']);
        if ($q) {
            $elements = $elements->where(function ($query) use ($q) {
                $query->where('title', 'LIKE', '%' . $q . '%');
                $query->orWhere('description', 'LIKE', '%' . $q . '%');
                $query->orWhere('address', 'LIKE', '%' . $q . '%');
                $query->orWhere('posted_at', 'LIKE', '%' . $q . '%');
                if (Carbon::hasFormat($q, 'd-m-Y')) {
                    $query->orWhere('posted_at', 'LIKE', '%' . Carbon::createFromFormat('d-m-Y', $q)->format('Y-m-d') . '%');
                }
            });
            $elements = $elements->orWhereHas('codeUbigeoRel', function ($query) use ($q) {
                $query->where('department', 'LIKE', '%' . $q . '%');
                $query->orWhere('province', 'LIKE', '%' . $q . '%');
                $query->orWhere('district', 'LIKE', '%' . $q . '%');
            });
        }
        if ($request->sort_by) {
            $elements = $elements->orderBy($request->sort_by, $request->descending)->paginate((int) $request->per_page);
        } else {
            $elements = $elements->paginate((int) $request->per_page);
        }

        return EmploymentResource::collection($elements);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\API\v1\Employment\EmploymentRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(EmploymentRequest $request): JsonResponse
    {
        $dto = CreateEmploymentDto::fromRequest($request);

        $element = new CreateEmploymentAction(new Employment());

        return $element->execute($dto);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Employment  $employment
     * @return \Illuminate\Http\Response
     */
    public function show(Employment $employment): JsonResource
    {
        $employment->loadCount(['similarEmploymentRels'])->load(['codeUbigeoRel', 'typeRel', 'areaRel', 'similarEmploymentRels.similarEmploymentRel']);
        return new EmploymentResource($employment);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\API\v1\Employment\EmploymentRequest  $request
     * @param  \App\Models\Employment  $employment
     * @return \Illuminate\Http\Response
     */
    public function update(EmploymentRequest $request, Employment $employment): JsonResponse
    {
        $dto = UpdateEmploymentDto::fromRequest($request);

        $element = new UpdateEmploymentAction($employment);

        return $element->execute($dto);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Employment  $employment
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Employment $employment): JsonResponse
    {
        if ($employment->leadWorkWithUsRels()->count() > 0) {
            return ApiResponse::createResponse()
                ->withStatusCode(422)
                ->withMessage("El empleo no se puede eliminar porque tiene leads asociados.")
                ->build();
        }

        $employment->delete();

        return ApiResponse::createResponse()
            ->withMessage(trans('custom.message.delete.success', ['name' => trans('custom.attribute.employment')]))
            ->build();
    }
}
