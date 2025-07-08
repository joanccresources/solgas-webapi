<?php

namespace App\Http\Controllers\API\v1\Content;

use App\Actions\v1\Content\ContentFooter\CreateContentFooterAction;
use App\Actions\v1\Content\ContentFooter\UpdateContentFooterAction;
use App\DTOs\v1\Content\ContentFooter\CreateContentFooterDto;
use App\DTOs\v1\Content\ContentFooter\UpdateContentFooterDto;
use App\Http\Controllers\API\v1\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\API\v1\Content\ContentFooterRequest;
use App\Http\Resources\v1\ContentFooterResource;
use App\Models\ContentFooter;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ContentFooterController extends Controller
{
    /**
     * Create the controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->authorizeResource(ContentFooter::class, 'content_footer');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request): JsonResource
    {
        $elements =  ContentFooter::withCount(['contentFooterMenuRels' => function ($query) {
            $query->whereNull('content_footer_menu_id');
        },])->orderBy('created_at', 'DESC')->get();

        return ContentFooterResource::collection($elements);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\API\v1\Content\ContentFooterRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ContentFooterRequest $request): JsonResponse
    {
        $dto = CreateContentFooterDto::fromRequest($request);

        $element = new CreateContentFooterAction(new ContentFooter());

        return $element->execute($dto);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ContentFooter  $contentFooter
     * @return \Illuminate\Http\Response
     */
    public function show(ContentFooter $contentFooter): JsonResource
    {
        $contentFooter->loadCount(['contentFooterMenuRels' => function ($query) {
            $query->whereNull('content_footer_menu_id');
        }]);

        return new ContentFooterResource($contentFooter);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\API\v1\Content\ContentFooterRequest  $request
     * @param  \App\Models\ContentFooter  $contentFooter
     * @return \Illuminate\Http\Response
     */
    public function update(ContentFooterRequest $request, ContentFooter $contentFooter): JsonResponse
    {
        $dto = UpdateContentFooterDto::fromRequest($request);

        $element = new UpdateContentFooterAction($contentFooter);

        return $element->execute($dto);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ContentFooter  $contentFooter
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(ContentFooter $contentFooter): JsonResponse
    {
        $contentFooter->delete();

        return ApiResponse::createResponse()
            ->withMessage(trans('custom.message.delete.success', ['name' => trans('custom.attribute.element')]))
            ->build();
    }
}
