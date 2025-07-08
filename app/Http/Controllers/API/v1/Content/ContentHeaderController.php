<?php

namespace App\Http\Controllers\API\v1\Content;

use App\Actions\v1\Content\ContentHeader\CreateContentHeaderAction;
use App\Actions\v1\Content\ContentHeader\UpdateContentHeaderAction;
use App\DTOs\v1\Content\ContentHeader\CreateContentHeaderDto;
use App\DTOs\v1\Content\ContentHeader\UpdateContentHeaderDto;
use App\Http\Controllers\API\v1\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\API\v1\Content\ContentHeaderRequest;
use App\Http\Resources\v1\ContentHeaderResource;
use App\Models\ContentHeader;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ContentHeaderController extends Controller
{
    /**
     * Create the controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->authorizeResource(ContentHeader::class, 'content_header');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request): JsonResource
    {
        $elements = ContentHeader::withCount(['contentHeaderMenuRels' => function ($query) {
            $query->whereNull('content_header_menu_id');
        }])->orderBy('created_at', 'DESC')->get();

        return ContentHeaderResource::collection($elements);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\API\v1\Content\ContentHeaderRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ContentHeaderRequest $request): JsonResponse
    {
        $dto = CreateContentHeaderDto::fromRequest($request);

        $element = new CreateContentHeaderAction(new ContentHeader());

        return $element->execute($dto);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ContentHeader  $contentHeader
     * @return \Illuminate\Http\Response
     */
    public function show(ContentHeader $contentHeader): JsonResource
    {
        $contentHeader->loadCount(['contentHeaderMenuRels' => function ($query) {
            $query->whereNull('content_header_menu_id');
        }]);

        return new ContentHeaderResource($contentHeader);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\API\v1\Content\ContentHeaderRequest  $request
     * @param  \App\Models\ContentHeader  $contentHeader
     * @return \Illuminate\Http\Response
     */
    public function update(ContentHeaderRequest $request, ContentHeader $contentHeader): JsonResponse
    {
        $dto = UpdateContentHeaderDto::fromRequest($request);

        $element = new UpdateContentHeaderAction($contentHeader);

        return $element->execute($dto);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ContentHeader  $contentHeader
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(ContentHeader $contentHeader): JsonResponse
    {
        $contentHeader->delete();

        return ApiResponse::createResponse()
            ->withMessage(trans('custom.message.delete.success', ['name' => trans('custom.attribute.element')]))
            ->build();
    }
}
