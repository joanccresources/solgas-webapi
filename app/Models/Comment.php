<?php

namespace App\Models;

use BeyondCode\Comments\Comment as CommentsComment;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

class Comment extends CommentsComment
{
    /**
     * Cargar comentarios recursivamente.
     */
    public function scopeWithRecursiveReplies(Builder $query)
    {
        $query->with([
            'comments' => function ($query) {
                $query->withRecursiveReplies(); // Llamada recursiva para cargar más niveles
            }
        ]);
    }

    protected $appends = [
        "created_at_format",
        "created_at_format2",
        "updated_at_format",
        "updated_at_format2"
    ];

    public function userRel(): BelongsTo
    {
        return $this->belongsTo(UserComment::class, 'user_id', 'id');
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
