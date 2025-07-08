<?php

namespace App\Http\Controllers\API\v1\Content;

use App\Actions\v1\Content\SustainabilityReportObject\CreateSustainabilityReportObjectAction;
use App\Actions\v1\Content\SustainabilityReportObject\UpdateSustainabilityReportObjectAction;
use App\Actions\v1\Helpers\Order\UpdateElementOrderAction;
use App\DTOs\v1\Content\SustainabilityReportObject\CreateSustainabilityReportObjectDto;
use App\DTOs\v1\Content\SustainabilityReportObject\UpdateSustainabilityReportObjectDto;
use App\DTOs\v1\Helpers\Order\UpdateContentOrderDto;
use App\Http\Controllers\API\v1\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\API\v1\Content\SustainabilityReportObjectRequest;
use App\Http\Requests\API\v1\Helpers\Order\ContentOrderRequest;
use App\Http\Resources\v1\SustainabilityReportObjectResource;
use App\Models\SustainabilityReport;
use App\Models\SustainabilityReportObject;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class SustainabilityReportObjectController extends Controller
{
    /**
     * Create the controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->authorizeResource(SustainabilityReportObject::class, 'sustainability_report_object');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, SustainabilityReport $sustainabilityReport): JsonResource
    {
        $elements =  SustainabilityReportObject::with(['reportObjectsRel'])
            ->where('sustainability_report_id', $sustainabilityReport->id)
            ->orderBy('index', 'ASC')
            ->get();

        return SustainabilityReportObjectResource::collection($elements);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\API\v1\Content\SustainabilityReportObjectRequest  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(SustainabilityReportObjectRequest $request): JsonResponse
    {
        $dto = CreateSustainabilityReportObjectDto::fromRequest($request);

        $element = new CreateSustainabilityReportObjectAction(new SustainabilityReportObject(), Storage::disk('s3'));

        return $element->execute($dto);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\SustainabilityReportObject  $sustainabilityReportObject
     * @return \Illuminate\Http\Resources\Json\JsonResource
     */
    public function show(SustainabilityReportObject $sustainabilityReportObject): JsonResource
    {
        $sustainabilityReportObject->load('reportObjectsRel');
        return new SustainabilityReportObjectResource($sustainabilityReportObject);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\API\v1\Content\SustainabilityReportObjectRequest  $request
     * @param  \App\Models\SustainabilityReportObject  $sustainabilityReportObject
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(SustainabilityReportObjectRequest $request, SustainabilityReportObject $sustainabilityReportObject): JsonResponse
    {
        $dto = UpdateSustainabilityReportObjectDto::fromRequest($request);
        if (!$request->hasFile('image')) {
            $dto->image = null;
        }

        $action = new UpdateSustainabilityReportObjectAction($sustainabilityReportObject, Storage::disk('s3'));

        return $action->execute($dto);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\SustainabilityReportObject  $sustainabilityReportObject
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(SustainabilityReportObject $sustainabilityReportObject): JsonResponse
    {
        $image = $sustainabilityReportObject->image;

        $delete = $sustainabilityReportObject->delete();

        if ($delete) {
            Storage::disk('s3')->delete('public/images/sustainability-reports/' . $image);
        }

        return ApiResponse::createResponse()
            ->withMessage(trans('custom.message.delete.success', ['name' => trans('custom.attribute.element')]))
            ->build();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\API\v1\Helpers\Order\ContentOrderRequest  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function setOrder(ContentOrderRequest $request): JsonResponse
    {
        $this->authorize('order', SustainabilityReportObject::class);

        $dto = UpdateContentOrderDto::fromRequest($request);

        $useCase = new UpdateElementOrderAction(new SustainabilityReportObject());

        return $useCase->execute($dto);
    }
}
