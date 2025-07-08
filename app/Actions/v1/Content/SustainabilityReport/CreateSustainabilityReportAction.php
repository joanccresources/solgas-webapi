<?php

declare(strict_types=1);

namespace App\Actions\v1\Content\SustainabilityReport;

use App\Actions\v1\Helpers\Max\MaxElementUseCase;
use App\Actions\v1\Helpers\Storage\GenerateFileAction;
use App\DTOs\v1\Helpers\Storage\GenerateFileDto;
use App\DTOs\v1\Content\SustainabilityReport\CreateSustainabilityReportDto;
use App\Http\Controllers\API\v1\Helpers\ApiResponse;
use App\Http\Resources\v1\SustainabilityReportResource;
use App\Models\SustainabilityReport;
use Illuminate\Http\JsonResponse;

class CreateSustainabilityReportAction
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

    public function execute(CreateSustainabilityReportDto $dto)
    {
        return $this
            ->createPdf($dto)
            ->create($dto)
            ->buildResponse($dto);
    }

    protected function createPdf(CreateSustainabilityReportDto $dto): self
    {
        if ($dto->pdf) {
            $imageDto = GenerateFileDto::fromArray(['file' => $dto->pdf]);
            $generate = new GenerateFileAction($this->storage);
            $this->pdf = $generate->execute(
                $imageDto->file,
                self::FOLDER_PRINCIPAL . self::FOLDER_IMAGE
            );
        }

        return $this;
    }

    protected function create(CreateSustainabilityReportDto $dto): self
    {
        $generateMaxValue = new MaxElementUseCase(SustainabilityReport::selectRaw('MAX(id),MAX(`index`) as "value"')->get());
        $max_value = $generateMaxValue->execute();

        $this->element->title = $dto->title;
        $this->element->title_milestones = $dto->title_milestones;
        $this->element->active = $dto->active;
        $this->element->index = $max_value;
        $this->element->pdf = $this->pdf;
        $this->element->save();

        return $this;
    }

    protected function buildResponse($dto): JsonResponse
    {
        return ApiResponse::createResponse()
            ->withData(new SustainabilityReportResource($this->element))
            ->withMessage(trans('custom.message.create.success', ['name' => trans('custom.attribute.element')]))
            ->build();
    }
}
