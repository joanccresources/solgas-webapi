<?php

namespace App\Http\Controllers\API\v1\Blog;

use App\Actions\v1\Blog\Tag\CreateTagAction;
use App\Actions\v1\Blog\Tag\UpdateTagAction;
use App\DTOs\v1\Blog\Tag\CreateTagDto;
use App\DTOs\v1\Blog\Tag\UpdateTagDto;
use App\Http\Controllers\API\v1\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\API\v1\Blog\TagRequest;
use App\Http\Resources\v1\TagResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Models\Tag;

class TagController extends Controller
{
    /**
     * Create the controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->authorizeResource(Tag::class, 'tag');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $q = $request->q;
        $elements = Tag::withCount(['tagPostRels']);
        if ($q) {
            $elements = $elements->where(function ($query) use ($q) {
                $query->where('name', 'LIKE', '%' . $q . '%');
                $query->orWhere('slug', 'LIKE', '%' . $q . '%');
            });
        }
        if ($request->sort_by) {
            $elements = $elements->orderBy($request->sort_by, $request->descending)->paginate((int) $request->per_page);
        } else {
            $elements = $elements->paginate((int) $request->per_page);
        }
        return TagResource::collection($elements);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\API\v1\Blog\TagRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(TagRequest $request)
    {
        $dto = CreateTagDto::fromRequest($request);

        $element = new CreateTagAction(new Tag());

        return $element->execute($dto);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Tag  $tag
     * @return \Illuminate\Http\Response
     */
    public function show(Tag $tag)
    {
        $tag->loadCount('tagPostRels');
        return new TagResource($tag);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\API\v1\Blog\TagRequest  $request
     * @param  \App\Models\Tag  $tag
     * @return \Illuminate\Http\Response
     */
    public function update(TagRequest $request, Tag $tag)
    {
        $dto = UpdateTagDto::fromRequest($request);

        $element = new UpdateTagAction($tag);

        return $element->execute($dto);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Tag  $tag
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Tag $tag): JsonResponse
    {
        if ($tag->tagPostRels()->count() > 0) {
            return ApiResponse::createResponse()
                ->withStatusCode(422)
                ->withMessage("La etiqueta no se puede eliminar porque tiene publicaciones asociadas.")
                ->build();
        }

        $tag->delete();

        return ApiResponse::createResponse()
            ->withMessage(trans('custom.message.delete.success', ['name' => trans('custom.attribute.tag')]))
            ->build();
    }
}
