<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

class AttributeValue extends Model
{
    use HasFactory;

    protected $appends = [
        "created_at_format",
        "created_at_format2",
        "updated_at_format",
        "updated_at_format2",
        "date_value_format",
        "datetime_value_format",
        "json_value_format"
    ];

    public function attributeRel(): BelongsTo
    {
        return $this->belongsTo(Attribute::class, 'attribute_id', 'id');
    }

    public function jsonValueFormat(): Attribute
    {
        return new Attribute(
            get: fn() => json_decode($this->json_value),
        );
    }

    public function dateValueFormat(): Attribute
    {
        return new Attribute(
            get: fn() => $this->date_value ? (Carbon::parse($this->date_value))->format('d/m/Y') : '',
        );
    }

    public function datetimeValueFormat(): Attribute
    {
        return new Attribute(
            get: fn() => $this->datetime_value ? (Carbon::parse($this->datetime_value))->format('d/m/Y H:i') : '',
        );
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
