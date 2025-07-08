<?php

declare(strict_types=1);

namespace App\Actions\v1\Setting\GeneralInformation;

use App\Actions\v1\Helpers\Storage\GenerateOptimizedImageAction;
use App\Actions\v1\Helpers\Storage\GenerateFileAction;
use App\DTOs\v1\Setting\GeneralInformation\UpdateGeneralInformationDto;
use App\DTOs\v1\Helpers\Storage\GenerateFileDto;
use App\Http\Controllers\API\v1\Helpers\ApiResponse;
use App\Http\Resources\v1\GeneralInformationResource;
use App\Models\GeneralInformation;
use Illuminate\Http\JsonResponse;

class UpdateGeneralInformationAction
{
    private const FOLDER_PRINCIPAL = 'public' . DIRECTORY_SEPARATOR;
    private const FOLDER_IMAGE = 'images' . DIRECTORY_SEPARATOR . 'informacion';

    protected $element;
    protected $storage;
    protected $logo_principal;
    protected $logo_footer;
    protected $logo_icon;
    protected $logo_email;

    public function __construct(GeneralInformation $element, $storage)
    {
        $this->element = $element;
        $this->storage = $storage;
        $this->logo_principal = '';
        $this->logo_footer = '';
        $this->logo_icon = '';
        $this->logo_email = '';
    }

    public function execute(UpdateGeneralInformationDto $dto)
    {
        return $this
            ->createImage($dto)
            ->createGeneralInformation($dto)
            ->buildResponse($dto);
    }

    protected function createImage($dto): self
    {
        // Logo Principal
        if ($dto->logo_principal) {
            $imageDto = GenerateFileDto::fromArray(['file' => $dto->logo_principal]);
            $generator = $this->isSvg($imageDto->file)
                ? new GenerateFileAction($this->storage)
                : new GenerateOptimizedImageAction($this->storage);

            $this->logo_principal = $generator->execute(
                $imageDto->file,
                self::FOLDER_PRINCIPAL . self::FOLDER_IMAGE
            );
        } else {
            $this->logo_principal = $this->element->logo_principal;
        }

        $this->deleteOldImage($dto->logo_principal, $this->element->logo_principal);

        // Logo Footer
        if ($dto->logo_footer) {
            $imageDto = GenerateFileDto::fromArray(['file' => $dto->logo_footer]);
            $generator = $this->isSvg($imageDto->file)
                ? new GenerateFileAction($this->storage)
                : new GenerateOptimizedImageAction($this->storage);

            $this->logo_footer = $generator->execute(
                $imageDto->file,
                self::FOLDER_PRINCIPAL . self::FOLDER_IMAGE
            );
        } else {
            $this->logo_footer = $this->element->logo_footer;
        }

        $this->deleteOldImage($dto->logo_footer, $this->element->logo_footer);

        // Logo Icon
        if ($dto->logo_icon) {
            $imageDto = GenerateFileDto::fromArray(['file' => $dto->logo_icon]);
            $generator = $this->isIcon($imageDto->file)
                ? new GenerateFileAction($this->storage)
                : new GenerateOptimizedImageAction($this->storage);

            $this->logo_icon = $generator->execute(
                $imageDto->file,
                self::FOLDER_PRINCIPAL . self::FOLDER_IMAGE
            );
        } else {
            $this->logo_icon = $this->element->logo_icon;
        }

        $this->deleteOldImage($dto->logo_icon, $this->element->logo_icon);

        // Logo Email
        if ($dto->logo_email) {
            $imageDto = GenerateFileDto::fromArray(['file' => $dto->logo_email]);
            $generator = new GenerateFileAction($this->storage);

            $this->logo_email = $generator->execute(
                $imageDto->file,
                self::FOLDER_PRINCIPAL . self::FOLDER_IMAGE
            );
        } else {
            $this->logo_email = $this->element->logo_email;
        }

        $this->deleteOldImage($dto->logo_email, $this->element->logo_email);

        return $this;
    }

    protected function createGeneralInformation(UpdateGeneralInformationDto $dto): self
    {
        $this->element->phone = $dto->phone;
        $this->element->whatsapp = $dto->whatsapp;
        $this->element->logo_principal = $this->logo_principal;
        $this->element->logo_footer = $this->logo_footer;
        $this->element->logo_icon = $this->logo_icon;
        $this->element->logo_email = $this->logo_email;
        $this->element->save();

        return $this;
    }

    protected function buildResponse($dto): JsonResponse
    {
        return ApiResponse::createResponse()
            ->withData(new GeneralInformationResource($this->element))
            ->withMessage(trans('custom.message.update.success', ['name' => trans('custom.attribute.general_information')]))
            ->build();
    }

    private function isSvg($file): bool
    {
        return $file->getClientOriginalExtension() === 'svg';
    }

    private function isIcon($file): bool
    {
        return $file->getClientOriginalExtension() === 'ico';
    }

    private function deleteOldImage($newImage, ?string $oldImage): void
    {
        if ($newImage && $oldImage) {
            $this->storage->delete(self::FOLDER_PRINCIPAL . self::FOLDER_IMAGE . DIRECTORY_SEPARATOR . $oldImage);
        }
    }
}
