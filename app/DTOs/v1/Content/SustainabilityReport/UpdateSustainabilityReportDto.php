<?php

declare(strict_types=1);

namespace App\DTOs\v1\Content\SustainabilityReport;

use Illuminate\Http\UploadedFile;
use App\Http\Requests\API\v1\Content\SustainabilityReportRequest;

class UpdateSustainabilityReportDto
{
    public function __construct(
        public string $title,
        public UploadedFile|null $pdf,
        public string|null $title_milestones,
        public bool|null $active
    ) {}

    public static function fromRequest(SustainabilityReportRequest $request): UpdateSustainabilityReportDto
    {
        return new self(
            title: $request->get('title'),
            pdf: $request->file('pdf'),
            title_milestones: $request->get('title_milestones'),
            active: (bool) $request->get('active')
        );
    }
}
