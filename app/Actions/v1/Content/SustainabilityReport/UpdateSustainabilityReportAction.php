<?php

declare(strict_types=1);

namespace App\Actions\v1\Content\SustainabilityReport;

use App\Actions\v1\Helpers\Storage\GenerateFileAction;
use App\DTOs\v1\Helpers\Storage\GenerateFileDto;
use App\DTOs\v1\Content\SustainabilityReport\UpdateSustainabilityReportDto;
use App\Http\Controllers\API\v1\Helpers\ApiResponse;
use App\Http\Resources\v1\SustainabilityReportResource;
use App\Models\SustainabilityReport;
use Illuminate\Http\JsonResponse;

class UpdateSustainabilityReportAction
{
    private const FOLDER_PRINCIPAL = 'public' . DIRECTORY_SEPARATOR;
    private const FOLDER_IMAGE = 'documentos' . DIRECTORY_SEPARATOR . 'sustainability-reports';

    protected $element;
    protected $storage;
    protected $pdf;

    public function __construct(SustainabilityReport $element, $storage)
    {
        $this->element = $element;
        $this->storage = $storage;
        $this->pdf = '';
    }

    public function execute(UpdateSustainabilityReportDto $dto)
    {
        return $this
            ->createPdf($dto)
            ->update($dto)
            ->buildResponse($dto);
    }

    protected function createPdf($dto): self
    {
        if ($dto->pdf) {
            $imageDto = GenerateFileDto::fromArray(['file' => $dto->pdf]);
            $generate = new GenerateFileAction($this->storage);
            $this->pdf = $generate->execute(
                $imageDto->file,
                self::FOLDER_PRINCIPAL . self::FOLDER_IMAGE
            );
        } else {
            $this->pdf = $this->element->pdf;
        }

        if ($dto->pdf && $this->element->pdf) {
            $this->storage->delete(self::FOLDER_PRINCIPAL . self::FOLDER_IMAGE . DIRECTORY_SEPARATOR . $this->element->pdf);
        }

        return $this;
    }

    protected function update(UpdateSustainabilityReportDto $dto): self
    {
        $this->element->title = $dto->title;
        $this->element->active = $dto->active;
        $this->element->title_milestones = $dto->title_milestones;
        $this->element->pdf = $this->pdf;
        $this->element->save();

        return $this;
    }

    protected function buildResponse($dto): JsonResponse
    {
        return ApiResponse::createResponse()
            ->withData(new SustainabilityReportResource($this->element))
            ->withMessage(trans('custom.message.update.success', ['name' => trans('custom.attribute.element')]))
            ->build();
    }
}
