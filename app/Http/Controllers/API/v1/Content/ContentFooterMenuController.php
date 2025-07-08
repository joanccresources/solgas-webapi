<?php

namespace App\Http\Controllers\API\v1\Content;

use App\Actions\v1\Content\ContentFooterMenu\CreateContentFooterMenuAction;
use App\Actions\v1\Content\ContentFooterMenu\UpdateContentFooterMenuAction;
use App\Actions\v1\Helpers\Order\UpdateElementOrderAction;
use App\DTOs\v1\Content\ContentFooterMenu\CreateContentFooterMenuDto;
use App\DTOs\v1\Content\ContentFooterMenu\UpdateContentFooterMenuDto;
use App\DTOs\v1\Helpers\Order\UpdateContentOrderDto;
use App\Http\Controllers\API\v1\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\API\v1\Content\ContentFooterMenuRequest;
use App\Http\Requests\API\v1\Helpers\Order\ContentOrderRequest;
use App\Http\Resources\v1\ContentFooterMenuResource;
use App\Models\ContentFooter;
use App\Models\ContentFooterMenu;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class ContentFooterMenuController extends Controller
{
    /**
     * Create the controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->authorizeResource(ContentFooterMenu::class, 'content_footer_menu');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, ContentFooter $contentFooter, ContentFooterMenu $contentFooterMenu = null): JsonResource
    {
        $elements =  ContentFooterMenu::withCount(['childMenus'])
            ->where('content_footer_id', $contentFooter->id);

        if ($contentFooterMenu) {
            $elements->where('content_footer_menu_id', $contentFooterMenu->id);
        } else {
            $elements->whereNull('content_footer_menu_id');
        }
        $elements = $elements->orderBy('index', 'ASC')
            ->get();

        return ContentFooterMenuResource::collection($elements);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\API\v1\Content\ContentFooterMenuRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ContentFooterMenuRequest $request): JsonResponse
    {
        $dto = CreateContentFooterMenuDto::fromRequest($request);

        $element = new CreateContentFooterMenuAction(new ContentFooterMenu(), Storage::disk('s3'));

        return $element->execute($dto);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ContentFooterMenu  $contentFooterMenu
     * @return \Illuminate\Http\Response
     */
    public function show(ContentFooterMenu $contentFooterMenu): JsonResource
    {
        $contentFooterMenu->load(['parentMenu', 'childMenus'])->loadCount(['childMenus']);

        return new ContentFooterMenuResource($contentFooterMenu);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\API\v1\Content\ContentFooterMenuRequest  $request
     * @param  \App\Models\ContentFooterMenu  $contentFooterMenu
     * @return \Illuminate\Http\Response
     */
    public function update(ContentFooterMenuRequest $request, ContentFooterMenu $contentFooterMenu): JsonResponse
    {
        $dto = UpdateContentFooterMenuDto::fromRequest($request);

        $element = new UpdateContentFooterMenuAction($contentFooterMenu, Storage::disk('s3'));

        return $element->execute($dto);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ContentFooterMenu  $contentFooterMenu
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(ContentFooterMenu $contentFooterMenu): JsonResponse
    {
        $contentFooterMenu->childMenus()->delete();
        $contentFooterMenu->delete();

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
        $this->authorize('order', ContentFooterMenu::class);

        $dto = UpdateContentOrderDto::fromRequest($request);

        $useCase = new UpdateElementOrderAction(new ContentFooterMenu());

        return $useCase->execute($dto);
    }
}
