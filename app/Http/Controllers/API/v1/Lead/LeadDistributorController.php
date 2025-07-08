<?php

namespace App\Http\Controllers\API\v1\Lead;

use App\Http\Controllers\API\v1\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Resources\v1\LeadDistributorResource;
use App\Models\LeadDistributor;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class LeadDistributorController extends Controller
{
    /**
     * Create the controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->authorizeResource(LeadDistributor::class, 'lead_distributor');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request): JsonResource
    {
        $q = $request->q;
        $elements = new LeadDistributor();
        if ($q) {
            $elements = $elements->where(function ($query) use ($q) {
                $query->where('full_name', 'LIKE', '%' . $q . '%');
                $query->orWhere('email', 'LIKE', '%' . $q . '%');
                $query->orWhere('dni_or_ruc', 'LIKE', '%' . $q . '%');
                $query->orWhere('phone_1', 'LIKE', '%' . $q . '%');
                $query->orWhere('phone_2', 'LIKE', '%' . $q . '%');
                $query->orWhere('address', 'LIKE', '%' . $q . '%');
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

        return LeadDistributorResource::collection($elements);
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
     * @param  \App\Models\LeadDistributor  $leadDistributor
     * @return \Illuminate\Http\Resources\Json\JsonResource
     */
    public function show(LeadDistributor $leadDistributor): JsonResource
    {
        $leadDistributor->load('codeUbigeoRel');
        return new LeadDistributorResource($leadDistributor);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, LeadDistributor $leadDistributor)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\LeadDistributor  $leadDistributor
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(LeadDistributor $leadDistributor): JsonResponse
    {
        $leadDistributor->delete();

        return ApiResponse::createResponse()
            ->withMessage(trans('custom.message.delete.success', ['name' => trans('custom.attribute.element')]))
            ->build();
    }
}
