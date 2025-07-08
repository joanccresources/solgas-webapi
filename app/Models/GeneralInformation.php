<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class GeneralInformation extends Model
{
    use HasFactory, LogsActivity;

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()->logOnly([
            'logo_principal',
            'logo_footer',
            'logo_icon',
            'logo_email',
            'phone',
            'whatsapp'
        ]);
    }

    protected $appends = [
        "created_at_format",
        "created_at_format2",
        "updated_at_format",
        "updated_at_format2",
        "logo_principal_format",
        "logo_footer_format",
        "logo_icon_format",
        "logo_email_format",
        "more_information_cookie_format"
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

    protected function logoPrincipalFormat(): Attribute
    {
        return new Attribute(
            get: fn() => $this->logo_principal
                ? config('services.s3_bucket.url_bucket_public')
                . DIRECTORY_SEPARATOR . 'public'
                . DIRECTORY_SEPARATOR . 'images'
                . DIRECTORY_SEPARATOR . 'informacion'
                . DIRECTORY_SEPARATOR . $this->logo_principal
                : '',
        );
    }

    protected function logoFooterFormat(): Attribute
    {
        return new Attribute(
            get: fn() => $this->logo_footer
                ? config('services.s3_bucket.url_bucket_public')
                . DIRECTORY_SEPARATOR . 'public'
                . DIRECTORY_SEPARATOR . 'images'
                . DIRECTORY_SEPARATOR . 'informacion'
                . DIRECTORY_SEPARATOR . $this->logo_footer
                : '',
        );
    }

    protected function logoIconFormat(): Attribute
    {
        return new Attribute(
            get: fn() => $this->logo_icon
                ? config('services.s3_bucket.url_bucket_public')
                . DIRECTORY_SEPARATOR . 'public'
                . DIRECTORY_SEPARATOR . 'images'
                . DIRECTORY_SEPARATOR . 'informacion'
                . DIRECTORY_SEPARATOR . $this->logo_icon
                : '',
        );
    }

    protected function logoEmailFormat(): Attribute
    {
        return new Attribute(
            get: fn() => $this->logo_email
                ? config('services.s3_bucket.url_bucket_public')
                . DIRECTORY_SEPARATOR . 'public'
                . DIRECTORY_SEPARATOR . 'images'
                . DIRECTORY_SEPARATOR . 'informacion'
                . DIRECTORY_SEPARATOR . $this->logo_email
                : '',
        );
    }

    protected function moreInformationCookieFormat(): Attribute
    {
        return new Attribute(
            get: fn() => $this->more_information_cookie
                ? config('services.s3_bucket.url_bucket_public')
                . DIRECTORY_SEPARATOR . 'public'
                . DIRECTORY_SEPARATOR . 'documentos'
                . DIRECTORY_SEPARATOR . 'informacion'
                . DIRECTORY_SEPARATOR . $this->more_information_cookie
                : '',
        );
    }
}
