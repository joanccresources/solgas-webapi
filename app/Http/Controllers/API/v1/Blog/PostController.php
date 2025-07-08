<?php

namespace App\Http\Controllers\API\v1\Blog;

use App\Actions\v1\Blog\Post\CreateImagePostAction;
use App\Actions\v1\Blog\Post\CreatePostAction;
use App\Actions\v1\Blog\Post\UpdatePostAction;
use App\DTOs\v1\Blog\Post\CreateImagePostDto;
use App\DTOs\v1\Blog\Post\CreatePostDto;
use App\DTOs\v1\Blog\Post\UpdatePostDto;
use App\Http\Controllers\API\v1\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\API\v1\Blog\ImagePostRequest;
use App\Http\Requests\API\v1\Blog\PostCommentStatusRequest;
use App\Http\Requests\API\v1\Blog\PostRequest;
use App\Http\Resources\v1\PostResource;
use App\Models\Comment;
use App\Models\Post;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Storage;

class PostController extends Controller
{
    /**
     * Create the controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->authorizeResource(Post::class, 'post');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request): JsonResource
    {
        $q = $request->q;
        $elements = Post::withCount(['tagPostRels', 'categoryPostRels', 'similarPostRels'])->with(['userRel']);
        if ($q) {
            $elements = $elements->where(function ($query) use ($q) {
                $query->where('title', 'LIKE', '%' . $q . '%');
                $query->orWhere('slug', 'LIKE', '%' . $q . '%');
                $query->orWhere('short_description', 'LIKE', '%' . $q . '%');
                $query->orWhere('publication_at', 'LIKE', '%' . $q . '%');
                if (Carbon::hasFormat($q, 'd-m-Y')) {
                    $query->orWhere('publication_at', 'LIKE', '%' . Carbon::createFromFormat('d-m-Y', $q)->format('Y-m-d') . '%');
                }
            });
            $elements = $elements->orWhereHas('userRel', function ($query) use ($q) {
                $query->where('name', 'LIKE', '%' . $q . '%');
            });
        }
        if ($request->sort_by) {
            $elements = $elements->orderBy($request->sort_by, $request->descending)->paginate((int) $request->per_page);
        } else {
            $elements = $elements->paginate((int) $request->per_page);
        }

        return PostResource::collection($elements);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\API\v1\Blog\PostRequest  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(PostRequest $request): JsonResponse
    {
        $dto = CreatePostDto::fromRequest($request);

        $element = new CreatePostAction(new Post(), Storage::disk('s3'));

        return $element->execute($dto);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Resources\Json\JsonResource
     */
    public function show(Post $post): JsonResource
    {
        $post->commentRels = Comment::where('commentable_type', Post::class)
            ->where('commentable_id', $post->id)
            ->with('userRel')
            ->withRecursiveReplies()
            ->get();

        $post->loadCount(['tagPostRels', 'categoryPostRels', 'similarPostRels'])->load(['tagPostRels.tagRel', 'categoryPostRels.categoryRel', 'userRel', 'similarPostRels.similarPostRel']);
        return new PostResource($post);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\API\v1\Blog\PostRequest  $request
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(PostRequest $request, Post $post): JsonResponse
    {
        $dto = UpdatePostDto::fromRequest($request);
        if (!$request->hasFile('image')) {
            $dto->image = null;
        }
        if (!$request->hasFile('thumbnail')) {
            $dto->thumbnail = null;
        }

        $action = new UpdatePostAction($post, Storage::disk('s3'));

        return $action->execute($dto);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Post $post): JsonResponse
    {
        $image = $post->image;
        $thumbnail = $post->thumbnail;

        $delete = $post->delete();

        if ($delete) {
            Storage::disk('s3')->delete('public/images/posts/' . $image);
            Storage::disk('s3')->delete('public/images/posts/' . $thumbnail);
        }

        return ApiResponse::createResponse()
            ->withMessage(trans('custom.message.delete.success', ['name' => trans('custom.attribute.post')]))
            ->build();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\API\v1\Blog\ImagePostRequest  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function uploadImage(ImagePostRequest $request): JsonResponse
    {
        $this->authorize(
            'noticias.publicaciones.create',
            Post::class
        );

        $dto = CreateImagePostDto::fromRequest($request);

        $element = new CreateImagePostAction(Storage::disk('s3'));

        return $element->execute($dto);
    }
}
