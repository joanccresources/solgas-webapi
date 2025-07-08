<?php

namespace App\DTOs\v1\Helpers\Order;

use App\Http\Requests\API\v1\Helpers\Order\ContentOrderRequest;

class UpdateContentOrderDto
{
    public function __construct(
        public array $items
    ) {
    }

    public static function fromRequest(ContentOrderRequest $request): UpdateContentOrderDto
    {
        return new self(
            items: $request->get('items')
        );
    }
}
