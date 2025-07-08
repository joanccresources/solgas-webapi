<?php

declare(strict_types=1);

namespace App\Actions\v1\Employment\Employment;

use App\DTOs\v1\Employment\Employment\UpdateEmploymentDto;
use App\Http\Controllers\API\v1\Helpers\ApiResponse;
use App\Http\Resources\v1\EmploymentResource;
use App\Models\Employment;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Carbon;

class UpdateEmploymentAction
{
    protected $element;

    public function __construct(Employment $element)
    {
        $this->element = $element;
    }

    public function execute(UpdateEmploymentDto $dto)
    {
        return $this
            ->update($dto)
            ->updateSimilarEmployments($dto)
            ->buildResponse($dto);
    }

    protected function update(UpdateEmploymentDto $dto): self
    {
        $this->element->title = $dto->title;
        $this->element->description = $dto->description;
        $this->element->address = $dto->address;
        $this->element->code_ubigeo = $dto->code_ubigeo;
        $this->element->posted_at = Carbon::createFromFormat('d-m-Y H:i:s', $dto->posted_at);
        $this->element->employment_type_id = $dto->employment_type_id;
        $this->element->employment_area_id = $dto->employment_area_id;
        $this->element->active = $dto->active;
        $this->element->save();

        return $this;
    }

    protected function updateSimilarEmployments(UpdateEmploymentDto $dto): self
    {
        if ($dto->similar_employments) {
            // Elimina las relaciones existentes
            $this->element->similarEmploymentRels()->delete();

            // Crea nuevas relaciones en la tabla intermedia
            foreach ($dto->similar_employments as $similarEmploymentId) {
                $this->element->similarEmploymentRels()->insert([
                    'employment_id' => $this->element->id,
                    'employment_similar_id' => $similarEmploymentId,
                ]);
            }
        }

        return $this;
    }

    protected function buildResponse($dto): JsonResponse
    {
        return ApiResponse::createResponse()
            ->withData(new EmploymentResource($this->element))
            ->withMessage(trans('custom.message.update.success', ['name' => trans('custom.attribute.employment')]))
            ->build();
    }
}
