<?php

namespace App\Models;

use App\Enums\ModelStatusEnum;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use BeyondCode\Comments\Traits\HasComments;
use Illuminate\Support\Carbon;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class Post extends Model
{
    use HasFactory, HasComments, LogsActivity;

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()->logOnly([
            'title',
            'slug',
            'short_description',
            'content',
            'image',
            'thumbnail',
            'publication_at',
            'user_id',
            'active',
            'view',
            'like',
            'shared'
        ]);
    }

    protected $appends = [
        "created_at_format",
        "created_at_format2",
        "updated_at_format",
        "updated_at_format2",
        "publication_at_format",
        "publication_at_format2",
        "publication_at_format3",
        "image_format",
        "thumbnail_format",
        "image_format2",
        "thumbnail_format2"
    ];

    protected function casts(): array
    {
        return [
            'active' => ModelStatusEnum::class,
        ];
    }

    public function tagPostRels(): HasMany
    {
        return $this->hasMany(TagPost::class, 'post_id', 'id');
    }

    public function categoryPostRels(): HasMany
    {
        return $this->hasMany(CategoryPost::class, 'post_id', 'id');
    }

    public function toManyTagPostRels(): BelongsToMany
    {
        return $this->belongsToMany(Tag::class, 'tag_posts', 'post_id', 'tag_id');
    }

    public function toManyCategoryPostRels(): BelongsToMany
    {
        return $this->belongsToMany(Category::class, 'category_posts', 'post_id', 'category_id');
    }

    public function userRel(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function similarPostRels(): HasMany
    {
        return $this->hasMany(PostSimilar::class, 'post_id', 'id');
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

    public function publicationAtFormat(): Attribute
    {
        return new Attribute(
            get: fn() => Carbon::parse($this->publication_at)->isoFormat('LLLL a'),
        );
    }

    public function publicationAtFormat2(): Attribute
    {
        return new Attribute(
            get: fn() => Carbon::parse($this->publication_at)->format('d/m/Y H:i'),
        );
    }

    public function publicationAtFormat3(): Attribute
    {
        return new Attribute(
            get: fn() => Carbon::parse($this->publication_at)->isoFormat('D [de] MMMM YYYY'),
        );
    }

    protected function imageFormat(): Attribute
    {
        return new Attribute(
            get: fn() => $this->image
                ? config('services.s3_bucket.url_bucket_public')
                . DIRECTORY_SEPARATOR . 'public'
                . DIRECTORY_SEPARATOR . 'images'
                . DIRECTORY_SEPARATOR . 'posts'
                . DIRECTORY_SEPARATOR . $this->image
                : null,
        );
    }

    protected function thumbnailFormat(): Attribute
    {
        return new Attribute(
            get: fn() => $this->thumbnail
                ? config('services.s3_bucket.url_bucket_public')
                . DIRECTORY_SEPARATOR . 'public'
                . DIRECTORY_SEPARATOR . 'images'
                . DIRECTORY_SEPARATOR . 'posts'
                . DIRECTORY_SEPARATOR . $this->thumbnail
                : null,
        );
    }

    protected function imageFormat2(): Attribute
    {
        return new Attribute(
            get: fn() => $this->image
                ? DIRECTORY_SEPARATOR . 'public'
                . DIRECTORY_SEPARATOR . 'images'
                . DIRECTORY_SEPARATOR . 'posts'
                . DIRECTORY_SEPARATOR . $this->image
                : null,
        );
    }

    protected function thumbnailFormat2(): Attribute
    {
        return new Attribute(
            get: fn() => $this->thumbnail
                ? DIRECTORY_SEPARATOR . 'public'
                . DIRECTORY_SEPARATOR . 'images'
                . DIRECTORY_SEPARATOR . 'posts'
                . DIRECTORY_SEPARATOR . $this->thumbnail
                : null,
        );
    }
}
