<?php

namespace App\Http\Controllers\API\v1\Automation;

use App\Actions\v1\Automation\Attribute\CreateAttributeAction;
use App\Actions\v1\Automation\Attribute\UpdateAttributeAction;
use App\Actions\v1\Helpers\Order\UpdateElementOrderAction;
use App\DTOs\v1\Automation\Attribute\CreateAttributeDto;
use App\DTOs\v1\Automation\Attribute\UpdateAttributeDto;
use App\DTOs\v1\Helpers\Order\UpdateContentOrderDto;
use App\Http\Controllers\API\v1\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\API\v1\Automation\AttributeRequest;
use App\Http\Requests\API\v1\Helpers\Order\ContentOrderRequest;
use App\Http\Resources\v1\AttributeResource;
use App\Models\Attribute;
use App\Traits\AttributeTrait;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AttributeController extends Controller
{
    use AttributeTrait;

    /**
     * Create the controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->authorizeResource(Attribute::class, 'attribute');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request): JsonResponse
    {
        $elements = Attribute::with(['optionRels'])->orderBy('index', 'ASC')->get();
        $models = $this->models();
        $data = array();

        foreach ($models as $key => $model) {

            $attributes = $elements->filter(function ($element, int $key) use ($model) {
                return $element->model == $model['id'];
            });

            array_push($data, array_merge($model, ['attributes' => AttributeResource::collection($attributes)]));
        }

        return ApiResponse::createResponse()
            ->withData($data)
            ->build();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\API\v1\Automation\AttributeRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AttributeRequest $request): JsonResponse
    {
        $dto = CreateAttributeDto::fromRequest($request);

        $element = new CreateAttributeAction(new Attribute());

        return $element->execute($dto);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Attribute  $attribute
     * @return \Illuminate\Http\Response
     */
    public function show(Attribute $attribute): JsonResource
    {
        $attribute->load(['optionRels', 'valueRels']);
        return new AttributeResource($attribute);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\API\v1\Automation\AttributeRequest  $request
     * @param  \App\Models\Attribute  $attribute
     * @return \Illuminate\Http\Response
     */
    public function update(AttributeRequest $request, Attribute $attribute): JsonResponse
    {
        $dto = UpdateAttributeDto::fromRequest($request);

        $element = new UpdateAttributeAction($attribute);

        return $element->execute($dto);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Attribute  $attribute
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Attribute $attribute): JsonResponse
    {
        $attribute->optionRels()->delete();
        $attribute->valueRels()->delete();
        $attribute->delete();

        return ApiResponse::createResponse()
            ->withMessage(trans('custom.message.delete.success', ['name' => trans('custom.attribute.attribute')]))
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
        $this->authorize('order', Attribute::class);

        $exist_model = $this->existModel($request->model);

        if (!$exist_model) {
            return ApiResponse::createResponse()
                ->withMessage('El model solicitado no existe.')
                ->withStatusCode(404)
                ->build();
        }

        $count_attributes = Attribute::where('model', $request->model)->count();

        if ($count_attributes == 0) {
            return ApiResponse::createResponse()
                ->withStatusCode(422)
                ->withMessage("El modelo $request->model no cuenta con atributos")
                ->build();
        }

        $dto = UpdateContentOrderDto::fromRequest($request);

        $useCase = new UpdateElementOrderAction(new Attribute(), (object) ['id' => $request->model], 'model');

        return $useCase->execute($dto);
    }
}
