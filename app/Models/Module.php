<?php

namespace App\Models;

use App\Enums\ModelStatusEnum;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;
use Spatie\Permission\Models\Permission;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class Module extends Model
{
    use HasFactory, LogsActivity;

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()->logOnly([
            'name',
            'singular_name',
            'assigned',
            'slug',
            'icon',
            'per_page',
            'page',
            'index',
            'sort_by',
            'order_direction',
            'is_crud',
            'show_in_sidebar',
            'is_removable',
            'active',
            'module_id',
        ]);
    }

    protected $appends = [
        "created_at_format",
        "created_at_format2",
        "updated_at_format",
        "updated_at_format2",
        "path_format",
        "columns_format",
        "create_edit_format",
    ];

    protected function casts(): array
    {
        return [
            'active' => ModelStatusEnum::class,
        ];
    }

    public function moduleRel(): BelongsTo
    {
        return $this->belongsTo(Module::class, 'module_id', 'id');
    }

    public function submoduleRels(): HasMany
    {
        return $this->hasMany(Module::class, 'module_id', 'id');
    }

    public function permissionRels(): HasMany
    {
        return $this->hasMany(Permission::class, 'module_id', 'id');
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

    public function pathFormat(): Attribute
    {
        return new Attribute(
            get: fn() => json_decode($this->path),
        );
    }

    public function columnsFormat(): Attribute
    {
        return new Attribute(
            get: fn() => json_decode($this->columns),
        );
    }

    public function createEditFormat(): Attribute
    {
        return new Attribute(
            get: fn() => json_decode($this->create_edit),
        );
    }
}
