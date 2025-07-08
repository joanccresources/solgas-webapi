<?php

declare(strict_types=1);

namespace App\DTOs\v1\Lead\LeadEmailDestination;

use App\Http\Requests\API\v1\Lead\LeadEmailDestinationRequest;

class CreateLeadEmailDestinationDto
{
    public function __construct(
        public string $name,
        public string $email,
    ) {}

    public static function fromRequest(LeadEmailDestinationRequest $request): CreateLeadEmailDestinationDto
    {
        return new self(
            name: $request->get('name'),
            email: $request->get('email'),
        );
    }
}
