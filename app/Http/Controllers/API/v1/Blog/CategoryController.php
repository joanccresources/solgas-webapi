<?php

namespace App\Http\Controllers\API\v1\Blog;

use App\Actions\v1\Blog\Category\CreateCategoryAction;
use App\Actions\v1\Blog\Category\UpdateCategoryAction;
use App\DTOs\v1\Blog\Category\CreateCategoryDto;
use App\DTOs\v1\Blog\Category\UpdateCategoryDto;
use App\Http\Controllers\API\v1\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\API\v1\Blog\CategoryRequest;
use App\Http\Resources\v1\CategoryResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Models\Category;

class CategoryController extends Controller
{
    /**
     * Create the controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->authorizeResource(Category::class, 'category');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $q = $request->q;
        $elements = Category::withCount(['categoryPostRels']);
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
        return CategoryResource::collection($elements);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\API\v1\Blog\CategoryRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CategoryRequest $request)
    {
        $dto = CreateCategoryDto::fromRequest($request);

        $element = new CreateCategoryAction(new Category());

        return $element->execute($dto);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function show(Category $category)
    {
        $category->loadCount('categoryPostRels');
        return new CategoryResource($category);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\API\v1\Blog\CategoryRequest  $request
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function update(CategoryRequest $request, Category $category)
    {
        $dto = UpdateCategoryDto::fromRequest($request);

        $element = new UpdateCategoryAction($category);

        return $element->execute($dto);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Category $category): JsonResponse
    {
        if ($category->categoryPostRels()->count() > 0) {
            return ApiResponse::createResponse()
                ->withStatusCode(422)
                ->withMessage("La categoría no se puede eliminar porque tiene publicaciones asociadas.")
                ->build();
        }

        $category->delete();

        return ApiResponse::createResponse()
            ->withMessage(trans('custom.message.delete.success', ['name' => trans('custom.attribute.category')]))
            ->build();
    }
}
