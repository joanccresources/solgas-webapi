<?php

namespace App\Actions\v1\Content\ContentPage;

use App\Services\Content\ContentProcessor;
use App\Services\Content\DynamicUploadHandler;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\API\v1\Helpers\ApiResponse;
use App\Http\Resources\v1\PageMultipleContentResource;

class UpdateContentMultiplePageAction
{
    protected $element;
    protected $contentProcessor;

    public function __construct($element, $storage)
    {
        $uploadHandler = new DynamicUploadHandler($storage);
        $this->contentProcessor = new ContentProcessor($uploadHandler, $storage, 'PageMultipleContent');
        $this->element = $element;
    }

    public function execute(Request $request)
    {
        $contentData = $request->content;

        $processedData = $this->contentProcessor->processContentData(
            $contentData,
            0, //se colocó 0 porque no se usa en page_multiple_contents
            $request,
            $this->element->id
        );

        $this->save($processedData, $request);

        return $this->buildResponse();
    }

    protected function save(array $data, $request): void
    {
        $this->element->json_value = json_encode($data);
        $this->element->save();
    }

    protected function buildResponse(): JsonResponse
    {
        return ApiResponse::createResponse()
            ->withData(PageMultipleContentResource::make($this->element))
            ->withMessage(trans('custom.message.update.success', ['name' => trans('custom.attribute.content_multiple_page')]))
            ->build();
    }
}
