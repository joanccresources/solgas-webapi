<?php

namespace App\Models;

use App\Enums\ModelStatusEnum;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class SustainabilityReportObject extends Model
{
    use HasFactory, LogsActivity;

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()->logOnly(['image', 'index', 'active', 'sustainability_report_id']);
    }

    protected $appends = [
        "created_at_format",
        "created_at_format2",
        "updated_at_format",
        "updated_at_format2",
        "image_format",
        "image_format2",
    ];

    protected function casts(): array
    {
        return [
            'active' => ModelStatusEnum::class,
        ];
    }

    public function reportObjectsRel(): BelongsTo
    {
        return $this->belongsTo(SustainabilityReport::class, 'sustainability_report_id', 'id');
    }

    public function createdAtFormat(): Attribute
    {
        return new Attribute(
            get: fn() => Carbon::parse($this->created_at)->isoFormat('LLLL a'),
        );
    }

    public function createdAtFormat2(): Attribute
    {
        return new Attribute(
            get: fn() => Carbon::parse($this->created_at)->format('d/m/Y H:i'),
        );
    }

    public function updatedAtFormat(): Attribute
    {
        return new Attribute(
            get: fn() => Carbon::parse($this->updated_at)->isoFormat('LLLL a'),
        );
    }

    public function updatedAtFormat2(): Attribute
    {
        return new Attribute(
            get: fn() => Carbon::parse($this->updated_at)->format('d/m/Y H:i'),
        );
    }

    protected function imageFormat(): Attribute
    {
        return new Attribute(
            get: fn() => $this->image
                ? config('services.s3_bucket.url_bucket_public')
                . DIRECTORY_SEPARATOR . 'public'
                . DIRECTORY_SEPARATOR . 'images'
                . DIRECTORY_SEPARATOR . 'sustainability-reports'
                . DIRECTORY_SEPARATOR . $this->image
                : null,
        );
    }

    protected function imageFormat2(): Attribute
    {
        return new Attribute(
            get: fn() => $this->image
                ? DIRECTORY_SEPARATOR . 'public'
                . DIRECTORY_SEPARATOR . 'images'
                . DIRECTORY_SEPARATOR . 'sustainability-reports'
                . DIRECTORY_SEPARATOR . $this->image
                : null,
        );
    }
}
