<?php

namespace App\Http\Controllers\API\v1\Map;

use App\Actions\v1\Helpers\Order\UpdateElementOrderAction;
use App\Actions\v1\Map\CreateMapServiceStationAction;
use App\Actions\v1\Map\UpdateMapServiceStationAction;
use App\DTOs\v1\Helpers\Order\UpdateContentOrderDto;
use App\DTOs\v1\Map\CreateMapServiceStationDto;
use App\DTOs\v1\Map\UpdateMapServiceStationDto;
use App\Http\Controllers\API\v1\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\API\v1\Helpers\Order\ContentOrderRequest;
use App\Http\Requests\API\v1\Map\MapServiceStationRequest;
use App\Http\Resources\v1\MapResource;
use App\Models\Map;
use App\Models\MasterUbigeo;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MapServiceStationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request): JsonResource
    {
        $this->authorize('viewAny', Map::class);

        $per_page = $request->per_page ?? 10;
        $q = $request->q;

        // 🔹 Obtener todos los ubigeos que coincidan con la búsqueda
        $ubigeos = MasterUbigeo::select('code_ubigeo', 'department', 'province', 'district')
            ->get();

        // 🔹 Crear un array asociativo usando `code_ubigeo` como clave
        $ubigeoMap = [];
        foreach ($ubigeos as $ubi) {
            $ubigeoMap[$ubi->code_ubigeo] = [
                'department_name' => $ubi->department ?? null,
                'province_name' => $ubi->province ?? null,
                'district_name' => $ubi->district ?? null,
            ];
        }

        // 🔹 Filtrar `Map`
        $elements = Map::with(['typeMapRel'])
            ->where('type_map_id', '<>', 4)
            ->when($q, function ($query) use ($q, $ubigeos) {
                $query->where(function ($qBuilder) use ($q, $ubigeos) {
                    $qBuilder->where('name', 'LIKE', "%$q%")
                        ->orWhere('address', 'LIKE', "%$q%")
                        ->orWhere('schedule', 'LIKE', "%$q%")
                        ->orWhere('phone', 'LIKE', "%$q%")
                        ->orWhere('latitude', 'LIKE', "%$q%")
                        ->orWhere('longitude', 'LIKE', "%$q%")
                        ->orWhere('coverage_area', 'LIKE', "%$q%");
                });
            });

        // 🔹 Aplicar ordenamiento y paginación
        $elements = $elements->orderBy($request->sort_by ?? 'id', $request->descending ? 'DESC' : 'ASC')->paginate((int) $per_page);

        // 🔹 Agregar los nombres correctos basados en `code_ubigeo`
        $elements->getCollection()->transform(function ($map) use ($ubigeoMap) {
            // Generar `code_ubigeo` desde los valores en `maps`
            $codeUbigeo = str_pad($map->code_department, 2, '0', STR_PAD_LEFT) .
                str_pad($map->code_province, 2, '0', STR_PAD_LEFT) .
                str_pad($map->code_district, 2, '0', STR_PAD_LEFT);

            // Asignar valores desde `ubigeoMap`
            $map->department = $ubigeoMap[$codeUbigeo]['department_name'] ?? null;
            $map->province = $ubigeoMap[$codeUbigeo]['province_name'] ?? null;
            $map->district = $ubigeoMap[$codeUbigeo]['district_name'] ?? null;

            return $map;
        });

        return MapResource::collection($elements);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\API\v1\Map\MapServiceStationRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(MapServiceStationRequest $request): JsonResponse
    {
        $this->authorize('create', Map::class);

        $dto = CreateMapServiceStationDto::fromRequest($request);

        $element = new CreateMapServiceStationAction(new Map());

        return $element->execute($dto);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Map  $mapServiceStation
     * @return \Illuminate\Http\Response
     */
    public function show(Map $mapServiceStation): JsonResource | JsonResponse
    {
        $this->authorize('view', $mapServiceStation);

        if ($mapServiceStation->type_map_id === 4) {
            return ApiResponse::createResponse()
                ->withStatusCode(422)
                ->withMessage("El recurso no existe")
                ->build();
        }

        $mapServiceStation->load(['typeMapRel']);

        return new MapResource($mapServiceStation);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\API\v1\Map\MapServiceStationRequest  $request
     * @param  \App\Models\Map  $mapServiceStation
     * @return \Illuminate\Http\Response
     */
    public function update(MapServiceStationRequest $request, Map $mapServiceStation): JsonResponse
    {
        $this->authorize('update', $mapServiceStation);

        if ($mapServiceStation->type_map_id === 4) {
            return ApiResponse::createResponse()
                ->withStatusCode(422)
                ->withMessage("El recurso no existe")
                ->build();
        }

        $dto = UpdateMapServiceStationDto::fromRequest($request);

        $element = new UpdateMapServiceStationAction($mapServiceStation);

        return $element->execute($dto);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Map  $mapServiceStation
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Map $mapServiceStation): JsonResponse
    {
        $this->authorize('delete', $mapServiceStation);

        if ($mapServiceStation->type_map_id === 4) {
            return ApiResponse::createResponse()
                ->withStatusCode(422)
                ->withMessage("El recurso no existe")
                ->build();
        }

        $mapServiceStation->delete();

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
        $this->authorize('order', Map::class);

        $dto = UpdateContentOrderDto::fromRequest($request);

        $useCase = new UpdateElementOrderAction(new Map());

        return $useCase->execute($dto);
    }
}
