<?php

namespace App\Models;

use App\Enums\ModelStatusEnum;
use App\Traits\AttributeTrait;
use Illuminate\Database\Eloquent\Casts\Attribute as CastsAttribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;

class Attribute extends Model
{
    use HasFactory, AttributeTrait;

    protected $appends = [
        "created_at_format",
        "created_at_format2",
        "updated_at_format",
        "updated_at_format2",
        "model_exist",
        "model_lookup_exist"
    ];

    protected function casts(): array
    {
        return [
            'active' => ModelStatusEnum::class,
        ];
    }

    public function modelExist(): CastsAttribute
    {
        return new CastsAttribute(
            get: fn() => $this->existModel($this->model),
        );
    }

    public function modelLookupExist(): CastsAttribute
    {
        return new CastsAttribute(
            get: fn() => $this->existLookupModel($this->exist_model_lookup),
        );
    }

    public function optionRels(): HasMany
    {
        return $this->hasMany(AttributeOption::class, 'attribute_id', 'id');
    }

    public function valueRels(): HasMany
    {
        return $this->hasMany(AttributeValue::class, 'attribute_id', 'id');
    }

    public function typeRel(): BelongsTo
    {
        return $this->belongsTo(AttributeType::class, 'attribute_type_id', 'id');
    }

    public function createdAtFormat(): CastsAttribute
    {
        return new CastsAttribute(
            get: fn() => Carbon::parse($this->created_at)->isoFormat('LLLL a'),
        );
    }

    public function createdAtFormat2(): CastsAttribute
    {
        return new CastsAttribute(
            get: fn() => Carbon::parse($this->created_at)->format('d/m/Y H:i'),
        );
    }

    public function updatedAtFormat(): CastsAttribute
    {
        return new CastsAttribute(
            get: fn() => Carbon::parse($this->updated_at)->isoFormat('LLLL a'),
        );
    }

    public function updatedAtFormat2(): CastsAttribute
    {
        return new CastsAttribute(
            get: fn() => Carbon::parse($this->updated_at)->format('d/m/Y H:i'),
        );
    }
}
