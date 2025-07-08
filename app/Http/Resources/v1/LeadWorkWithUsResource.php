<?php

namespace App\Http\Resources\v1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class LeadWorkWithUsResource extends JsonResource
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
            'cv_path' => $this->cv_path,
            'cv_path_format' => $this->cv_path_format,
            'full_name' => $this->full_name,
            'dni' => $this->dni,
            'phone' => $this->phone,
            'address' => $this->address,
            'email' => $this->email,

            'employment_id' => $this->employment_id,

            'employment_rel' => new EmploymentResource($this->whenLoaded('employmentRel')),

            'created_at' => $this->created_at,
            'created_at_format' => $this->created_at_format,
            'created_at_format_2' => $this->created_at_format2,
            'updated_at' => $this->updated_at,
            'updated_at_format' => $this->updated_at_format,
            'updated_at_format_2' => $this->updated_at_format2,
            'birth_date' => $this->birth_date,
            'birth_date_format' => $this->birth_date_format,
        ];
    }
}
