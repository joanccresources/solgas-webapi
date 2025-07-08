<?php

namespace App\Http\Resources\v1\Web;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ContentSocialNetworkPublicResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'url' => $this->url,
            'master_social_network_rel' => new ContentMasterSocialNetworkPublicResource($this->whenLoaded('masterSocialNetworkRel'))
        ];
    }
}
