<?php

declare(strict_types=1);

namespace App\Actions\v1\Content\ContentSocialNetwork;

use App\Actions\v1\Helpers\Max\MaxElementUseCase;
use App\DTOs\v1\Content\ContentSocialNetwork\CreateContentSocialNetworkDto;
use App\Http\Controllers\API\v1\Helpers\ApiResponse;
use App\Http\Resources\v1\ContentSocialNetworkResource;
use App\Models\ContentSocialNetwork;
use Illuminate\Http\JsonResponse;

class CreateContentSocialNetworkAction
{
    protected $element;

    public function __construct(ContentSocialNetwork $element)
    {
        $this->element = $element;
    }

    public function execute(CreateContentSocialNetworkDto $dto)
    {
        return $this
            ->create($dto)
            ->buildResponse($dto);
    }

    protected function create(CreateContentSocialNetworkDto $dto): self
    {
        $generateMaxValue = new MaxElementUseCase(ContentSocialNetwork::selectRaw('MAX(id),MAX(`index`) as "value"')->get());
        $max_value = $generateMaxValue->execute();

        $this->element->index = $max_value;
        $this->element->active = $dto->active;
        $this->element->url = $dto->url;
        $this->element->content_master_social_network_id = $dto->content_master_social_network_id;
        $this->element->save();

        return $this;
    }

    protected function buildResponse($dto): JsonResponse
    {
        $this->element->load(['masterSocialNetworkRel']);
        return ApiResponse::createResponse()
            ->withData(new ContentSocialNetworkResource($this->element))
            ->withMessage(trans('custom.message.create.success', ['name' => trans('custom.attribute.content_social_network')]))
            ->build();
    }
}
