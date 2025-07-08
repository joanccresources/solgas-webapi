<?php

namespace App\Actions\v1\Content\ContentPage;

use App\Actions\v1\Helpers\Max\MaxElementUseCase;
use App\Services\Content\ContentProcessor;
use App\Services\Content\DynamicUploadHandler;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\API\v1\Helpers\ApiResponse;
use App\Http\Resources\v1\PageMultipleContentResource;
use App\Models\PageMultipleContent;

class CreateContentMultiplePageAction
{
    protected $element;
    protected $contentProcessor;
    protected $pageMultipleField;

    public function __construct($pageMultipleField, $element, $storage)
    {
        $uploadHandler = new DynamicUploadHandler($storage);
        $this->contentProcessor = new ContentProcessor($uploadHandler, $storage, 'PageMultipleContent');
        $this->element = $element;
        $this->pageMultipleField = $pageMultipleField;
    }

    public function execute(Request $request)
    {
        $contentData = $request->content;

        $processedData = $this->contentProcessor->processContentData(
            $contentData,
            0, //se colocó 0 porque no se usa en page_multiple_contents
            $request,
            0 //se colocó 0 porue no tienen id el page_multiple_contents cuando se registra
        );

        $this->save($processedData);

        return $this->buildResponse();
    }

    protected function save(array $data): void
    {
        $generateMaxValue = new MaxElementUseCase(PageMultipleContent::selectRaw('MAX(id),MAX(`index`) as "value"')->where('page_multiple_field_id', $this->pageMultipleField->id)->get());
        $max_value = $generateMaxValue->execute();

        $this->element->index = $max_value;
        $this->element->page_multiple_field_id = $this->pageMultipleField->id;
        $this->element->json_value = json_encode($data);
        $this->element->save();
    }

    protected function buildResponse(): JsonResponse
    {
        return ApiResponse::createResponse()
            ->withData(PageMultipleContentResource::make($this->element))
            ->withMessage(trans('custom.message.create.success', ['name' => trans('custom.attribute.content_multiple_page')]))
            ->build();
    }
}
