<?php

namespace App\Http\Controllers\API\v1\Lead;

use App\Http\Controllers\API\v1\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Resources\v1\LeadWorkWithUsResource;
use App\Models\LeadWorkWithUs;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Storage;

class LeadWorkWithUsController extends Controller
{
    /**
     * Create the controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->authorizeResource(LeadWorkWithUs::class, 'lead_work_with_us');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request): JsonResource
    {
        $q = $request->q;
        $elements =  LeadWorkWithUs::with(['employmentRel.typeRel', 'employmentRel.areaRel']);
        if ($q) {
            $elements = $elements->where(function ($query) use ($q) {
                $query->where('full_name', 'LIKE', '%' . $q . '%');
                $query->orWhere('email', 'LIKE', '%' . $q . '%');
                $query->orWhere('dni', 'LIKE', '%' . $q . '%');
                $query->orWhere('address', 'LIKE', '%' . $q . '%');
                $query->orWhere('phone', 'LIKE', '%' . $q . '%');
                $query->orWhere('birth_date', 'LIKE', '%' . $q . '%');
                if (Carbon::hasFormat($q, 'd-m-Y')) {
                    $query->orWhere('birth_date', 'LIKE', '%' . Carbon::createFromFormat('d-m-Y', $q)->format('Y-m-d') . '%');
                }
            });
            $elements = $elements->orWhereHas('employmentRel', function ($query) use ($q) {
                $query->where('title', 'LIKE', '%' . $q . '%');
                $query->orWhere('description', 'LIKE', '%' . $q . '%');
            });
        }
        if ($request->sort_by) {
            $elements = $elements->orderBy($request->sort_by, $request->descending)->paginate((int) $request->per_page);
        } else {
            $elements = $elements->paginate((int) $request->per_page);
        }

        return LeadWorkWithUsResource::collection($elements);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\LeadWorkWithUs  $leadWorkWithU
     * @return \Illuminate\Http\Resources\Json\JsonResource
     */
    public function show(LeadWorkWithUs $leadWorkWithU): JsonResource
    {
        $leadWorkWithU->load(['employmentRel.typeRel', 'employmentRel.areaRel']);
        return new LeadWorkWithUsResource($leadWorkWithU);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, LeadWorkWithUs $leadWorkWithU)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\LeadWorkWithUs  $leadWorkWithU
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(LeadWorkWithUs $leadWorkWithU): JsonResponse
    {
        $cv_path_format = $leadWorkWithU->cv_path_format;

        $delete = $leadWorkWithU->delete();

        if ($delete) {
            Storage::disk('s3')->delete($cv_path_format);
        }

        return ApiResponse::createResponse()
            ->withMessage(trans('custom.message.delete.success', ['name' => trans('custom.attribute.element')]))
            ->build();
    }
}
