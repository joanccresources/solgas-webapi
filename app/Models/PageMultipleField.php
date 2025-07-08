<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PageMultipleField extends Model
{
    use HasFactory;

    protected $appends = [
        "created_at_format",
        "created_at_format2",
        "updated_at_format",
        "updated_at_format2"
    ];

    public function dataRels(): HasMany
    {
        return $this->hasMany(PageMultipleFieldData::class, 'page_multiple_field_id', 'id');
    }

    public function multipleFieldSectionRels(): HasMany
    {
        return $this->hasMany(PageMultipleFieldSection::class, 'page_multiple_field_id', 'id');
    }

    public function multipleContentRels(): HasMany
    {
        return $this->hasMany(PageMultipleContent::class, 'page_multiple_field_id', 'id');
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
