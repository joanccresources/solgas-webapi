<?php

declare(strict_types=1);

namespace App\Actions\v1\Content\ContentHeaderMenu;

use App\Actions\v1\Helpers\Max\MaxElementUseCase;
use App\Actions\v1\Helpers\Storage\GenerateFileAction;
use App\DTOs\v1\Content\ContentHeaderMenu\CreateContentHeaderMenuDto;
use App\DTOs\v1\Helpers\Storage\GenerateFileDto;
use App\Http\Controllers\API\v1\Helpers\ApiResponse;
use App\Http\Resources\v1\ContentHeaderMenuResource;
use App\Models\ContentHeaderMenu;
use Illuminate\Http\JsonResponse;

class CreateContentHeaderMenuAction
{
    protected $element;
    protected $storage;
    protected $content;

    const FOLDER_PRINCIPAL = 'public' . DIRECTORY_SEPARATOR;
    const FOLDER_IMAGE = 'images' . DIRECTORY_SEPARATOR . 'menu';
    const FOLDER_VIDEO = 'videos' . DIRECTORY_SEPARATOR . 'menu';
    const FOLDER_DOCUMENT = 'documentos' . DIRECTORY_SEPARATOR . 'menu';

    const INITIAL_IMAGE = 'imagen';
    const INITIAL_VIDEO = 'video';
    const INITIAL_DOCUMENT = 'documento';

    public function __construct(ContentHeaderMenu $element, $storage)
    {
        $this->element = $element;
        $this->storage = $storage;
        $this->content = '';
    }

    public function execute(CreateContentHeaderMenuDto $dto)
    {
        return $this
            ->createFile($dto)
            ->create($dto)
            ->buildResponse($dto);
    }

    protected function createFile($dto): self
    {
        if ($dto->content_menu_type_id == 4) {
            $this->content = $dto->content;
            return $this;
        }

        $file = $dto->content;

        $fileDto = GenerateFileDto::fromArray(['file' => $file]);
        $fileNameOnly = $file->getClientOriginalName();
        $this->storage->putFileAs(self::FOLDER_PRINCIPAL . $this->getFolderNameForType($dto->content_menu_type_id), $fileDto->file, $fileNameOnly);

        $this->content = $fileNameOnly;

        return $this;
    }

    protected function create(CreateContentHeaderMenuDto $dto): self
    {
        if ($dto->content_header_menu_id) {
            $generateMaxValue = new MaxElementUseCase(ContentHeaderMenu::selectRaw('MAX(id),MAX(`index`) as "value"')->where('content_header_menu_id', $dto->content_header_menu_id)->get());
        } else {
            $generateMaxValue = new MaxElementUseCase(ContentHeaderMenu::selectRaw('MAX(id),MAX(`index`) as "value"')->where('content_header_id', $dto->content_header_id)->get());
        }
        $max_value = $generateMaxValue->execute();

        $this->element->name = $dto->name;
        $this->element->content = $this->content;
        $this->element->active = $dto->active;
        $this->element->index = $max_value;
        $this->element->content_header_id = $dto->content_header_id;
        if ($dto->content_header_menu_id) {
            $this->element->content_header_menu_id = $dto->content_header_menu_id;
        }
        $this->element->content_menu_type_id = $dto->content_menu_type_id;
        $this->element->save();

        return $this;
    }

    protected function buildResponse($dto): JsonResponse
    {
        $this->element->load(['contentHeaderRel']);
        return ApiResponse::createResponse()
            ->withData(new ContentHeaderMenuResource($this->element))
            ->withMessage(trans('custom.message.create.success', ['name' => trans('custom.attribute.element')]))
            ->build();
    }

    public function getFolderNameForType(string $type): string
    {
        return match ($type) {
            "1" => self::FOLDER_IMAGE,
            "2" => self::FOLDER_VIDEO,
            "3" => self::FOLDER_DOCUMENT,
            default => self::FOLDER_DOCUMENT,
        };
    }

    protected function getInitialNameForType(string $type): string
    {
        return match ($type) {
            "1" => self::INITIAL_IMAGE,
            "2" => self::INITIAL_VIDEO,
            "3" => self::INITIAL_DOCUMENT,
            default => self::INITIAL_DOCUMENT,
        };
    }
}
