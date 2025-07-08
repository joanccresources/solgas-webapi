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

class ContentHeaderMenu extends Model
{
    use HasFactory, LogsActivity;

    const FOLDER_IMAGE = 'images' . DIRECTORY_SEPARATOR . 'menu';
    const FOLDER_VIDEO = 'videos' . DIRECTORY_SEPARATOR . 'menu';
    const FOLDER_DOCUMENT = 'documentos' . DIRECTORY_SEPARATOR . 'menu';

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()->logOnly(['name', 'active', 'url', 'index', 'content_footer_id', 'content_footer_menu_id']);
    }

    protected $appends = [
        "created_at_format",
        "created_at_format2",
        "updated_at_format",
        "updated_at_format2",
        "content_format",
        "content_format_2"
    ];

    protected function casts(): array
    {
        return [
            'active' => ModelStatusEnum::class,
        ];
    }

    public function contentHeaderRel(): BelongsTo
    {
        return $this->belongsTo(ContentHeader::class, 'content_header_id', 'id');
    }

    /**
     * Relación con el menú padre (auto-relación)
     */
    public function parentMenu(): BelongsTo
    {
        return $this->belongsTo(ContentHeaderMenu::class, 'content_header_menu_id');
    }

    public function menuTypeRel(): BelongsTo
    {
        return $this->belongsTo(ContentMenuType::class, 'content_menu_type_id');
    }

    /**
     * Relación con los menús hijos (auto-relación)
     */
    public function childMenus(): HasMany
    {
        return $this->hasMany(ContentHeaderMenu::class, 'content_header_menu_id');
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

    public function contentFormat(): Attribute
    {

        return new Attribute(
            get: fn() => $this->content_menu_type_id != 4 && $this->content ?
                config('services.s3_bucket.url_bucket_public')
                . DIRECTORY_SEPARATOR . 'public'
                . DIRECTORY_SEPARATOR . $this->getFolderNameForType($this->content_menu_type_id)
                . DIRECTORY_SEPARATOR . $this->content : $this->content,
        );
    }

    public function contentFormat2(): Attribute
    {

        return new Attribute(
            get: fn() => $this->content_menu_type_id != 4 && $this->content ?
                DIRECTORY_SEPARATOR . 'public'
                . DIRECTORY_SEPARATOR . $this->getFolderNameForType($this->content_menu_type_id)
                . DIRECTORY_SEPARATOR . $this->content : $this->content,
        );
    }

    public function getFolderNameForType(int $type): string
    {
        return match ($type) {
            1 => self::FOLDER_IMAGE,
            2 => self::FOLDER_VIDEO,
            3 => self::FOLDER_DOCUMENT,
            default => self::FOLDER_DOCUMENT,
        };
    }
}
