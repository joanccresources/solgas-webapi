<?php

namespace App\Http\Controllers\API\v1\Lead;

use App\Actions\v1\Lead\LeadEmailDestination\CreateLeadEmailDestinationAction;
use App\Actions\v1\Lead\LeadEmailDestination\UpdateLeadEmailDestinationAction;
use App\DTOs\v1\Lead\LeadEmailDestination\CreateLeadEmailDestinationDto;
use App\DTOs\v1\Lead\LeadEmailDestination\UpdateLeadEmailDestinationDto;
use App\Http\Controllers\API\v1\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\API\v1\Lead\LeadEmailDestinationRequest;
use App\Http\Resources\v1\LeadEmailDestinationResource;
use App\Models\LeadEmailDestination;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class LeadEmailDestinationController extends Controller
{
    /**
     * Create the controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->authorizeResource(LeadEmailDestination::class, 'leadEmail_destination');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request): JsonResource
    {
        $q = $request->q;
        $elements = new LeadEmailDestination();
        if ($q) {
            $elements = $elements->where(function ($query) use ($q) {
                $query->where('name', 'LIKE', '%' . $q . '%');
                $query->orWhere('email', 'LIKE', '%' . $q . '%');
            });
        }
        if ($request->sort_by) {
            $elements = $elements->orderBy($request->sort_by, $request->descending)->paginate((int) $request->per_page);
        } else {
            $elements = $elements->paginate((int) $request->per_page);
        }

        return LeadEmailDestinationResource::collection($elements);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\API\v1\Lead\LeadEmailDestinationRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(LeadEmailDestinationRequest $request): JsonResponse
    {
        $dto = CreateLeadEmailDestinationDto::fromRequest($request);

        $element = new CreateLeadEmailDestinationAction(new LeadEmailDestination());

        return $element->execute($dto);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\LeadEmailDestination  $leadEmailDestination
     * @return \Illuminate\Http\Response
     */
    public function show(LeadEmailDestination $leadEmailDestination): JsonResource
    {
        return new LeadEmailDestinationResource($leadEmailDestination);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\API\v1\Lead\LeadEmailDestinationRequest  $request
     * @param  \App\Models\LeadEmailDestination  $leadEmailDestination
     * @return \Illuminate\Http\Response
     */
    public function update(LeadEmailDestinationRequest $request, LeadEmailDestination $leadEmailDestination): JsonResponse
    {
        $dto = UpdateLeadEmailDestinationDto::fromRequest($request);

        $element = new UpdateLeadEmailDestinationAction($leadEmailDestination);

        return $element->execute($dto);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\LeadEmailDestination  $leadEmailDestination
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(LeadEmailDestination $leadEmailDestination): JsonResponse
    {
        $leadEmailDestination->delete();

        return ApiResponse::createResponse()
            ->withMessage(trans('custom.message.delete.success', ['name' => trans('custom.attribute.element')]))
            ->build();
    }
}
