<?php

declare(strict_types=1);

namespace App\DTOs\v1\Content\ContentSocialNetwork;

use App\Http\Requests\API\v1\Content\ContentSocialNetworkRequest;

class UpdateContentSocialNetworkDto
{
    public function __construct(
        public string $url,
        public int $content_master_social_network_id,
        public bool|null $active
    ) {}

    public static function fromRequest(ContentSocialNetworkRequest $request): UpdateContentSocialNetworkDto
    {
        return new self(
            url: $request->get('url'),
            content_master_social_network_id: $request->get('content_master_social_network_id'),
            active: (bool) $request->get('active')
        );
    }
}
