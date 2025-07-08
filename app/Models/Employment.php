<?php

namespace App\Models;

use App\Enums\ModelStatusEnum;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class Employment extends Model
{
    use HasFactory, LogsActivity;

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()->logOnly([
            'title',
            'description',
            'address',
            'code_ubigeo',
            'posted_at',
            'employment_type_id',
            'employment_area_id',
            'active'
        ]);
    }

    protected $appends = [
        "created_at_format",
        "created_at_format2",
        "updated_at_format",
        "updated_at_format2",
        "posted_at_format",
        "posted_at_format2"
    ];

    protected function casts(): array
    {
        return [
            'active' => ModelStatusEnum::class,
        ];
    }

    public function leadWorkWithUsRels(): HasMany
    {
        return $this->hasMany(LeadWorkWithUs::class, 'employment_id', 'id');
    }

    public function typeRel(): BelongsTo
    {
        return $this->belongsTo(EmploymentType::class, 'employment_type_id', 'id');
    }

    public function areaRel(): BelongsTo
    {
        return $this->belongsTo(EmploymentArea::class, 'employment_area_id', 'id');
    }

    public function codeUbigeoRel(): BelongsTo
    {
        return $this->belongsTo(MasterUbigeo::class, 'code_ubigeo', 'code_ubigeo');
    }

    public function similarEmploymentRels(): HasMany
    {
        return $this->hasMany(EmploymentSimilar::class, 'employment_id', 'id');
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

    public function postedAtFormat(): Attribute
    {
        return new Attribute(
            get: fn() => Carbon::parse($this->posted_at)->isoFormat('LLLL a'),
        );
    }

    public function postedAtFormat2(): Attribute
    {
        return new Attribute(
            get: fn() => Carbon::parse($this->posted_at)->format('d/m/Y H:i'),
        );
    }
}
