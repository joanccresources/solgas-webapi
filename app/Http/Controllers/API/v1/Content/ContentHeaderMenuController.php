<?php

namespace App\Http\Controllers\API\v1\Content;

use App\Actions\v1\Content\ContentHeaderMenu\CreateContentHeaderMenuAction;
use App\Actions\v1\Content\ContentHeaderMenu\UpdateContentHeaderMenuAction;
use App\Actions\v1\Helpers\Order\UpdateElementOrderAction;
use App\DTOs\v1\Content\ContentHeaderMenu\CreateContentHeaderMenuDto;
use App\DTOs\v1\Content\ContentHeaderMenu\UpdateContentHeaderMenuDto;
use App\DTOs\v1\Helpers\Order\UpdateContentOrderDto;
use App\Http\Controllers\API\v1\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\API\v1\Content\ContentHeaderMenuRequest;
use App\Http\Requests\API\v1\Helpers\Order\ContentOrderRequest;
use App\Http\Resources\v1\ContentHeaderMenuResource;
use App\Models\ContentHeader;
use App\Models\ContentHeaderMenu;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class ContentHeaderMenuController extends Controller
{
    /**
     * Create the controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->authorizeResource(ContentHeaderMenu::class, 'content_header_menu');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, ContentHeader $contentHeader, ContentHeaderMenu $contentHeaderMenu = null): JsonResource
    {
        $elements =  ContentHeaderMenu::withCount(['childMenus'])
            ->where('content_header_id', $contentHeader->id);

        if ($contentHeaderMenu) {
            $elements->where('content_header_menu_id', $contentHeaderMenu->id);
        } else {
            $elements->whereNull('content_header_menu_id');
        }
        $elements = $elements->orderBy('index', 'ASC')
            ->get();

        return ContentHeaderMenuResource::collection($elements);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\API\v1\Content\ContentHeaderMenuRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ContentHeaderMenuRequest $request): JsonResponse
    {
        $dto = CreateContentHeaderMenuDto::fromRequest($request);

        $element = new CreateContentHeaderMenuAction(new ContentHeaderMenu(), Storage::disk('s3'));

        return $element->execute($dto);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ContentHeaderMenu  $contentHeaderMenu
     * @return \Illuminate\Http\Response
     */
    public function show(ContentHeaderMenu $contentHeaderMenu): JsonResource
    {
        $contentHeaderMenu->load(['parentMenu', 'childMenus'])->loadCount(['childMenus']);

        return new ContentHeaderMenuResource($contentHeaderMenu);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\API\v1\Content\ContentHeaderMenuRequest  $request
     * @param  \App\Models\ContentHeaderMenu  $contentHeaderMenu
     * @return \Illuminate\Http\Response
     */
    public function update(ContentHeaderMenuRequest $request, ContentHeaderMenu $contentHeaderMenu): JsonResponse
    {
        $dto = UpdateContentHeaderMenuDto::fromRequest($request);

        $element = new UpdateContentHeaderMenuAction($contentHeaderMenu, Storage::disk('s3'));

        return $element->execute($dto);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ContentHeaderMenu  $contentHeaderMenu
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(ContentHeaderMenu $contentHeaderMenu): JsonResponse
    {
        $contentHeaderMenu->childMenus()->delete();
        $contentHeaderMenu->delete();

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
        $this->authorize('order', ContentHeaderMenu::class);

        $dto = UpdateContentOrderDto::fromRequest($request);

        $useCase = new UpdateElementOrderAction(new ContentHeaderMenu());

        return $useCase->execute($dto);
    }
}
