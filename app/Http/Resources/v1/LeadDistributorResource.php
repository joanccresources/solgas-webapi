<?php

namespace App\Http\Resources\v1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class LeadDistributorResource extends JsonResource
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
            'dni_or_ruc' => $this->dni_or_ruc,
            'phone_1' => $this->phone_1,
            'phone_2' => $this->phone_2,
            'email' => $this->email,
            'address' => $this->address,
            'code_ubigeo' => $this->code_ubigeo,
            'code_ubigeo_rel' => new MasterUbigeoResource($this->whenLoaded('codeUbigeoRel')),

            'has_store' => $this->has_store,
            'sells_gas_cylinders' => $this->sells_gas_cylinders,
            'brands_sold' => $this->brands_sold,
            'selling_time' => $this->selling_time,
            'monthly_sales' => $this->monthly_sales,
            'accepts_data_policy' => $this->accepts_data_policy,

            'created_at' => $this->created_at,
            'created_at_format' => $this->created_at_format,
            'created_at_format_2' => $this->created_at_format2,
            'updated_at' => $this->updated_at,
            'updated_at_format' => $this->updated_at_format,
            'updated_at_format_2' => $this->updated_at_format2,
        ];
    }
}
