<?php

namespace App\Http\Resources\v1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class LeadServiceStationResource extends JsonResource
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
            'full_name' => $this->full_name,
            'company' => $this->company,
            'ruc' => $this->ruc,
            'phone' => $this->phone,
            'email' => $this->email,
            'message' => $this->message,
            'region' => $this->region,
            'created_at' => $this->created_at,
            'created_at_format' => $this->created_at_format,
            'created_at_format_2' => $this->created_at_format2,
            'updated_at' => $this->updated_at,
            'updated_at_format' => $this->updated_at_format,
            'updated_at_format_2' => $this->updated_at_format2,
        ];
    }
}
