<?php

declare(strict_types=1);

namespace App\Actions\v1\Setting\GeneralInformation;

use App\Actions\v1\Helpers\Storage\GenerateFileAction;
use App\DTOs\v1\Setting\GeneralInformation\UpdateGeneralInformationCookieDto;
use App\DTOs\v1\Helpers\Storage\GenerateFileDto;
use App\Http\Controllers\API\v1\Helpers\ApiResponse;
use App\Http\Resources\v1\GeneralInformationResource;
use App\Models\GeneralInformation;
use Illuminate\Http\JsonResponse;

class UpdateGeneralInformationCookieAction
{
    private const FOLDER_PRINCIPAL = 'public' . DIRECTORY_SEPARATOR;
    private const FOLDER_IMAGE = 'documentos' . DIRECTORY_SEPARATOR . 'informacion';

    protected $element;
    protected $storage;
    protected $more_information_cookie;

    public function __construct(GeneralInformation $element, $storage)
    {
        $this->element = $element;
        $this->storage = $storage;
        $this->more_information_cookie = '';
    }

    public function execute(UpdateGeneralInformationCookieDto $dto)
    {
        return $this
            ->createFile($dto)
            ->createGeneralInformation($dto)
            ->buildResponse($dto);
    }

    protected function createFile($dto): self
    {
        if ($dto->more_information_cookie) {
            $imageDto = GenerateFileDto::fromArray(['file' => $dto->more_information_cookie]);
            $generate = new GenerateFileAction($this->storage);
            $this->more_information_cookie = $generate->execute(
                $imageDto->file,
                self::FOLDER_PRINCIPAL . self::FOLDER_IMAGE
            );
        } else {
            $this->more_information_cookie = $this->element->more_information_cookie;
        }

        if ($dto->more_information_cookie && $this->element->more_information_cookie) {
            $this->storage->delete(self::FOLDER_PRINCIPAL . self::FOLDER_IMAGE . DIRECTORY_SEPARATOR . $this->element->more_information_cookie);
        }

        return $this;
    }

    protected function createGeneralInformation(UpdateGeneralInformationCookieDto $dto): self
    {
        $this->element->title_cookie = $dto->title_cookie;
        $this->element->description_cookie = $dto->description_cookie;
        $this->element->more_information_cookie = $this->more_information_cookie;
        $this->element->text_button_necessary_cookie = $dto->text_button_necessary_cookie;
        $this->element->text_button_allow_cookie = $dto->text_button_allow_cookie;
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
}
