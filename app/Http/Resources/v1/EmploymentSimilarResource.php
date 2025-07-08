<?php

namespace App\Http\Resources\v1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class EmploymentSimilarResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,

            'employment_id' => $this->employment_id,
            'employment_similar_id' => $this->employment_similar_id,

            'employment_rel' => new EmploymentResource($this->whenLoaded('employmentRel')),
            'similar_employment_rel' => new EmploymentResource($this->whenLoaded('similarEmploymentRel'))
        ];
    }
}
