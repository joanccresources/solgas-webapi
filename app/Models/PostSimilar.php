<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class PostSimilar extends Model
{
    use HasFactory, LogsActivity;

    protected $fillable = ['post_id', 'similar_post_id'];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()->logOnly([
            'post_id',
            'post_similar_id',
        ]);
    }

    public function postRel(): BelongsTo
    {
        return $this->belongsTo(Post::class, 'post_id', 'id');
    }

    public function similarPostRel(): BelongsTo
    {
        return $this->belongsTo(Post::class, 'post_similar_id', 'id');
    }
}
