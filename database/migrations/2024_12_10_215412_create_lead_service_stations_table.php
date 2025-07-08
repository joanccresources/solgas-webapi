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
        Schema::create('lead_service_stations', function (Blueprint $table) {
            $table->id();
            $table->string('full_name')->nullable();
            $table->string('company')->nullable();
            $table->string('ruc')->nullable();
            $table->string('phone')->nullable();
            $table->string('email')->nullable();
            $table->string('region')->nullable();
            $table->text('message')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lead_service_stations');
    }
};
