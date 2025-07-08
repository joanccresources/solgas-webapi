<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class LeadWorkWithUs extends Model
{
    use HasFactory, LogsActivity;

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()->logOnly([
            'cv_path',
            'full_name',
            'dni',
            'phone',
            'address',
            'email',
            'birth_date',
            'employment_id',
        ]);
    }

    protected $appends = [
        "cv_path_format",
        "created_at_format",
        "created_at_format2",
        "updated_at_format",
        "updated_at_format2",
        "birth_date_format"
    ];

    public function employmentRel(): BelongsTo
    {
        return $this->belongsTo(Employment::class, 'employment_id', 'id');
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

    public function birthDateFormat(): Attribute
    {
        return new Attribute(
            get: fn() => Carbon::parse($this->birth_date)->format('d/m/Y'),
        );
    }

    public function cvPathFormat(): Attribute
    {
        return new Attribute(
            get: fn() => $this->cv_path ?  DIRECTORY_SEPARATOR . 'private' . DIRECTORY_SEPARATOR . 'documentos' . DIRECTORY_SEPARATOR . 'work_with_us' . DIRECTORY_SEPARATOR . $this->cv_path : null,
        );
    }
}
