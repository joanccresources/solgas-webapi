<?php

namespace App\Http\Controllers\API\v1\Content;

use App\Actions\v1\Content\ContentPage\CreateContentMultiplePageAction;
use App\Actions\v1\Content\ContentPage\UpdateContentMultiplePageAction;
use App\Actions\v1\Content\ContentPage\UpdateContentPageAction;
use App\Actions\v1\Helpers\Order\UpdateElementOrderAction;
use App\DTOs\v1\Helpers\Order\UpdateContentOrderDto;
use App\Http\Controllers\API\v1\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\API\v1\Helpers\Order\ContentOrderRequest;
use App\Http\Requests\API\v1\Page\PageContentRequest;
use App\Http\Resources\v1\PageMultipleContentResource;
use App\Http\Resources\v1\PageMultipleFieldSectionResource;
use App\Http\Resources\v1\PageResource;
use App\Http\Resources\v1\PageSectionResource;
use App\Models\Page;
use App\Models\PageContent;
use App\Models\PageMultipleContent;
use App\Models\PageMultipleField;
use App\Models\PageMultipleFieldSection;
use App\Models\PageSection;
use App\Utils\FieldValueProcessor;
use App\Utils\PageMultipleContentProcessor;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class ContentPageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(): JsonResource
    {
        $this->authorize('index', Page::class);

        $elements =  Page::where('active', true)->orderBy('created_at', 'ASC')->get();

        return PageResource::collection($elements);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function indexPageSection(Page $page): JsonResource
    {
        $this->authorize('viewPageSection', $page);

        $elements = PageSection::withCount(['fieldRels', 'multipleFieldSectionRels'])->where('page_id', $page->id)->orderBy('index', 'ASC')->get();

        return PageSectionResource::collection($elements);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function indexPageSectionField(PageSection $pageSection): JsonResponse
    {
        $this->authorize('viewPageSectionField', $pageSection);

        $pageSection->load(['fieldRels' => function ($query) {
            $query->orderBy('index', 'asc');
        }, 'fieldRels.typeRel']);

        $pageContent = PageContent::where('page_section_id', $pageSection->id)
            ->pluck('value', 'variable_page_field');

        $data = $pageSection->fieldRels->map(function ($field) use ($pageContent) {

            $value = FieldValueProcessor::processValue(
                $field->typeRel->type,
                $pageContent[$field->variable] ?? null
            );

            return [
                "id" => $field->id,
                "name" => $field->name,
                "variable_page_field" => $field->variable,
                "type" => $field->typeRel->type,
                "value" => $pageContent[$field->variable] ?? '',
                'value_format' => $value['value_format'],
                'value_format_2' => $value['value_format_2']
            ];
        });

        return ApiResponse::createResponse()
            ->withData($data)
            ->build();
    }

    /**
     * update a newly created resource in storage.
     *
     * @param  \App\Http\Requests\API\v1\Page\PageContentRequest  $request
     * @param  \App\Models\PageSection  $pageSection
     * @return \Illuminate\Http\JsonResponse
     */
    public function updatePageSectionField(PageContentRequest $request, PageSection $pageSection): JsonResponse
    {
        $this->authorize('updatePageSectionField', $pageSection);

        $action = new UpdateContentPageAction($pageSection, Storage::disk('s3'));

        return $action->execute($request);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function indexPageMultipleFieldSection(PageSection $pageSection): JsonResource
    {
        $this->authorize('viewPageMultipleFieldSection', $pageSection);

        $elements =  PageMultipleFieldSection::with([
            'multipleFieldRel' => function ($query) {
                $query->withCount(['multipleContentRels']);
            },
        ])
            ->where('page_section_id', $pageSection->id)
            ->orderBy('created_at', 'DESC')->get();

        return PageMultipleFieldSectionResource::collection($elements);
    }

    /**
     * Display a listing of PageMultipleContent
     *
     * @return \Illuminate\Http\Response
     */
    public function indexPageMultipleField(PageMultipleField $pageMultipleField): JsonResource
    {
        $this->authorize('viewPageMultipleField', $pageMultipleField);

        $elements =  PageMultipleContent::with(['multipleFieldRel'])
            ->where('page_multiple_field_id', $pageMultipleField->id)
            ->orderBy('index', 'ASC')
            ->orderBy('created_at', 'DESC')
            ->get();

        // Usar map para transformar cada elemento
        $elements = $elements->map(function ($pageMultipleContent) {
            return PageMultipleContentProcessor::process($pageMultipleContent);
        });

        return PageMultipleContentResource::collection($elements);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\API\v1\Page\PageContentRequest  $request
     * @param  \App\Models\PageSection  $pageSection
     * @return \Illuminate\Http\JsonResponse
     */
    public function storePageMultipleContent(PageContentRequest $request, PageMultipleField $pageMultipleField): JsonResponse
    {
        $this->authorize('createPageMultipleContent', PageMultipleContent::class);

        $action = new CreateContentMultiplePageAction($pageMultipleField, new PageMultipleContent(), Storage::disk('s3'));

        return $action->execute($request);
    }

    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function showPageMultipleFieldFormat(PageMultipleField $pageMultipleField): JsonResponse
    {
        $this->authorize('viewPageMultipleFieldFormat', $pageMultipleField);

        $newJsonValueFormat = $pageMultipleField->dataRels
            ->sortBy('index') // Ordena por el campo index en orden ascendente
            ->values() // Reinicia las claves para mantener un arreglo indexado
            ->map(function ($dataRel) {
                $variable = $dataRel->variable;

                return [
                    'name' => $dataRel->name,
                    'variable_page_field' => $variable,
                    'type' => $dataRel->typeRel->type,
                    'value' => '',
                ];
            });


        return ApiResponse::createResponse()
            ->withData($newJsonValueFormat)
            ->build();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\PageMultipleContent  $pageMultipleContent
     * @return \Illuminate\Http\Response
     */
    public function showPageMultipleContent(PageMultipleContent $pageMultipleContent): JsonResponse
    {
        $this->authorize('viewPageMultipleContent', $pageMultipleContent);

        $pageMultipleContent->load(['multipleFieldRel.dataRels.typeRel']);

        $pageMultipleContent = PageMultipleContentProcessor::process($pageMultipleContent);

        return ApiResponse::createResponse()
            ->withData([
                'id' => $pageMultipleContent->id,
                'json_value' => $pageMultipleContent->json_value,
                'json_value_format' => $pageMultipleContent->json_value_format2,
                'page_multiple_field_id' => $pageMultipleContent->page_multiple_field_id
            ])
            ->build();
    }


    /**
     * Update a newly created resource in storage.
     *
     * @param  \App\Http\Requests\API\v1\Page\PageContentRequest  $request
     * @param  \App\Models\PageSection  $pageSection
     * @return \Illuminate\Http\JsonResponse
     */
    public function updatePageMultipleContent(PageContentRequest $request, PageMultipleContent $pageMultipleContent): JsonResponse
    {
        $this->authorize('updatePageMultipleContent', $pageMultipleContent);

        $action = new UpdateContentMultiplePageAction($pageMultipleContent, Storage::disk('s3'));

        return $action->execute($request);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\PageMultipleContent  $pageMultipleContent
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroyPageMultipleContent(PageMultipleContent $pageMultipleContent): JsonResponse
    {
        $this->authorize('deletePageMultipleContent', $pageMultipleContent);

        $pageMultipleContent->delete();

        return ApiResponse::createResponse()
            ->withMessage(trans('custom.message.delete.success', ['name' => trans('custom.attribute.content_multiple_page')]))
            ->build();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\API\v1\Helpers\Order\ContentOrderRequest  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function setOrder(ContentOrderRequest $request, PageMultipleField $pageMultipleField): JsonResponse
    {
        $this->authorize('orderPageMultipleContent', PageMultipleContent::class);

        if ($pageMultipleField->multipleContentRels()->count() == 0) {
            return ApiResponse::createResponse()
                ->withStatusCode(422)
                ->withMessage("El elemento múltiple $pageMultipleField->name no cuenta con contenido")
                ->build();
        }

        $dto = UpdateContentOrderDto::fromRequest($request);

        $useCase = new UpdateElementOrderAction(new PageMultipleContent(), $pageMultipleField, 'page_multiple_field_id');

        return $useCase->execute($dto);
    }
}
