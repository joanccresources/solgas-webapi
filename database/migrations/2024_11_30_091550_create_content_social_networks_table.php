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
        Schema::create('content_social_networks', function (Blueprint $table) {
            $table->id();

            $table->integer('index')->default(0)->nullable();
            $table->boolean('active')->default(true);
            $table->text('url')->nullable();
            $table->foreignId('content_master_social_network_id')->constrained('content_master_social_networks');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('content_social_networks');
    }
};
