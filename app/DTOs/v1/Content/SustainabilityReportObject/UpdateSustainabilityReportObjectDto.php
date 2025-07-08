<?php

declare(strict_types=1);

namespace App\DTOs\v1\Content\SustainabilityReportObject;

use Illuminate\Http\UploadedFile;
use App\Http\Requests\API\v1\Content\SustainabilityReportObjectRequest;

class UpdateSustainabilityReportObjectDto
{
    public function __construct(
        public UploadedFile|null $image,
        public string $sustainability_report_id,
        public bool|null $active
    ) {}

    public static function fromRequest(SustainabilityReportObjectRequest $request): UpdateSustainabilityReportObjectDto
    {
        return new self(
            image: $request->file('image'),
            sustainability_report_id: $request->get('sustainability_report_id'),
            active: (bool) $request->get('active')
        );
    }
}
