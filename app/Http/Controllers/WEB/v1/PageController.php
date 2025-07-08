<?php

declare(strict_types=1);

namespace App\Http\Controllers\WEB\v1;

use App\Enums\ModelStatusEnum;
use App\Http\Controllers\API\v1\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\API\v1\Blog\CommentRequest;
use App\Http\Resources\v1\Web\CommentPostPublicResource;
use App\Http\Resources\v1\Web\PagePublicResource;
use App\Http\Resources\v1\Web\PostPublicResource;
use App\Models\Page;
use App\Models\Comment;
use App\Models\Post;
use App\Models\UserComment;
use App\Utils\ModelValidator;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Traits\ProcessesSectionRelations;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Carbon;

class PageController extends Controller
{
    use ProcessesSectionRelations;

    /**
     * Get page content
     *
     * @param Request $request
     * @param Page $page
     * @return JsonResponse
     */

    public function getPageContent(Request $request, Page $page): JsonResponse
    {
        $response = ModelValidator::validateActive($page);
        if ($response) return $response;

        $page->load(['sectionRels.contentRels', 'sectionRels.contentRels', 'sectionRels.multipleFieldSectionRels.multipleFieldRel.multipleContentRels']);

        $this->processSectionRelations($page->sectionRels);

        return ApiResponse::createResponse()
            ->withData(
                [
                    'page' => new PagePublicResource($page),
                ]
            )
            ->build();
    }

    public function getPosts(Request $request): JsonResource
    {
        $per_page =  $request->per_page ?  $request->per_page : 10;
        $q = $request->q;
        $category_id = $request->category_id;
        $publication_at = $request->publication_at ? Carbon::createFromFormat('d-m-Y', $request->publication_at) : null;

        $elements = Post::query()->where('active', 1)->with(['categoryPostRels.categoryRel']);
        if ($q) {
            $elements = $elements->where(function ($query) use ($q) {
                $query->where('title', 'LIKE', '%' . $q . '%');
                $query->orWhere('slug', 'LIKE', '%' . $q . '%');
                $query->orWhere('short_description', 'LIKE', '%' . $q . '%');
                $query->orWhere('content', 'LIKE', '%' . $q . '%');
                $query->orWhereHas('tagPostRels', function ($query) use ($q) {
                    $query->whereHas('tagRel', function ($query) use ($q) {
                        $query->where('name', 'LIKE', '%' . $q . '%');
                    });
                });
                $query->orWhereHas('categoryPostRels', function ($query) use ($q) {
                    $query->whereHas('categoryRel', function ($query) use ($q) {
                        $query->where('name', 'LIKE', '%' . $q . '%');
                    });
                });
            });
        }

        if ($category_id) {
            $elements = $elements->whereHas('categoryPostRels', function ($query) use ($category_id) {
                $query->where('category_id', $category_id);
            });
        }

        if ($publication_at) {
            $elements = $elements->whereDate('publication_at', '=', $publication_at);
        }


        if ($request->sort_by) {
            $elements = $elements->orderBy($request->sort_by, $request->descending ? $request->descending : 'ASC')->paginate((int) $per_page);
        } else {
            $elements = $elements->paginate((int) $per_page);
        }
        return PostPublicResource::collection($elements);
    }

    public function getPost(Request $request, Post $post): JsonResource | JsonResponse
    {
        $post->view += 1;
        $post->save();

        $post->commentRels = Comment::where('commentable_type', Post::class)
            ->where('commentable_id', $post->id)
            ->where('is_approved', true)
            ->withRecursiveReplies()
            ->get();

        $post->load(['tagPostRels.tagRel', 'categoryPostRels.categoryRel', 'similarPostRels' => function ($query) {
            $query->whereHas('similarPostRel', function ($q) {
                $q->where('active', 1);
            })->with([
                'similarPostRel.categoryPostRels.categoryRel'
            ]);
        }, 'userRel']);

        return new PostPublicResource($post);
    }

    public function likePost(Request $request, Post $post)
    {
        if (!$post->active->value) {
            return ApiResponse::createResponse()
                ->withMessage('El recurso solicitado no existe.')
                ->withStatusCode(404)
                ->build();
        }

        $post->like = ((int) $post->like) + 1;
        $post->save();

        return ApiResponse::createResponse()
            ->withMessage('Se ha dado like correctamente.')
            ->withStatusCode(200)
            ->build();
    }

    public function dislikePost(Request $request, Post $post)
    {
        if (!$post->active->value) {
            return ApiResponse::createResponse()
                ->withMessage('El recurso solicitado no existe.')
                ->withStatusCode(404)
                ->build();
        }

        $post->like =  $post->like > 0 ? ((int) $post->like) - 1 : 0;
        $post->save();

        return ApiResponse::createResponse()
            ->withMessage('Se ha dado dislike correctamente.')
            ->withStatusCode(200)
            ->build();
    }

    public function sharedPost(Request $request, Post $post)
    {
        if (!$post->active->value) {
            return ApiResponse::createResponse()
                ->withMessage('El recurso solicitado no existe.')
                ->withStatusCode(404)
                ->build();
        }

        $post->shared = ((int) $post->shared) + 1;
        $post->save();

        return ApiResponse::createResponse()
            ->withMessage('Se ha compartido correctamente.')
            ->withStatusCode(200)
            ->build();
    }

    public function saveCommentPost(CommentRequest $request, Post $post): JsonResponse
    {
        if (!$post->active->value) {
            return ApiResponse::createResponse()
                ->withMessage('El recurso solicitado no existe.')
                ->withStatusCode(404)
                ->build();
        }

        //save user comment
        $userComment = new UserComment();
        $userComment->name = $request->name;
        $userComment->save();

        $comment = $post->commentAsUser($userComment, $request->comment);
        $comment->approve();

        return ApiResponse::createResponse()
            ->withData(new CommentPostPublicResource($comment->load('userRel')))
            ->withMessage('Se ha comentado correctamente.')
            ->withStatusCode(200)
            ->build();
    }

    public function replyCommentPost(CommentRequest $request, Post $post, Comment $comment): JsonResponse
    {
        if (!$post->active->value) {
            return ApiResponse::createResponse()
                ->withMessage('El recurso solicitado no existe.')
                ->withStatusCode(404)
                ->build();
        }

        //save user comment
        $userComment = new UserComment();
        $userComment->name = $request->name;
        $userComment->save();

        $comment = $comment->commentAsUser($userComment, $request->comment);
        $comment->approve();

        return ApiResponse::createResponse()
            ->withData(new CommentPostPublicResource($comment->load('userRel')))
            ->withMessage('Se ha respondido correctamente.')
            ->withStatusCode(200)
            ->build();
    }

    public function getSitemapPosts(Request $request)
    {
        $posts = Post::all()->map(function ($post) {
            return [
                'loc' => config('services.urls.url_fronted') . '/noticias/' . $post->slug, // URL del post
                'lastmod' => Carbon::parse($post->updated_at)->toIso8601String(), // Última modificación en formato ISO 8601
                'changefreq' => 'weekly', // Frecuencia de actualización (puedes cambiarlo dinámicamente)
                'priority' => 0.8 // Prioridad (ajustable según importancia)
            ];
        });

        return ApiResponse::createResponse()
            ->withData($posts)
            ->withStatusCode(200)
            ->build();
    }

    public function getSitemapPages(Request $request)
    {
        $pages = Page::all()->map(function ($page) {
            return [
                'loc' => config('services.urls.url_fronted') . $page->path, // URL de la página
                'lastmod' => Carbon::parse($page->updated_at)->toIso8601String(), // Última modificación en formato ISO 8601
                'changefreq' => 'weekly', // Frecuencia de actualización (puedes cambiarlo dinámicamente)
                'priority' => 1.0 // Prioridad máxima
            ];
        });

        return ApiResponse::createResponse()
            ->withData($pages)
            ->withStatusCode(200)
            ->build();
    }
}
