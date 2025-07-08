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
        Schema::create('sustainability_report_objects', function (Blueprint $table) {
            $table->id();
            $table->string('image')->nullable();
            $table->integer('index')->default(0)->nullable();
            $table->boolean('active')->default(true)->nullable();
            $table->foreignId('sustainability_report_id')->constrained('sustainability_reports')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sustainability_report_objects');
    }
};
