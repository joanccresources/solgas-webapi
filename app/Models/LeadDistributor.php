<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class LeadDistributor extends Model
{
    use HasFactory, LogsActivity;

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()->logOnly([
            'full_name',
            'dni_or_ruc',
            'phone_1',
            'phone_2',
            'email',
            'code_ubigeo',
            'address',
        ]);
    }

    protected $appends = [
        "created_at_format",
        "created_at_format2",
        "updated_at_format",
        "updated_at_format2"
    ];

    public function codeUbigeoRel(): BelongsTo
    {
        return $this->belongsTo(MasterUbigeo::class, 'code_ubigeo', 'code_ubigeo');
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
