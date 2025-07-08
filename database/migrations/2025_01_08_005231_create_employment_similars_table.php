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
        Schema::create('employment_similars', function (Blueprint $table) {
            $table->id();

            $table->foreignId('employment_id')->constrained('employments')->cascadeOnDelete();
            $table->foreignId('employment_similar_id')->constrained('employments')->cascadeOnDelete();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employment_similars');
    }
};
