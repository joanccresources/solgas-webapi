<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class EmploymentSimilar extends Model
{
    use HasFactory, LogsActivity;

    protected $fillable = ['employment_id', 'similar_employment_id'];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()->logOnly([
            'employment_id',
            'employment_similar_id',
        ]);
    }

    public function employmentRel(): BelongsTo
    {
        return $this->belongsTo(Employment::class, 'employment_id', 'id');
    }

    public function similarEmploymentRel(): BelongsTo
    {
        return $this->belongsTo(Employment::class, 'employment_similar_id', 'id');
    }
}
