<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PageSection extends Model
{
    use HasFactory;

    protected $appends = [
        "created_at_format",
        "created_at_format2",
        "updated_at_format",
        "updated_at_format2"
    ];

    public function pageRel(): BelongsTo
    {
        return $this->belongsTo(Page::class, 'page_id', 'id');
    }

    public function fieldRels(): HasMany
    {
        return $this->hasMany(PageField::class, 'page_section_id', 'id');
    }

    public function contentRels(): HasMany
    {
        return $this->hasMany(PageContent::class, 'page_section_id', 'id');
    }

    public function multipleFieldSectionRels(): HasMany
    {
        return $this->hasMany(PageMultipleFieldSection::class, 'page_section_id', 'id');
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
}
