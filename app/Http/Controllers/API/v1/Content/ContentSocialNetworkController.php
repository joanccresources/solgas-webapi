<?php

namespace App\Http\Controllers\API\v1\Content;

use App\Actions\v1\Content\ContentSocialNetwork\CreateContentSocialNetworkAction;
use App\Actions\v1\Content\ContentSocialNetwork\UpdateContentSocialNetworkAction;
use App\Actions\v1\Helpers\Order\UpdateElementOrderAction;
use App\DTOs\v1\Content\ContentSocialNetwork\CreateContentSocialNetworkDto;
use App\DTOs\v1\Content\ContentSocialNetwork\UpdateContentSocialNetworkDto;
use App\DTOs\v1\Helpers\Order\UpdateContentOrderDto;
use App\Http\Controllers\API\v1\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\API\v1\Content\ContentSocialNetworkRequest;
use App\Http\Requests\API\v1\Helpers\Order\ContentOrderRequest;
use App\Http\Resources\v1\ContentSocialNetworkResource;
use App\Models\ContentSocialNetwork;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ContentSocialNetworkController extends Controller
{
    /**
     * Create the controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->authorizeResource(ContentSocialNetwork::class, 'content_social_network');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request): JsonResource
    {
        $elements =  ContentSocialNetwork::with(['masterSocialNetworkRel'])->orderBy('index', 'ASC')->get();

        return ContentSocialNetworkResource::collection($elements);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\API\v1\Content\ContentSocialNetworkRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ContentSocialNetworkRequest $request): JsonResponse
    {
        $dto = CreateContentSocialNetworkDto::fromRequest($request);

        $element = new CreateContentSocialNetworkAction(new ContentSocialNetwork());

        return $element->execute($dto);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ContentSocialNetwork  $contentSocialNetwork
     * @return \Illuminate\Http\Response
     */
    public function show(ContentSocialNetwork $contentSocialNetwork): JsonResource
    {
        $contentSocialNetwork->load(['masterSocialNetworkRel']);

        return new ContentSocialNetworkResource($contentSocialNetwork);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\API\v1\Content\ContentSocialNetworkRequest  $request
     * @param  \App\Models\ContentSocialNetwork  $contentSocialNetwork
     * @return \Illuminate\Http\Response
     */
    public function update(ContentSocialNetworkRequest $request, ContentSocialNetwork $contentSocialNetwork): JsonResponse
    {
        $dto = UpdateContentSocialNetworkDto::fromRequest($request);

        $element = new UpdateContentSocialNetworkAction($contentSocialNetwork);

        return $element->execute($dto);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ContentSocialNetwork  $contentSocialNetwork
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(ContentSocialNetwork $contentSocialNetwork): JsonResponse
    {
        $contentSocialNetwork->delete();

        return ApiResponse::createResponse()
            ->withMessage(trans('custom.message.delete.success', ['name' => trans('custom.attribute.content_social_network')]))
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
        $this->authorize('order', ContentSocialNetwork::class);

        $dto = UpdateContentOrderDto::fromRequest($request);

        $useCase = new UpdateElementOrderAction(new ContentSocialNetwork());

        return $useCase->execute($dto);
    }
}
