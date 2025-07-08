<?php

namespace App\Http\Controllers\API\v1\Content;

use App\Actions\v1\Content\SustainabilityReport\CreateSustainabilityReportAction;
use App\Actions\v1\Content\SustainabilityReport\UpdateSustainabilityReportAction;
use App\Actions\v1\Helpers\Order\UpdateElementOrderAction;
use App\DTOs\v1\Content\SustainabilityReport\CreateSustainabilityReportDto;
use App\DTOs\v1\Content\SustainabilityReport\UpdateSustainabilityReportDto;
use App\DTOs\v1\Helpers\Order\UpdateContentOrderDto;
use App\Http\Controllers\API\v1\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\API\v1\Content\SustainabilityReportRequest;
use App\Http\Requests\API\v1\Helpers\Order\ContentOrderRequest;
use App\Http\Resources\v1\SustainabilityReportResource;
use App\Models\SustainabilityReport;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class SustainabilityReportController extends Controller
{
    /**
     * Create the controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->authorizeResource(SustainabilityReport::class, 'sustainability_report');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request): JsonResource
    {
        $elements =  SustainabilityReport::withCount(['reportObjectsRels'])->orderBy('index', 'ASC')->get();

        return SustainabilityReportResource::collection($elements);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\API\v1\Content\SustainabilityReportRequest  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(SustainabilityReportRequest $request): JsonResponse
    {
        $dto = CreateSustainabilityReportDto::fromRequest($request);

        $element = new CreateSustainabilityReportAction(new SustainabilityReport(), Storage::disk('s3'));

        return $element->execute($dto);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\SustainabilityReport  $sustainabilityReport
     * @return \Illuminate\Http\Resources\Json\JsonResource
     */
    public function show(SustainabilityReport $sustainabilityReport): JsonResource
    {
        $sustainabilityReport->loadCount(['reportObjectsRels'])->load(['reportObjectsRels']);
        return new SustainabilityReportResource($sustainabilityReport);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\API\v1\Content\SustainabilityReportRequest  $request
     * @param  \App\Models\SustainabilityReport  $sustainabilityReport
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(SustainabilityReportRequest $request, SustainabilityReport $sustainabilityReport): JsonResponse
    {
        $dto = UpdateSustainabilityReportDto::fromRequest($request);
        if (!$request->hasFile('pdf')) {
            $dto->pdf = null;
        }

        $action = new UpdateSustainabilityReportAction($sustainabilityReport, Storage::disk('s3'));

        return $action->execute($dto);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\SustainabilityReport  $sustainabilityReport
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(SustainabilityReport $sustainabilityReport): JsonResponse
    {
        $pdf = $sustainabilityReport->pdf;
        $sustainabilityReportObjects = $sustainabilityReport->reportObjectsRels();

        $delete = $sustainabilityReport->delete();
        $deleteSustainabilityReportObjects = $sustainabilityReportObjects->delete();

        if ($delete) {
            Storage::disk('s3')->delete('public/documentos/sustainability-reports/' . $pdf);
        }

        if ($deleteSustainabilityReportObjects) {
            foreach ($sustainabilityReportObjects as $sustainabilityReportObject) {
                Storage::disk('s3')->delete('public/images/sustainability-reports/' . $sustainabilityReportObject->image);
            }
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
        $this->authorize('order', SustainabilityReport::class);

        $dto = UpdateContentOrderDto::fromRequest($request);

        $useCase = new UpdateElementOrderAction(new SustainabilityReport());

        return $useCase->execute($dto);
    }
}
