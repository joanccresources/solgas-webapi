<?php

namespace App\Models;

use App\Enums\ModelStatusEnum;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Page extends Model
{
    use HasFactory;

    protected $appends = [
        "created_at_format",
        "created_at_format2",
        "updated_at_format",
        "updated_at_format2",
        "seo_image_format",
        "seo_image_format2"
    ];

    protected function casts(): array
    {
        return [
            'active' => ModelStatusEnum::class,
        ];
    }

    public function sectionRels(): HasMany
    {
        return $this->hasMany(PageSection::class, 'page_id', 'id');
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

    protected function seoImageFormat(): Attribute
    {
        return new Attribute(
            get: fn() => $this->seo_image
                ? config('services.s3_bucket.url_bucket_public')
                . DIRECTORY_SEPARATOR . 'public'
                . DIRECTORY_SEPARATOR . 'images'
                . DIRECTORY_SEPARATOR . 'pages'
                . DIRECTORY_SEPARATOR . $this->seo_image
                : null,
        );
    }

    protected function seoImageFormat2(): Attribute
    {
        return new Attribute(
            get: fn() => $this->seo_image
                ? DIRECTORY_SEPARATOR . 'public'
                . DIRECTORY_SEPARATOR . 'images'
                . DIRECTORY_SEPARATOR . 'pages'
                . DIRECTORY_SEPARATOR . $this->seo_image
                : null,
        );
    }
}
