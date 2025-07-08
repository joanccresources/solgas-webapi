<?php

namespace App\Http\Controllers\API\v1\Page;

use App\Actions\v1\Page\Page\CreatePageAction;
use App\Actions\v1\Page\Page\UpdatePageAction;
use App\DTOs\v1\Page\Page\CreatePageDto;
use App\DTOs\v1\Page\Page\UpdatePageDto;
use App\Http\Controllers\API\v1\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\API\v1\Page\PageRequest;
use App\Http\Resources\v1\PageResource;
use App\Models\Page;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class PageController extends Controller
{
    /**
     * Create the controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->authorizeResource(Page::class, 'page');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request): JsonResource
    {
        $q = $request->q;
        $elements = Page::withCount(['sectionRels']);
        if ($q) {
            $elements = $elements->where(function ($query) use ($q) {
                $query->where('name', 'LIKE', '%' . $q . '%');
                $query->orWhere('slug', 'LIKE', '%' . $q . '%');
                $query->orWhere('seo_description', 'LIKE', '%' . $q . '%');
                $query->orWhere('seo_keywords', 'LIKE', '%' . $q . '%');
                $query->orWhere('seo_image', 'LIKE', '%' . $q . '%');
            });
        }
        if ($request->sort_by) {
            $elements = $elements->orderBy($request->sort_by, $request->descending)->paginate((int) $request->per_page);
        } else {
            $elements = $elements->paginate((int) $request->per_page);
        }

        return PageResource::collection($elements);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\API\v1\Page\PageRequest  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(PageRequest $request): JsonResponse
    {
        $dto = CreatePageDto::fromRequest($request);

        $element = new CreatePageAction(new Page(), Storage::disk('s3'));

        return $element->execute($dto);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Page  $page
     * @return \Illuminate\Http\Resources\Json\JsonResource
     */
    public function show(Page $page): JsonResource
    {
        $page->loadCount(['sectionRels']);
        return new PageResource($page);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\API\v1\Page\PageRequest  $request
     * @param  \App\Models\Page  $page
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(PageRequest $request, Page $page): JsonResponse
    {
        $dto = UpdatePageDto::fromRequest($request);
        if (!$request->hasFile('seo_image')) {
            $dto->seo_image = null;
        }

        $action = new UpdatePageAction($page, Storage::disk('s3'));

        return $action->execute($dto);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Page  $page
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Page $page): JsonResponse
    {
        $page->delete();

        return ApiResponse::createResponse()
            ->withMessage(trans('custom.message.delete.success', ['name' => trans('custom.attribute.page')]))
            ->build();
    }
}
