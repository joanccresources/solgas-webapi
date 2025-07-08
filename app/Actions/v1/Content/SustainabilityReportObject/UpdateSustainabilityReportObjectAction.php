<?php

declare(strict_types=1);

namespace App\Actions\v1\Content\SustainabilityReportObject;

use App\Actions\v1\Helpers\Storage\GenerateOptimizedImageAction;
use App\DTOs\v1\Helpers\Storage\GenerateFileDto;
use App\DTOs\v1\Content\SustainabilityReportObject\UpdateSustainabilityReportObjectDto;
use App\Http\Controllers\API\v1\Helpers\ApiResponse;
use App\Http\Resources\v1\SustainabilityReportObjectResource;
use App\Models\SustainabilityReportObject;
use Illuminate\Http\JsonResponse;

class UpdateSustainabilityReportObjectAction
{
    private const FOLDER_PRINCIPAL = 'public' . DIRECTORY_SEPARATOR;
    private const FOLDER_IMAGE = 'images' . DIRECTORY_SEPARATOR . 'sustainability-reports';

    protected $element;
    protected $storage;
    protected $image;

    public function __construct(SustainabilityReportObject $element, $storage)
    {
        $this->element = $element;
        $this->storage = $storage;
        $this->image = '';
    }

    public function execute(UpdateSustainabilityReportObjectDto $dto)
    {
        return $this
            ->createPdf($dto)
            ->update($dto)
            ->buildResponse($dto);
    }

    protected function createPdf($dto): self
    {
        if ($dto->image) {
            $imageDto = GenerateFileDto::fromArray(['file' => $dto->image]);
            $generate = new GenerateOptimizedImageAction($this->storage);
            $this->image = $generate->execute(
                $imageDto->file,
                self::FOLDER_PRINCIPAL . self::FOLDER_IMAGE
            );
        } else {
            $this->image = $this->element->image;
        }

        if ($dto->image && $this->element->image) {
            $this->storage->delete(self::FOLDER_PRINCIPAL . self::FOLDER_IMAGE . DIRECTORY_SEPARATOR . $this->element->image);
        }

        return $this;
    }

    protected function update(UpdateSustainabilityReportObjectDto $dto): self
    {
        $this->element->active = $dto->active;
        $this->element->sustainability_report_id = $dto->sustainability_report_id;
        $this->element->image = $this->image;
        $this->element->save();

        return $this;
    }

    protected function buildResponse($dto): JsonResponse
    {
        return ApiResponse::createResponse()
            ->withData(new SustainabilityReportObjectResource($this->element))
            ->withMessage(trans('custom.message.update.success', ['name' => trans('custom.attribute.element')]))
            ->build();
    }
}
