<?php

namespace App\Http\Controllers\API\v1\Lead;

use App\Http\Controllers\API\v1\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Resources\v1\LeadServiceStationResource;
use App\Models\LeadServiceStation;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class LeadServiceStationController extends Controller
{
    /**
     * Create the controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->authorizeResource(LeadServiceStation::class, 'lead_service_station');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request): JsonResource
    {
        $q = $request->q;
        $elements = new LeadServiceStation();
        if ($q) {
            $elements = $elements->where(function ($query) use ($q) {
                $query->where('full_name', 'LIKE', '%' . $q . '%');
                $query->orWhere('email', 'LIKE', '%' . $q . '%');
                $query->orWhere('company', 'LIKE', '%' . $q . '%');
                $query->orWhere('ruc', 'LIKE', '%' . $q . '%');
                $query->orWhere('phone', 'LIKE', '%' . $q . '%');
                $query->orWhere('message', 'LIKE', '%' . $q . '%');
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

        return LeadServiceStationResource::collection($elements);
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
     * @param  \App\Models\LeadServiceStation  $leadServiceStation
     * @return \Illuminate\Http\Resources\Json\JsonResource
     */
    public function show(LeadServiceStation $leadServiceStation): JsonResource
    {
        $leadServiceStation->load('codeUbigeoRel');
        return new LeadServiceStationResource($leadServiceStation);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, LeadServiceStation $leadServiceStation)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\LeadServiceStation  $leadServiceStation
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(LeadServiceStation $leadServiceStation): JsonResponse
    {
        $leadServiceStation->delete();

        return ApiResponse::createResponse()
            ->withMessage(trans('custom.message.delete.success', ['name' => trans('custom.attribute.element')]))
            ->build();
    }
}
