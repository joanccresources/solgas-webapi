<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class CookieConsent extends Model
{
    use HasFactory, LogsActivity;

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()->logOnly(['ip_address', 'user_agent', 'cookie_preferences', 'accepted_at']);
    }

    protected $appends = [
        "created_at_format",
        "created_at_format2",
        "updated_at_format",
        "updated_at_format2",
        "accepted_at_format",
        "accepted_at_format2",
        "cookie_preferences_format",
    ];

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

    public function acceptedAtFormat(): Attribute
    {
        return new Attribute(
            get: fn() => Carbon::parse($this->accepted_at)->isoFormat('LLLL a'),
        );
    }

    public function acceptedAtFormat2(): Attribute
    {
        return new Attribute(
            get: fn() => Carbon::parse($this->accepted_at)->format('d/m/Y H:i'),
        );
    }

    public function cookiePreferencesFormat(): Attribute
    {
        return new Attribute(
            get: fn() => json_decode($this->cookie_preferences),
        );
    }
}
