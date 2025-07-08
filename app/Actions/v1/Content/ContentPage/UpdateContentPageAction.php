<?php

namespace App\Actions\v1\Content\ContentPage;

use App\Services\Content\ContentProcessor;
use App\Services\Content\DynamicUploadHandler;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\API\v1\Helpers\ApiResponse;
use App\Models\PageContent;
use App\Models\PageSection;

class UpdateContentPageAction
{
    protected $contentProcessor;
    protected $pageSection;

    public function __construct(PageSection $pageSection, $storage)
    {
        $uploadHandler = new DynamicUploadHandler($storage);
        $this->contentProcessor = new ContentProcessor($uploadHandler, $storage, 'PageContent');
        $this->pageSection = $pageSection;
    }

    public function execute(Request $request)
    {
        $contentData = $request->content;

        $processedData = $this->contentProcessor->processContentData(
            $contentData,
            $this->pageSection->id,
            $request
        );

        $this->savePageContent($processedData);

        return $this->buildResponse($processedData);
    }

    /**
     * Guardar múltiples registros en PageContent.
     */
    private function savePageContent(array $data): void
    {
        foreach ($data as $record) {
            PageContent::updateOrCreate(
                [
                    'page_section_id' => $record['page_section_id'],
                    'variable_page_field' => $record['variable_page_field'],
                ],
                [
                    'value' => $record['value'],
                ]
            );
        }
    }
    protected function buildResponse(array $processedData): JsonResponse
    {
        return ApiResponse::createResponse()
            ->withData($processedData)
            ->withMessage(trans('custom.message.update.success', ['name' => trans('custom.attribute.content_page')]))
            ->build();
    }
}
