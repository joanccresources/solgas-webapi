<?php

namespace App\Http\Controllers\API\v1\Content;

use App\Actions\v1\Content\ContentSeo\UpdateContentSeoAction;
use App\DTOs\v1\Content\ContentSeo\UpdateContentSeoDto;
use App\Http\Controllers\Controller;
use App\Http\Requests\API\v1\Content\ContentSeoRequest;
use App\Http\Resources\v1\ContentSeoResource;
use App\Models\Page;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class ContentSeoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request): JsonResource
    {
        $this->authorize('viewAny', Page::class);

        $elements =  Page::where('active', true)->orderBy('created_at', 'ASC')->get();

        return ContentSeoResource::collection($elements);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Page $contentSeo)
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\API\v1\Content\ContentSeoRequest  $request
     * @param  \App\Models\Page  $contentSeo
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(ContentSeoRequest $request, Page $contentSeo): JsonResponse
    {
        $this->authorize('update', $contentSeo);

        $dto = UpdateContentSeoDto::fromRequest($request);
        if (!$request->hasFile('seo_image')) {
            $dto->seo_image = null;
        }

        $action = new UpdateContentSeoAction($contentSeo, Storage::disk('s3'));

        return $action->execute($dto);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Page $contentSeo)
    {
        //
    }
}
