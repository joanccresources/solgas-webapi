<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use App\Enums\ModelStatusEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Contracts\Auth\CanResetPassword;
use App\Notifications\v1\ResetPassword;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Support\Carbon;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class User extends Authenticatable implements MustVerifyEmail, CanResetPassword
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles, LogsActivity;

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()->logOnly([
            'name',
            'email',
            'phone',
            'active',
            'image'
        ]);
    }

    protected $appends = [
        'avatar_initials',
        "created_at_format",
        "created_at_format2",
        "updated_at_format",
        "updated_at_format2"
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'active' => ModelStatusEnum::class,
        ];
    }

    public function avatarInitials(): Attribute
    {
        $full_name = $this->name . " " . $this->last_name;
        $temp = explode(' ', trim($full_name));
        $initials = strtoupper(substr($temp[0], 0, 1));
        if (count($temp) > 1) {
            $initials = $initials . strtoupper(substr($temp[1], 0, 1));
        }

        return new Attribute(
            get: fn() => $initials,
        );
    }

    /**
     * Send the password reset notification.
     *
     * @param string $token
     */
    public function sendPasswordResetNotification($token)
    {
        $this->notify(new ResetPassword($token, $this));
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
