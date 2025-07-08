<?php

namespace App\Http\Controllers\API\v1\Blog;

use App\Http\Controllers\API\v1\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\API\v1\Blog\PostCommentStatusRequest;
use App\Http\Resources\v1\CommentResource;
use App\Models\Comment;
use App\Models\Post;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CommentController extends Controller
{
    /**
     * Create the controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->authorizeResource(Comment::class, 'comment');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, Post $post): JsonResource
    {
        $q = $request->q;
        $elements = Comment::with(['userRel'])->where('commentable_id', $post->id)->where('commentable_type', Post::class)->withRecursiveReplies();
        if ($q) {
            $elements = $elements->where(function ($query) use ($q) {
                $query->where('comment', 'LIKE', '%' . $q . '%');
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

        return CommentResource::collection($elements);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Comment  $comment
     * @return \Illuminate\Http\Resources\Json\JsonResource
     */
    public function show(Comment $comment): JsonResource
    {
        $comment->load(['userRel'])->withRecursiveReplies();

        return new CommentResource($comment);
    }

    public function statusComment(PostCommentStatusRequest $request, Comment $comment): JsonResponse
    {
        $this->authorize('update', $comment);

        if ($request->is_approved) {
            $comment->approved();
        } else {
            $comment->disapprove();
        }

        $comment->save();

        return ApiResponse::createResponse()
            ->withMessage(trans('custom.message.update.success', ['name' => trans('custom.attribute.comment')]))
            ->build();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Comment  $comment
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Comment $comment): JsonResponse
    {
        $comment->delete();

        return ApiResponse::createResponse()
            ->withMessage(trans('custom.message.delete.success', ['name' => trans('custom.attribute.comment')]))
            ->build();
    }
}
