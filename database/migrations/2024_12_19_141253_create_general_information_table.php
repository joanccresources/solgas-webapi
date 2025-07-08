<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('general_information', function (Blueprint $table) {
            $table->id();

            $table->string('logo_principal')->nullable();
            $table->string('logo_footer')->nullable();
            $table->string('logo_icon')->nullable();
            $table->string('logo_email')->nullable();
            $table->string('phone')->nullable();
            $table->string('whatsapp')->nullable();
            $table->string('recaptcha_secret_key')->nullable();
            $table->string('recaptcha_site_key')->nullable();
            $table->string('recaptcha_google_url_verify')->nullable();
            $table->string('google_tag_manager_id')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('general_information');
    }
};
